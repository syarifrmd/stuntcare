<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FatSecretService
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl = 'https://platform.fatsecret.com/rest/server.api';
    protected $tokenUrl = 'https://oauth.fatsecret.com/connect/token';
    protected $accessToken;

    public function __construct()
    {
        $this->clientId = config('services.fatsecret.client_id');
        $this->clientSecret = config('services.fatsecret.client_secret');
        
        // Debug: Log credentials (remove in production)
        \Log::info('FatSecret credentials', [
            'client_id' => $this->clientId ? 'set' : 'not set',
            'client_secret' => $this->clientSecret ? 'set' : 'not set'
        ]);
        
        $this->accessToken = $this->getAccessToken();
    }

    protected function getAccessToken()
    {
        try {
            $response = Http::asForm()->post($this->tokenUrl, [
                'grant_type' => 'client_credentials',
                'scope' => 'basic',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);
            
            \Log::info('FatSecret token response', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body()
            ]);
            
            if ($response->successful()) {
                $tokenData = $response->json();
                if (isset($tokenData['access_token'])) {
                    \Log::info('FatSecret token obtained successfully', [
                        'token_type' => $tokenData['token_type'] ?? 'unknown',
                        'expires_in' => $tokenData['expires_in'] ?? 'unknown'
                    ]);
                    return $tokenData['access_token'];
                } else {
                    \Log::error('FatSecret token response missing access_token', [
                        'available_keys' => array_keys($tokenData),
                        'response' => $tokenData
                    ]);
                }
            } else {
                \Log::error('FatSecret token request failed', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'body' => $response->body()
                ]);
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::error('FatSecret getAccessToken exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return null;
        }
    }

    /**
     * Test API connection and credentials
     */
    public function testConnection()
    {
        if (!$this->clientId || !$this->clientSecret) {
            return [
                'success' => false,
                'message' => 'FatSecret credentials not configured'
            ];
        }

        if (!$this->accessToken) {
            return [
                'success' => false,
                'message' => 'Failed to obtain access token'
            ];
        }

        // Try a simple search to test the connection
        try {
            $result = $this->searchFood('apple', 1, 1);
            if (isset($result['error'])) {
                return [
                    'success' => false,
                    'message' => 'API test failed: ' . $result['message']
                ];
            }
            
            return [
                'success' => true,
                'message' => 'FatSecret API connection successful'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection test exception: ' . $e->getMessage()
            ];
        }
    }

    public function searchFood($query, $page = 1, $maxResults = 20, $region = 'ID')
    {
        if (!$this->accessToken) {
            \Log::error('FatSecret searchFood: No access token available');
            return [
                'error' => true,
                'message' => 'No access token available. Please check FatSecret credentials.',
                'response' => null,
            ];
        }

        try {
            // FatSecret API expects form data, not JSON
            $params = [
                'method' => 'foods.search',
                'search_expression' => $query,
                'page_number' => $page,
                'max_results' => $maxResults,
                'format' => 'json',
                'locale' => 'id_ID', 
                'region' => $region, 
            ];
            
            \Log::info('FatSecret searchFood request', [
                'params' => $params,
                'token' => substr($this->accessToken, 0, 20) . '...'
            ]);
            
            $response = Http::withToken($this->accessToken)
                ->asForm()
                ->post($this->baseUrl, $params);
                
            \Log::info('FatSecret searchFood response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            if ($response->successful()) {
                $json = $response->json();
                
                // Log the full response structure for debugging
                \Log::info('FatSecret API response structure', [
                    'response_keys' => isset($json) ? array_keys($json) : 'null',
                    'full_response' => $json
                ]);
                
                // Handle different response structures
                if (isset($json['foods'])) {
                    // Case 1: Response has 'foods' key
                    if (isset($json['foods']['food'])) {
                        // Case 1a: foods.food exists (normal structure)
                        \Log::info('FatSecret searchFood: Normal response structure found');
                        return $json;
                    } elseif (is_array($json['foods'])) {
                        // Case 1b: foods is array directly
                        \Log::info('FatSecret searchFood: Foods array structure found');
                        return $json;
                    } else {
                        // Case 1c: foods exists but no food data
                        \Log::warning('FatSecret searchFood: Foods key exists but no food data', [
                            'foods_content' => $json['foods']
                        ]);
                        return [
                            'error' => true,
                            'message' => 'No food data found in response',
                            'response' => $json,
                        ];
                    }
                } elseif (isset($json['error'])) {
                    // Case 2: API returned an error
                    \Log::error('FatSecret API returned error', [
                        'error' => $json['error']
                    ]);
                    return [
                        'error' => true,
                        'message' => 'API Error: ' . ($json['error']['message'] ?? 'Unknown error'),
                        'response' => $json,
                    ];
                } elseif (empty($json) || !is_array($json)) {
                    // Case 3: Empty or invalid response
                    \Log::warning('FatSecret searchFood: Empty or invalid JSON response', [
                        'response_type' => gettype($json),
                        'response' => $json
                    ]);
                    return [
                        'error' => true,
                        'message' => 'Empty or invalid response from FatSecret API',
                        'response' => $json,
                    ];
                } else {
                    // Case 4: Unknown structure
                    \Log::warning('FatSecret searchFood: Unknown response structure', [
                        'response' => $json,
                        'available_keys' => array_keys($json)
                    ]);
                    return [
                        'error' => true,
                        'message' => 'Invalid response structure from FatSecret API',
                        'response' => $json,
                    ];
                }
            }
            
            // Handle HTTP errors
            \Log::error('FatSecret API HTTP error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [
                'error' => true,
                'message' => 'HTTP Error ' . $response->status() . ': Failed to fetch food data from FatSecret API',
                'response' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            \Log::error('FatSecret searchFood exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [
                'error' => true,
                'message' => 'Exception occurred: ' . $e->getMessage(),
                'response' => null,
            ];
        }
    }

    public function getFoodDetails($foodId, $region = 'ID')
    {
        if (!$this->accessToken) {
            return [
                'error' => true,
                'message' => 'No access token available. Please check FatSecret credentials.',
                'response' => null,
            ];
        }

        try {
            $params = [
                'method' => 'food.get',
                'food_id' => $foodId,
                'format' => 'json',
                'locale' => 'id_ID', 
                'region' => $region, 
            ];
            
            $response = Http::withToken($this->accessToken)
                ->asForm()
                ->post($this->baseUrl, $params);
                
            if ($response->successful()) {
                return $response->json();
            }
            
            return [
                'error' => true,
                'message' => 'Failed to fetch food details from FatSecret API',
                'response' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            \Log::error('FatSecret getFoodDetails exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [
                'error' => true,
                'message' => 'Exception occurred: ' . $e->getMessage(),
                'response' => null,
            ];
        }
    }

    public function getFoodCategories($region = 'ID')
    {
        if (!$this->accessToken) {
            return [
                'error' => true,
                'message' => 'No access token available. Please check FatSecret credentials.',
                'response' => null,
            ];
        }

        try {
            $params = [
                'method' => 'food_categories.get',
                'format' => 'json',
                'locale' => 'id_ID', // Set locale to Indonesian
                'region' => $region, // Set region to Indonesia
            ];
            
            $response = Http::withToken($this->accessToken)
                ->asForm()
                ->post($this->baseUrl, $params);
                
            if ($response->successful()) {
                return $response->json();
            }
            
            return [
                'error' => true,
                'message' => 'Failed to fetch food categories from FatSecret API',
                'response' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            \Log::error('FatSecret getFoodCategories exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [
                'error' => true,
                'message' => 'Exception occurred: ' . $e->getMessage(),
                'response' => null,
            ];
        }
    }

    public function foodsSearchV3($query, $page = 0, $maxResults = 20, $region = 'ID', $language = 'id')
    {
        if (!$this->accessToken) {
            \Log::error('FatSecret foodsSearchV3: No access token available');
            return [
                'error' => true,
                'message' => 'No access token available. Please check FatSecret credentials.',
                'response' => null,
            ];
        }

        try {
            $url = 'https://platform.fatsecret.com/rest/foods/search/v3';
            $params = [
                'search_expression' => $query,
                'page_number' => $page, // zero-based
                'max_results' => $maxResults,
                'region' => $region,
                'language' => $language,
                'format' => 'json',
            ];
            
            \Log::info('FatSecret foodsSearchV3 request', [
                'url' => $url,
                'params' => $params,
                'token' => substr($this->accessToken, 0, 20) . '...'
            ]);
            
            $response = Http::withToken($this->accessToken)
                ->get($url, $params);
                
            \Log::info('FatSecret foodsSearchV3 response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            if ($response->successful()) {
                $json = $response->json();
                
                // Check if we have a premier scope error
                if (isset($json['error']) && isset($json['error']['code']) && $json['error']['code'] == 14) {
                    \Log::warning('FatSecret foodsSearchV3: Premier scope required, falling back to v2 API');
                    // Fallback to v2 API
                    return $this->searchFood($query, $page + 1, $maxResults, $region);
                }
                
                // Check if we have a valid response structure
                if (isset($json['foods']) && isset($json['foods']['food'])) {
                    \Log::info('FatSecret foodsSearchV3: Valid response structure found');
                    return $json;
                } elseif (isset($json['foods']) && is_array($json['foods'])) {
                    // Sometimes the food might be directly in foods array
                    \Log::info('FatSecret foodsSearchV3: Foods array found');
                    return $json;
                } else {
                    \Log::warning('FatSecret foodsSearchV3: Invalid response structure', [
                        'response' => $json,
                        'available_keys' => isset($json) ? array_keys($json) : 'null'
                    ]);
                    return [
                        'error' => true,
                        'message' => 'Invalid response structure from FatSecret API v3',
                        'response' => $json,
                    ];
                }
            }
            
            return [
                'error' => true,
                'message' => 'Failed to fetch food data from FatSecret API v3',
                'response' => $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            \Log::error('FatSecret foodsSearchV3 exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [
                'error' => true,
                'message' => 'Exception occurred: ' . $e->getMessage(),
                'response' => null,
            ];
        }
    }
}