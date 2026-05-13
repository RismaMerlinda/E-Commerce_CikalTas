<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $question = $request->input('message');
        $lowQ = strtolower(trim($question));

        // --- 1. DATA TOKO ---
        $allFaqs = Faq::all();
        $storeData = "";
        foreach ($allFaqs as $f) { $storeData .= "- Q: {$f->question} | A: {$f->answer}\n"; }

        // --- 2. SYSTEM PROMPT (THE HUMAN BRAIN) ---
        $systemPrompt = "Kamu adalah Cikal, admin asisten dari CikalTas. ✨🎒
Bicaralah dengan gaya bahasa manusia yang natural, santai, dan asik. Panggil 'Kakak'.
JANGAN PERNAH pakai template atau kalimat yang diulang-ulang.
Jawablah secara mengalir dan nyambung dengan pertanyaan user.
Gunakan data ini untuk jawaban teknis:
{$storeData}";

        // --- 3. CALL AI (REAL-TIME ENGINE) ---
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";
        
        try {
            $response = Http::withoutVerifying()->timeout(15)->post($url, [
                'contents' => [['parts' => [['text' => $systemPrompt . "\n\nUser: " . $question]]]]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($answer) return Response::json(['reply' => trim($answer)], 200);
            }
            
            // --- 4. ULTIMATE RANDOMIZED FALLBACK (Anti-Template) ---
            // Cari data dengan skor kecocokan tertinggi
            $keywords = collect(explode(' ', str_replace(['?', '!', '.', ','], '', $lowQ)))->filter(fn($w) => strlen($w) > 2)->values();
                
            $match = $allFaqs->map(function($f) use ($keywords) {
                $score = 0;
                $q = strtolower($f->question);
                foreach ($keywords as $word) { if (str_contains($q, $word)) $score += 10; }
                $f->match_score = $score;
                return $f;
            })->sortByDesc('match_score')->first();

            if ($match && $match->match_score >= 10) {
                $ans = $match->answer;
                $openers = [
                    "Oh, kalau soal itu gini Kak... $ans ✨",
                    "Buat yang Kakak tanya, itu $ans. Semoga jelas ya! 😊",
                    "Ini info yang Cikal punya Kak: $ans",
                    "Oke Kak, jadi $ans. Ada lagi yang bikin penasaran?",
                    "Kebetulan Cikal tahu nih! $ans ✨"
                ];
                return Response::json(['reply' => $openers[array_rand($openers)]], 200);
            }

            // Sapaan / Hal Umum
            $randGreet = [
                "Halo Kak! ✨ Seneng banget bisa ketemu Kakak. Mau tanya apa nih soal tas kita?",
                "Hai! 👋 Cikal siap bantu jawab apa aja soal tas keren kita nih. Mau Cikal spill koleksi terbaru?",
                "Halo Kakak! 😊 Ada yang bisa Cikal bantu biar harinya makin kece pake tas baru?",
                "Hai Kak! Cikal standby nih. Lagi cari tas buat acara apa?"
            ];
            return Response::json(['reply' => $randGreet[array_rand($randGreet)]], 200);

        } catch (\Exception $e) {
            return Response::json(['reply' => "Halo Kak! 😊 Cikal tetep standby di sini buat bantu Kakak cari tas impian. Tanya apa aja yuk!"], 200);
        }
    }
}
