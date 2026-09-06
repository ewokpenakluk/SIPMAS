<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman form registrasi warga.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun warga baru.
     */
    public function register(Request $request)
    {
        // Bersihkan spasi dan karakter non-digit dari NIK dan No HP sebelum validasi
        $nik = preg_replace('/[^0-9]/', '', $request->nik);
        $no_hp = preg_replace('/[^0-9]/', '', $request->no_hp);

        $request->merge([
            'nik' => $nik,
            'no_hp' => $no_hp,
        ]);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'digits:16', 'unique:pengguna,nik'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'digits:12'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus berjumlah persis 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar sebelumnya.',
            'alamat.required' => 'Alamat lengkap domisili wajib diisi.',
            'no_hp.required' => 'Nomor telepon / WhatsApp wajib diisi.',
            'no_hp.digits' => 'Nomor Telepon / WhatsApp harus berjumlah persis 12 digit angka.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'peran' => 'warga',
        ]);

        // Setelah registrasi berhasil, lemparkan/arahkan ke halaman login (tab Masuk)
        return redirect()->route('portal', ['tab' => 'masuk'])
            ->with('success', 'Registrasi akun berhasil! Silakan masuk dengan NIK dan Kata Sandi yang baru Anda buat.');
    }
}
