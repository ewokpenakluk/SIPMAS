<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    /**
     * Tampilkan halaman kelola / verifikasi pengaduan admin.
     */
    public function show($id = null)
    {
        // Sample data pengaduan sesuai mockup #LAP-2024-089
        $laporan = [
            'id' => $id ?? 1,
            'nomor_tiket' => 'LAP-2024-089',
            'nama_pelapor' => 'Budi Santoso',
            'kategori' => 'Infrastruktur & Jalan',
            'tanggal_dilaporkan' => '24 Okt 2024, 14:30 WIB',
            'lokasi' => 'Jl. Raya Sagalaherang No. 45',
            'status' => 'menunggu', // menunggu, diproses, selesai, ditolak
            'status_label' => 'Menunggu Verifikasi',
            'deskripsi' => 'Terdapat jalan berlubang yang cukup dalam di dekat perempatan pasar desa. Sangat membahayakan pengendara motor terutama saat malam hari karena minimnya penerangan di area tersebut. Mohon segera ditindaklanjuti sebelum ada korban jiwa.',
            'bukti_foto' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop',
            'riwayat_perubahan' => [
                [
                    'judul' => 'Laporan Dibuat',
                    'oleh' => 'Budi Santoso (Pelapor)',
                    'waktu' => '24 Okt 2024, 14:30 WIB',
                    'state' => 'created',
                ],
                [
                    'judul' => 'Status Diperbarui: Menunggu Verifikasi',
                    'oleh' => 'Sistem',
                    'waktu' => '24 Okt 2024, 14:35 WIB',
                    'state' => 'updated',
                ],
            ]
        ];

        return view('admin.pengaduan.kelola', compact('laporan'));
    }

    /**
     * Update status dan kirim tanggapan resmi dari admin.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string'],
            'pesan' => ['nullable', 'string'],
        ]);

        return redirect()->back()->with('success', 'Status pengaduan dan tanggapan admin berhasil disimpan!');
    }
}
