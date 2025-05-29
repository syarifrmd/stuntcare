<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\DailyIntakeController;
use App\Http\Controllers\LihatProfilController;
use App\Http\Controllers\KonsultasiDokterController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

     // Menampilkan jadwal konsultasi yang tersedia untuk user
    Route::get('/konsultasidokter', [KonsultasiDokterController::class, 'index'])->name('konsultasidokter.index');
    // Menyimpan pemesanan konsultasi oleh user
    Route::post('/konsultasidokter/{id}', [KonsultasiDokterController::class, 'store'])->name('konsultasidokter.store');

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
    
    //Jadwal CRUD
    Route::get('dokter/konsultasi', [DokterController::class, 'indexJadwal'])->name('dokter.konsultasi.index');
    Route::get('dokter/konsultasi/create', [DokterController::class, 'createJadwal'])->name('dokter.konsultasi.create');
    Route::post('konsultasidokter/{id}/book', [KonsultasiDokterController::class, 'book'])->name('konsultasidokter.book');
    Route::post('dokter/konsultasi/{id}/confirm-pemesanan', [DokterController::class, 'confirmPemesananJadwal'])->name('dokter.konsultasi.confirmPemesanan');
    Route::post('dokter/konsultasi', [DokterController::class, 'storeJadwal'])->name('dokter.konsultasi.store');
    Route::get('dokter/konsultasi/{id}/edit', [DokterController::class, 'editJadwal'])->name('dokter.konsultasi.edit');
    Route::put('dokter/konsultasi/{id}', [DokterController::class, 'updateJadwal'])->name('dokter.konsultasi.update');
    Route::delete('dokter/konsultasi/{id}', [DokterController::class, 'destroyJadwal'])->name('dokter.konsultasi.destroy');

    // Artikel (CRUD) 
    Route::get('dokter/artikel', [ArtikelController::class, 'indexDokter'])->name('dokter.artikel.index');
    Route::post('dokter/artikel', [ArtikelController::class, 'createDokter'])->name('dokter.artikel.create');
    Route::get('dokter/artikel/{id}', [ArtikelController::class, 'showDokter'])->name('dokter.artikel.show');
    Route::post('dokter/artikel', [ArtikelController::class, 'storeDokter'])->name('dokter.artikel.store');
    Route::put('dokter/artikel/{artikel}', [ArtikelController::class, 'updateDokter'])->name('dokter.artikel.update');
    Route::delete('dokter/artikel/{artikel}', [ArtikelController::class, 'destroyDokter'])->name('dokter.artikel.destroy');

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


Route::resource('lihatprofile', LihatProfilController::class);


// Route::get('/verify-otp/{id}', [RegisteredUserController::class, 'showOtpForm'])->name('verify.otp.form');
// Route::post('/verify-otp/{id}', [RegisteredUserController::class, 'verifyOtp'])->name('verify.otp');
// Route::get('/verify-otp/{user}', [RegisteredUserController::class, 'showForm'])->name('verify.otp');
// Route::post('/verify-otp/{user}', [RegisteredUserController::class, 'verify']);

Route::get('/verify-otp', [RegisteredUserController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('verify.otp');



