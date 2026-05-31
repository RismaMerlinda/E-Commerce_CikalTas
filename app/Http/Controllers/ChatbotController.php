<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);
        $question = trim($request->input('message'));

        $conversation = \App\Models\Conversation::firstOrCreate(
            ['user_id' => auth()->id()]
        );
        $conversation->update(['last_message_at' => now()]);

        // Simpan pesan awal ke database
        $dbMessage = $conversation->messages()->create([
            'sender_type' => 'user',
            'sender_id' => auth()->id(),
            'message' => $question,
            'is_read' => true,
        ]);

        $reply = null;

        // --- 1. DATA TOKO (FAQ & PRODUK) ---
        $allFaqs    = Faq::all();
        $allProducts = Product::where('stock', '>', 0)->get();

        // --- 2. COBA LOCAL REPLY DULU (hemat kuota API) ---
        $localReply = $this->getLocalReply($question, $allFaqs, $allProducts);
        if ($localReply) {
            $reply = trim($localReply);
        } else {
            // --- 3. CEK CACHE (pertanyaan sama tidak panggil API lagi) ---
            $cacheKey = 'chatbot_' . md5(Str::lower(trim($question)));
            $cached = Cache::get($cacheKey);
            if ($cached) {
                $reply = $cached;
            } else {
                // --- 4. BANGUN STORE DATA & SYSTEM PROMPT ---
                $storeData = "=== DATA FAQ ===\n";
                foreach ($allFaqs as $f) {
                    $storeData .= "- Q: {$f->question} | A: {$f->answer}\n";
                }
                $storeData .= "\n=== DATA PRODUK TERSEDIA ===\n";
                foreach ($allProducts as $p) {
                    $price = number_format($p->price, 0, ',', '.');
                    $storeData .= "- {$p->name} (Kategori: {$p->category}, Warna: {$p->color}) | Harga: Rp{$price} | Stok: {$p->stock} | Deskripsi: {$p->description}\n";
                }

                $systemPrompt = "Kamu adalah Cikal, asisten virtual toko tas CikalTas. ✨🎒
Tugasmu HANYA membantu pertanyaan seputar toko CikalTas: produk tas, harga, ukuran, bahan, cara order, pembayaran, pengiriman, retur, dan info toko.

ATURAN KETAT:
- Jika pertanyaan TIDAK berhubungan dengan tas atau toko CikalTas, TOLAK dengan ramah.
- Jika pelanggan bertanya tentang CUSTOM TAS (bikin tas custom, pesan desain sendiri), BERIKAN JAWABAN ini:
  'Wah asik banget Kak mau pesan custom tas! ✨ Langsung aja isi detail pesanan Kakak di form ini ya:
  👉 https://forms.gle/Qe4s1K9DhvHVA38Q6
  
  Nanti tim Cikal bakal langsung hubungi Kakak buat ngobrolin desain dan harganya. Ditunggu ya Kak pesenannya! 🥰'
- JANGAN menyuruh pelanggan mencari formulir di website. Selalu berikan link Google Form di atas.
- Bicaralah natural, santai, asik. Panggil 'Kakak'.
- JANGAN pakai template selain format link di atas.

Data toko untuk referensi jawaban teknis:
{$storeData}";

                // --- 5. PANGGIL GEMINI API (dengan retry jika 429) ---
                $answer = $this->callGeminiWithRetry($question, $systemPrompt);

                if ($answer) {
                    $reply = trim($answer);
                    // Simpan ke cache selama 30 menit
                    Cache::put($cacheKey, $reply, now()->addMinutes(30));

                    // Log ke n8n (opsional, tidak blocking)
                    $this->logToN8n($question, $reply);
                } else {
                    // --- 6. SMART FALLBACK berdasarkan kata kunci ---
                    $reply = $this->getSmartFallback($question);
                }
            }
        }

        // Update balasan di database
        if ($reply) {
            $conversation->messages()->create([
                'sender_type' => 'ai',
                'message' => $reply,
                'is_read' => false,
            ]);
        }

        return Response::json(['reply' => $reply], 200);
    }

    /**
     * Tampilkan riwayat chat chatbot pelanggan.
     */
    public function history()
    {
        $conversation = \App\Models\Conversation::where('user_id', auth()->id())->first();
        if (!$conversation) {
            return Response::json([], 200);
        }
        
        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        return Response::json($messages, 200);
    }

    /**
     * Panggil Gemini API dengan retry otomatis jika kena rate limit (429).
     */
    private function callGeminiWithRetry(string $question, string $systemPrompt, int $maxRetry = 2): ?string
    {
        $apiKey    = env('GEMINI_API_KEY', '');
        $model     = env('GEMINI_MODEL', 'gemini-2.5-flash');
        $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $payload = [
            'contents' => [
                [
                    'role'  => 'user',
                    'parts' => [['text' => $question]]
                ]
            ],
            'systemInstruction' => [
                'parts' => [['text' => $systemPrompt]]
            ],
            'generationConfig' => [
                'temperature'     => 0.7,
                'maxOutputTokens' => 700,
            ]
        ];

        for ($attempt = 1; $attempt <= $maxRetry; $attempt++) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(25)
                    ->post($geminiUrl, $payload);

                if ($response->successful()) {
                    $data   = $response->json();
                    $answer = $this->extractGeminiAnswer($data);
                    if ($answer) {
                        return $answer;
                    }
                }

                // Rate limit — tunggu lalu coba lagi
                if ($response->status() === 429) {
                    Log::warning("Gemini 429 rate limit, attempt {$attempt}/{$maxRetry}");
                    if ($attempt < $maxRetry) {
                        sleep(3); // tunggu 3 detik sebelum retry
                        continue;
                    }
                    break;
                }

                Log::warning('Gemini API non-200', [
                    'status' => $response->status(),
                    'body'   => substr($response->body(), 0, 300),
                ]);
                break;

            } catch (\Exception $e) {
                Log::error('ChatbotController Gemini error: ' . $e->getMessage());
                break;
            }
        }

        return null;
    }

    /**
     * Jawaban lokal berbasis keyword — tidak membutuhkan API.
     */
    private function getLocalReply(string $question, $faqs, $products): ?string
    {
        $q = Str::lower($question);

        // Sapa
        if (preg_match('/^(halo|hai|hi|hei|hey|assalam|pagi|siang|sore|malam|selamat)/', $q)) {
            return "Halo Kakak! 👋 Selamat datang di CikalTas! 🎒✨ Ada yang bisa Cikal bantu hari ini?";
        }

        // Terima kasih
        if (Str::contains($q, ['terima kasih', 'makasih', 'thanks', 'thank you', 'thx'])) {
            return "Sama-sama Kakak! 😊 Senang bisa bantu. Kalau ada pertanyaan lain, Cikal siap membantu ya! 🎒";
        }

        // Custom tas
        if (Str::contains($q, ['custom', 'pesan khusus', 'desain sendiri', 'bikin tas', 'buat tas'])) {
            return "Wah asik banget Kak mau pesan custom tas! ✨ Langsung aja isi detail pesanan Kakak di form ini ya:\n👉 https://forms.gle/Qe4s1K9DhvHVA38Q6\n\nNanti tim Cikal bakal langsung hubungi Kakak buat ngobrolin desain dan harganya. Ditunggu ya Kak pesenannya! 🥰";
        }

        // Ekspedisi / kurir
        if (Str::contains($q, ['ekspedisi', 'kurir', 'jne', 'j&t', 'jnt', 'sicepat', 'pos indonesia', 'tiki', 'anteraja'])) {
            return "CikalTas menggunakan jasa ekspedisi **JNE, J&T Express, SiCepat, dan Pos Indonesia**. Pilih sesuai kebutuhan Kakak ya! 🚚\n\nEstimasi pengiriman reguler biasanya **2–5 hari kerja** tergantung lokasi tujuan.";
        }

        // 0. Coba cocokkan NAMA PRODUK presisi dulu (biar tidak tertimpa FAQ atau kategori umum)
        foreach ($products as $product) {
            $name = Str::lower($product->name);
            if (Str::contains($q, $name)) {
                $price = number_format($product->price, 0, ',', '.');

                if (Str::contains($q, ['harga', 'berapa', 'price', 'cost'])) {
                    return "Harga {$product->name} saat ini **Rp{$price}** Kak. 🏷️ Mau langsung order? 😊";
                }
                if (Str::contains($q, ['stok', 'tersedia', 'ada', 'ready', 'stock'])) {
                    return "Stok {$product->name} saat ini **{$product->stock} pcs** Kak. 📦 Masih ready nih!";
                }
                if (Str::contains($q, ['bahan', 'material', 'detail', 'ukuran', 'dimensi', 'deskripsi', 'warna', 'spec'])) {
                    return "Detail **{$product->name}** Kak:\n📋 {$product->description}\n🎨 Warna: {$product->color}\n💰 Harga: Rp{$price}\n📦 Stok: {$product->stock} pcs";
                }

                return "**{$product->name}** adalah {$product->category} dengan harga **Rp{$price}** dan stok {$product->stock} pcs. 🎒\n{$product->description}\n\nMau tahu lebih lanjut Kak? 😊";
            }
        }

        // 1. Jawaban khusus untuk pertanyaan tas anak berdasarkan umur
        if ($ageBasedReply = $this->getAgeBasedBackpackReply($q, $products)) {
            return $ageBasedReply;
        }

        // 2. Jawaban khusus untuk pertanyaan kategori usia / anak-kuliah-dewasa
        if ($ageCategoryReply = $this->getAgeCategoryOverviewReply($q, $products)) {
            return $ageCategoryReply;
        }

        // 3. Jawaban khusus untuk pertanyaan ransel cowok/cewek agar tidak terlalu general
        if ($genderedBackpackReply = $this->getGenderedBackpackReply($q, $products)) {
            return $genderedBackpackReply;
        }

        // 4. Jawaban khusus untuk cakupan pengiriman ke daerah/wilayah/luar kota
        if ($shippingRegionReply = $this->getShippingEstimateReply($q)) {
            return $shippingRegionReply;
        }

        // 2. FAQ — cocokkan kata kunci dari pertanyaan FAQ dengan pengamanan stop words
        $stopWords = ['apa', 'siapa', 'mana', 'yang', 'saja', 'berapa', 'harga', 'apakah', 'adakah', 'bagaimana', 'dimana', 'kapan', 'saya', 'kamu', 'anda', 'kakak', 'cikal', 'toko', 'bisa', 'untuk', 'dengan', 'atau', 'pada', 'juga', 'mau', 'tanya', 'dong', 'sih', 'kah', 'ada', 'dan', 'di', 'tas', 'tas?'];
        $userCleanQuery = Str::lower(preg_replace('/[^\w\s]/u', '', $q));
        $userWords = preg_split('/\s+/', $userCleanQuery, -1, PREG_SPLIT_NO_EMPTY);

        $bestFaq = null;
        $bestMatchCount = 0;

        foreach ($faqs as $faq) {
            $faqQuestion = Str::lower(preg_replace('/[^\w\s]/u', '', $faq->question));
            $faqWords = preg_split('/\s+/', $faqQuestion, -1, PREG_SPLIT_NO_EMPTY);
            
            // Ambil kata-kata penting (bukan stop words) dengan panjang >= 3
            $significantFaqWords = array_filter($faqWords, function($word) use ($stopWords) {
                return !in_array($word, $stopWords) && strlen($word) >= 3;
            });
            
            // Hitung kecocokan kata penting secara aman (menghindari sub-kata parsial seperti 'berapa' mengandung 'apa')
            $matchCount = 0;
            foreach ($significantFaqWords as $sfw) {
                $matched = false;
                foreach ($userWords as $uw) {
                    // Cocok presisi, atau cocok dengan akhiran (misal 'lokasi' dengan 'lokasinya', 'diskon' dengan 'diskonnya')
                    if ($uw === $sfw || (Str::startsWith($uw, $sfw) && strlen($uw) - strlen($sfw) <= 4)) {
                        $matched = true;
                        break;
                    }
                }
                if ($matched) {
                    $matchCount++;
                }
            }
            
            $totalSignificant = count($significantFaqWords);
            if ($totalSignificant > 0) {
                // Tentukan syarat kelayakan minimal (threshold)
                // Jika kata penting >= 3, butuh minimal 2 kecocokan. Jika < 3, butuh minimal 1.
                $requiredMatches = $totalSignificant >= 3 ? 2 : 1;
                if ($matchCount >= $requiredMatches) {
                    // Cari yang memiliki jumlah kecocokan kata penting terbanyak
                    if ($matchCount > $bestMatchCount) {
                        $bestMatchCount = $matchCount;
                        $bestFaq = $faq;
                    }
                }
            } else {
                // Fallback jika tidak ada kata penting (misal pertanyaan sangat pendek)
                if (Str::contains($userCleanQuery, $faqQuestion)) {
                    if ($bestMatchCount === 0) {
                        $bestFaq = $faq;
                    }
                }
            }
        }

        if ($bestFaq) {
            return $bestFaq->answer;
        }

        // 3. Produk Kategori atau Warna (jika tidak ketemu nama produk presisi)
        foreach ($products as $product) {
            $category = Str::lower($product->category ?? '');
            $color    = Str::lower($product->color ?? '');

            if ((strlen($category) > 2 && Str::contains($q, $category)) || (strlen($color) > 2 && Str::contains($q, $color))) {
                $price = number_format($product->price, 0, ',', '.');

                if (Str::contains($q, ['harga', 'berapa', 'price', 'cost'])) {
                    return "Harga {$product->name} saat ini **Rp{$price}** Kak. 🏷️ Mau langsung order? 😊";
                }
                if (Str::contains($q, ['stok', 'tersedia', 'ada', 'ready', 'stock'])) {
                    return "Stok {$product->name} saat ini **{$product->stock} pcs** Kak. 📦 Masih ready nih!";
                }
                if (Str::contains($q, ['bahan', 'material', 'detail', 'ukuran', 'dimensi', 'deskripsi', 'warna', 'spec'])) {
                    return "Detail **{$product->name}** Kak:\n📋 {$product->description}\n🎨 Warna: {$product->color}\n💰 Harga: Rp{$price}\n📦 Stok: {$product->stock} pcs";
                }

                return "**{$product->name}** adalah {$product->category} dengan harga **Rp{$price}** dan stok {$product->stock} pcs. 🎒\n{$product->description}\n\nMau tahu lebih lanjut Kak? 😊";
            }
        }

        return null;
    }

    /**
     * Jawaban khusus untuk pertanyaan ransel cowok/cewek agar tidak terlalu general.
     */
    private function getGenderedBackpackReply(string $question, $products): ?string
    {
        $q = Str::lower($question);
        if (!Str::contains($q, ['ransel', 'tas ransel', 'backpack'])) {
            return null;
        }

        $isMale = Str::contains($q, ['pria', 'cowok', 'cowo', 'laki-laki', 'laki laki', 'male']);
        $isFemale = Str::contains($q, ['wanita', 'perempuan', 'cewek', 'cewe', 'female']);
        if (! $isMale && ! $isFemale) {
            return null;
        }

        $matches = [];
        foreach ($products as $product) {
            $category = Str::lower($product->category ?? '');
            if ($isMale && (Str::contains($category, 'ransel pria') || Str::contains($category, 'ransel anak laki') || Str::contains($category, 'laki-laki'))) {
                $matches[] = $product;
            }
            if ($isFemale && Str::contains($category, 'ransel anak perempuan')) {
                $matches[] = $product;
            }
        }

        if (empty($matches)) {
            return null;
        }

        $lines = [];
        foreach ($matches as $product) {
            $price = number_format($product->price, 0, ',', '.');
            $lines[] = "- {$product->name} ({$product->category}) — Rp{$price}";
        }

        $header = $isMale
            ? "Ini daftar ransel cowok yang tersedia di CikalTas:" 
            : "Ini daftar ransel cewek yang tersedia di CikalTas:";

        return $header . "\n" . implode("\n", $lines) . "\n\nKalau Kakak mau, Cikal bisa bantu pilihkan yang paling cocok untuk kebutuhan Kakak juga.";
    }

    /**
     * Jawaban khusus atau umum untuk kategori usia/target pengguna (anak-anak, kuliah, dewasa).
     */
    private function getAgeCategoryOverviewReply(string $question, $products): ?string
    {
        $q = Str::lower($question);

        // Filter awal agar tidak semua pertanyaan masuk ke sini
        if (!Str::contains($q, ['anak', 'kids', 'tk', 'sd', 'bocah', 'paud', 'balita', 'kuliah', 'mahasiswa', 'mahassiswa', 'mahasiswi', 'kampus', 'student', 'dewasa', 'kerja', 'kantor', 'formal', 'ibu', 'bapak', 'kantoran', 'kategori', 'usia', 'umur', 'kelompok'])) {
            return null;
        }

        // Tentukan target spesifik dari pertanyaan user
        $isKids = Str::contains($q, ['anak', 'kids', 'tk', 'sd', 'bocah', 'paud', 'balita']);
        $isStudent = Str::contains($q, ['kuliah', 'mahasiswa', 'mahasiswi', 'mahassiswa', 'kampus', 'student']);
        $isAdult = Str::contains($q, ['dewasa', 'kerja', 'kantor', 'formal', 'ibu', 'bapak', 'kantoran']);

        // 1. JIKA HANYA TANYA ANAK-ANAK
        if ($isKids && !$isStudent && !$isAdult) {
            return "Untuk produk **anak-anak**, CikalTas memiliki beberapa pilihan ransel sekolah yang sangat lucu, ringan, dan nyaman dipakai:\n\n" .
                   "👦 **Ransel Anak Laki-laki:**\n" .
                   "- **Ransel Anak Cowok Dinosaurus Biru** — Rp119.000 (Aman untuk anak usia 4-10 tahun, nyaman di punggung)\n" .
                   "- **Ransel Anak Cowok Superhero Merah** — Rp109.000 (Desain keren, cocok untuk TK hingga SD kelas 3)\n\n" .
                   "👧 **Ransel Anak Perempuan:**\n" .
                   "- **Ransel Anak Cewek Bunga Pink Manis** — Rp115.000 (Motif manis dengan bonus gantungan kunci imut)\n" .
                   "- **Ransel Anak Cewek Unicorn Ungu** — Rp125.000 (Dilengkapi glitter halus & sequin reversible cantik)\n\n" .
                   "Semua ransel anak kami dilengkapi dengan tali bahu berpadding tebal untuk menjaga kesehatan punggung si kecil. Kakak tertarik dengan model yang mana? 😊";
        }

        // 2. JIKA HANYA TANYA KULIAH / MAHASISWA
        if ($isStudent && !$isKids && !$isAdult) {
            return "Untuk kebutuhan **kuliah / mahasiswa**, CikalTas merekomendasikan tas yang luas, kuat, dan pas untuk membawa laptop serta buku:\n\n" .
                   "💻 **Tas Laptop (Protektif & Fungsional):**\n" .
                   "- **Tas Laptop Profesional Abu 15.6\"** — Rp245.000 (Sangat spacious, kompartemen laptop/tablet terpisah & port USB)\n" .
                   "- **Tas Laptop Slim Hitam 14\"** — Rp195.000 (Ramping, ringan hanya 450gr, elegan & anti-shock)\n\n" .
                   "🎒 **Ransel Pria Dewasa (Gaya Trendy & Kuat):**\n" .
                   "- **Ransel Pria Urban Tactical Hitam** — Rp189.000 (Anti air nylon 900D, port USB, muat laptop 15.6\")\n" .
                   "- **Ransel Pria Casual Navy Minimalis** — Rp159.000 (Simpel, trendy, berlubang sirkulasi udara)\n" .
                   "- **Ransel Pria Outdoor Olive Green** — Rp225.000 (Kapasitas besar 40L, pas untuk kuliah/hiking)\n\n" .
                   "👜 **Tas Selempang (Kasual & Hangout):**\n" .
                   "- **Tas Selempang Pria Kulit Coklat** — Rp129.000 (Bahan kulit sintetis premium, compact & modis)\n" .
                   "- **Tas Selempang Wanita Hitam Elegan** — Rp135.000 (PU leather premium, rantai logam modis)\n\n" .
                   "Pilihan di atas sangat cocok untuk aktivitas kampus harian Kakak. Ada model yang paling Kakak sukai? 😊";
        }

        // 3. JIKA HANYA TANYA DEWASA / KERJA
        if ($isAdult && !$isKids && !$isStudent) {
            return "Untuk **kategori Dewasa / Pekerja**, CikalTas menghadirkan koleksi premium yang elegan untuk menunjang penampilan profesional maupun kasual:\n\n" .
                   "💼 **Tas Kerja & Laptop Premium:**\n" .
                   "- **Tas Laptop Profesional Abu 15.6\"** — Rp245.000 (Desain formal & aman untuk laptop besar)\n" .
                   "- **Tas Laptop Slim Hitam 14\"** — Rp195.000 (Ramping, elegan, sangat ringan untuk mobilitas tinggi)\n" .
                   "- **Ransel Pria Urban Tactical Hitam** — Rp189.000 (Tangguh, kompartemen luas, anti air)\n" .
                   "- **Ransel Pria Casual Navy Minimalis** — Rp159.000 (Gaya minimalis kasual yang rapi)\n\n" .
                   "👜 **Tas Wanita (Tote, Shoulder, Sling & Clutch):**\n" .
                   "- **Tas Tote Wanita Canvas Krem** — Rp165.000 (Sangat spacious, muat laptop 13\", gaya Skandinavian modern)\n" .
                   "- **Tas Kulit Wanita Shoulder Brown** — Rp210.000 (Kulit sintetis tebal, hardware gold mewah, elegan)\n" .
                   "- **Tas Clutch Wanita Hitam Mewah** — Rp99.000 (Glitter/glossy dengan hardware gold, untuk pesta/malam)\n" .
                   "- **Tas Wanita Sling Mini Elegan** — Rp89.000 (Bahan velvet hijau emerald vintage yang modis)\n\n" .
                   "Koleksi dewasa kami dirancang dengan material berkualitas tinggi untuk kenyamanan dan durabilitas maksimal. Kakak sedang mencari tas untuk keperluan formal atau kasual? 😊";
        }

        // 4. JIKA TANYA SECARA UMUM ATAU CAMPURAN (OVERVIEW KATEGORI)
        return "CikalTas menyediakan berbagai pilihan tas berkualitas yang dikelompokkan berdasarkan kategori usia dan kebutuhan berikut:\n\n" .
               "👶 **1. Anak-anak:**\n" .
               "- Ransel Anak Laki-laki (motif dinosaurus, superhero)\n" .
               "- Ransel Anak Perempuan (motif bunga pink, unicorn)\n\n" .
               "🎓 **2. Kuliah / Mahasiswa:**\n" .
               "- Tas Laptop (Protektif, slot 14\" & 15.6\", port USB)\n" .
               "- Ransel Pria Dewasa (Urban tactical & casual minimalis)\n" .
               "- Tas Selempang (Kasual, trendy & hangout)\n\n" .
               "💼 **3. Dewasa / Kerja:**\n" .
               "- Tas Tote Wanita Canvas Krem (Muat laptop 13\")\n" .
               "- Tas Kulit Shoulder Bag Wanita (Mewah & formal)\n" .
               "- Tas Clutch Pesta (Elegan & eksklusif)\n" .
               "- Tas Selempang & Ransel Laptop Kerja\n\n" .
               "Kakak bisa langsung menanyakan rekomendasi spesifik, misalnya: *\"rekomendasi tas anak\"*, *\"tas untuk kuliah\"*, atau *\"tas untuk kerja dewasa\"*. Cikal siap bantu pilihkan yang paling cocok! 😊";
    }

    /**
     * Jawaban khusus untuk pertanyaan umur anak.
     */
    private function getAgeBasedBackpackReply(string $question, $products): ?string
    {
        if (!Str::contains($question, ['anak', 'tahun', 'usia', 'umur'])) {
            return null;
        }

        if (!preg_match('/\b(\d{1,2})\s*(tahun|thn|th)\b/i', $question, $matches)) {
            return null;
        }

        $age = (int) $matches[1];
        if ($age <= 0 || $age > 18) {
            return null;
        }

        $isMale = Str::contains($question, ['cowok', 'cowo', 'laki-laki', 'laki laki', 'pria']);
        $isFemale = Str::contains($question, ['cewek', 'cewe', 'perempuan', 'wanita']);

        $maleProducts = [];
        $femaleProducts = [];
        foreach ($products as $product) {
            $category = Str::lower($product->category ?? '');
            if (!Str::contains($category, 'ransel anak')) {
                continue;
            }

            $range = $this->extractAgeRangeFromDescription($product->description);
            $matchesAge = false;
            if ($range !== null) {
                [$minAge, $maxAge] = $range;
                $matchesAge = ($age >= $minAge && $age <= $maxAge);
            } else {
                $matchesAge = true;
            }

            if (! $matchesAge) {
                continue;
            }

            if (Str::contains($category, 'laki-laki')) {
                $maleProducts[] = $product;
            }
            if (Str::contains($category, 'perempuan')) {
                $femaleProducts[] = $product;
            }
        }

        if ($isMale && empty($maleProducts)) {
            return "Maaf Kak, untuk usia {$age} tahun belum ada ransel cowok yang cocok di katalog kami saat ini.";
        }
        if ($isFemale && empty($femaleProducts)) {
            return "Maaf Kak, untuk usia {$age} tahun belum ada ransel cewek yang cocok di katalog kami saat ini.";
        }
        if (! $isMale && ! $isFemale && empty($maleProducts) && empty($femaleProducts)) {
            return null;
        }

        $recommendedMale = $maleProducts[0] ?? null;
        $recommendedFemale = $femaleProducts[0] ?? null;

        if ($isMale && $recommendedMale) {
            $price = number_format($recommendedMale->price, 0, ',', '.');
            return "Tas anak umur {$age} tahun saya rekomendasikan {$recommendedMale->name}. {$recommendedMale->category} ini {$recommendedMale->description} Harga Rp{$price}.";
        }

        if ($isFemale && $recommendedFemale) {
            $price = number_format($recommendedFemale->price, 0, ',', '.');
            return "Tas anak umur {$age} tahun saya rekomendasikan {$recommendedFemale->name}. {$recommendedFemale->category} ini {$recommendedFemale->description} Harga Rp{$price}.";
        }

        $reply = "Tas anak umur {$age} tahun saya rekomendasikan untuk tas ini:\n";
        if ($recommendedMale) {
            $price = number_format($recommendedMale->price, 0, ',', '.');
            $reply .= "- Untuk anak laki-laki: {$recommendedMale->name} (Rp{$price}).\n";
        }
        if ($recommendedFemale) {
            $price = number_format($recommendedFemale->price, 0, ',', '.');
            $reply .= "- Untuk anak perempuan: {$recommendedFemale->name} (Rp{$price}).\n";
        }
        $reply .= "\nKalau Kakak mau, Cikal bantu pilihkan yang paling pas lagi ya!";
        return trim($reply);
    }

    private function extractAgeRangeFromDescription(string $description): ?array
    {
        if (preg_match('/(\d{1,2})\s*-\s*(\d{1,2})\s*tahun/i', $description, $matches)) {
            return [(int) $matches[1], (int) $matches[2]];
        }
        if (preg_match('/untuk anak usia\s*(\d{1,2})\s*[-–]?\s*(\d{1,2})\s*tahun/i', $description, $matches)) {
            return [(int) $matches[1], (int) $matches[2]];
        }
        if (preg_match('/untuk anak usia\s*(\d{1,2})\s*tahun/i', $description, $matches)) {
            return [(int) $matches[1], (int) $matches[1]];
        }
        if (preg_match('/anak usia\s*(\d{1,2})\s*tahun/i', $description, $matches)) {
            return [(int) $matches[1], (int) $matches[1]];
        }
        return null;
    }

    private function extractGeminiAnswer(array $data): ?string
    {
        if (empty($data['candidates'][0]['content']) || !is_array($data['candidates'][0]['content'])) {
            return null;
        }

        $answer = '';
        foreach ($data['candidates'][0]['content'] as $content) {
            if (!empty($content['parts']) && is_array($content['parts'])) {
                foreach ($content['parts'] as $part) {
                    if (isset($part['text'])) {
                        $answer .= $part['text'];
                    }
                }
            } elseif (isset($content['text'])) {
                $answer .= $content['text'];
            }
        }

        return trim($answer) ?: null;
    }

    /**
     * Fallback cerdas berdasarkan kata kunci jika API gagal.
     */
    /**
     * Jawaban khusus untuk pertanyaan wilayah / daerah pengiriman.
     * Mengembalikan estimasi waktu pengiriman spesifik berdasarkan kata kunci daerah.
     */
    private function getShippingEstimateReply(string $question): ?string
    {
        $q = Str::lower($question);
        $regions = [
            'jogja' => '2-4 hari kerja',
            'yogyakarta' => '2-4 hari kerja',
            'jakarta' => '1-2 hari kerja',
            'jabar' => '2-4 hari kerja',
            'jawa' => '2-4 hari kerja',
            'bali' => '3-5 hari kerja',
            'kalimantan' => '5-7 hari kerja',
            'sumatra' => '4-6 hari kerja',
            'sulawesi' => '5-7 hari kerja',
            'papua' => '7-10 hari kerja',
        ];
        foreach ($regions as $key => $estimate) {
            if (Str::contains($q, $key)) {
                return "Pengiriman ke {$key} biasanya memakan waktu **{$estimate}** dengan ekspedisi JNE, J&T, atau SiCepat.";
            }
        }
        return null;
    }

    private function getSmartFallback(string $question): string
    {
        $q = Str::lower($question);

        if (Str::contains($q, ['order', 'pesan', 'beli', 'cara order', 'cara beli'])) {
            return "Untuk order Kakak bisa langsung pilih produk di website dan checkout, atau hubungi kami di DM Instagram CikalTas ya! 🛍️";
        }
        if (Str::contains($q, ['ongkir', 'ongkos', 'kirim', 'pengiriman', 'ekspedisi'])) {
            return "Pengiriman kami pakai JNE/J&T/SiCepat Kak, ongkir sesuai berat dan lokasi. Bisa dicek saat checkout ya! 🚚";
        }
        if (Str::contains($q, ['bayar', 'payment', 'transfer', 'rekening', 'cod', 'dana', 'gopay', 'ovo'])) {
            return "Pembayaran bisa via transfer bank, e-wallet (GoPay/OVO/DANA), dan COD untuk area tertentu Kak! 💳";
        }
        if (Str::contains($q, ['retur', 'return', 'tukar', 'refund', 'rusak', 'cacat'])) {
            return "Untuk retur/penukaran produk, silakan hubungi kami di DM Instagram CikalTas dalam 3x24 jam setelah barang diterima ya Kak! 🔄";
        }
        if (Str::contains($q, ['diskon', 'promo', 'sale', 'voucher', 'kode', 'potongan'])) {
            return "Untuk info promo dan diskon terbaru, pantau terus Instagram CikalTas ya Kak! 🎉 Jangan sampai ketinggalan!";
        }
        if (Str::contains($q, ['produk', 'tas', 'model', 'koleksi', 'pilihan'])) {
            return "CikalTas punya banyak koleksi tas kece Kak! 🎒 Cek semua produk kami di halaman produk ya, ada banyak pilihan warna dan model menarik!";
        }

        return "Hai Kakak! 👋 Maaf Cikal belum bisa jawab pertanyaan itu sekarang. Untuk info lebih lanjut, hubungi kami langsung di DM Instagram **CikalTas** ya! 🎒😊";
    }

    /**
     * Jawaban khusus untuk pertanyaan seputar daerah/wilayah cakupan pengiriman.
     */
    private function getShippingRegionReply(string $question): ?string
    {
        $q = Str::lower($question);
        
        if (!Str::contains($q, ['daerah', 'wilayah', 'luar kota', 'luar jawa', 'luar pulau', 'kirim ke', 'ongkir ke', 'cakupan', 'jangkauan', 'area pengiriman', 'ke surabaya', 'ke bandung', 'ke medan', 'ke semarang', 'ke jogja', 'ke bali', 'ke makassar', 'ke kalimantan', 'ke sumatera', 'ke sulawesi', 'kirim paket'])) {
            return null;
        }
        
        return "CikalTas melayani pengiriman ke **seluruh wilayah Indonesia**! 🇮🇩✨\n\n" .
               "Kami bekerja sama dengan berbagai ekspedisi terpercaya seperti JNE, J&T, SiCepat, dan Pos Indonesia untuk memastikan tas pilihan Kakak sampai dengan aman.\n\n" .
               "Khusus untuk daerah **Jakarta dan sekitarnya (Jabodetabek):**\n" .
               "- Tersedia opsi pengiriman *Same-Day* atau *Instant*.\n" .
               "- Gratis Ongkir untuk total pembelian di atas **Rp500.000**!\n\n" .
               "Kakak ingin mengirim tas ke daerah mana? Cikal bisa bantu cek estimasi waktu dan ekspedisi terbaiknya! 😊";
    }

    /**
     * Kirim log ke n8n (opsional, tidak blocking).
     */
    private function logToN8n(string $question, string $answer): void
    {
        $n8nUrl = env('N8N_WEBHOOK_URL');
        if (!$n8nUrl) return;

        try {
            Http::withoutVerifying()->timeout(3)->post($n8nUrl, [
                'question' => $question,
                'reply'    => $answer,
                'source'   => 'cikal-chatbot',
            ]);
        } catch (\Exception $e) {
            // Abaikan error jika n8n tidak aktif
        }
    }
}
