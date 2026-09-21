@extends('layouts.app')

@section('title', 'Beranda - Desa Sagalaherang')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">

    <!-- HERO SECTION -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center reveal">
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
                <img src="{{ asset('images/hero-desa.jpg') }}" 
                     alt="Pemandangan Desa Sagalaherang Subang" 
                     class="w-full h-80 sm:h-95 object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                <div class="absolute bottom-4 right-4 bg-black/40 backdrop-blur-md text-white text-[11px] px-3.5 py-1.5 rounded-lg font-medium border border-white/20 shadow-sm">
                    Desa Sagalaherang, Subang
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR PENGADUAN SECTION -->
    <section class="pt-6 reveal">
        <h2 class="text-center font-bold text-slate-800 text-lg mb-10 tracking-tight">
            Alur Pengaduan
        </h2>

        <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto">
            
            <!-- Connecting line for desktop (Figma Design) -->
            <div class="hidden lg:block absolute top-1/2 left-12 right-12 h-0.5 bg-slate-200 -translate-y-1/2 z-0"></div>
            
            <!-- Step 1: Daftar -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M3 4h4v4H3V4zm6 0h4v4H9V4zm6 0h4v4h-4V4zM3 10h4v4H3v-4zm6 0h4v4H9v-4zm6 0h4v4h-4v-4zM3 16h4v4H3v-4zm6 0h4v4H9v-4z"/>
                        <path d="M18.7 15.3l-3.7 3.7V21h2l3.7-3.7-2-2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-1.5">Daftar</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-45 mx-auto">
                    Buat akun untuk mulai mengajukan.
                </p>
            </div>

            <!-- Step 2: Ajukan -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <i class="fa-solid fa-file-pen text-base"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-1.5">Ajukan</h3>
                <p class="text-xs text-slate-500 leading-relaxed max-w-45 mx-auto">
                    Tuliskan detail keluhan Anda.
                </p>
            </div>

            <!-- Step 3: Verifikasi (Verified Badge Icon dari Figma) -->
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#80EE82] text-[#06612B] flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                    <svg class="w-6 h-6 fill-current text-[#06612B]" viewBox="0 0 24 24">
                        <path d="M23 12l-2.44-2.79.34-3.69-3.61-.82-1.89-3.2L12 2.96 8.6 1.5 6.71 4.7l-3.61.81.34 3.7L1 12l2.44 2.79-.34 3.7 3.61.82 1.89 3.2 3.4-1.47 3.4 1.46 1.89-3.19 3.61-.82-.34-3.69L23 12zm-12.91 4.72l-3.8-3.81 1.48-1.48 2.32 2.33 5.85-5.87 1.48 1.48-7.33 7.35z"/>
                    </svg>
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
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 reveal">
        
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
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch reveal">
        
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
                                Jl. Sagala Herang Subang No.101, Sagalaherang Kaler,<br>
                                Kec. Sagalaherang, Kab. Subang,<br>
                                Jawa Barat 41282
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
                title="Peta Lokasi Kantor Desa Sagalaherang Kaler"
                src="https://maps.google.com/maps?q=Jl.+Sagala+Herang+Subang+No.101,+Sagalaherang+Kaler,+Kec.+Sagalaherang,+Kabupaten+Subang,+Jawa+Barat+41282&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                class="w-full h-full min-h-75 border-0" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </section>

</div>
@endsection
