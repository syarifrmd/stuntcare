<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // Menampilkan semua data makanan, dengan filter kategori opsional, pencarian
    public function index(Request $request)
    {
        $query = Food::query();
        $child = null;

        // Only get child if child_id is provided
        if ($request->has('child_id')) {
            $child = Children::where('id', $request->child_id)
                            ->where('user_id', Auth::id())
                            ->first();
        }

        // Filter kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter pencarian nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query->get();

        return view('foods.index', compact('foods', 'child'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        return view('foods.create');
    }

    // Menyimpan data makanan ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required',
            'category'     => 'required',
            'energy'       => 'required|numeric',
            'protein'      => 'required|numeric',
            'fat'          => 'required|numeric',
            'carbohydrate' => 'required|numeric',
            'created_by' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('makanan', 'public');
            $validated['foto'] = $path;
        }

       Food::create($validated);

        return redirect()->route('food.index', ['child_id' => $request->child_id])
            ->with('success', 'Data berhasil disimpan!');
        }
    
        public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return back()->with('success', 'Makanan berhasil dihapus.');
}

    public function searchFatSecret(Request $request)
    {
        $foods = [];
        $error = null;
        
        // Get child if child_id is provided
        $child = null;
        if ($request->has('child_id')) {
            $child = Children::where('id', $request->child_id)
                            ->where('user_id', Auth::id())
                            ->first();
        }
        
        if ($request->has('query') && !empty($request->query)) {
            try {
                $fatSecret = app(\App\Services\FatSecretService::class);
                $query = trim($request->input('query'));
                $result = $fatSecret->searchFood($query, 1, 20);
                
                \Log::info('FatSecret search result (v3)', [
                    'query' => $query,
                    'result' => $result
                ]);
                
                // Check if there's an error in the result
                if (isset($result['error']) && $result['error'] === true) {
                    $error = $result['message'] ?? 'Gagal mengambil data dari FatSecret.';
                    \Log::error('FatSecret search error (v3)', ['error' => $result]);
                } else {
                    // Try to extract foods from different possible structures
                    $extractedFoods = $this->extractFoodsFromResponse($result);
                    
                    if (!empty($extractedFoods)) {
                        $foods = $extractedFoods;
                        \Log::info('FatSecret foods found (v3)', ['count' => count($foods)]);
                    } else {
                        $error = 'Tidak ada hasil ditemukan untuk kata kunci "' . $query . '"';
                        \Log::warning('FatSecret no results (v3)', ['result' => $result]);
                    }
                }
            } catch (\Exception $e) {
                $error = 'Terjadi kesalahan saat mencari makanan: ' . $e->getMessage();
                \Log::error('FatSecret search exception (v3)', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
        
        \Log::info('Controller passing to view (v3)', [
            'foods_count' => count($foods),
            'error' => $error,
            'foods_sample' => array_slice($foods, 0, 2)
        ]);
        
        return view('foods.searchFatSecret', compact('foods', 'error', 'child'));
    }

    /**
     * Extract foods array from various possible response structures
     */
    private function extractFoodsFromResponse($response)
    {
        $foods = [];
        
        // Structure 1: Standard FatSecret structure
        if (isset($response['foods']['food'])) {
            $foodData = $response['foods']['food'];
            // Ensure it's an array (single result comes as object)
            $foods = is_array($foodData) && isset($foodData[0]) ? $foodData : [$foodData];
        }
        // Structure 2: Foods directly in array
        elseif (isset($response['foods']) && is_array($response['foods'])) {
            $foods = $response['foods'];
        }
        // Structure 3: Direct food array (uncommon but possible)
        elseif (isset($response['food']) && is_array($response['food'])) {
            $foods = $response['food'];
        }
        // Structure 4: Response is the foods array itself
        elseif (is_array($response) && !isset($response['error'])) {
            // Check if this looks like a foods array
            if (isset($response[0]['food_name']) || isset($response[0]['food_id'])) {
                $foods = $response;
            }
        }
        
        // Filter and validate food items
        $validFoods = [];
        foreach ($foods as $food) {
            if (is_array($food) && (isset($food['food_name']) || isset($food['food_id']))) {
                $validFoods[] = $food;
            }
        }
        
        \Log::info('Extracted foods', [
            'original_structure' => array_keys($response ?? []),
            'extracted_count' => count($validFoods),
            'first_food_keys' => !empty($validFoods) ? array_keys($validFoods[0]) : []
        ]);
        
        return $validFoods;
    }

public function getFoodDetails(Request $request, \App\Services\FatSecretService $fatSecret)
{
    $request->validate(['food_id' => 'required']);

    try {
        $foodDetail = $fatSecret->getFoodDetails($request->food_id);

        if (isset($foodDetail['error']) && $foodDetail['error'] === true) {
            return response()->json([
                'success' => false,
                'message' => $foodDetail['message'] ?? 'Gagal mengambil detail makanan'
            ], 400);
        }

        if (isset($foodDetail['food'])) {
            $foodData = $foodDetail['food'];
            
            // Process servings data
            $servings = [];
            if (isset($foodData['servings']['serving'])) {
                $servingData = $foodData['servings']['serving'];
                // Ensure servings is always an array
                if (!isset($servingData[0])) {
                    $servingData = [$servingData];
                }
                $servings = $servingData;
            }

            return response()->json([
                'success' => true,
                'food' => [
                    'food_id' => $foodData['food_id'] ?? '',
                    'food_name' => $foodData['food_name'] ?? '',
                    'food_type' => $foodData['food_type'] ?? '',
                    'food_url' => $foodData['food_url'] ?? '',
                    'food_images' => $foodData['food_images'] ?? null,
                    'brand_name' => $foodData['brand_name'] ?? '',
                    'servings' => $servings
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Format data dari FatSecret tidak sesuai'
        ], 400);

    } catch (\Exception $e) {
        \Log::error('Get food details exception', ['exception' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem saat mengambil detail makanan'
        ], 500);
    }
}

public function addFromFatSecret(Request $request, \App\Services\FatSecretService $fatSecret)
{
    $request->validate(['food_id' => 'required']);

    try {
        $foodDetail = $fatSecret->getFoodDetails($request->food_id, 'ID', 'id');

        if (isset($foodDetail['error'])) {
            return back()->with('error', 'Gagal mengambil detail makanan: ' . $foodDetail['message']);
        }

        if (isset($foodDetail['food'])) {
            $foodData = $foodDetail['food'];

            // Mengambil langsung data servings dari API tanpa manipulasi
            $servings = $foodData['servings']['serving'];

            // Pastikan jika hanya ada 1 serving, tetap dijadikan array agar mudah di-loop
            if (!isset($servings[0])) {
                $servings = [$servings];
            }

            foreach ($servings as $servingData) {
                // Nama makanan disertai takaran sesuai data API
                $foodNameWithServing = $foodData['food_name'] . ' - ' . $servingData['serving_description'];

                $categoryMap = [
                    'Brand' => 'Fatsecret', 'Generic' => 'Fatsecret', 'Fruit' => 'Buah',
                    'Vegetable' => 'Sayuran', 'Meat' => 'Lauk Pauk', 'Snack' => 'Camilan',
                    'Staple' => 'Makanan Pokok',
                ];
                $rawCategory = $foodData['food_type'] ?? 'Generic';
                $category = $categoryMap[$rawCategory] ?? 'Fatsecret';

                // Simpan makanan dengan data asli dari API (takaran & kandungan gizi sesuai API)
                $food = Food::firstOrCreate(
                    ['name' => $foodNameWithServing],
                    [
                        'category'     => $category,
                        'energy'       => (float)($servingData['calories'] ?? 0),
                        'protein'      => (float)($servingData['protein'] ?? 0),
                        'fat'          => (float)($servingData['fat'] ?? 0),
                        'carbohydrate' => (float)($servingData['carbohydrate'] ?? 0),
                        'created_by'   => auth()->id(),
                    ]
                );
            }

            return back()->with('success', 'Semua takaran makanan dari "' . $foodData['food_name'] . '" berhasil ditambahkan!');
        }

        return back()->with('error', 'Format data dari FatSecret tidak sesuai.');
    } catch (\Exception $e) {
        \Log::error('Add from FatSecret exception', ['exception' => $e->getMessage()]);
        return back()->with('error', 'Terjadi kesalahan sistem saat menambah makanan.');
    }
}


}
