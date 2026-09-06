<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman Dashboard Warga (User Login).
     */
    public function index()
    {
        // Proteksi: Akun Admin tidak boleh masuk ke halaman masyarakat
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan mengakses halaman masyarakat. Anda telah dialihkan ke Admin Dashboard.');
        }

        $user = Auth::user();
        $namaWarga = $user ? $user->nama : 'Masyarakat Desa';

        if ($user) {
            $userComplaints = Pengaduan::where('pengguna_id', $user->id);

            $stats = [
                'diterima' => (clone $userComplaints)->whereIn('status', ['menunggu', 'diterima'])->count(),
                'diproses' => (clone $userComplaints)->where('status', 'diproses')->count(),
                'selesai' => (clone $userComplaints)->where('status', 'selesai')->count(),
                'ditolak' => (clone $userComplaints)->where('status', 'ditolak')->count(),
            ];

            $recentList = (clone $userComplaints)->with('kategori')->orderBy('created_at', 'desc')->take(5)->get();

            $aktivitasTerakhir = $recentList->map(function ($item) {
                return [
                    'judul' => $item->judul,
                    'kategori' => $item->kategori->nama ?? 'Umum',
                    'tanggal' => $item->created_at ? $item->created_at->format('d M Y, H:i') : date('d M Y, H:i'),
                    'status' => $item->status,
                ];
            })->toArray();
        } else {
            $stats = [
                'diterima' => 0,
                'diproses' => 0,
                'selesai' => 0,
                'ditolak' => 0,
            ];
            $aktivitasTerakhir = [];
        }

        return view('warga.dashboard', compact('namaWarga', 'stats', 'aktivitasTerakhir'));
    }
}
