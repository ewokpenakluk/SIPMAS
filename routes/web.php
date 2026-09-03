<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LacakStatusController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PortalController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\RiwayatController as WargaRiwayatController;
use App\Http\Controllers\Warga\ProfilController as WargaProfilController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\StatistikController as AdminStatistikController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Dashboard Admin Panel & Admin Login
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin', [AdminDashboardController::class, 'index']);

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

// Kelola Pengaduan Admin
Route::get('/admin/pengaduan/kelola', [AdminPengaduanController::class, 'show'])->name('admin.pengaduan.kelola');
Route::get('/admin/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->name('admin.pengaduan.show');
Route::post('/admin/pengaduan/{id}/update', [AdminPengaduanController::class, 'updateStatus'])->name('admin.pengaduan.update');

// Statistik & Rekapitulasi Data Admin
Route::get('/admin/statistik', [AdminStatistikController::class, 'index'])->name('admin.statistik');

// Dashboard Warga (User Terautentikasi / Sample Tampilan)
Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

// Profil Akun Warga
Route::get('/profil', [WargaProfilController::class, 'index'])->name('profil');
Route::post('/profil', [WargaProfilController::class, 'update'])->name('profil.update');

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
Route::get('/pengaduan/buat', function () {
    if (!Auth::check()) {
        return redirect()->route('portal', ['tab' => 'daftar']);
    }
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
