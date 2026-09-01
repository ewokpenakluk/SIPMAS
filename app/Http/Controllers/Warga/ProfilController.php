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
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:15'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        return redirect()->route('profil')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
