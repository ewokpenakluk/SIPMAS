<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman form login warga.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login warga/user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login_identifier.required' => 'NIK atau Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $identifier = trim($request->login_identifier);
        $password = $request->password;

        // 1. Coba login via NIK atau Email
        if (Auth::attempt(['nik' => $identifier, 'password' => $password], $request->boolean('remember')) ||
            Auth::attempt(['email' => $identifier, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali!');
        }

        // 2. Cek apakah akun dengan NIK / Email tersebut ADA di database
        $userExists = User::where('nik', $identifier)
            ->orWhere('email', $identifier)
            ->exists();

        // 3. Jika akun BELUM ADA (Masyarakat belum memiliki akun)
        if (!$userExists) {
            return redirect()->route('portal', ['tab' => 'daftar'])
                ->with('info', "Akun ('$identifier') belum terdaftar. Silakan registrasi terlebih dahulu untuk membuat akun baru.")
                ->withInput();
        }

        // 4. Jika akun ADA tetapi password salah
        return back()->withErrors([
            'password' => 'Kata sandi yang Anda masukkan salah. Silakan periksa kembali.',
        ])->onlyInput('login_identifier');
    }
}
