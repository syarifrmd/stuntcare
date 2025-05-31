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
        // Ambil child_id dari query string
    $child_id = $request->child_id;

    // Cari data anak berdasarkan ID dan user yang sedang login
    $child = Children::where('id', $child_id)
                     ->where('user_id', Auth::id())
                     ->firstOrFail(); // lebih aman, akan error 404 jika anak tidak ditemukan

    $query = Food::query();

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

}
