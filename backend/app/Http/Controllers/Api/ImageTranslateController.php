<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ImageTranslateController extends Controller
{
    public function analyzeAndTranslate(Request $request)
    {
        try {
            $request->validate([
                'word' => 'required|string',
                'to' => 'required|string'
            ]);

            $word = $request->input('word');
            $to = $request->input('to');

            // API 1 - Prevod
            $translationResponse = Http::withOptions([
                'verify' => false
            ])->get('https://api.mymemory.translated.net/get', [
                'q' => $word,
                'langpair' => 'en|' . $to
            ]);

            if (!$translationResponse->successful()) {
                return response()->json([
                    'error' => 'Translation API failed',
                    'status' => $translationResponse->status(),
                    'response' => $translationResponse->body()
                ], 500);
            }

            $translationData = $translationResponse->json();
            $translation = $translationData['responseData']['translatedText'] ?? '';

            // API 2 - Sinonimi
            $synonymsResponse = Http::withOptions([
                'verify' => false
            ])->get('https://api.datamuse.com/words', [
                'rel_syn' => $word
            ]);

            if (!$synonymsResponse->successful()) {
                return response()->json([
                    'error' => 'Synonyms API failed',
                    'status' => $synonymsResponse->status(),
                    'response' => $synonymsResponse->body()
                ], 500);
            }

            $synonymsData = $synonymsResponse->json();

            $synonyms = collect($synonymsData)
                ->pluck('word')
                ->take(5)
                ->values();

            return response()->json([
                'english_word' => $word,
                'translated_word' => $translation,
                'target_language' => $to,
                'synonyms' => $synonyms,
                'apis_used' => [
                    'MyMemory Translation API',
                    'Datamuse API'
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Server exception',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}