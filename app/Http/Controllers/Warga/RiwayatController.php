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

        // Query pengaduan milik user dari database
        $query = Pengaduan::where('pengguna_id', $user->id)
            ->with('kategori')
            ->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('nomor_tiket', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        if (!empty($statusFilter)) {
            $query->where('status', strtolower($statusFilter));
        }

        $pengaduanList = $query->get();

        // Format data riwayat agar kompatibel dengan template view
        $sampleRiwayat = $pengaduanList->map(function ($item) {
            $badgeClass = match ($item->status) {
                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                'diterima' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                'selesai' => 'bg-emerald-50 text-[#06612B] border-emerald-200/60',
                'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                default => 'bg-amber-50 text-amber-700 border-amber-200/60',
            };

            return [
                'id' => $item->id,
                'nomor_tiket' => '#' . $item->nomor_tiket,
                'raw_tiket' => $item->nomor_tiket,
                'tanggal' => $item->created_at ? $item->created_at->format('d M Y') : date('d M Y'),
                'judul' => $item->judul,
                'kategori' => $item->kategori->nama ?? 'Umum',
                'status' => $item->status,
                'status_label' => ucfirst($item->status),
                'badge_class' => $badgeClass,
                'catatan_admin' => $item->catatan_admin,
            ];
        })->toArray();

        return view('warga.riwayat', compact('sampleRiwayat', 'search', 'statusFilter'));
    }
}
