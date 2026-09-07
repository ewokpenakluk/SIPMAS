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
use App\Http\Controllers\Warga\PengaduanBuatController as WargaPengaduanBuatController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\StatistikController as AdminStatistikController;
use Illuminate\Support\Facades\Auth;

// Halaman Publik (Landing Page Desa)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Auth Routes (Portal Login & Daftar Warga - Khusus Tamu / Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/portal', [PortalController::class, 'index'])->name('portal');
    
    // Rute Login & Register mengarahkan ke portal terpadu
    Route::get('/login', function () {
        return redirect()->route('portal', ['tab' => 'masuk']);
    })->name('login');
    
    Route::get('/register', function () {
        return redirect()->route('portal', ['tab' => 'daftar']);
    })->name('register');

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

    // Login Admin
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login']);
});

// Logout Rute (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('beranda')->with('success', 'Anda telah berhasil keluar.');
    })->name('logout');

    Route::post('/admin/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar dari Admin Panel.');
    })->name('admin.logout');
});

// ==========================================
// RUTE KHUSUS MASYARAKAT / WARGA (WAJIB LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Dashboard Warga
    Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

    // Profil Akun Warga
    Route::get('/profil', [WargaProfilController::class, 'index'])->name('profil');
    Route::post('/profil', [WargaProfilController::class, 'update'])->name('profil.update');

    // Riwayat Pengaduan Warga
    Route::get('/riwayat', [WargaRiwayatController::class, 'index'])->name('riwayat');

    // Form Buat Pengaduan Baru Warga
    Route::get('/pengaduan/buat', [WargaPengaduanBuatController::class, 'create'])->name('pengaduan.buat');
    Route::post('/pengaduan/buat', [WargaPengaduanBuatController::class, 'store'])->name('pengaduan.store');

    // Lacak Status Pengaduan Warga
    Route::get('/pengaduan/lacak', [LacakStatusController::class, 'index'])->name('pengaduan.lacak');
    Route::get('/lacak', [LacakStatusController::class, 'index']);
});

// ==========================================
// RUTE KHUSUS ADMIN PANEL (WAJIB LOGIN ADMIN)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [AdminDashboardController::class, 'index']);

    // Kelola Pengaduan Admin & Live Search
    Route::get('/pengaduan/search/live', [AdminPengaduanController::class, 'liveSearch'])->name('pengaduan.search.live');
    Route::get('/pengaduan/kelola', [AdminPengaduanController::class, 'show'])->name('pengaduan.kelola');
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('/pengaduan/{id}/update', [AdminPengaduanController::class, 'updateStatus'])->name('pengaduan.update');

    // Statistik & Rekapitulasi Data Admin
    Route::get('/statistik', [AdminStatistikController::class, 'index'])->name('statistik');
});

// Placeholder routes informasi publik
Route::get('/kontak', function () {
    return view('beranda');
})->name('kontak');

Route::get('/kebijakan-privasi', function () {
    return view('beranda');
})->name('kebijakan-privasi');

Route::get('/bantuan', function () {
    return view('beranda');
})->name('bantuan');
