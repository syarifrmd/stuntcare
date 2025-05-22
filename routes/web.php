<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DailyIntakeController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\HomeController;

// Halaman Welcome (public)
// Halaman utama (opsional)
Route::get('/', function () {
    return view('welcome');
});

// Default Breeze dashboard (boleh dihapus jika tidak dipakai)
Route::get('/dashboard', function () {
    return redirect()->route('dashboard.redirect');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route ini menentukan redirect berdasarkan role
Route::get('/redirect', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->intended('/admin'); // default route Filament
    }

    return redirect()->intended('/user/dashboard');
})->middleware(['auth'])->name('dashboard.redirect');

// Dashboard untuk user biasa
Route::middleware(['auth', 'verified'])->group(function () {
    //Route::get('/user/dashboard', function () {
      //  return view('user.dashboard');
    //})->name('user.dashboard');
    Route::get('/user/dashboard', [HomeController::class, 'dashboard'])->name('user.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('artikel', ArtikelController::class);

Route::resource('food', FoodController::class);
Route::resource('pemantauan', PemantauanController::class);
Route::resource('children', ChildrenController::class);

Route::post('/intakes/store-direct', [DailyIntakeController::class, 'storeFromFood'])->name('intakes.storeDirect');


