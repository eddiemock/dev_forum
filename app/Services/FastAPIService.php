<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FastAPIService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'http://178.62.9.51';
        $this->apiKey = env('DIGITALOCEAN_API_KEY');
    }

    public function predict($text)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post("{$this->baseUrl}/predict", ['text' => $text]);

            if ($response->successful()) {
                // Log the successful response
                Log::info('Successful prediction from FastAPI.', [
                    'request' => $text,
                    'response' => $response->json(),
                ]);
                
                return $response->json();
            } else {
                // Log unsuccessful responses, including client and server errors
                Log::error('Failed prediction from FastAPI.', [
                    'request' => $text,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                
                return false;
            }
        } catch (\Exception $e) {
            // Log any exceptions that occur during the request
            Log::critical('Exception occurred while making prediction from FastAPI.', [
                'request' => $text,
                'exceptionMessage' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
