<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class LacakStatusController extends Controller
{
    /**
     * Tampilkan halaman Lacak Status Pengaduan.
     */
    public function index(Request $request)
    {
        $nomorTiket = $request->query('tiket');
        $pengaduan = null;

        if ($nomorTiket) {
            $pengaduan = Pengaduan::with(['kategori', 'pengguna', 'tanggapan'])
                ->where('nomor_tiket', $nomorTiket)
                ->first();
        }

        // Data sampel untuk tampilan mockup jika tiket tidak dicari atau belum ada input
        $sampleData = [
            'nomor_tiket' => $nomorTiket ?? 'SGH-202310-045',
            'kategori' => 'INFRASTRUKTUR',
            'status' => 'diverifikasi', // status: diajukan / diterima, diverifikasi, diproses, selesai, ditolak
            'judul' => 'Jalan Berlubang di Dusun Krajan',
            'dilaporkan_lalu' => 'Dilaporkan 2 hari lalu',
            'deskripsi' => 'Terdapat jalan berlubang yang cukup dalam di pertigaan dekat balai desa. Sangat membahayakan pengendara motor terutama saat malam hari dan hujan karena tertutup genangan air. Mohon segera diperbaiki.',
            'tanggapan_admin' => 'Terima kasih atas laporannya. Saat ini sedang dalam pengecekan lapangan oleh tim infrastruktur desa untuk estimasi perbaikan.',
            'tanggapan_waktu' => 'Dibalas pada: 24 Okt 2023, 10:30 WIB',
            'timeline' => [
                [
                    'label' => 'Diajukan',
                    'detail' => 'Laporan diterima sistem.',
                    'waktu' => '22 Okt 2023, 08:15 WIB',
                    'state' => 'completed', // completed, active, pending
                ],
                [
                    'label' => 'Diverifikasi',
                    'detail' => 'Laporan sedang dicek oleh admin.',
                    'waktu' => null,
                    'state' => 'active',
                ],
                [
                    'label' => 'Diproses',
                    'detail' => 'Tindakan sedang dilakukan.',
                    'waktu' => null,
                    'state' => 'pending',
                ],
                [
                    'label' => 'Selesai',
                    'detail' => 'Pengaduan telah diselesaikan.',
                    'waktu' => null,
                    'state' => 'pending',
                ],
            ]
        ];

        return view('pengaduan.lacak', compact('nomorTiket', 'pengaduan', 'sampleData'));
    }
}
