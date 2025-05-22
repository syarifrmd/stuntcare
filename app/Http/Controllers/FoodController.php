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
        $child = Children::where('user_id', Auth::id())->first();

        $query = Food::query();

        //filter kategori
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
        $request->validate([
            'name'         => 'required',
            'category'     => 'required',
            'energy'       => 'numeric',
            'protein'      => 'numeric',
            'fat'          => 'numeric',
            'carbohydrate' => 'numeric',
        ]);

        Food::create($request->all());

        return redirect()->route('food.index')->with('success', 'Data berhasil disimpan!');
    }
}
