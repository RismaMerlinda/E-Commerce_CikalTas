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
        $localReply = $this->getLocalReply($question);
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

                $storeData .= "\n=== INFORMASI PENGIRIMAN & EKSPEDISI ===\n";
                $storeData .= "- Ekspedisi yang digunakan: JNE, J&T Express, SiCepat, dan Pos Indonesia.\n";
                $storeData .= "- Estimasi pengiriman reguler secara umum: 2-5 hari kerja (Tergantung lokasi tujuan).\n";
                $storeData .= "- Estimasi spesifik wilayah:\n";
                $storeData .= "  * Jakarta & sekitarnya (Jabodetabek): 1-2 hari kerja.\n";
                $storeData .= "  * Pulau Jawa (luar Jabodetabek seperti Bandung, Jogja, Semarang, Surabaya): 2-4 hari kerja.\n";
                $storeData .= "  * Bali: 3-5 hari kerja.\n";
                $storeData .= "  * Sumatra: 4-6 hari kerja.\n";
                $storeData .= "  * Kalimantan & Sulawesi: 5-7 hari kerja.\n";
                $storeData .= "  * Papua: 7-10 hari kerja.\n";
                $storeData .= "- Karakteristik/Perbandingan Ekspedisi (jika pelanggan bertanya mana yang lebih bagus/cepat/rekomen):\n";
                $storeData .= "  * J&T Express: Populer karena pengirimannya cepat, update resi real-time di sistem, dan kurir aktif mengantar hingga malam.\n";
                $storeData .= "  * JNE: Sangat aman, terpercaya, dan memiliki jangkauan terluas ke wilayah kecamatan hingga pedesaan.\n";
                $storeData .= "  * SiCepat: Terkenal ekonomis/murah namun tetap memiliki kecepatan dan ketepatan waktu yang baik.\n";
                $storeData .= "  * Pos Indonesia: Ekspedisi BUMN dengan harga paling ramah kantong untuk daerah pedalaman atau pelosok tanah air.\n";

                $systemPrompt = "Kamu adalah Cikal, asisten virtual toko tas CikalTas. ✨🎒
Tugasmu HANYA membantu pertanyaan seputar toko CikalTas: produk tas, harga, ukuran, bahan, cara order, pembayaran, pengiriman (ekspedisi/kurir), retur, dan info toko.

ATURAN KETAT:
- Jawab HANYA dengan pesan yang ditujukan langsung kepada pelanggan. JANGAN PERNAH menampilkan outline, draft, catatan internal, atau teks bahasa Inggris (seperti 'Call to action', 'alternative', dll). Langsung berikan jawaban akhirmu.
- SELALU gunakan Bahasa Indonesia yang natural, santai, asik, dan panggil pelanggan 'Kakak'.
- Jika pertanyaan TIDAK berhubungan dengan tas atau toko CikalTas (dan bukan percakapan santai seperti sapaan/terima kasih), TOLAK dengan ramah.
- Jika pelanggan bertanya tentang perbandingan kurir (misalnya bagusan/cepatan mana JNE vs J&T), berikan analisis yang objektif dan membantu berdasarkan data karakteristik ekspedisi yang kami miliki (jangan menjawab kaku, jawablah secara natural).
- Jika pelanggan bertanya tentang CUSTOM TAS (bikin tas custom, pesan desain sendiri), BERIKAN JAWABAN ini:
  'Wah asik banget Kak mau pesan custom tas! ✨ Langsung aja isi detail pesanan Kakak di form ini ya:
  👉 https://forms.gle/Qe4s1K9DhvHVA38Q6
  
  Nanti tim Cikal bakal langsung hubungi Kakak buat ngobrolin desain dan harganya. Ditunggu ya Kak pesenannya! 🥰'
- JANGAN menyuruh pelanggan mencari formulir di website. Selalu berikan link Google Form di atas jika ditanya custom tas.
- JANGAN pakai template kaku selain format link custom tas di atas.

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
                'maxOutputTokens' => 2000,
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
     * Jawaban lokal berbasis keyword sangat sederhana — tidak membajak pertanyaan kompleks.
     */
    private function getLocalReply(string $question): ?string
    {
        $q = Str::lower(trim($question));

        // Sapaan satu kata atau frasa sangat sederhana
        if (in_array($q, ['halo', 'hai', 'hi', 'hei', 'hey', 'p', 'pagi', 'siang', 'sore', 'malam', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'])) {
            return "Halo Kakak! 👋 Selamat datang di CikalTas! 🎒✨ Ada yang bisa Cikal bantu hari ini?";
        }

        // Terima kasih sangat singkat
        if (in_array($q, ['terima kasih', 'makasih', 'thanks', 'thank you', 'thx', 'suwun', 'nuhun'])) {
            return "Sama-sama Kakak! 😊 Senang bisa bantu. Kalau ada pertanyaan lain, Cikal siap membantu ya! 🎒";
        }

        return null;
    }

    private function extractGeminiAnswer(array $data): ?string
    {
        if (empty($data['candidates'][0]['content']['parts']) || !is_array($data['candidates'][0]['content']['parts'])) {
            return null;
        }

        $answer = '';
        foreach ($data['candidates'][0]['content']['parts'] as $part) {
            if (isset($part['text'])) {
                $answer .= $part['text'];
            }
        }

        return trim($answer) ?: null;
    }

    /**
     * Fallback cerdas berdasarkan kata kunci jika API gagal.
     */
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

        return "Hai Kakak! 👋 Maaf Cikal belum bisa jawab pertanyaan itu sekarang. Untuk info lebih lanjut, hubungi langsung melalui chat Admin! 🎒😊";
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
