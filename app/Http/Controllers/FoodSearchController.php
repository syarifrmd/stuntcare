<?php

namespace App\Http\Controllers;

use App\Services\FatSecretService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FoodSearchController extends Controller
{
    protected $fatSecretService;

    public function __construct(FatSecretService $fatSecretService)
    {
        $this->fatSecretService = $fatSecretService;
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $page = $request->get('page', 1);
        $maxResults = 40;

        // Cache key based on query and page
        $cacheKey = "fatsecret_search_{$query}_{$page}";

        return Cache::remember($cacheKey, 3600, function () use ($query, $page, $maxResults) {
            return $this->fatSecretService->searchFood($query, $page, $maxResults);
        });
    }

    public function getDetails($foodId)
    {
        // Cache key based on food ID
        $cacheKey = "fatsecret_food_{$foodId}";

        return Cache::remember($cacheKey, 3600, function () use ($foodId) {
            return $this->fatSecretService->getFoodDetails($foodId);
        });
    }

    public function getCategories()
    {
        // Cache categories for a longer time since they don't change often
        return Cache::remember('fatsecret_categories', 86400, function () {
            return $this->fatSecretService->getFoodCategories();
        });
    }
} 