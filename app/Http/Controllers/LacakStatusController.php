<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LacakStatusController extends Controller
{
    /**
     * Tampilkan halaman Lacak Status Pengaduan.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('portal', ['tab' => 'daftar']);
        }

        $nomorTiket = trim($request->query('tiket'));
        $nomorTiketClean = ltrim($nomorTiket, '#');

        $pengaduanModel = null;
        if ($nomorTiketClean) {
            $pengaduanModel = Pengaduan::with(['kategori', 'pengguna', 'tanggapan'])
                ->where('nomor_tiket', $nomorTiketClean)
                ->first();
        }

        if ($pengaduanModel) {
            $timeline = [
                [
                    'label' => 'Diajukan',
                    'detail' => 'Laporan diterima sistem.',
                    'waktu' => $pengaduanModel->created_at ? $pengaduanModel->created_at->format('d M Y, H:i') . ' WIB' : null,
                    'state' => 'completed',
                ],
                [
                    'label' => 'Diverifikasi',
                    'detail' => 'Laporan dicek oleh admin.',
                    'waktu' => $pengaduanModel->status !== 'menunggu' ? 'Telah diverifikasi' : null,
                    'state' => in_array($pengaduanModel->status, ['diterima', 'diproses', 'selesai', 'ditolak']) ? 'completed' : 'active',
                ],
                [
                    'label' => 'Diproses',
                    'detail' => 'Tindakan sedang dilakukan tim.',
                    'waktu' => in_array($pengaduanModel->status, ['diproses', 'selesai']) ? 'Sedang/telah diproses' : null,
                    'state' => $pengaduanModel->status === 'diproses' ? 'active' : (in_array($pengaduanModel->status, ['selesai']) ? 'completed' : 'pending'),
                ],
                [
                    'label' => $pengaduanModel->status === 'ditolak' ? 'Ditolak' : 'Selesai',
                    'detail' => $pengaduanModel->status === 'ditolak' ? 'Pengaduan tidak dapat diproses.' : 'Pengaduan telah diselesaikan.',
                    'waktu' => in_array($pengaduanModel->status, ['selesai', 'ditolak']) ? ($pengaduanModel->updated_at ? $pengaduanModel->updated_at->format('d M Y, H:i') . ' WIB' : null) : null,
                    'state' => in_array($pengaduanModel->status, ['selesai', 'ditolak']) ? 'completed' : 'pending',
                ],
            ];

            $lastTanggapan = $pengaduanModel->tanggapan->last();
            $tanggapanPesan = $lastTanggapan ? $lastTanggapan->pesan : ($pengaduanModel->catatan_admin ?? 'Pengaduan Anda telah diterima oleh sistem. Menunggu penanganan dari tim admin desa.');
            $tanggapanWaktu = $lastTanggapan && $lastTanggapan->created_at ? 'Dibalas pada: ' . $lastTanggapan->created_at->format('d M Y, H:i') . ' WIB' : 'Catatan Tim Desa';

            $sampleData = [
                'nomor_tiket' => $pengaduanModel->nomor_tiket,
                'kategori' => strtoupper($pengaduanModel->kategori->nama ?? 'UMUM'),
                'status' => $pengaduanModel->status,
                'judul' => $pengaduanModel->judul,
                'dilaporkan_lalu' => 'Dilaporkan ' . ($pengaduanModel->created_at ? $pengaduanModel->created_at->diffForHumans() : 'baru saja'),
                'deskripsi' => $pengaduanModel->deskripsi,
                'foto' => $pengaduanModel->foto ? asset('storage/' . $pengaduanModel->foto) : null,
                'tanggapan_admin' => $tanggapanPesan,
                'tanggapan_waktu' => $tanggapanWaktu,
                'timeline' => $timeline,
            ];
        } else {
            $sampleData = [
                'nomor_tiket' => $nomorTiket ?: 'SGH-202310-045',
                'kategori' => 'INFRASTRUKTUR',
                'status' => 'diverifikasi',
                'judul' => 'Jalan Berlubang di Dusun Krajan',
                'dilaporkan_lalu' => 'Dilaporkan 2 hari lalu',
                'deskripsi' => 'Terdapat jalan berlubang yang cukup dalam di pertigaan dekat balai desa. Sangat membahayakan pengendara motor terutama saat malam hari.',
                'foto' => null,
                'tanggapan_admin' => 'Terima kasih atas laporannya. Saat ini sedang dalam pengecekan lapangan oleh tim infrastruktur desa.',
                'tanggapan_waktu' => 'Dibalas pada: 24 Okt 2023, 10:30 WIB',
                'timeline' => [
                    [
                        'label' => 'Diajukan',
                        'detail' => 'Laporan diterima sistem.',
                        'waktu' => '22 Okt 2023, 08:15 WIB',
                        'state' => 'completed',
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
        }

        return view('pengaduan.lacak', compact('nomorTiket', 'pengaduanModel', 'sampleData'));
    }
}
