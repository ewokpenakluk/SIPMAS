<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman Dashboard Admin Panel.
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan masuk sebagai admin terlebih dahulu untuk mengakses Admin Panel.');
        }

        $adminUser = Auth::user();

        // Hitung real metrics dari database pengaduan
        $totalMasuk = Pengaduan::count();
        $belumDiverifikasi = Pengaduan::where('status', 'menunggu')->count();
        $sedangDiproses = Pengaduan::whereIn('status', ['diproses', 'diterima'])->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        $metrics = [
            'total_masuk' => $totalMasuk,
            'belum_diverifikasi' => $belumDiverifikasi,
            'sedang_diproses' => $sedangDiproses,
            'selesai' => $selesai,
        ];

        // Tren mingguan dinamis dari database (Senin-Minggu)
        $startOfWeek = now()->startOfWeek();
        $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $trenMingguan = [];

        foreach ($days as $index => $hariLabel) {
            $date = (clone $startOfWeek)->addDays($index);
            $count = Pengaduan::whereDate('created_at', $date->toDateString())->count();
            $trenMingguan[] = [
                'hari' => $hariLabel,
                'nilai' => $count,
            ];
        }

        // Ambil pengaduan terbaru dari database dengan pagination (5 item per halaman)
        $perluVerifikasi = Pengaduan::with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.dashboard', compact('adminUser', 'metrics', 'trenMingguan', 'perluVerifikasi'));
    }
}
