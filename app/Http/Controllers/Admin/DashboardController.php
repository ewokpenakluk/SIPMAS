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

        // Tren mingguan
        $trenMingguan = [
            ['hari' => 'Sen', 'nilai' => 35],
            ['hari' => 'Sel', 'nilai' => 60],
            ['hari' => 'Rab', 'nilai' => 25],
            ['hari' => 'Kam', 'nilai' => 95],
            ['hari' => 'Jum', 'nilai' => 70],
            ['hari' => 'Sab', 'nilai' => 45],
            ['hari' => 'Min', 'nilai' => 15],
        ];

        // Ambil pengaduan terbaru dari database yang memerlukan verifikasi
        $latestPengaduan = Pengaduan::with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $perluVerifikasi = $latestPengaduan->map(function ($item) {
            $badgeClass = match ($item->status) {
                'diproses' => 'bg-blue-50 text-blue-700 border-blue-100',
                'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'ditolak' => 'bg-rose-50 text-rose-700 border-rose-100',
                default => 'bg-amber-50 text-amber-700 border-amber-100',
            };

            return [
                'id' => $item->id,
                'nomor_tiket' => $item->nomor_tiket,
                'tiket' => $item->nomor_tiket,
                'tanggal' => $item->created_at ? $item->created_at->format('d M Y') : date('d M Y'),
                'nama_pelapor' => $item->nama_pelapor,
                'nama_warga' => $item->nama_pelapor,
                'kategori' => $item->kategori->nama ?? 'Umum',
                'judul' => $item->judul,
                'status' => strtoupper($item->status),
                'badge_class' => $badgeClass,
            ];
        })->toArray();

        return view('admin.dashboard', compact('adminUser', 'metrics', 'trenMingguan', 'perluVerifikasi'));
    }
}
