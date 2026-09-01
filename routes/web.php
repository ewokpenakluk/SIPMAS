<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LacakStatusController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PortalController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\RiwayatController as WargaRiwayatController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Dashboard Warga (User Terautentikasi / Sample Tampilan)
Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

// Riwayat Pengaduan Warga
Route::get('/riwayat', [WargaRiwayatController::class, 'index'])->name('riwayat');

// Lacak Status Pengaduan
Route::get('/pengaduan/lacak', [LacakStatusController::class, 'index'])->name('pengaduan.lacak');
Route::get('/lacak', [LacakStatusController::class, 'index']);

// Auth Routes (Portal Login & Daftar Toggle)
Route::middleware('guest')->group(function () {
    Route::get('/portal', [PortalController::class, 'index'])->name('portal');
    
    // Rute Login & Register mengarahkan ke portal dengan tab terintegrasi
    Route::get('/login', function () {
        return redirect()->route('portal', ['tab' => 'masuk']);
    })->name('login');
    
    Route::get('/register', function () {
        return redirect()->route('portal', ['tab' => 'daftar']);
    })->name('register');

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('beranda')->with('success', 'Anda telah berhasil keluar.');
})->name('logout');

// Placeholder routes untuk navigasi & fitur warga
Route::get('/profil', function () {
    return view('warga.dashboard');
})->name('profil');

Route::get('/pengaduan/buat', function () {
    return view('warga.dashboard');
})->name('pengaduan.buat');

Route::get('/kontak', function () {
    return view('beranda');
})->name('kontak');

Route::get('/kebijakan-privasi', function () {
    return view('beranda');
})->name('kebijakan-privasi');

Route::get('/bantuan', function () {
    return view('beranda');
})->name('bantuan');
