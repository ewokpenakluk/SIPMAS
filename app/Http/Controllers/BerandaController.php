<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Hitung data statistik pengaduan secara dinamis
        $totalPengaduan = Pengaduan::count();
        $selesai = Pengaduan::where('status', 'selesai')->count();
        $dalamProses = Pengaduan::whereIn('status', ['menunggu', 'diterima', 'diproses'])->count();

        return view('beranda', compact('totalPengaduan', 'selesai', 'dalamProses'));
    }
}
