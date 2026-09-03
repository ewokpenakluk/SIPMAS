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
        // Proteksi: Akun Admin tidak boleh masuk ke halaman masyarakat
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan mengakses halaman masyarakat. Anda telah dialihkan ke Admin Dashboard.');
        }

        if (!Auth::check()) {
            return redirect()->route('portal', ['tab' => 'daftar']);
        }

        $search = $request->query('search');
        $statusFilter = $request->query('status');

        $user = Auth::user();

        // Data sampel riwayat pengaduan warga untuk tampilan mockup
        $sampleRiwayat = [
            [
                'nomor_tiket' => '#TKT-20231024-001',
                'raw_tiket' => 'TKT-20231024-001',
                'tanggal' => '24 Okt 2023',
                'judul' => 'Lampu Jalan Mati di Perempatan RT 03',
                'kategori' => 'Infrastruktur',
                'status' => 'diproses',
                'status_label' => 'Diproses',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200/60',
            ],
            [
                'nomor_tiket' => '#TKT-20231015-042',
                'raw_tiket' => 'TKT-20231015-042',
                'tanggal' => '15 Okt 2023',
                'judul' => 'Penumpukan Sampah Liar di Lapangan Desa',
                'kategori' => 'Kebersihan',
                'status' => 'selesai',
                'status_label' => 'Selesai',
                'badge_class' => 'bg-emerald-50 text-[#06612B] border-emerald-200/60',
            ],
            [
                'nomor_tiket' => '#TKT-20231002-088',
                'raw_tiket' => 'TKT-20231002-088',
                'tanggal' => '02 Okt 2023',
                'judul' => 'Permohonan Ronda Malam Tambahan',
                'kategori' => 'Keamanan',
                'status' => 'menunggu',
                'status_label' => 'Menunggu',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200/60',
            ],
        ];

        return view('warga.riwayat', compact('sampleRiwayat', 'search', 'statusFilter'));
    }
}
