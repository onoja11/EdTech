<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenAI;

class ChatController extends Controller
{
    public function generate(Request $request)
    {
           $request->validate([
        'prompt' => 'required|string',
        'lesson_id' => 'required|integer|exists:lessons,id',
    ]);

    $prompt = $request->input('prompt');

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url . '?key=' . env('GEMINI_API_KEY'), [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
        ]);


        if($response){
            Question::create([
                'user_id' => auth()->id(),
                'lesson_id' => $request->input('lesson_id'),
                'question' => $prompt,
                'ai_response' => $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null,
                'response_time' => now(),
            ]);
        }
 $data = $response->json();
 $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        
       

   

    return response()->json($data);  
  }
}
