<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foods;

class FoodController extends Controller
{
    // Menampilkan semua data makanan
    public function index()
    {
        $foods = Foods::all();
        return view('foods.index', compact('foods'));
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
            'name' => 'required',
            'category' => 'required',
            'energy' => 'numeric',
            'protein' => 'numeric',
            'fat' => 'numeric',
            'carbohydrate' => 'numeric',
        ]);

        Foods::create($request->all());

        return redirect()->route('foods.index')->with('success', 'Data berhasil disimpan!');
    }
}
