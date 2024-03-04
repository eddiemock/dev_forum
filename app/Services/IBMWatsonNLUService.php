<?php
namespace App\Services;

use GuzzleHttp\Client;

class IBMWatsonNLUService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('IBM_WATSON_NLU_URL'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('apikey:' . env('IBM_WATSON_NLU_API_KEY'))
            ]
        ]);
    }

    public function analyzeText($text)
    {
        $response = $this->client->post('/v1/analyze?version=2021-08-01', [
            'json' => [
                'text' => $text,
                'features' => [
                    'sentiment' => new \stdClass(),
                    'entities' => new \stdClass(),
                    'keywords' => new \stdClass(),
                ],
                'language' => 'en'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
