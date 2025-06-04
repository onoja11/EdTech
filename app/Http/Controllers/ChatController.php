<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'lesson_id' => 'required|integer|exists:lessons,id',
        ]);

        $prompt = $request->input('prompt');
        $lessonId = $request->input('lesson_id');

        // Step 1: Send prompt to Gemini API
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url . '?key=' . env('GEMINI_API_KEY'), [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
        ]);

        $data = $response->json();
        $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        // Step 2: Store the question + AI response
        if ($response->successful() && $answer) {
            Question::create([
                'user_id' => auth()->id(),
                'lesson_id' => $lessonId,
                'question' => $prompt,
                'ai_response' => $answer,
                'response_time' => now(),
            ]);
        }

        // Step 3: Find recommended PDFs related to the prompt
        $keywords = explode(' ', strtolower($prompt));
        $pdfs = Pdf::where('lesson_id', $lessonId)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->orWhere('title', 'like', "%$word%")
                          ->orWhere('description', 'like', "%$word%");
                }
            })
            ->limit(5)
            ->get();

        // Step 4: Return the AI answer and recommended PDFs
        return response()->json([
            'candidates' => $data['candidates'] ?? [],
            'pdfs' => $pdfs
        ]);
    }
}
