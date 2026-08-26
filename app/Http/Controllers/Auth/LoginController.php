<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

        $identifier = $request->login_identifier;
        $password = $request->password;

        // Coba autentikasi via NIK terlebih dahulu
        if (Auth::attempt(['nik' => $identifier, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali!');
        }

        // Coba autentikasi via Email jika login_identifier berformat email atau bukan NIK
        if (Auth::attempt(['email' => $identifier, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali!');
        }

        // Jika keduanya gagal
        return back()->withErrors([
            'login_identifier' => 'NIK / Username atau Kata Sandi yang Anda masukkan salah.',
        ])->onlyInput('login_identifier');
    }
}
