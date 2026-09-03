<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatistikController extends Controller
{
    /**
     * Tampilkan halaman statistik & rekapitulasi data admin.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan masuk sebagai admin terlebih dahulu untuk mengakses Admin Panel.');
        }

        $rentangWaktu = $request->query('rentang', 'bulan_ini');
        $kategori = $request->query('kategori');
        $status = $request->query('status');

        // Sample metrics data
        $metrics = [
            'total_pengaduan' => 142,
            'total_growth' => '+12% dari bulan lalu',
            'menunggu_proses' => 28,
            'menunggu_note' => 'Butuh perhatian',
            'sedang_diproses' => 45,
            'diproses_note' => 'Dalam pengerjaan tim',
            'selesai_ditangani' => 69,
            'selesai_note' => 'Tingkat resolusi 85%',
            'resolusi_rate' => 'Tingkat resolusi 85%',
        ];

        // Sample data tabel detail pengaduan
        $rekapTable = [
            [
                'id' => '#PGD-0102',
                'raw_id' => 102,
                'tanggal' => '24 Okt 2024',
                'pelapor' => 'Budi Santoso',
                'kategori' => 'Infrastruktur',
                'judul' => 'Jalan berlubang di depan pasar...',
                'status' => 'MENUNGGU',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200/60',
            ],
            [
                'id' => '#PGD-0101',
                'raw_id' => 101,
                'tanggal' => '23 Okt 2024',
                'pelapor' => 'Siti Aminah',
                'kategori' => 'Layanan Publik',
                'judul' => 'Permohonan perbaikan lampu jalan...',
                'status' => 'DIPROSES',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200/60',
            ],
            [
                'id' => '#PGD-0100',
                'raw_id' => 100,
                'tanggal' => '22 Okt 2024',
                'pelapor' => 'Agus Supriyadi',
                'kategori' => 'Keamanan',
                'judul' => 'Pos ronda butuh perbaikan perabotan...',
                'status' => 'SELESAI',
                'badge_class' => 'bg-emerald-50 text-[#06612B] border-emerald-200/60',
            ],
        ];

        $detailData = $rekapTable;

        // Sample Kategori Donut Chart
        $kategoriChart = [
            ['nama' => 'Infrastruktur & Jalan', 'persen' => 45, 'warna' => '#06612B'],
            ['nama' => 'Layanan Publik', 'persen' => 25, 'warna' => '#80EE82'],
            ['nama' => 'Keamanan & Ketertiban', 'persen' => 15, 'warna' => '#3B82F6'],
            ['nama' => 'Kebersihan & Lingkungan', 'persen' => 10, 'warna' => '#F59E0B'],
            ['nama' => 'Lainnya', 'persen' => 5, 'warna' => '#94A3B8'],
        ];

        // Sample Resolution Chart
        $resolutionChart = [
            ['bulan' => 'Jul', 'masuk' => 30, 'selesai' => 25],
            ['bulan' => 'Agu', 'masuk' => 40, 'selesai' => 38],
            ['bulan' => 'Sep', 'masuk' => 35, 'selesai' => 32],
            ['bulan' => 'Okt', 'masuk' => 45, 'selesai' => 41],
        ];

        return view('admin.statistik', compact(
            'metrics',
            'detailData',
            'rekapTable',
            'kategoriChart',
            'resolutionChart',
            'rentangWaktu',
            'kategori',
            'status'
        ));
    }
}
