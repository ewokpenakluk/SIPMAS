@extends('layouts.app')

@section('title', 'Lacak Status Pengaduan - Desa Sagalaherang')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- HEADING & SUBTITLE -->
    <section>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Lacak Status Pengaduan
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1.5">
            Pantau progress laporan yang telah Anda sampaikan ke pemerintah desa.
        </p>
    </section>

    <!-- SEARCH CARD -->
    <section class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('pengaduan.lacak') }}" method="GET" class="space-y-2">
            <label for="tiket" class="block text-xs font-semibold text-slate-700">
                Masukkan Nomor Tiket Pengaduan
            </label>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                    <input type="text" 
                           id="tiket" 
                           name="tiket" 
                           value="{{ $nomorTiket ?? old('tiket', $sampleData['nomor_tiket']) }}" 
                           placeholder="SGH-202310-045" 
                           class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] focus:bg-white transition-all">
                </div>
                <button type="submit" 
                        class="bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs px-6 py-3.5 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
                    <span>Cari Tiket</span>
                </button>
            </div>
        </form>
    </section>

    <!-- GRID HASIL TRACKING (DETAIL & PROGRESS TIMELINE) -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: DETAIL LAPORAN & TANGGAPAN ADMIN -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-sm space-y-6">
            
            <!-- Category Badge & Status Pill -->
            <div class="flex items-center justify-between gap-3">
                <span class="bg-emerald-50 text-emerald-700 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full border border-emerald-100">
                    {{ $sampleData['kategori'] }}
                </span>
                <span class="bg-slate-100 text-slate-600 font-semibold text-[11px] px-3.5 py-1 rounded-full">
                    {{ ucfirst($sampleData['status']) }}
                </span>
            </div>

            <!-- Title & Meta -->
            <div>
                <h2 class="text-lg font-bold text-slate-900 tracking-tight leading-snug">
                    {{ $sampleData['judul'] }}
                </h2>
                <p class="text-xs text-slate-400 font-medium mt-1 pb-4 border-b border-slate-100">
                    Tiket: <span class="text-slate-600 font-semibold">{{ $sampleData['nomor_tiket'] }}</span> • {{ $sampleData['dilaporkan_lalu'] }}
                </p>
            </div>

            <!-- Deskripsi Laporan -->
            <div>
                <h3 class="text-xs font-bold text-slate-800 mb-1.5">
                    Deskripsi Laporan
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed font-normal">
                    {{ $sampleData['deskripsi'] }}
                </p>
            </div>

            <!-- Tanggapan Admin Box -->
            <div class="bg-slate-50 border-l-4 border-[#06612B] rounded-r-xl p-4 sm:p-4.5 space-y-1.5">
                <div class="flex items-center gap-2 text-xs font-bold text-[#06612B]">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Tanggapan Admin</span>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed font-medium">
                    {{ $sampleData['tanggapan_admin'] }}
                </p>
                <div class="text-[11px] text-slate-400 font-normal pt-0.5">
                    {{ $sampleData['tanggapan_waktu'] }}
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN: CARD PROGRESS VERTICAL TIMELINE -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 sm:p-7 border border-slate-100 shadow-sm space-y-6">
            
            <h3 class="text-base font-bold text-slate-900 tracking-tight">
                Progress
            </h3>

            <!-- Timeline Step Container -->
            <div class="space-y-0 pl-1">
                
                <!-- Step 1: Diajukan (Completed) -->
                <div class="relative flex items-start gap-4 pb-8">
                    <!-- Vertical Line Connector -->
                    <div class="absolute left-3 top-6 bottom-0 w-0.5 bg-emerald-600"></div>
                    
                    <!-- Icon -->
                    <div class="relative z-10 w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shadow-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <!-- Content -->
                    <div class="pt-0.5">
                        <h4 class="text-xs font-bold text-slate-900">Diajukan</h4>
                        <p class="text-[11px] text-slate-500 font-normal mt-0.5">Laporan diterima sistem.</p>
                        <span class="text-[10px] text-slate-400 font-medium block mt-1">22 Okt 2023, 08:15 WIB</span>
                    </div>
                </div>

                <!-- Step 2: Diverifikasi (Active) -->
                <div class="relative flex items-start gap-4 pb-8">
                    <!-- Vertical Line Connector -->
                    <div class="absolute left-3 top-6 bottom-0 w-0.5 bg-slate-200"></div>

                    <!-- Icon Ring -->
                    <div class="relative z-10 w-6 h-6 rounded-full border-2 border-emerald-600 bg-white flex items-center justify-center">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-600"></div>
                    </div>

                    <!-- Content -->
                    <div class="pt-0.5">
                        <h4 class="text-xs font-bold text-emerald-700">Diverifikasi</h4>
                        <p class="text-[11px] text-slate-600 font-medium mt-0.5">Laporan sedang dicek oleh admin.</p>
                    </div>
                </div>

                <!-- Step 3: Diproses (Pending) -->
                <div class="relative flex items-start gap-4 pb-8">
                    <!-- Vertical Line Connector -->
                    <div class="absolute left-3 top-6 bottom-0 w-0.5 bg-slate-200"></div>

                    <!-- Icon Gray Circle -->
                    <div class="relative z-10 w-6 h-6 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center"></div>

                    <!-- Content -->
                    <div class="pt-0.5">
                        <h4 class="text-xs font-semibold text-slate-400">Diproses</h4>
                        <p class="text-[11px] text-slate-300 font-normal mt-0.5">Tindakan sedang dilakukan.</p>
                    </div>
                </div>

                <!-- Step 4: Selesai (Pending) -->
                <div class="relative flex items-start gap-4">
                    <!-- Icon Gray Circle -->
                    <div class="relative z-10 w-6 h-6 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center"></div>

                    <!-- Content -->
                    <div class="pt-0.5">
                        <h4 class="text-xs font-semibold text-slate-400">Selesai</h4>
                        <p class="text-[11px] text-slate-300 font-normal mt-0.5">Pengaduan telah diselesaikan.</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

</div>
@endsection
