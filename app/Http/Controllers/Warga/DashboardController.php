<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman Dashboard Warga (User Login).
     */
    public function index()
    {
        // Ambil nama user login atau default Budi Santoso untuk sampel tampilan
        $user = Auth::user();
        $namaWarga = $user ? $user->nama : 'Budi Santoso';

        // Sampel data ringkasan status & aktivitas terakhir
        $stats = [
            'diterima' => 2,
            'diproses' => 1,
            'selesai' => 5,
            'ditolak' => 0,
        ];

        $aktivitasTerakhir = [
            [
                'judul' => 'Lampu Jalan Mati di RT 03',
                'kategori' => 'Infrastruktur',
                'tanggal' => '12 Okt 2023, 14:30',
                'status' => 'diproses',
            ],
            [
                'judul' => 'Saluran Air Tersumbat',
                'kategori' => 'Lingkungan',
                'tanggal' => '05 Okt 2023, 09:15',
                'status' => 'selesai',
            ],
            [
                'judul' => 'Jalan Berlubang di Dekat Balai Desa',
                'kategori' => 'Infrastruktur',
                'tanggal' => '28 Sep 2023, 11:00',
                'status' => 'selesai',
            ],
        ];

        return view('warga.dashboard', compact('namaWarga', 'stats', 'aktivitasTerakhir'));
    }
}
