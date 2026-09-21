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
        // Proteksi: Wajib login untuk mengakses halaman profil
        if (!Auth::check()) {
            return redirect()->route('portal', ['tab' => 'masuk'])
                ->with('error', 'Silakan masuk ke akun Anda terlebih dahulu untuk melihat profil.');
        }

        // Proteksi: Akun Admin tidak boleh masuk ke halaman masyarakat
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan mengakses halaman masyarakat. Anda telah dialihkan ke Admin Dashboard.');
        }

        $user = Auth::user();

        $warga = [
            'nama' => $user->nama,
            'nik' => $user->nik,
            'alamat' => $user->alamat,
            'no_hp' => $user->no_hp,
            'foto_profil' => $user->foto_profil_url,
            'peran' => 'Warga Desa',
            'status' => 'AKTIF',
            'terdaftar_sejak' => $user->created_at ? $user->created_at->format('d M Y') : '12 Jan 2023',
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
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto_profil.image' => 'File foto profil harus berupa gambar.',
            'foto_profil.max' => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        $user = Auth::user();
        if ($user) {
            $dataUpdate = [
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ];

            if ($request->hasFile('foto_profil')) {
                if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
                }
                $path = $request->file('foto_profil')->store('foto_profil', 'public');
                $dataUpdate['foto_profil'] = $path;
            }

            $user->update($dataUpdate);
        }

        return back()->with('success', 'Profil Anda telah berhasil diperbarui!');
    }
}
