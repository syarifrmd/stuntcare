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
use App\Http\Controllers\DokterController;
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
    elseif ($user->role === 'dokter') {
        return redirect()->intended('/dokter');
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


// Route untuk dokter
Route::middleware(['auth', 'verified'])->group(function () {
    // Route untuk dashboard dokter
    Route::get('/dokter', [DokterController::class, 'dashboard'])->name('dokter.dashboard');
    
    // Konsultasi Dokter (CRUD) 
    Route::get('dokter/konsultasi', [DokterController::class, 'indexKonsultasi'])->name('dokter.konsultasi.index');
    Route::get('dokter/konsultasi/{id}', [DokterController::class, 'showKonsultasi'])->name('dokter.konsultasi.show');
    Route::post('dokter/konsultasi', [DokterController::class, 'storeKonsultasi'])->name('dokter.konsultasi.store');
    Route::put('dokter/konsultasi/{id}', [DokterController::class, 'updateKonsultasi'])->name('dokter.konsultasi.update');
    Route::delete('dokter/konsultasi/{id}', [DokterController::class, 'destroyKonsultasi'])->name('dokter.konsultasi.destroy');
    
    // Artikel (CRUD) 
    Route::get('dokter/artikel', [DokterController::class, 'indexArtikel'])->name('dokter.artikel.index');
    Route::get('dokter/artikel/{id}', [DokterController::class, 'showArtikel'])->name('dokter.artikel.show');
    Route::post('dokter/artikel', [DokterController::class, 'storeArtikel'])->name('dokter.artikel.store');
    Route::put('dokter/artikel/{id}', [DokterController::class, 'updateArtikel'])->name('dokter.artikel.update');
    Route::delete('dokter/artikel/{id}', [DokterController::class, 'destroyArtikel'])->name('dokter.artikel.destroy');
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


