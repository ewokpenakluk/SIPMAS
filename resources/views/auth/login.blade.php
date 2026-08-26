@extends('layouts.app')

@section('title', 'Login Warga - Desa Sagalaherang')

@section('content')
<div class="min-h-[calc(100vh-160px)] py-10 px-4 flex items-center justify-center bg-[#F8FAF8]">
    
    <!-- CARD LOGIN CONTAINER -->
    <div class="max-w-sm sm:max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-200">
        
        <!-- Top Green Accent Line -->
        <div class="h-1.5 w-full bg-[#06612B]"></div>

        <div class="p-6 sm:p-8">
            
            <!-- LOGO & HEADER -->
            <div class="text-center mb-6">
                <!-- Emblem Logo Desa Sagalaherang -->
                <div class="w-14 h-14 rounded-2xl bg-[#06612B] text-[#80EE82] flex items-center justify-center mx-auto shadow-md shadow-emerald-900/10 mb-3">
                    <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2L3 9v11a1 1 0 001 1h16a1 1 0 001-1V9l-9-7zm0 2.84L18.5 10H5.5L12 4.84zM5 12h14v7H5v-7z"/>
                    </svg>
                </div>
                
                <h1 class="text-xl sm:text-2xl font-bold text-[#06612B] tracking-tight">
                    Selamat Datang
                </h1>
                <p class="text-xs text-slate-500 mt-1 max-w-[280px] mx-auto leading-relaxed">
                    Layanan Masyarakat Digital Desa Sagalaherang
                </p>
            </div>

            <!-- ERROR ALERT -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-xs">
                    <div class="font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <!-- FORM LOGIN -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Field 1: NIK / Username -->
                <div>
                    <label for="login_identifier" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        NIK / Username
                    </label>
                    <input type="text" 
                           id="login_identifier" 
                           name="login_identifier" 
                           value="{{ old('login_identifier') }}" 
                           required 
                           placeholder="Masukkan NIK atau Username" 
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                </div>

                <!-- Field 2: Kata Sandi -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-700">
                            Kata Sandi
                        </label>
                        <a href="#" class="text-[11px] font-semibold text-[#06612B] hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="Masukkan Kata Sandi" 
                               class="w-full pl-3.5 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                        <button type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="eye-icon" class="fa-regular fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="pt-3">
                    <button type="submit" 
                            class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3.5 rounded-full shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>Masuk</span>
                    </button>
                </div>
            </form>

            <!-- FOOTER LINK -->
            <div class="mt-6 text-center text-xs text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#06612B] font-bold hover:underline ml-1">
                    Daftar
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
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
