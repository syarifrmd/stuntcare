<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
use App\Http\Controllers\DokterProfileController;
use App\Http\Controllers\NotifikasiController;

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
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [HomeController::class, 'dashboard'])->name('user.dashboard');

    // Menampilkan jadwal konsultasi yang tersedia untuk user
    Route::get('/konsultasidokter', [KonsultasiDokterController::class, 'index'])->name('konsultasidokter.index');
    // Menyimpan pemesanan konsultasi oleh user
    Route::post('/konsultasidokter/{id}', [KonsultasiDokterController::class, 'store'])->name('konsultasidokter.store');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // FATSECRET API
    Route::get('/foods/search-fatsecret', [FoodController::class, 'searchFatSecret'])->name('food.searchFatSecret');
    Route::post('/foods/add-fatsecret', [FoodController::class, 'addFromFatSecret'])->name('food.addFromFatSecret');
    Route::post('/foods/get-details', [FoodController::class, 'getFoodDetails'])->name('food.getFoodDetails');


});


Route::get('/pemantauan/histori', [HistoriController::class, 'index'])
    ->name('histori.index')
    ->middleware('auth');
// Route untuk dokter
Route::middleware(['auth', 'verified', 'role:dokter'])->group(function () {
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

    // Doctor Profile Routes
    Route::get('/dokter/profile/edit', [DokterProfileController::class, 'edit'])->name('dokter.profile.edit');
    Route::put('/dokter/profile/update', [DokterProfileController::class, 'update'])->name('dokter.profile.update');
});

// Resource controllers dengan middleware role
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::resource('artikel', ArtikelController::class);
    Route::resource('food', FoodController::class);
    Route::resource('pemantauan', PemantauanController::class);
    Route::resource('children', ChildrenController::class);
    Route::resource('lihatprofile', LihatProfilController::class);
    
    // Daily intake tambahan
    Route::post('/intakes/store-direct', [DailyIntakeController::class, 'storeFromFood'])->name('intakes.storeDirect');
});


// Route untuk admin (Filament)
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });
});

// Auth routes dari Breeze
require __DIR__.'/auth.php';

Route::get('/verify-otp', [RegisteredUserController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('verify.otp');

Route::post('konsultasidokter/{id}/book', [KonsultasiDokterController::class, 'book'])->name('konsultasidokter.book');
    Route::post('dokter/konsultasi/{id}/confirm-pemesanan', [DokterController::class, 'confirmPemesananJadwal'])->name('dokter.konsultasi.confirmPemesanan');

Route::get('/notifikasi', [NotifikasiController::class, 'riwayat'])->name('notifikasi.riwayat');
Route::get('/notifikasi/{id}/read', [NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.read');
Route::post('/notifikasi/read-all', [NotifikasiController::class, 'tandaiSemuaDibaca'])->name('notifikasi.readAll');



