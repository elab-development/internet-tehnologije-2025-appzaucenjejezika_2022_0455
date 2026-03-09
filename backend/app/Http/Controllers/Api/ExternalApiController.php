<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalApiController extends Controller
{
    public function translate(Request $request)
    {
        $text = $request->text;
        $lang = $request->lang;

        $response = Http::get('https://api.mymemory.translated.net/get', [
            'q' => $text,
            'langpair' => 'en|' . $lang
        ]);

        return response()->json($response->json());
    }

    public function synonyms(Request $request)
    {
        $word = $request->word;

        $response = Http::get('https://api.datamuse.com/words', [
            'rel_syn' => $word
        ]);

        return response()->json($response->json());
    }
}