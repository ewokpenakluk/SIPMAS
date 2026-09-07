<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        // Hitung data statistik pengaduan secara dinamis
        $totalPengaduan = Pengaduan::count();
        $selesai = Pengaduan::where('status', 'selesai')->count();
        $dalamProses = Pengaduan::whereIn('status', ['menunggu', 'diterima', 'diproses'])->count();

        return view('beranda', compact('totalPengaduan', 'selesai', 'dalamProses'));
    }
}
