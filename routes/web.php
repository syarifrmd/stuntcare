<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\DailyIntakeController;
use App\Http\Controllers\LihatProfilController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsultasiDokterController;

// Halaman Welcome (public)
Route::get('/', function () {
    return view('welcome');
});

// Default Breeze dashboard
Route::get('/dashboard', function () {
    return redirect()->route('dashboard.redirect');
})->middleware(['auth', 'verified'])->name('dashboard');

// Redirect berdasarkan role
Route::get('/redirect', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->intended('/admin'); // Default route Filament
    }

    return redirect()->intended('/user/dashboard');
})->middleware(['auth'])->name('dashboard.redirect');

// Route untuk user biasa
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes dari Breeze
require __DIR__.'/auth.php';

// Resource controllers
Route::resource('artikel', ArtikelController::class);
Route::resource('food', FoodController::class);
Route::resource('pemantauan', PemantauanController::class);
Route::resource('children', ChildrenController::class);
Route::resource('histori', HistoriController::class);

// Daily intake tambahan
Route::post('/intakes/store-direct', [DailyIntakeController::class, 'storeFromFood'])->name('intakes.storeDirect');

// Route untuk Konsultasi Dokter
Route::resource('konsultasi-dokter', KonsultasiDokterController::class)->only([
    'index', 'show'
]);

Route::resource('lihatprofile', LihatProfilController::class);