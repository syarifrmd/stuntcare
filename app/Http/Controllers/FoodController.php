<?php
namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // Menampilkan semua data makanan
    public function index()
    {
        $foods = Food::all();
        $child = Children::where('user_id', Auth::id())->first(); // atau yang sedang dipilih user
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
            'name' => 'required',
            'category' => 'required',
            'energy' => 'numeric',
            'protein' => 'numeric',
            'fat' => 'numeric',
            'carbohydrate' => 'numeric',
        ]);

        Food::create($request->all());

        return redirect()->route('foods.index')->with('success', 'Data berhasil disimpan!');
    }
}
