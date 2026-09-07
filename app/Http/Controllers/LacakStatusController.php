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
            $status = strtolower($pengaduanModel->status);
            
            // Riwayat tanggapan terbaru
            $lastTanggapan = $pengaduanModel->tanggapan ? $pengaduanModel->tanggapan->last() : null;
            $adminUser = $lastTanggapan && $lastTanggapan->pengguna ? $lastTanggapan->pengguna : null;
            $adminNama = $adminUser ? $adminUser->nama : 'Tim Admin Desa Sagalaherang';

            $tanggapanPesan = $lastTanggapan && !empty($lastTanggapan->pesan) 
                ? $lastTanggapan->pesan 
                : ($pengaduanModel->catatan_admin ?: 'Pengaduan Anda telah tercatat pada sistem. Tim admin Desa Sagalaherang sedang meninjau dan menindaklanjuti laporan Anda.');
                
            $tanggapanWaktu = $lastTanggapan && $lastTanggapan->created_at 
                ? 'Dibalas pada: ' . $lastTanggapan->created_at->format('d M Y, H:i') . ' WIB' 
                : ($pengaduanModel->catatan_admin ? 'Catatan Resmi Tim Desa' : 'Otomatis oleh Sistem');

            // Susun status badge class
            $badgeStatusClass = match ($status) {
                'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'diproses', 'diterima' => 'bg-blue-50 text-blue-700 border-blue-200',
                'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
                default => 'bg-amber-50 text-amber-700 border-amber-200',
            };

            // Susun 4 langkah timeline dinamis sesuai status database
            $timeline = [
                [
                    'label' => 'Diajukan',
                    'detail' => 'Laporan pengaduan berhasil diterima oleh sistem.',
                    'waktu' => $pengaduanModel->created_at ? $pengaduanModel->created_at->format('d M Y, H:i') . ' WIB' : null,
                    'state' => 'completed',
                ],
                [
                    'label' => 'Diverifikasi',
                    'detail' => $status === 'menunggu' ? 'Laporan sedang dicek oleh admin.' : 'Laporan telah diverifikasi oleh admin.',
                    'waktu' => in_array($status, ['diterima', 'diproses', 'selesai', 'ditolak']) 
                        ? ($pengaduanModel->updated_at ? $pengaduanModel->updated_at->format('d M Y, H:i') . ' WIB' : 'Telah diverifikasi') 
                        : null,
                    'state' => in_array($status, ['diterima', 'diproses', 'selesai', 'ditolak']) ? 'completed' : 'active',
                ],
                [
                    'label' => 'Diproses',
                    'detail' => $status === 'selesai' 
                        ? 'Tindakan penanganan telah selesai dikerjakan.' 
                        : ($status === 'diproses' || $status === 'diterima'
                            ? 'Tindakan penanganan sedang dilakukan oleh tim lapangan.' 
                            : ($status === 'ditolak' ? 'Laporan tidak dapat diproses.' : 'Menunggu giliran pengerjaan lapangan.')),
                    'waktu' => in_array($status, ['diproses', 'selesai']) 
                        ? ($pengaduanModel->updated_at ? $pengaduanModel->updated_at->format('d M Y, H:i') . ' WIB' : null) 
                        : null,
                    'state' => $status === 'selesai' 
                        ? 'completed' 
                        : (in_array($status, ['diproses', 'diterima']) ? 'active' : ($status === 'ditolak' ? 'pending' : 'pending')),
                ],
                [
                    'label' => $status === 'ditolak' ? 'Ditolak' : 'Selesai',
                    'detail' => $status === 'ditolak' 
                        ? 'Pengaduan ditolak atau tidak dapat diproses lebih lanjut.' 
                        : ($status === 'selesai' 
                            ? 'Pengaduan telah berhasil diselesaikan.' 
                            : 'Menunggu penyelesaian akhir laporan.'),
                    'waktu' => in_array($status, ['selesai', 'ditolak']) 
                        ? ($pengaduanModel->updated_at ? $pengaduanModel->updated_at->format('d M Y, H:i') . ' WIB' : null) 
                        : null,
                    'state' => $status === 'selesai' ? 'completed' : ($status === 'ditolak' ? 'rejected' : 'pending'),
                ],
            ];

            $sampleData = [
                'nomor_tiket' => $pengaduanModel->nomor_tiket,
                'kategori' => strtoupper($pengaduanModel->kategori->nama ?? 'UMUM'),
                'status' => $pengaduanModel->status,
                'status_label' => ucfirst($pengaduanModel->status),
                'badge_class' => $badgeStatusClass,
                'judul' => $pengaduanModel->judul,
                'dilaporkan_lalu' => 'Dilaporkan ' . ($pengaduanModel->created_at ? $pengaduanModel->created_at->diffForHumans() : 'baru saja'),
                'deskripsi' => $pengaduanModel->deskripsi,
                'foto' => $pengaduanModel->foto ? asset('storage/' . $pengaduanModel->foto) : null,
                'tanggapan_admin' => $tanggapanPesan,
                'tanggapan_waktu' => $tanggapanWaktu,
                'admin_nama' => $adminNama,
                'timeline' => $timeline,
            ];
        } else {
            $sampleData = [
                'nomor_tiket' => $nomorTiket ?: 'SGH-202310-045',
                'kategori' => 'INFRASTRUKTUR',
                'status' => 'diverifikasi',
                'status_label' => 'Diverifikasi',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
                'judul' => 'Jalan Berlubang di Dusun Krajan',
                'dilaporkan_lalu' => 'Dilaporkan 2 hari lalu',
                'deskripsi' => 'Terdapat jalan berlubang yang cukup dalam di pertigaan dekat balai desa. Sangat membahayakan pengendara motor terutama saat malam hari.',
                'foto' => null,
                'tanggapan_admin' => 'Terima kasih atas laporannya. Saat ini sedang dalam pengecekan lapangan oleh tim infrastruktur desa.',
                'tanggapan_waktu' => 'Dibalas pada: 24 Okt 2023, 10:30 WIB',
                'admin_nama' => 'Admin Desa Sagalaherang',
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
