<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Placeholder routes untuk navigasi & tombol
Route::get('/profil', function () {
    return view('beranda'); // Sementara kembali ke beranda
})->name('profil');

Route::get('/riwayat', function () {
    return view('beranda');
})->name('riwayat');

Route::get('/pengaduan/buat', function () {
    return view('beranda');
})->name('pengaduan.buat');

Route::get('/pengaduan/lacak', function () {
    return view('beranda');
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
