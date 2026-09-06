<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
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

        $totalPengaduan = Pengaduan::count();
        $menungguProses = Pengaduan::where('status', 'menunggu')->count();
        $sedangDiproses = Pengaduan::whereIn('status', ['diproses', 'diterima'])->count();
        $selesaiDitangani = Pengaduan::where('status', 'selesai')->count();

        $metrics = [
            'total_pengaduan' => $totalPengaduan,
            'total_growth' => '+12% dari bulan lalu',
            'menunggu_proses' => $menungguProses,
            'menunggu_note' => 'Butuh perhatian',
            'sedang_diproses' => $sedangDiproses,
            'diproses_note' => 'Dalam pengerjaan tim',
            'selesai_ditangani' => $selesaiDitangani,
            'selesai_note' => 'Tingkat resolusi 85%',
            'resolusi_rate' => 'Tingkat resolusi 85%',
        ];

        // Query pengaduan list untuk tabel rekapitulasi
        $query = Pengaduan::with('kategori')->orderBy('created_at', 'desc');

        if (!empty($status)) {
            $query->where('status', strtolower($status));
        }

        $pengaduanList = $query->get();

        $rekapTable = $pengaduanList->map(function ($item) {
            $badgeClass = match ($item->status) {
                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                'selesai' => 'bg-emerald-50 text-[#06612B] border-emerald-200/60',
                'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                default => 'bg-amber-50 text-amber-700 border-amber-200/60',
            };

            return [
                'id' => '#' . $item->nomor_tiket,
                'raw_id' => $item->id,
                'tanggal' => $item->created_at ? $item->created_at->format('d M Y') : date('d M Y'),
                'pelapor' => $item->nama_pelapor,
                'kategori' => $item->kategori->nama ?? 'Umum',
                'judul' => $item->judul,
                'status' => strtoupper($item->status),
                'badge_class' => $badgeClass,
            ];
        })->toArray();

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
