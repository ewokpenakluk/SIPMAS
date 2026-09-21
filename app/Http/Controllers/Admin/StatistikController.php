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
        $resolusiRate = $totalPengaduan > 0 ? round(($selesaiDitangani / $totalPengaduan) * 100) : 0;

        $metrics = [
            'total_pengaduan' => $totalPengaduan,
            'total_growth' => 'Data Real-time',
            'menunggu_proses' => $menungguProses,
            'menunggu_note' => 'Butuh perhatian',
            'sedang_diproses' => $sedangDiproses,
            'diproses_note' => 'Dalam pengerjaan tim',
            'selesai_ditangani' => $selesaiDitangani,
            'selesai_note' => 'Tingkat resolusi ' . $resolusiRate . '%',
            'resolusi_rate' => 'Tingkat resolusi ' . $resolusiRate . '%',
        ];

        // Query pengaduan list untuk tabel rekapitulasi
        $query = Pengaduan::with('kategori')->orderBy('created_at', 'desc');

        if (!empty($status)) {
            $query->where('status', strtolower($status));
        }

        // Pagination: 5 data per halaman
        $pengaduanPaginated = $query->paginate(5)->withQueryString();

        $detailData = $pengaduanPaginated;

        // Hitung Kategori Chart secara dinamis dari database
        $colors = ['#06612B', '#80EE82', '#3B82F6', '#F59E0B', '#94A3B8', '#EC4899'];
        $kategoriList = \App\Models\Kategori::withCount('pengaduan')->get();
        $kategoriChart = $kategoriList->map(function ($kat, $index) use ($totalPengaduan, $colors) {
            $persen = $totalPengaduan > 0 ? round(($kat->pengaduan_count / $totalPengaduan) * 100) : 0;
            return [
                'nama' => $kat->nama,
                'persen' => $persen,
                'warna' => $colors[$index % count($colors)],
            ];
        })->toArray();

        // Hitung Resolution Chart secara dinamis (4 bulan terakhir)
        $resolutionChart = [];
        for ($i = 3; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulanName = $date->format('M');
            $masuk = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $selesai = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'selesai')
                ->count();

            $resolutionChart[] = [
                'bulan' => $bulanName,
                'masuk' => $masuk,
                'selesai' => $selesai,
            ];
        }

        return view('admin.statistik', compact(
            'metrics',
            'detailData',
            'kategoriChart',
            'resolutionChart',
            'rentangWaktu',
            'kategori',
            'status'
        ));
    }
}
