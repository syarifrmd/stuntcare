<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiDokter;

class KonsultasiDokterController extends Controller
{
    public function index()
    {
        $konsultasi = KonsultasiDokter::latest()->paginate(10);
        return view('konsultasidokter.index', compact('konsultasi'));
    }

    public function show(KonsultasiDokter $konsultasi)
    {
        return view('konsultasidokter.show', compact('konsultasi'));
    }
}