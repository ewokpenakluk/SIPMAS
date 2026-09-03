<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman form login admin.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses autentikasi login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login_identifier.required' => 'NIP atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identifier = trim($request->login_identifier);
        $password = $request->password;

        // Autentikasi via Email / NIP
        if (Auth::attempt(['email' => $identifier, 'password' => $password], $request->boolean('remember')) ||
            Auth::attempt(['nik' => $identifier, 'password' => $password], $request->boolean('remember'))) {
            
            $user = Auth::user();

            // Proteksi Khusus: Hanya Akun Admin / Superadmin yang diizinkan masuk melalui Admin Login
            if ($user && $user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali di Admin Panel, ' . ($user->nama ?? 'Admin') . '!');
            }

            // Jika akun adalah warga/masyarakat biasa (bukan admin)
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'login_identifier' => 'Akun masyarakat tidak diizinkan masuk ke halaman Admin Panel. Silakan login melalui portal masyarakat.',
            ])->onlyInput('login_identifier');
        }

        return back()->withErrors([
            'login_identifier' => 'NIP / Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('login_identifier');
    }
}
