<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman Profil Akun Warga.
     */
    public function index()
    {
        // Proteksi: Akun Admin tidak boleh masuk ke halaman masyarakat
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan mengakses halaman masyarakat. Anda telah dialihkan ke Admin Dashboard.');
        }

        $user = Auth::user();

        // Data sampel warga jika belum login
        $warga = [
            'nama' => $user ? $user->nama : 'Budi Santoso',
            'nik' => $user ? $user->nik : '3213XXXXXXXXXXXX',
            'alamat' => $user ? $user->alamat : 'Jl. Raya Sagalaherang No. 45, RT 02/RW 01',
            'no_hp' => $user ? $user->no_hp : '081234567890',
            'peran' => 'Warga Desa',
            'status' => 'AKTIF',
            'terdaftar_sejak' => '12 Jan 2023',
        ];

        return view('warga.profil', compact('warga'));
    }

    /**
     * Update data profil akun warga.
     */
    public function update(Request $request)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan mengakses halaman masyarakat.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        return back()->with('success', 'Profil Anda telah berhasil diperbarui!');
    }
}
