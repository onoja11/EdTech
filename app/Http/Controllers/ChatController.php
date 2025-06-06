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
        
        // Get the current lesson
        $currentLesson = Lesson::find($lessonId);
        
        // Extract content from current lesson's PDF
        $currentPdfContent = $this->extractPdfContent($currentLesson->content);
        
        // Find recommendations for better lessons
        $recommendations = $this->findRelevantLessons($prompt, $currentLesson);
        
        // Build context-aware prompt with recommendations
        $contextualPrompt = $this->buildContextualPrompt($prompt, $currentPdfContent, $currentLesson, $recommendations);
        
        // Generate AI response
        $aiResponse = $this->callGeminiAPI($contextualPrompt);
        
        // Save the question and response
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
            ],
            'recommendations' => $recommendations
        ]);
    }

    private function findRelevantLessons($userPrompt, $currentLesson)
    {
        // Get all lessons except the current one
        $otherLessons = Lesson::where('id', '!=', $currentLesson->id)
                              ->select('id', 'title', 'subject', 'content')
                              ->get();
        
        $relevantLessons = [];
        $keywords = $this->extractKeywords($userPrompt);
        
        foreach ($otherLessons as $lesson) {
            $relevanceScore = $this->calculateRelevanceScore($userPrompt, $keywords, $lesson);
            
            if ($relevanceScore > 0.3) { // Threshold for relevance
                $relevantLessons[] = [
                    'lesson' => $lesson,
                    'score' => $relevanceScore,
                    'reason' => $this->generateRecommendationReason($userPrompt, $lesson)
                ];
            }
        }
        
        // Sort by relevance score and return top 3
        usort($relevantLessons, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        return array_slice($relevantLessons, 0, 3);
    }

    private function extractKeywords($text)
    {
        // Convert to lowercase and remove punctuation
        $text = strtolower(preg_replace('/[^\w\s]/', ' ', $text));
        
        // Split into words
        $words = preg_split('/\s+/', $text);
        
        // Remove common stop words
        $stopWords = ['the', 'is', 'at', 'which', 'on', 'and', 'a', 'to', 'are', 'as', 'was', 'with', 'for', 'by', 'an', 'be', 'or', 'in', 'that', 'have', 'it', 'not', 'of', 'you', 'what', 'can', 'how', 'why', 'when', 'where', 'do', 'does'];
        
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });
        
        return array_unique($keywords);
    }

    private function calculateRelevanceScore($userPrompt, $keywords, $lesson)
    {
        $score = 0;
        $maxScore = 0;
        
        // Check title relevance (weight: 40%)
        $titleWords = strtolower($lesson->title);
        $titleMatches = 0;
        foreach ($keywords as $keyword) {
            if (strpos($titleWords, $keyword) !== false) {
                $titleMatches++;
            }
        }
        $titleScore = count($keywords) > 0 ? ($titleMatches / count($keywords)) * 0.4 : 0;
        $score += $titleScore;
        $maxScore += 0.4;
        
        // Check subject relevance (weight: 30%)
        $subjectWords = strtolower($lesson->subject);
        $subjectMatches = 0;
        foreach ($keywords as $keyword) {
            if (strpos($subjectWords, $keyword) !== false) {
                $subjectMatches++;
            }
        }
        $subjectScore = count($keywords) > 0 ? ($subjectMatches / count($keywords)) * 0.3 : 0;
        $score += $subjectScore;
        $maxScore += 0.3;
        
        // Check content relevance (weight: 30%)
        $contentText = $this->extractPdfContent($lesson->content);
        if (!empty($contentText)) {
            $contentWords = strtolower($contentText);
            $contentMatches = 0;
            foreach ($keywords as $keyword) {
                if (strpos($contentWords, $keyword) !== false) {
                    $contentMatches++;
                }
            }
            $contentScore = count($keywords) > 0 ? ($contentMatches / count($keywords)) * 0.3 : 0;
            $score += $contentScore;
            $maxScore += 0.3;
        }
        
        return $maxScore > 0 ? $score / $maxScore : 0;
    }

    private function generateRecommendationReason($userPrompt, $lesson)
    {
        $keywords = $this->extractKeywords($userPrompt);
        $reasons = [];
        
        // Check what makes this lesson relevant
        $titleWords = strtolower($lesson->title);
        $subjectWords = strtolower($lesson->subject);
        
        foreach ($keywords as $keyword) {
            if (strpos($titleWords, $keyword) !== false) {
                $reasons[] = "covers '{$keyword}' in the title";
            }
            if (strpos($subjectWords, $keyword) !== false) {
                $reasons[] = "focuses on '{$keyword}' as the main subject";
            }
        }
        
        if (empty($reasons)) {
            return "might provide additional context for your question";
        }
        
        return "This lesson " . implode(' and ', array_unique($reasons));
    }

    private function extractPdfContent($pdfPath)
    {
        try {
            $fullPath = storage_path('app/public/' . $pdfPath);
            
            if (!file_exists($fullPath)) {
                \Log::warning('PDF file not found: ' . $fullPath);
                return '';
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($fullPath);
            $text = $pdf->getText();
            
            // Clean and limit the text (Gemini has token limits)
            $cleanText = $this->cleanText($text);
            return substr($cleanText, 0, 10000); // Limit to ~10000 characters
            
        } catch (\Exception $e) {
            \Log::error('PDF parsing error: ' . $e->getMessage());
            return '';
        }
    }

    private function cleanText($text)
    {
        // Remove extra whitespace and clean up the text
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        // Remove special characters that might cause issues
        $text = preg_replace('/[^\w\s\.\,\!\?\:\;\-\(\)]/', '', $text);
        return $text;
    }

    private function buildContextualPrompt($userPrompt, $pdfContent, $lesson, $recommendations = [])
    {
        $recommendationText = '';
        if (!empty($recommendations)) {
            $recommendationText = "\n\nRELATED LESSONS THAT MIGHT HELP:\n";
            foreach ($recommendations as $rec) {
                $recommendationText .= "- \"{$rec['lesson']->title}\" (Subject: {$rec['lesson']->subject}) - {$rec['reason']}\n";
            }
            $recommendationText .= "\nIf the current lesson doesn't fully address the student's question, mention these related lessons that might provide better explanations.";
        }

        $contextualPrompt = "You are an AI study assistant helping a student understand their lesson content. 

LESSON INFORMATION:
- Title: {$lesson->title}
- Subject: {$lesson->subject}

LESSON CONTENT FROM PDF:
{$pdfContent}

STUDENT'S QUESTION: {$userPrompt}
{$recommendationText}

INSTRUCTIONS:
1. Answer the student's question primarily based on the lesson content provided above
2. If the lesson content doesn't fully address the question, use your general knowledge to provide additional helpful information, but clearly indicate when you're doing so
3. Always relate your answer back to the lesson content when possible
4. Keep your response clear, educational, and encouraging
5. Use examples from the lesson content when explaining concepts
6. If the lesson content is empty or unclear, let the student know and provide a general answer
7. If there are related lessons that might better explain the topic, suggest them to the student with a brief explanation of why they might be helpful

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
                \Log::error('Gemini API error: ' . $response->body());
                return 'Sorry, I encountered an error while processing your question. Please try again.';
            }
            
        } catch (\Exception $e) {
            \Log::error('Gemini API exception: ' . $e->getMessage());
            return 'Sorry, I encountered an error while processing your question. Please try again.';
        }
    }
}