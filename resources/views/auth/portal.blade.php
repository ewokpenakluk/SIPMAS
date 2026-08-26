@extends('layouts.app')

@section('title', 'Portal Desa Sagalaherang - Login & Daftar')

@section('content')
<div class="min-h-[calc(100vh-160px)] py-10 px-4 flex flex-col items-center justify-center bg-[#F8FAF8]">
    
    <!-- HEADER PORTAL -->
    <div class="text-center mb-6 max-w-md mx-auto">
        <!-- Emblem Logo Desa Sagalaherang -->
        <div class="w-16 h-16 rounded-2xl bg-[#06612B] text-[#80EE82] flex items-center justify-center mx-auto shadow-md shadow-emerald-900/10 mb-3">
            <svg class="w-9 h-9 fill-current" viewBox="0 0 24 24">
                <path d="M12 2L3 9v11a1 1 0 001 1h16a1 1 0 001-1V9l-9-7zm0 2.84L18.5 10H5.5L12 4.84zM5 12h14v7H5v-7z"/>
            </svg>
        </div>
        
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#06612B] tracking-tight">
            Portal Desa Sagalaherang
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
            Layanan Masyarakat Digital yang Terintegrasi dan Transparan
        </p>
    </div>

    <!-- CARD CONTAINER TOGGLE -->
    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-200">
        
        <div class="p-6 sm:p-8">
            
            <!-- TAB TOGGLE NAVIGATION -->
            <div class="grid grid-cols-2 text-center border-b border-slate-100 mb-6 font-semibold text-xs sm:text-sm">
                <button type="button" 
                        id="tab-btn-masuk" 
                        onclick="switchTab('masuk')" 
                        class="pb-3 border-b-2 transition-all {{ $activeTab === 'masuk' ? 'text-[#06612B] border-[#06612B] font-bold' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
                    Masuk
                </button>
                <button type="button" 
                        id="tab-btn-daftar" 
                        onclick="switchTab('daftar')" 
                        class="pb-3 border-b-2 transition-all {{ $activeTab === 'daftar' ? 'text-[#06612B] border-[#06612B] font-bold' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
                    Daftar
                </button>
            </div>

            <!-- ERROR & SUCCESS ALERT -->
            @if (session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-xs">
                    <div class="font-semibold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Mohon periksa kembali input Anda:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TAB 1: FORM MASUK (LOGIN) -->
            <div id="tab-content-masuk" class="{{ $activeTab === 'masuk' ? 'block' : 'hidden' }}">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-[#06612B] tracking-tight mb-0.5">
                        Selamat Datang Kembali
                    </h2>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Silakan masuk ke akun Anda untuk mengakses layanan desa.
                    </p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- NIK / Username -->
                    <div>
                        <label for="portal_login_identifier" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            NIK / Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-id-card text-xs"></i>
                            </div>
                            <input type="text" 
                                   id="portal_login_identifier" 
                                   name="login_identifier" 
                                   value="{{ old('login_identifier') }}" 
                                   required 
                                   placeholder="Masukkan 16 digit NIK" 
                                   class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="portal_password" class="block text-xs font-semibold text-slate-700">
                                Password
                            </label>
                            <a href="#" class="text-[11px] font-semibold text-[#06612B] hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <input type="password" 
                                   id="portal_password" 
                                   name="password" 
                                   required 
                                   placeholder="Masukkan password Anda" 
                                   class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('portal_password', 'portal-eye-icon')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i id="portal-eye-icon" class="fa-regular fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Masuk -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-to-bracket text-xs"></i>
                            <span>Masuk</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: FORM DAFTAR (REGISTRASI) -->
            <div id="tab-content-daftar" class="{{ $activeTab === 'daftar' ? 'block' : 'hidden' }}">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-[#06612B] tracking-tight mb-0.5">
                        Buat Akun Warga Baru
                    </h2>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Lengkapi data Anda untuk mendaftar layanan desa.
                    </p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="portal_nama" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap (Sesuai KTP)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-user text-xs"></i>
                            </div>
                            <input type="text" 
                                   id="portal_nama" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   required 
                                   placeholder="Masukkan nama lengkap" 
                                   class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                        </div>
                    </div>

                    <!-- NIK (16 Digit) -->
                    <div>
                        <label for="portal_nik" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            NIK (16 Digit)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-id-card text-xs"></i>
                            </div>
                            <input type="text" 
                                   id="portal_nik" 
                                   name="nik" 
                                   value="{{ old('nik') }}" 
                                   maxlength="16" 
                                   required 
                                   placeholder="Contoh: 321xxxxxxxxxxxxx" 
                                   class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Pastikan NIK terdiri dari 16 angka.</p>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="portal_alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Alamat Lengkap
                        </label>
                        <textarea id="portal_alamat" 
                                  name="alamat" 
                                  rows="2" 
                                  required 
                                  placeholder="Masukkan alamat domisili saat ini" 
                                  class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all resize-none">{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Nomor Telepon / WhatsApp -->
                    <div>
                        <label for="portal_no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nomor Telepon / WhatsApp
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </div>
                            <input type="text" 
                                   id="portal_no_hp" 
                                   name="no_hp" 
                                   value="{{ old('no_hp') }}" 
                                   required 
                                   placeholder="08xxxxxxxxxx" 
                                   class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all"
                                   oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                        </div>
                    </div>

                    <!-- Kata Sandi -->
                    <div>
                        <label for="portal_reg_password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <input type="password" 
                                   id="portal_reg_password" 
                                   name="password" 
                                   required 
                                   placeholder="Minimal 8 karakter" 
                                   class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('portal_reg_password', 'reg-eye-icon-1')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i id="reg-eye-icon-1" class="fa-regular fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Kata Sandi -->
                    <div>
                        <label for="portal_reg_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Konfirmasi Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-rotate-left text-xs"></i>
                            </div>
                            <input type="password" 
                                   id="portal_reg_password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="Ulangi kata sandi" 
                                   class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('portal_reg_password_confirmation', 'reg-eye-icon-2')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i id="reg-eye-icon-2" class="fa-regular fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Daftar -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                            <span>Daftar Akun</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- FOOTER COPYRIGHT BELOW CARD -->
    <div class="text-[11px] text-slate-400 text-center font-medium mt-8">
        © 2024 Desa Sagalaherang. Layanan Masyarakat Digital.
    </div>

</div>

<script>
    function switchTab(tabName) {
        const contentMasuk = document.getElementById('tab-content-masuk');
        const contentDaftar = document.getElementById('tab-content-daftar');
        const btnMasuk = document.getElementById('tab-btn-masuk');
        const btnDaftar = document.getElementById('tab-btn-daftar');

        if (tabName === 'masuk') {
            contentMasuk.classList.remove('hidden');
            contentMasuk.classList.add('block');
            contentDaftar.classList.remove('block');
            contentDaftar.classList.add('hidden');

            btnMasuk.className = "pb-3 border-b-2 transition-all text-[#06612B] border-[#06612B] font-bold";
            btnDaftar.className = "pb-3 border-b-2 transition-all text-slate-400 border-transparent hover:text-slate-600 font-semibold";
        } else {
            contentDaftar.classList.remove('hidden');
            contentDaftar.classList.add('block');
            contentMasuk.classList.remove('block');
            contentMasuk.classList.add('hidden');

            btnDaftar.className = "pb-3 border-b-2 transition-all text-[#06612B] border-[#06612B] font-bold";
            btnMasuk.className = "pb-3 border-b-2 transition-all text-slate-400 border-transparent hover:text-slate-600 font-semibold";
        }
    }

    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
