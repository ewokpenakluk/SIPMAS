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

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// ==========================================
// RUTE ADMIN PANEL (TERSTRUKTUR & TERTATA)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Auth Login Admin
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    // Admin Authenticated Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Kelola & Verifikasi Pengaduan
        Route::get('/pengaduan/kelola', [AdminPengaduanController::class, 'show'])->name('pengaduan.kelola');
        Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
        Route::post('/pengaduan/{id}/update', [AdminPengaduanController::class, 'updateStatus'])->name('pengaduan.update');
        
        // Rekapitulasi Data & Statistik
        Route::get('/statistik', [AdminStatistikController::class, 'index'])->name('statistik');
    });

});

// ==========================================
// RUTE WARGA / MASYARAKAT
// ==========================================
Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
Route::get('/profil', [WargaProfilController::class, 'index'])->name('profil');
Route::post('/profil', [WargaProfilController::class, 'update'])->name('profil.update');
Route::get('/riwayat', [WargaRiwayatController::class, 'index'])->name('riwayat');
Route::get('/pengaduan/buat', [WargaPengaduanBuatController::class, 'create'])->name('pengaduan.buat');
Route::post('/pengaduan/buat', [WargaPengaduanBuatController::class, 'store'])->name('pengaduan.store');
Route::get('/pengaduan/lacak', [LacakStatusController::class, 'index'])->name('pengaduan.lacak');
Route::get('/lacak', [LacakStatusController::class, 'index']);

// Auth Routes Warga (Portal Login & Daftar Toggle)
Route::middleware('guest')->group(function () {
    Route::get('/portal', [PortalController::class, 'index'])->name('portal');
    
    Route::get('/login', function () {
        return redirect()->route('portal', ['tab' => 'masuk']);
    })->name('login');
    
    Route::get('/register', function () {
        return redirect()->route('portal', ['tab' => 'daftar']);
    })->name('register');

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout User / Admin
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('beranda')->with('success', 'Anda telah berhasil keluar.');
})->name('logout');

// Footer & Static Info Routes
Route::get('/kontak', function () {
    return view('beranda');
})->name('kontak');

Route::get('/kebijakan-privasi', function () {
    return view('beranda');
})->name('kebijakan-privasi');

Route::get('/bantuan', function () {
    return view('beranda');
})->name('bantuan');
