<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenAiModerationService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ],
        ]);
    }

    public function moderateText($text)
{
    try {
        $response = $this->client->post('v1/moderations', [
            'json' => ['input' => $text],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        Log::info('Moderation response:', $data); // Ensure this logs the detailed response

        return $data;
    } catch (\Exception $e) {
        Log::error('Failed to moderate comment:', ['exception' => $e->getMessage()]);
        return null;
    }
}

}
