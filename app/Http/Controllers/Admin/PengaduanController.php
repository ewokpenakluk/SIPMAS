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
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan masuk sebagai admin terlebih dahulu untuk mengakses Admin Panel.');
        }

        // Cari pengaduan berdasarkan ID, atau ambil pengaduan terbaru
        $pengaduanModel = null;
        if ($id) {
            $pengaduanModel = Pengaduan::with(['kategori', 'pengguna', 'tanggapan.pengguna'])->find($id);
        }

        if (!$pengaduanModel) {
            $pengaduanModel = Pengaduan::with(['kategori', 'pengguna', 'tanggapan.pengguna'])
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if (!$pengaduanModel) {
            $laporan = [
                'id' => 1,
                'nomor_tiket' => 'ADU-2024-001',
                'nama_pelapor' => 'Budi Santoso',
                'kategori' => 'Infrastruktur & Jalan',
                'tanggal_dilaporkan' => date('d M Y, H:i') . ' WIB',
                'lokasi' => 'Jl. Raya Sagalaherang No. 45',
                'status' => 'menunggu',
                'status_label' => 'Menunggu Verifikasi',
                'deskripsi' => 'Pengaduan sampel belum tersedia.',
                'catatan_admin' => null,
                'bukti_foto' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop',
                'riwayat_perubahan' => [
                    [
                        'judul' => 'Laporan Dibuat',
                        'oleh' => 'Sistem',
                        'waktu' => date('d M Y, H:i') . ' WIB',
                        'state' => 'created',
                    ]
                ]
            ];
            return view('admin.pengaduan.kelola', compact('laporan'));
        }

        // Susun riwayat audit log perubahan dari tanggapan
        $riwayatList = [];
        $riwayatList[] = [
            'judul' => 'Laporan Dibuat oleh Warga',
            'oleh' => $pengaduanModel->nama_pelapor . ' (Pelapor)',
            'waktu' => $pengaduanModel->created_at ? $pengaduanModel->created_at->format('d M Y, H:i') . ' WIB' : '-',
            'state' => 'created',
        ];

        foreach ($pengaduanModel->tanggapan as $t) {
            $riwayatList[] = [
                'judul' => 'Status Diperbarui: ' . strtoupper($t->status_diubah_ke ?? $pengaduanModel->status),
                'oleh' => ($t->pengguna->nama ?? 'Admin') . ' — "' . $t->pesan . '"',
                'waktu' => $t->created_at ? $t->created_at->format('d M Y, H:i') . ' WIB' : '-',
                'state' => 'updated',
            ];
        }

        // Tentukan foto URL (storage atau fallback image)
        $fotoUrl = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800&auto=format&fit=crop';
        if ($pengaduanModel->foto) {
            $fotoUrl = asset('storage/' . $pengaduanModel->foto);
        }

        $laporan = [
            'id' => $pengaduanModel->id,
            'nomor_tiket' => $pengaduanModel->nomor_tiket,
            'nama_pelapor' => $pengaduanModel->nama_pelapor,
            'kategori' => $pengaduanModel->kategori->nama ?? 'Umum',
            'tanggal_dilaporkan' => $pengaduanModel->created_at ? $pengaduanModel->created_at->format('d M Y, H:i') . ' WIB' : date('d M Y, H:i') . ' WIB',
            'lokasi' => $pengaduanModel->lokasi ?? 'Desa Sagalaherang',
            'status' => $pengaduanModel->status,
            'status_label' => ucfirst($pengaduanModel->status),
            'deskripsi' => $pengaduanModel->deskripsi,
            'catatan_admin' => $pengaduanModel->catatan_admin,
            'bukti_foto' => $fotoUrl,
            'riwayat_perubahan' => $riwayatList,
        ];

        return view('admin.pengaduan.kelola', compact('laporan'));
    }

    /**
     * Update status dan kirim tanggapan resmi dari admin.
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan masuk sebagai admin terlebih dahulu.');
        }

        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            return redirect()->back()->with('error', 'Data pengaduan tidak ditemukan.');
        }

        $newStatus = $request->status;
        if ($request->action === 'tolak') {
            $newStatus = 'ditolak';
        }

        $pesanTanggapan = $request->pesan ?? $request->tanggapan;

        $pengaduan->status = $newStatus;
        if (!empty($pesanTanggapan)) {
            $pengaduan->catatan_admin = $pesanTanggapan;

            Tanggapan::create([
                'pengaduan_id' => $pengaduan->id,
                'pengguna_id' => Auth::id(),
                'pesan' => $pesanTanggapan,
                'status_diubah_ke' => $newStatus,
            ]);
        }
        $pengaduan->save();

        return redirect()->back()->with('success', 'Status pengaduan #' . $pengaduan->nomor_tiket . ' dan tanggapan admin berhasil diperbarui!');
    }

    /**
     * Live search pengaduan berdasarkan tiket, nama pelapor, atau judul untuk Admin Panel.
     */
    public function liveSearch(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = trim($request->get('q', ''));
        if (empty($query)) {
            return response()->json([]);
        }

        // Hilangkan simbol # jika ada di awal nomor tiket
        $cleanQuery = ltrim($query, '#');

        $results = Pengaduan::with('kategori')
            ->where(function ($q) use ($cleanQuery, $query) {
                $q->where('nomor_tiket', 'LIKE', "%{$cleanQuery}%")
                  ->orWhere('nama_pelapor', 'LIKE', "%{$query}%")
                  ->orWhere('judul', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($item) {
                $badgeBg = match ($item->status) {
                    'diproses', 'diterima' => 'bg-blue-50 text-blue-700 border-blue-100',
                    'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                    'ditolak' => 'bg-rose-50 text-rose-700 border-rose-100',
                    default => 'bg-amber-50 text-amber-700 border-amber-100',
                };

                return [
                    'id' => $item->id,
                    'nomor_tiket' => '#' . $item->nomor_tiket,
                    'nama_pelapor' => $item->nama_pelapor,
                    'judul' => $item->judul,
                    'kategori' => $item->kategori->nama ?? 'Umum',
                    'status' => ucfirst($item->status),
                    'badge_class' => $badgeBg,
                    'tanggal' => $item->created_at ? $item->created_at->format('d M Y') : '-',
                    'url' => route('admin.pengaduan.show', ['id' => $item->id]),
                ];
            });

        return response()->json($results);
    }
}
