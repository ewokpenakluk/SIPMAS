<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Dashboard Warga (User Terautentikasi / Sample Tampilan)
Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

// Auth Routes (Registrasi Warga)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Login Placeholder
    Route::get('/login', function () {
        return view('auth.register');
    })->name('login');
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

Route::get('/riwayat', function () {
    return view('warga.dashboard');
})->name('riwayat');

Route::get('/pengaduan/buat', function () {
    return view('warga.dashboard');
})->name('pengaduan.buat');

Route::get('/pengaduan/lacak', function () {
    return view('warga.dashboard');
})->name('pengaduan.lacak');

Route::get('/kontak', function () {
    return view('beranda');
})->name('kontak');

Route::get('/kebijakan-privasi', function () {
    return view('beranda');
})->name('kebijakan-privasi');

Route::get('/bantuan', function () {
    return view('beranda');
})->name('bantuan');
