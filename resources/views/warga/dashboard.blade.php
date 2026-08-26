@extends('layouts.app')

@section('title', 'Dashboard Warga - Desa Sagalaherang')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- SALAM & HEADER GREETING -->
    <section>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
            <span>Halo, {{ $namaWarga }}!</span>
            <span class="text-2xl sm:text-3xl">👋</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1.5">
            Selamat datang kembali di layanan masyarakat digital Desa Sagalaherang.
        </p>
    </section>

    <!-- 4 RINGKASAN STATUS CARDS -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: DITERIMA -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-inbox text-sm"></i>
                </div>
                <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    Diterima
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">
                {{ $stats['diterima'] }}
            </div>
        </div>

        <!-- Card 2: DIPROSES -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-rotate text-sm"></i>
                </div>
                <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    Diproses
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">
                {{ $stats['diproses'] }}
            </div>
        </div>

        <!-- Card 3: SELESAI -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                    <i class="fa-regular fa-circle-check text-sm"></i>
                </div>
                <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    Selesai
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">
                {{ $stats['selesai'] }}
            </div>
        </div>

        <!-- Card 4: DITOLAK -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center mb-3">
                    <i class="fa-regular fa-circle-xmark text-sm"></i>
                </div>
                <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    Ditolak
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900">
                {{ $stats['ditolak'] }}
            </div>
        </div>

    </section>

    <!-- GRID KONTEN UTAMA: AKSI CEPAT & AKTIVITAS TERAKHIR -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start pt-2">
        
        <!-- KOLOM KIRI: AKSI CEPAT -->
        <div class="lg:col-span-4 space-y-4">
            <h2 class="font-bold text-slate-900 text-base tracking-tight">
                Aksi Cepat
            </h2>
            
            <div class="space-y-3">
                <!-- Tombol 1: Ajukan Pengaduan Baru -->
                <a href="{{ route('pengaduan.buat') }}" 
                   class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3.5 px-5 rounded-2xl shadow-sm flex items-center gap-3 transition-all hover:-translate-y-0.5">
                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <span>Ajukan Pengaduan Baru</span>
                </a>

                <!-- Tombol 2: Lihat Riwayat -->
                <a href="{{ route('riwayat') }}" 
                   class="w-full border-2 border-[#06612B] text-[#06612B] hover:bg-[#EAFCEB] font-semibold text-xs py-3.5 px-5 rounded-2xl flex items-center gap-3 transition-all">
                    <div class="w-6 h-6 rounded-full bg-[#06612B]/10 flex items-center justify-center">
                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                    </div>
                    <span>Lihat Riwayat</span>
                </a>

                <!-- Tombol 3: Update Profil -->
                <a href="{{ route('profil') }}" 
                   class="w-full border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs py-3.5 px-5 rounded-2xl flex items-center gap-3 transition-all">
                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fa-regular fa-user text-xs"></i>
                    </div>
                    <span>Update Profil</span>
                </a>
            </div>
        </div>

        <!-- KOLOM KANAN: AKTIVITAS TERAKHIR -->
        <div class="lg:col-span-8 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-slate-900 text-base tracking-tight">
                    Aktivitas Terakhir
                </h2>
                <a href="{{ route('riwayat') }}" class="text-xs font-semibold text-[#06612B] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <!-- List Cards Pengaduan -->
            <div class="space-y-3">
                @foreach ($aktivitasTerakhir as $item)
                    <div class="bg-white rounded-2xl border border-slate-100 p-4 sm:p-5 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-sm mb-1">
                                {{ $item['judul'] }}
                            </h3>
                            <p class="text-[11px] text-slate-400 font-medium">
                                {{ $item['kategori'] }} • {{ $item['tanggal'] }}
                            </p>
                        </div>

                        <div>
                            @if ($item['status'] === 'diproses')
                                <span class="bg-blue-50 text-blue-600 border border-blue-100 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full inline-block">
                                    Diproses
                                </span>
                            @elseif ($item['status'] === 'selesai')
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full inline-block">
                                    Selesai
                                </span>
                            @elseif ($item['status'] === 'diterima')
                                <span class="bg-amber-50 text-amber-600 border border-amber-100 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full inline-block">
                                    Diterima
                                </span>
                            @else
                                <span class="bg-rose-50 text-rose-600 border border-rose-100 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full inline-block">
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>

</div>
@endsection
