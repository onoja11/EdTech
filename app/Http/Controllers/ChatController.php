<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

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
        
        $currentLesson = Lesson::find($lessonId);
        
        $currentPdfContent = $this->extractPdfContent($currentLesson->content);
        
        $contextualPrompt = $this->buildContextualPrompt($prompt, $currentPdfContent, $currentLesson);
        $aiResponse = $this->callGeminiAPI($contextualPrompt);
        
        Question::create([
            'user_id' => auth()->id(),
            'lesson_id' => $lessonId,
            'question' => $prompt,
            'ai_response' => $aiResponse,
            'response_time' => now(),
        ]);

        return response()->json([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            ['text' => $aiResponse]
                        ]
                    ]
                ]
            ]
        ]);
    }

    private function extractPdfContent($pdfPath)
    {
        try {
            $fullPath = storage_path('app/public/' . $pdfPath);
            
            if (!file_exists($fullPath)) {
                return '';
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($fullPath);
            $text = $pdf->getText();
            
            $cleanText = $this->cleanText($text);
            return substr($cleanText, 0, 10000); 
            
        } catch (\Exception $e) {
            return '';
        }
    }

    private function cleanText($text)
    {
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        $text = preg_replace('/[^\w\s\.\,\!\?\:\;\-\(\)]/', '', $text);
        return $text;
    }

    private function buildContextualPrompt($userPrompt, $pdfContent, $lesson)
    {
        $contextualPrompt = "You are an AI study assistant helping a student understand their lesson content. 

LESSON INFORMATION:
- Title: {$lesson->title}
- Subject: {$lesson->subject}

LESSON CONTENT FROM PDF:
{$pdfContent}

STUDENT'S QUESTION: {$userPrompt}

INSTRUCTIONS:
1. Answer the student's question primarily based on the lesson content provided above
2. If the lesson content doesn't fully address the question, use your general knowledge to provide additional helpful information, but clearly indicate when you're doing so
3. Always relate your answer back to the lesson content when possible
4. Keep your response clear, educational, and encouraging
5. Use examples from the lesson content when explaining concepts
6. If the lesson content is empty or unclear, let the student know and provide a general answer

Please provide a comprehensive and helpful answer based on the lesson material:";

        return $contextualPrompt;
    }

    private function callGeminiAPI($prompt)
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        
        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url . '?key=' . env('GEMINI_API_KEY'), [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1500,
                    'topP' => 0.8,
                    'topK' => 40
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I couldn\'t generate a response at this time.';
            } else {
                return 'Sorry, I encountered an error while processing your question. Please try again.';
            }
            
        } catch (\Exception $e) {
            return 'Sorry, I encountered an error while processing your question. Please try again.';
        }
    }
}