<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiDokter;

class KonsultasiDokterController extends Controller
{
    public function index()
    {
        $konsultasis = KonsultasiDokter::latest()->paginate(10);
        return view('konsultasi.index', compact('konsultasis'));
    }

    public function show(KonsultasiDokter $konsultasi)
    {
        return view('konsultasi.show', compact('konsultasi'));
    }
}