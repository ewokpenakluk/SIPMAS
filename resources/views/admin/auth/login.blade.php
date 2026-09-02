@extends('layouts.app')

@section('title', 'Login Admin - Desa Sagalaherang')

@section('content')
<div class="min-h-[calc(100vh-160px)] py-10 px-4 flex items-center justify-center bg-[#F8FAF8]">
    
    <!-- CARD LOGIN ADMIN CONTAINER -->
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
                    Sistem Administrasi
                </h1>
                <p class="text-xs text-slate-500 mt-1 max-w-[280px] mx-auto leading-relaxed font-medium">
                    Desa Sagalaherang
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

            <!-- FORM LOGIN ADMIN -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Field 1: NIP / Username -->
                <div>
                    <label for="login_identifier" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        NIP / Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user text-xs"></i>
                        </div>
                        <input type="text" 
                               id="login_identifier" 
                               name="login_identifier" 
                               value="{{ old('login_identifier') }}" 
                               required 
                               placeholder="Masukkan NIP atau Username" 
                               class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                    </div>
                </div>

                <!-- Field 2: Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="Masukkan Password" 
                               class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                        <button type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="eye-icon" class="fa-regular fa-eye text-xs"></i>
                        </button>
                    </div>

                    <!-- Link Lupa Password (Right Aligned) -->
                    <div class="text-right mt-2">
                        <a href="#" class="text-[11px] font-semibold text-[#06612B] hover:underline">
                            Lupa Password?
                        </a>
                    </div>
                </div>

                <!-- SUBMIT BUTTON MASUK SEBAGAI ADMIN -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3.5 rounded-full shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>Masuk sebagai Admin</span>
                        <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                    </button>
                </div>
            </form>

            <!-- FOOTER TEXT INSIDE CARD -->
            <div class="border-t border-slate-100 pt-4 mt-6 text-center text-[11px] text-slate-400 font-medium flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-shield-halved text-emerald-600 text-xs"></i>
                <span>Portal Resmi Admin Desa Sagalaherang</span>
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
