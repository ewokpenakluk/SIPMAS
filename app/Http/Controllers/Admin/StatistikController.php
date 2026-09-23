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
        $kategoriId = $request->query('kategori');
        $status = $request->query('status');

        // Base Query untuk filter dinamis
        $baseQuery = Pengaduan::query();

        // 1. Filter Rentang Waktu
        if ($rentangWaktu === 'bulan_ini') {
            $baseQuery->whereYear('created_at', now()->year)
                      ->whereMonth('created_at', now()->month);
        } elseif ($rentangWaktu === 'bulan_lalu') {
            $prevMonth = now()->subMonth();
            $baseQuery->whereYear('created_at', $prevMonth->year)
                      ->whereMonth('created_at', $prevMonth->month);
        } elseif ($rentangWaktu === 'tahun_ini') {
            $baseQuery->whereYear('created_at', now()->year);
        }

        // 2. Filter Kategori
        if (!empty($kategoriId)) {
            $baseQuery->where('kategori_id', $kategoriId);
        }

        // 3. Filter Status
        if (!empty($status)) {
            if ($status === 'diproses') {
                $baseQuery->whereIn('status', ['diproses', 'diterima']);
            } else {
                $baseQuery->where('status', strtolower($status));
            }
        }

        // Hitung Metrik Berdasarkan Filter
        $totalPengaduan = (clone $baseQuery)->count();
        $menungguProses = (clone $baseQuery)->where('status', 'menunggu')->count();
        $sedangDiproses = (clone $baseQuery)->whereIn('status', ['diproses', 'diterima'])->count();
        $selesaiDitangani = (clone $baseQuery)->where('status', 'selesai')->count();
        $resolusiRate = $totalPengaduan > 0 ? round(($selesaiDitangani / $totalPengaduan) * 100) : 0;

        $metrics = [
            'total_pengaduan' => $totalPengaduan,
            'total_growth' => 'Data Terfilter',
            'menunggu_proses' => $menungguProses,
            'menunggu_note' => 'Butuh perhatian',
            'sedang_diproses' => $sedangDiproses,
            'diproses_note' => 'Dalam pengerjaan tim',
            'selesai_ditangani' => $selesaiDitangani,
            'selesai_note' => 'Tingkat resolusi ' . $resolusiRate . '%',
            'resolusi_rate' => 'Tingkat resolusi ' . $resolusiRate . '%',
        ];

        // Query pengaduan list untuk tabel rekapitulasi (Paginate 5 per halaman)
        $detailData = (clone $baseQuery)->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        // Data Kategori dari Database untuk dropdown filter & chart
        $allKategori = \App\Models\Kategori::all();
        $colors = ['#06612B', '#80EE82', '#3B82F6', '#F59E0B', '#94A3B8', '#EC4899'];
        
        // Base Query tanpa filter kategori untuk statistik per kategori
        $kategoriQuery = (clone $baseQuery);
        if (!empty($kategoriId)) {
            $kategoriQuery = Pengaduan::query();
            if ($rentangWaktu === 'bulan_ini') {
                $kategoriQuery->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
            } elseif ($rentangWaktu === 'bulan_lalu') {
                $prevMonth = now()->subMonth();
                $kategoriQuery->whereYear('created_at', $prevMonth->year)->whereMonth('created_at', $prevMonth->month);
            } elseif ($rentangWaktu === 'tahun_ini') {
                $kategoriQuery->whereYear('created_at', now()->year);
            }
            if (!empty($status)) {
                if ($status === 'diproses') {
                    $kategoriQuery->whereIn('status', ['diproses', 'diterima']);
                } else {
                    $kategoriQuery->where('status', strtolower($status));
                }
            }
        }

        $totalKategoriCount = (clone $kategoriQuery)->count();
        $kategoriChart = $allKategori->map(function ($kat, $index) use ($kategoriQuery, $totalKategoriCount, $colors) {
            $count = (clone $kategoriQuery)->where('kategori_id', $kat->id)->count();
            $persen = $totalKategoriCount > 0 ? round(($count / $totalKategoriCount) * 100) : 0;
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
            
            $monthQuery = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
            
            if (!empty($kategoriId)) {
                $monthQuery->where('kategori_id', $kategoriId);
            }

            $masuk = (clone $monthQuery)->count();
            $selesai = (clone $monthQuery)->where('status', 'selesai')->count();

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
            'kategoriId',
            'status',
            'allKategori'
        ));
    }
}
