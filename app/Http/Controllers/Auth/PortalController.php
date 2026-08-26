<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    /**
     * Tampilkan halaman Portal Desa Sagalaherang (Login & Daftar Toggle).
     */
    public function index(Request $request)
    {
        // Tab aktif default: 'masuk' atau 'daftar'
        $activeTab = $request->query('tab', 'masuk');
        if (!in_array($activeTab, ['masuk', 'daftar'])) {
            $activeTab = 'masuk';
        }

        return view('auth.portal', compact('activeTab'));
    }
}
