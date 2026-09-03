@extends('layouts.app')

@section('title', 'Beranda - Desa Sagalaherang')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">

    <!-- HERO SECTION -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
        <!-- Left Text & Buttons -->
        <div class="lg:col-span-6 space-y-6">
            <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 tracking-tight leading-snug lg:leading-[1.35]">
                Layanan Pengaduan<br>Online Desa Sagalaherang
            </h1>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-lg font-normal">
                Sampaikan aspirasi dan keluhan Anda secara langsung demi kemajuan desa kita bersama.
            </p>
            <div class="flex items-center gap-4 pt-2">
                <a href="{{ route('login') }}" class="bg-[#06612B] hover:bg-[#044920] text-white px-7 py-3.5 rounded-xl font-semibold text-xs tracking-wide shadow-md shadow-brand-dark/20 transition-all hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                    <span>Masuk / Login</span>
                    <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Right Hero Image -->
        <div class="lg:col-span-6">
            <div class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-100 group">
                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1200&auto=format&fit=crop" 
                     alt="Pemandangan Desa Sagalaherang Subang" 
                     class="w-full h-80 sm:h-95 object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-linear-to-t from-slate-900/30 via-transparent to-transparent"></div>
                <div class="absolute bottom-4 right-4 bg-black/40 backdrop-blur-md text-white text-[11px] px-3 py-1.5 rounded-lg font-medium border border-white/20">
                    Desa Sagalaherang, Subang
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR PENGADUAN SECTION -->
    <section class="pt-6">
        <h2 class="text-center font-bold text-slate-800 text-lg mb-10 tracking-tight">
            Alur Pengaduan
        </h2>

        <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto">
            
            <!-- Step 1: Daftar -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <i class="fa-solid fa-shapes text-base"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-1.5">Daftar</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-45 mx-auto">
                    Buat akun untuk mulai mengajukan.
                </p>
            </div>

            <!-- Step 2: Ajukan -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <i class="fa-solid fa-[#06612B] fa-file-pen text-base"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-1.5">Ajukan</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-45 mx-auto">
                    Tuliskan detail keluhan Anda.
                </p>
            </div>

            <!-- Step 3: Verifikasi -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <i class="fa-solid fa-shield-check text-base"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-1.5">Verifikasi</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-45 mx-auto">
                    Admin akan memvalidasi laporan.
                </p>
            </div>

            <!-- Step 4: Selesai -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <i class="fa-solid fa-check-double text-base"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-1.5">Selesai</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-45 mx-auto">
                    Masalah ditindaklanjuti.
                </p>
            </div>

        </div>
    </section>

    <!-- STATISTIK PENGADUAN SECTION -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Total Pengaduan -->
        <div class="bg-[#06612B] rounded-2xl p-8 text-center text-white shadow-md shadow-emerald-950/10 flex flex-col justify-center">
            <span class="text-4xl sm:text-5xl font-black tracking-tight mb-2">
                {{ number_format($totalPengaduan) }}
            </span>
            <span class="text-xs font-medium text-emerald-100 tracking-wide">
                Total Pengaduan
            </span>
        </div>

        <!-- Card 2: Selesai ditangani -->
        <div class="bg-[#80EE82] rounded-2xl p-8 text-center text-slate-900 shadow-sm flex flex-col justify-center">
            <span class="text-4xl sm:text-5xl font-black tracking-tight mb-2">
                {{ number_format($selesai) }}
            </span>
            <span class="text-xs font-semibold text-slate-700 tracking-wide">
                Selesai ditangani
            </span>
        </div>

        <!-- Card 3: Dalam Proses -->
        <div class="bg-[#FFC0B4] rounded-2xl p-8 text-center text-slate-900 shadow-sm flex flex-col justify-center">
            <span class="text-4xl sm:text-5xl font-black tracking-tight mb-2">
                {{ number_format($dalamProses) }}
            </span>
            <span class="text-xs font-semibold text-slate-700 tracking-wide">
                Dalam Proses
            </span>
        </div>

    </section>

    <!-- HUBUNGI KAMI & PETA LOKASI SECTION -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Left: Hubungi Kami -->
        <div class="lg:col-span-6 bg-white rounded-2xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-lg mb-6">Hubungi Kami</h3>
                
                <div class="space-y-5">
                    <!-- Alamat -->
                    <div class="flex items-start gap-4">
                        <div class="text-emerald-700 mt-1">
                            <i class="fa-solid fa-location-dot text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 mb-0.5">Alamat</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Kantor Kepala Desa Sagalaherang,<br>
                                Kecamatan Sagalaherang,<br>
                                Kabupaten Subang, Jawa Barat
                            </p>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="flex items-start gap-4">
                        <div class="text-emerald-700 mt-1">
                            <i class="fa-solid fa-phone text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 mb-0.5">Telepon</h4>
                            <p class="text-xs text-slate-500">
                                +62 812 3456 7890
                            </p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="text-emerald-700 mt-1">
                            <i class="fa-regular fa-envelope text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 mb-0.5">Email</h4>
                            <p class="text-xs text-slate-500">
                                layanan@sagalaherang.desa.id
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Peta Lokasi Sagalaherang -->
        <div class="lg:col-span-6 bg-slate-200 rounded-2xl overflow-hidden shadow-sm border border-slate-200 relative min-h-75">
            <iframe 
                title="Peta Lokasi Desa Sagalaherang"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.337077421319!2d107.65219967499479!3d-6.728646993267566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e734fdfcb0bf%3A0x401e8f1fc28c680!2sSagalaherang%2C%20Subang%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                class="w-full h-full min-h-75 border-0" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </section>

</div>
@endsection
