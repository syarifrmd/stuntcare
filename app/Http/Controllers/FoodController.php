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
                $query = trim($request->input('query'));
                $result = $fatSecret->searchFood($query, 1, 20);
                \Log::info('FatSecret search result (v2)', [
                    'query' => $query,
                    'result' => $result
                ]);
                if (isset($result['error'])) {
                    $error = $result['message'] ?? 'Gagal mengambil data dari FatSecret.';
                    \Log::error('FatSecret search error (v2)', ['error' => $result]);
                } elseif (isset($result['foods']['food'])) {
                    $foods = is_array($result['foods']['food']) ? $result['foods']['food'] : [$result['foods']['food']];
                    \Log::info('FatSecret foods found (v2)', ['count' => count($foods)]);
                } else {
                    $error = 'Tidak ada hasil ditemukan';
                    \Log::warning('FatSecret no results (v2)', ['result' => $result]);
                }
            } catch (\Exception $e) {
                $error = 'Terjadi kesalahan saat mencari makanan: ' . $e->getMessage();
                \Log::error('FatSecret search exception (v2)', ['exception' => $e]);
            }
        }
        \Log::info('Controller passing to view (v2)', [
            'foods_count' => count($foods),
            'error' => $error,
            'foods_sample' => array_slice($foods, 0, 2)
        ]);
        return view('foods.searchFatSecret', compact('foods', 'error'));
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
