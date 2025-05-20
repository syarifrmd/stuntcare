<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $artikels = Artikel::with('author')->latest()->paginate(10);

        // Artikel yang dipilih untuk ditampilkan lengkap
        $selectedArtikel = null;
        if ($request->has('selected_id')) {
            $selectedArtikel = Artikel::find($request->input('selected_id'));
        }

        return view('artikel.index', compact('artikels', 'selectedArtikel'));
    }
}
