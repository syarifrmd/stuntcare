<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;

class HomeController extends Controller
{
    public function dashboard()
    {
        $articles = Artikel::latest()->take(3)->get();
        return view('user.dashboard', compact('articles'));
    }
}
