@extends('layouts.app')

@section('title', 'Daftar Akun Warga - Desa Sagalaherang')

@section('content')
<div class="min-h-[calc(100vh-160px)] py-10 px-4 flex items-center justify-center bg-[#F8FAF8]">
    
    <!-- CARD REGISTER CONTAINER -->
    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-200">
        
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
                
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                    Buat Akun Warga
                </h1>
                <p class="text-xs text-slate-500 mt-1 max-w-[260px] mx-auto leading-relaxed">
                    Daftarkan diri Anda untuk mengakses layanan digital desa.
                </p>
            </div>

            <!-- ERROR ALERT -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-xs">
                    <div class="font-semibold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Mohon periksa kembali form berikut:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM REGISTRASI -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Field 1: Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap (Sesuai KTP)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user text-xs"></i>
                        </div>
                        <input type="text" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama') }}" 
                               required 
                               placeholder="Masukkan nama lengkap" 
                               class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                    </div>
                </div>

                <!-- Field 2: NIK (16 Digit) -->
                <div>
                    <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        NIK (16 Digit)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-id-card text-xs"></i>
                        </div>
                        <input type="text" 
                               id="nik" 
                               name="nik" 
                               value="{{ old('nik') }}" 
                               maxlength="16" 
                               required 
                               placeholder="Contoh: 321xxxxxxxxxxxxx" 
                               class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-300">
                            <i class="fa-solid fa-circle-info text-xs" title="NIK harus terdiri dari 16 angka"></i>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Pastikan NIK terdiri dari 16 angka.</p>
                </div>

                <!-- Field 3: Alamat Lengkap -->
                <div>
                    <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Alamat Lengkap
                    </label>
                    <textarea id="alamat" 
                              name="alamat" 
                              rows="3" 
                              required 
                              placeholder="Masukkan alamat domisili saat ini" 
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all resize-none">{{ old('alamat') }}</textarea>
                </div>

                <!-- Field 4: Nomor Telepon / WhatsApp -->
                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nomor Telepon / WhatsApp
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </div>
                        <input type="text" 
                               id="no_hp" 
                               name="no_hp" 
                               value="{{ old('no_hp') }}" 
                               required 
                               placeholder="08xxxxxxxxxx" 
                               class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all"
                               oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                    </div>
                </div>

                <!-- Field 5: Kata Sandi -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="Minimal 8 karakter" 
                               class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                        <button type="button" 
                                onclick="togglePasswordVisibility('password', 'eye-icon-1')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="eye-icon-1" class="fa-regular fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Field 6: Konfirmasi Kata Sandi -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                        </div>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="Ulangi kata sandi" 
                               class="w-full pl-9 pr-9 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                        <button type="button" 
                                onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-2')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i id="eye-icon-2" class="fa-regular fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>Daftar Akun</span>
                    </button>
                </div>
            </form>

            <!-- FOOTER LINK -->
            <div class="mt-6 text-center text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#06612B] font-bold hover:underline ml-1">
                    Masuk di sini
                </a>
            </div>

        </div>
    </div>
</div>

<script>
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
