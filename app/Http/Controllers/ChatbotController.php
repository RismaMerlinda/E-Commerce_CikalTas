<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chat request.
     * Expects JSON { "message": "user question" }
     */
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $question = $request->input('message');

        // Simple retrieval from FAQs (RAG)
        $faq = Faq::where('question', 'like', "%{$question}%")
            ->orderBy('created_at', 'desc')
            ->first();

        $context = $faq ? $faq->answer : '';

        $systemPrompt = "Kamu adalah 'Cikal Assistant', asisten virtual yang ramah, sopan, dan sangat membantu dari toko tas premium bernama 'CikalTas'. 
Kamu menggunakan bahasa Indonesia yang santai tapi profesional. 
Toko CikalTas menjual berbagai macam tas berkualitas premium, stylish, modern, dan nyaman digunakan untuk segala aktivitas.
Jika ada pelanggan bertanya tentang produk, harga, atau cara pembelian, jawablah dengan antusias.
Jika pertanyaan di luar konteks tas, fashion, atau layanan toko, tolaklah dengan sopan dengan mengatakan bahwa kamu hanya bisa membantu seputar produk CikalTas.
Panduan cara pemesanan: Pelanggan bisa klik 'Beli Sekarang' atau tambah ke 'Keranjang' lalu checkout.
Jika ada informasi FAQ berikut, gunakan sebagai referensi tambahan: [ {$context} ]";

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return Response::json(['reply' => 'Mohon maaf, sistem AI kami belum dikonfigurasi (GEMINI_API_KEY belum diisi di .env). Silakan hubungi admin.'], 200);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";
        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $question]
                    ]
                ]
            ]
        ];

        try {
            $apiResponse = Http::withoutVerifying()->timeout(30)->post($url, $payload);
            if ($apiResponse->failed()) {
                Log::error('Gemini API error', ['status' => $apiResponse->status(), 'body' => $apiResponse->body()]);
                return Response::json(['reply' => 'Maaf, saya sedang mengalami gangguan koneksi. Silakan coba lagi nanti.'], 200);
            }
            $data = $apiResponse->json();
            
            // Check for valid response structure
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $answer = $data['candidates'][0]['content']['parts'][0]['text'];
            } else {
                Log::error('Unexpected Gemini Response', ['response' => $data]);
                $answer = 'Maaf, saya tidak mengerti maksud Anda. Bisa tolong ulangi?';
            }
            
            return Response::json(['reply' => trim($answer)], 200);
        } catch (\Exception $e) {
            Log::error('Gemini request exception', ['message' => $e->getMessage()]);
            return Response::json(['reply' => 'Maaf, terjadi kesalahan pada server kami saat memproses pesan Anda.'], 200);
        }
    }
}
?>
