<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FatSecretService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $baseUrl = 'https://platform.fatsecret.com/rest/server.api';

    public function __construct()
    {
        $this->consumerKey = config('services.fatsecret.consumer_key');
        $this->consumerSecret = config('services.fatsecret.consumer_secret');
    }

    protected function generateOAuthParams($method)
    {
        $params = [
            'oauth_consumer_key' => $this->consumerKey,
            'oauth_nonce' => Str::random(32),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
            'format' => 'json',
            'method' => $method
        ];

        return $params;
    }

    protected function generateSignature($params, $method = 'GET')
    {
        $baseString = $method . '&' . rawurlencode($this->baseUrl) . '&';
        $paramString = http_build_query($params);
        $baseString .= rawurlencode($paramString);

        $key = rawurlencode($this->consumerSecret) . '&';
        $signature = base64_encode(hash_hmac('sha1', $baseString, $key, true));

        return $signature;
    }

    public function searchFood($query, $page = 1, $maxResults = 20)
    {
        $params = $this->generateOAuthParams('foods.search');
        $params['search_expression'] = $query;
        $params['page_number'] = $page;
        $params['max_results'] = $maxResults;

        $params['oauth_signature'] = $this->generateSignature($params);

        $response = Http::get($this->baseUrl, $params);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Failed to fetch food data from FatSecret API'
        ];
    }

    public function getFoodDetails($foodId)
    {
        $params = $this->generateOAuthParams('food.get');
        $params['food_id'] = $foodId;

        $params['oauth_signature'] = $this->generateSignature($params);

        $response = Http::get($this->baseUrl, $params);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Failed to fetch food details from FatSecret API'
        ];
    }

    public function getFoodCategories()
    {
        $params = $this->generateOAuthParams('food_categories.get');

        $params['oauth_signature'] = $this->generateSignature($params);

        $response = Http::get($this->baseUrl, $params);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Failed to fetch food categories from FatSecret API'
        ];
    }
} 