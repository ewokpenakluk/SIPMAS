<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Tampilkan halaman statistik & rekapitulasi data admin.
     */
    public function index(Request $request)
    {
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
            'resolusi_rate' => 'Tingkat resolusi 85%',
        ];

        // Sample data tabel detail pengaduan
        $detailData = [
            [
                'id' => '#PGD-0102',
                'raw_id' => 102,
                'tanggal' => '24 Okt 2024',
                'pelapor' => 'Budi Santoso',
                'kategori' => 'Infrastruktur',
                'judul' => 'Jalan berlubang di depan...',
                'status' => 'MENUNGGU',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200',
            ],
            [
                'id' => '#PGD-0101',
                'raw_id' => 101,
                'tanggal' => '22 Okt 2024',
                'pelapor' => 'Siti Aminah',
                'kategori' => 'Layanan Publik',
                'judul' => 'Keterlambatan pencetakan...',
                'status' => 'DIPROSES',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
            ],
            [
                'id' => '#PGD-0100',
                'raw_id' => 100,
                'tanggal' => '20 Okt 2024',
                'pelapor' => 'Agus Pratama',
                'kategori' => 'Lingkungan',
                'judul' => 'Tumpukan sampah liar d...',
                'status' => 'SELESAI',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            ],
        ];

        return view('admin.statistik', compact('rentangWaktu', 'kategori', 'status', 'metrics', 'detailData'));
    }
}
