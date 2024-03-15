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

        $flaggedCategories = [];

        // Assuming each result could contain multiple categories
        if (!empty($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $result) {
                if (!empty($result['flagged'])) {
                    foreach ($result['categories'] as $category => $value) {
                        if ($value === true) {
                            // Add the category to the list if it's flagged
                            $flaggedCategories[$category] = $value;
                        }
                    }
                }
            }
        }

        return ['flagged' => !empty($flaggedCategories), 'categories' => $flaggedCategories];
    } catch (\Exception $e) {
        Log::error('Failed to moderate comment:', ['exception' => $e->getMessage()]);
        return ['flagged' => false, 'categories' => []];
    }
}

}
