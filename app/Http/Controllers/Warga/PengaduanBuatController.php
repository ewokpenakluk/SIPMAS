<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanBuatController extends Controller
{
    /**
     * Tampilkan halaman form buat pengaduan baru.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('portal', ['tab' => 'daftar']);
        }

        // Ambil daftar kategori dari database (atau fallback sample)
        $kategoriList = Kategori::all();
        if ($kategoriList->isEmpty()) {
            $kategoriList = collect([
                (object)['id' => 1, 'nama' => 'Infrastruktur & Jalan'],
                (object)['id' => 2, 'nama' => 'Layanan Publik'],
                (object)['id' => 3, 'nama' => 'Keamanan & Ketertiban'],
                (object)['id' => 4, 'nama' => 'Kebersihan & Lingkungan'],
                (object)['id' => 5, 'nama' => 'Lain-lain'],
            ]);
        }

        return view('pengaduan.buat', compact('kategoriList'));
    }

    /**
     * Simpan pengaduan baru yang dikirimkan warga.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('portal', ['tab' => 'daftar']);
        }

        $request->validate([
            'kategori_id' => ['required'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'lokasi' => ['required', 'string'],
            'tanggal_kejadian' => ['required', 'date'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ], [
            'kategori_id.required' => 'Kategori masalah wajib dipilih.',
            'deskripsi.required' => 'Deskripsi masalah wajib diisi.',
            'deskripsi.min' => 'Deskripsi masalah minimal 10 karakter.',
            'lokasi.required' => 'Lokasi / alamat kejadian wajib diisi.',
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'foto.image' => 'File bukti harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        $user = Auth::user();

        $pengaduan = Pengaduan::create([
            'kategori_id' => $request->kategori_id,
            'pengguna_id' => $user ? $user->id : null,
            'nama_pelapor' => $user ? $user->nama : 'Masyarakat Sagalaherang',
            'nik' => $user ? $user->nik : '3213XXXXXXXXXXXX',
            'no_hp' => $user ? $user->no_hp : '081234567890',
            'alamat' => $user ? $user->alamat : 'Desa Sagalaherang',
            'judul' => mb_strimwidth($request->deskripsi, 0, 50, '...'),
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $fotoPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengaduan.lacak', ['tiket' => $pengaduan->nomor_tiket])
            ->with('success', 'Pengaduan berhasil diajukan! Nomor tiket Anda: ' . $pengaduan->nomor_tiket);
    }
}
