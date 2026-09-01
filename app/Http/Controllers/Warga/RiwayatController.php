<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Tampilkan halaman Riwayat Pengaduan Warga.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $statusFilter = $request->query('status');

        $user = Auth::user();

        // Data sampel riwayat pengaduan warga untuk tampilan mockup
        $sampleRiwayat = [
            [
                'nomor_tiket' => '#TKT-20231024-001',
                'raw_tiket' => 'TKT-20231024-001',
                'tanggal' => '24 Okt 2023, 14:30',
                'kategori' => 'Infrastruktur',
                'status' => 'SELESAI',
                'badge_class' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            ],
            [
                'nomor_tiket' => '#TKT-20231025-042',
                'raw_tiket' => 'TKT-20231025-042',
                'tanggal' => '25 Okt 2023, 09:15',
                'kategori' => 'Lingkungan',
                'status' => 'DIPROSES',
                'badge_class' => 'bg-slate-100 text-slate-600 border-slate-200',
            ],
            [
                'nomor_tiket' => '#TKT-20231026-088',
                'raw_tiket' => 'TKT-20231026-088',
                'tanggal' => '26 Okt 2023, 16:45',
                'kategori' => 'Pelayanan Publik',
                'status' => 'MENUNGGU',
                'badge_class' => 'bg-rose-50 text-rose-600 border-rose-100',
            ],
        ];

        return view('warga.riwayat', compact('search', 'statusFilter', 'sampleRiwayat'));
    }
}
