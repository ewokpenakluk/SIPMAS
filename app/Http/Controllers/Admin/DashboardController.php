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

        // Sample data statistik sesuai mockup
        $metrics = [
            'total_masuk' => 142,
            'belum_diverifikasi' => 28,
            'sedang_diproses' => 45,
            'selesai' => 69,
        ];

        // Sample tren pengaduan mingguan
        $trenMingguan = [
            ['hari' => 'Sen', 'nilai' => 35],
            ['hari' => 'Sel', 'nilai' => 60],
            ['hari' => 'Rab', 'nilai' => 25],
            ['hari' => 'Kam', 'nilai' => 95],
            ['hari' => 'Jum', 'nilai' => 70],
            ['hari' => 'Sab', 'nilai' => 45],
            ['hari' => 'Min', 'nilai' => 15],
        ];

        // Sample pengaduan terbaru yang perlu verifikasi
        $perluVerifikasi = [
            [
                'id' => 1,
                'nomor_tiket' => 'LAP-2024-089',
                'tiket' => 'LAP-2024-089',
                'tanggal' => '24 Okt 2024',
                'nama_pelapor' => 'Budi Santoso',
                'nama_warga' => 'Budi Santoso',
                'kategori' => 'Infrastruktur & Jalan',
                'judul' => 'Jalan Berlubang di Dekat Perempatan Pasar',
                'status' => 'MENUNGGU',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            ],
            [
                'id' => 2,
                'nomor_tiket' => 'LAP-2024-088',
                'tiket' => 'LAP-2024-088',
                'tanggal' => '23 Okt 2024',
                'nama_pelapor' => 'Siti Aminah',
                'nama_warga' => 'Siti Aminah',
                'kategori' => 'Layanan Publik',
                'judul' => 'Permohonan Perbaikan Penerangan Jalan RT 03',
                'status' => 'MENUNGGU',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-100',
            ],
            [
                'id' => 3,
                'nomor_tiket' => 'LAP-2024-087',
                'tiket' => 'LAP-2024-087',
                'tanggal' => '22 Okt 2024',
                'nama_pelapor' => 'Agus Supriyadi',
                'nama_warga' => 'Agus Supriyadi',
                'kategori' => 'Kebersihan & Lingkungan',
                'judul' => 'Saluran Drainase Tersumbat Sampah',
                'status' => 'MENUNGGU',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-100',
            ],
        ];

        return view('admin.dashboard', compact('adminUser', 'metrics', 'trenMingguan', 'perluVerifikasi'));
    }
}
