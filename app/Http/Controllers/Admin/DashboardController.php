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
        $adminUser = Auth::user();

        // Sample data statistik sesuai mockup
        $metrics = [
            'total_masuk' => 142,
            'belum_diverifikasi' => 28,
            'sedang_diproses' => 45,
            'selesai' => 69,
        ];

        // Sample tren pengaduan mingguan (Persentase / Nilai bar)
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
                'tanggal' => '12 Okt 2024',
                'nama_warga' => 'Siti Aminah',
                'kategori' => 'Infrastruktur',
                'badge_class' => 'bg-rose-50 text-rose-600 border-rose-100',
                'tiket' => 'SGH-20241012-001',
            ],
            [
                'tanggal' => '11 Okt 2024',
                'nama_warga' => 'Agus Supriyadi',
                'kategori' => 'Keamanan Lingkungan',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'tiket' => 'SGH-20241011-042',
            ],
            [
                'tanggal' => '10 Okt 2024',
                'nama_warga' => 'Rini Astuti',
                'kategori' => 'Kebersihan',
                'badge_class' => 'bg-rose-50 text-rose-600 border-rose-100',
                'tiket' => 'SGH-20241010-088',
            ],
        ];

        return view('admin.dashboard', compact('adminUser', 'metrics', 'trenMingguan', 'perluVerifikasi'));
    }
}
