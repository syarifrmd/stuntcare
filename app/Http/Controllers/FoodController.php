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
        
        if ($request->has('query') && !empty($request->query)) {
            try {
                $fatSecret = app(\App\Services\FatSecretService::class);
                
                // Ensure we pass the correct parameters
                $query = trim($request->input('query'));
                $region = $request->input('region', 'ID'); // Default to Indonesia
                $language = $request->input('language', 'id'); // Default to Indonesian
                
                // Use the new v3 API for better Indonesian food search
                $result = $fatSecret->foodsSearchV3($query, 0, 20, $region, $language);
                
                \Log::info('FatSecret search result (v3)', [
                    'query' => $query,
                    'region' => $region,
                    'language' => $language,
                    'result' => $result
                ]);
                
                if (isset($result['error'])) {
                    $error = $result['message'];
                    \Log::error('FatSecret search error (v3)', ['error' => $result]);
                } elseif (isset($result['foods']['food'])) {
                    // Handle array of foods
                    $foods = is_array($result['foods']['food']) ? $result['foods']['food'] : [$result['foods']['food']];
                    \Log::info('FatSecret foods found (v3)', ['count' => count($foods)]);
                } else {
                    $error = 'Tidak ada hasil ditemukan';
                    \Log::warning('FatSecret no results (v3)', ['result' => $result]);
                }
            } catch (\Exception $e) {
                $error = 'Terjadi kesalahan saat mencari makanan: ' . $e->getMessage();
                \Log::error('FatSecret search exception (v3)', ['exception' => $e]);
            }
        }
        
        // Debug: Log what we're passing to view
        \Log::info('Controller passing to view (v3)', [
            'foods_count' => count($foods),
            'error' => $error,
            'foods_sample' => array_slice($foods, 0, 2)
        ]);
        
        return view('foods.searchFatSecret', compact('foods', 'error'));
    }

    public function addFromFatSecret(Request $request)
    {
        try {
            $request->validate([
                'food_id' => 'required',
                'food_name' => 'required'
            ]);
            
            $fatSecret = app(\App\Services\FatSecretService::class);
            $region = $request->input('region', 'ID'); // Default to Indonesia
            $language = $request->input('language', 'id'); // Default to Indonesian
            $foodDetail = $fatSecret->getFoodDetails($request->food_id, $region);
            
            if (isset($foodDetail['error'])) {
                return back()->with('error', 'Gagal mengambil detail makanan: ' . $foodDetail['message']);
            }
            
            if (isset($foodDetail['food'])) {
                $food = $foodDetail['food'];
                $nutrient = $food['servings']['serving'][0] ?? [];
                
                // Check if food already exists
                $existingFood = Food::where('name', $food['food_name'])->first();
                if ($existingFood) {
                    return back()->with('error', 'Makanan ini sudah ada di database.');
                }
                
                Food::create([
                    'name' => $food['food_name'],
                    'category' => $food['food_type'] ?? 'FatSecret',
                    'energy' => $nutrient['calories'] ?? 0,
                    'protein' => $nutrient['protein'] ?? 0,
                    'fat' => $nutrient['fat'] ?? 0,
                    'carbohydrate' => $nutrient['carbohydrate'] ?? 0,
                    'created_by' => auth()->id(),
                ]);
                
                return back()->with('success', 'Makanan "' . $food['food_name'] . '" berhasil ditambahkan ke database!');
            }
            
            return back()->with('error', 'Gagal menambah makanan dari FatSecret.');
            
        } catch (\Exception $e) {
            \Log::error('FatSecret addFromFatSecret exception', ['exception' => $e]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
