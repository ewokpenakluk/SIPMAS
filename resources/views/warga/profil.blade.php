@extends('layouts.app')

@section('title', 'Profil Saya - Desa Sagalaherang')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    <!-- HEADER PROFIL & TOMBOL ACTION -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#06612B] tracking-tight">
                Profil Akun
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
                Kelola informasi pribadi dan pengaturan keamanan Anda.
            </p>
        </div>

        <!-- Tombol Buat Laporan di Header -->
        <a href="{{ route('pengaduan.buat') }}" 
           class="inline-flex items-center justify-center gap-2 bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-[0.99] self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Buat Laporan Baru</span>
        </a>
    </div>

    <!-- ALERT NOTIFIKASI -->
    @if (session('success'))
        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2 mb-6">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- File Input Tersembunyi untuk Foto Profil -->
        <input type="file" 
               id="foto_profil" 
               name="foto_profil" 
               accept="image/*" 
               class="hidden" 
               onchange="previewAvatar(this)">

        <!-- GRID 2 KARTU (SUMMARY PROFIL & FORM INFORMASI PRIBADI) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- KARTU 1 (KIRI): SUMMARY PROFIL, AVATAR & TOMBOL LOGOUT -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center space-y-4">
                <!-- Avatar Circle with Camera Edit Badge -->
                <div class="relative w-24 h-24 mx-auto cursor-pointer group"
                     onclick="document.getElementById('foto_profil').click()"
                     title="Klik untuk mengubah foto profil">
                    <img id="avatar-preview"
                         src="{{ $warga['foto_profil'] }}" 
                         alt="{{ $warga['nama'] }}" 
                         class="w-24 h-24 rounded-full object-cover border-2 border-slate-100 shadow-sm bg-slate-50 group-hover:opacity-90 transition-opacity">
                    <!-- Pencil/Camera Edit Badge -->
                    <button type="button" 
                            title="Ubah Foto Profil" 
                            class="absolute bottom-0 right-0 w-7 h-7 bg-[#06612B] hover:bg-[#044920] text-white rounded-full flex items-center justify-center text-xs shadow-md border-2 border-white transition-colors">
                        <i class="fa-solid fa-camera text-[10px]"></i>
                    </button>
                </div>

                <div>
                    <h2 class="font-bold text-slate-900 text-base sm:text-lg">
                        {{ $warga['nama'] }}
                    </h2>
                    <p class="text-xs text-slate-500 font-normal mt-0.5">
                        {{ $warga['peran'] }}
                    </p>
                </div>

                <div class="border-t border-slate-100 my-3"></div>

                <!-- Status & Terdaftar -->
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Status Akun</span>
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-bold text-[10px] uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                            {{ $warga['status'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Terdaftar Sejak</span>
                        <span class="font-semibold text-slate-800">
                            {{ $warga['terdaftar_sejak'] }}
                        </span>
                    </div>
                </div>

                <!-- TOMBOL LOGOUT PENYESUAIAN TATA LETAK -->
                <div class="border-t border-slate-100 pt-3">
                    <button type="button" 
                            onclick="document.getElementById('form-logout-warga').submit()"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl border border-rose-100/80 transition-all active:scale-[0.99] cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket text-xs text-rose-500"></i>
                        <span>Keluar dari Akun (Logout)</span>
                    </button>
                </div>

            </div>

            <!-- KARTU 2 (KANAN): FORM INFORMASI PRIBADI -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-7 space-y-4">
                
                <div class="flex items-center gap-2 font-bold text-slate-900 text-base mb-2">
                    <i class="fa-regular fa-user text-[#06612B]"></i>
                    <span>Informasi Pribadi</span>
                </div>

                <!-- Grid 2 Column: Nama & NIK -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Field 1: Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $warga['nama']) }}" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                    </div>

                    <!-- Field 2: NIK (Read-only) -->
                    <div>
                        <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1.5 flex items-center justify-between">
                            <span>NIK</span>
                            <span class="text-[10px] font-normal text-slate-400">(Read-only)</span>
                        </label>
                        <input type="text" 
                               id="nik" 
                               value="{{ $warga['nik'] }}" 
                               disabled 
                               readonly 
                               class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-500 font-mono font-medium cursor-not-allowed">
                    </div>
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
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all resize-none">{{ old('alamat', $warga['alamat']) }}</textarea>
                </div>

                <!-- Field 4: Nomor Telepon -->
                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nomor Telepon
                    </label>
                    <input type="text" 
                           id="no_hp" 
                           name="no_hp" 
                           value="{{ old('no_hp', $warga['no_hp']) }}" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <a href="{{ route('profil') }}" 
                       class="bg-[#80EE82] hover:bg-[#6ed970] text-[#06612B] font-semibold text-xs px-6 py-2.5 rounded-xl shadow-xs transition-all">
                        Batal
                    </a>
                    
                    <button type="submit" 
                            class="bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs px-6 py-2.5 rounded-xl shadow-xs transition-all hover:shadow-md active:scale-[0.99]">
                        Simpan Perubahan
                    </button>
                </div>

            </div>

        </div>

    </form>

    <!-- FORM LOGOUT INDEPENDEN UNTUK DIPANGGUL OLEH TOMBOL DI KARTU PROFIL -->
    <form id="form-logout-warga" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
