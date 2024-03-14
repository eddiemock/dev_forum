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
        Log::info('Moderation response:', $data);

        // Default to not flagged
        $flagged = false;

        // Check if there's at least one result and if it's flagged
        if (!empty($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $result) {
                if (!empty($result['flagged'])) {
                    $flagged = true;
                    break; // Stop checking if any result is flagged
                }
            }
        }

        return ['flagged' => $flagged];
    } catch (\Exception $e) {
        Log::error('Failed to moderate comment:', ['exception' => $e->getMessage()]);
        return ['flagged' => false]; // Assume not flagged if there's an error, or handle as needed
    }
}


}
