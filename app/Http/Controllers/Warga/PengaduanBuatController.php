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

        // Ambil daftar kategori dari database
        $kategoriList = Kategori::all();
        if ($kategoriList->isEmpty()) {
            $kategoriList = collect([
                (object)['id' => 1, 'nama' => 'Infrastruktur & Jalan'],
                (object)['id' => 2, 'nama' => 'Pelayanan Publik'],
                (object)['id' => 3, 'nama' => 'Keamanan & Ketertiban'],
                (object)['id' => 4, 'nama' => 'Kebersihan & Lingkungan'],
                (object)['id' => 5, 'nama' => 'Lain-lain'],
            ]);
        }

        // Hitung pengaduan user dalam 7 hari terakhir (1 minggu)
        $user = Auth::user();
        $pengaduanMingguIni = Pengaduan::where('pengguna_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $kuotaTersisa = max(0, 3 - $pengaduanMingguIni);

        return view('pengaduan.buat', compact('kategoriList', 'pengaduanMingguIni', 'kuotaTersisa'));
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

        if (!Auth::check()) {
            return redirect()->route('portal', ['tab' => 'masuk']);
        }

        $user = Auth::user();

        // Validasi kuota maksimal 3 pengaduan per 1 minggu (7 hari)
        $pengaduanMingguIni = Pengaduan::where('pengguna_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        if ($pengaduanMingguIni >= 3) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Batas kuota pengaduan tercapai! Setiap akun warga hanya dapat mengirim maksimal 3 pengaduan dalam 1 minggu. Kuota Anda akan ter-reset otomatis 7 hari setelah pengaduan sebelumnya.');
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

        $pengaduan = Pengaduan::create([
            'kategori_id' => $request->kategori_id,
            'pengguna_id' => $user->id,
            'nama_pelapor' => $user->nama ?? 'Warga Sagalaherang',
            'nik' => $user->nik ?? '3213000000000000',
            'no_hp' => $user->no_hp ?? '081234567890',
            'alamat' => $user->alamat ?? 'Desa Sagalaherang',
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi ?? 'Desa Sagalaherang',
            'foto' => $fotoPath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('riwayat')
            ->with('success', 'Pengaduan Anda berhasil dikirim dengan Nomor Tiket #' . $pengaduan->nomor_tiket . '! Tim desa akan segera menindaklanjuti.');
    }
}
