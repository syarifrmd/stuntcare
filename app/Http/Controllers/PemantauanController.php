<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemantauanController extends Controller
{
    public function index()
    {
        return view('user.pemantauangizi');
    }

    public function create()
    {
        return view('user.pemantauangizi');
    }

    public function store(Request $request)
    {
        return redirect()->route('user.pemantauangizi')->with('success', 'Data berhasil ditambahkan!');
    }
}
