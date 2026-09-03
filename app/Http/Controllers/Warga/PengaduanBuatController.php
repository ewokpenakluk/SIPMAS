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
        // Proteksi: Akun Admin tidak boleh masuk ke halaman masyarakat
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan mengakses halaman masyarakat. Anda telah dialihkan ke Admin Dashboard.');
        }

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
     * Simpan pengaduan baru dari warga ke database.
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Admin tidak diizinkan membuat pengaduan masyarakat.');
        }

        $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_kejadian' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'kategori_id.required' => 'Silakan pilih kategori pengaduan.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'deskripsi.required' => 'Deskripsi pengaduan wajib diisi.',
            'foto.image' => 'File bukti harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan_foto', 'public');
        }

        $user = Auth::user();

        $pengaduan = Pengaduan::create([
            'kategori_id' => $request->kategori_id,
            'pengguna_id' => $user ? $user->id : null,
            'nama_pelapor' => $user ? $user->nama : 'Warga Sagalaherang',
            'nik' => $user ? ($user->nik ?? '3213000000000000') : '3213000000000000',
            'no_hp' => $user ? ($user->no_hp ?? '081234567890') : '081234567890',
            'alamat' => $user ? ($user->alamat ?? 'Desa Sagalaherang') : 'Desa Sagalaherang',
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $fotoPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('riwayat')
            ->with('success', 'Pengaduan Anda berhasil dikirim dengan Nomor Tiket #' . $pengaduan->nomor_tiket . '! Tim desa akan segera menindaklanjuti.');
    }
}
