<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey = 'AIzaSyC6xoyJQ2hvQsyDtH44df794wLlroId4F0';
    protected $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function ask($messages)
    {
        $response = Http::post($this->endpoint.'?key='.$this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $messages]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text') ?? 'Maaf, tidak ada jawaban.';
        }
        return 'Terjadi kesalahan: ' . $response->body();
    }
} 