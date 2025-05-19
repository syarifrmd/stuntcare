<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;

// Halaman utama (opsional)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk fitur makanan
Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/create', [FoodController::class, 'create'])->name('foods.create');
Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
