@extends('layouts.admin')

@section('title', 'Dashboard Admin - Desa Sagalaherang')

@section('content')
<div class="space-y-6">
    
    <!-- TOP HEADER AREA -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Dashboard Overview
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
                Selamat datang kembali di sistem administrasi pengaduan desa.
            </p>
        </div>

        <!-- Admin Profile Card Badge -->
        <div class="bg-white rounded-full border border-slate-100 shadow-sm p-1.5 pr-5 flex items-center gap-3 self-start sm:self-auto">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=256&auto=format&fit=crop" 
                 alt="Admin Profile" 
                 class="w-9 h-9 rounded-full object-cover border border-slate-100">
            <div>
                <h4 class="font-bold text-slate-900 text-xs">
                    {{ Auth::user()->nama ?? 'Budi Santoso' }}
                </h4>
                <p class="text-[10px] text-slate-400 font-medium">
                    Kepala Desa
                </p>
            </div>
        </div>
    </div>

    <!-- 4 METRIC CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Masuk -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block mb-1">
                    Total Masuk
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['total_masuk'] }}
                </span>
            </div>
            <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-inbox text-sm"></i>
            </div>
        </div>

        <!-- Card 2: Belum Diverifikasi -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block mb-1">
                    Belum Diverifikasi
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['belum_diverifikasi'] }}
                </span>
            </div>
            <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fa-regular fa-clock text-sm"></i>
            </div>
        </div>

        <!-- Card 3: Sedang Diproses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block mb-1">
                    Sedang Diproses
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['sedang_diproses'] }}
                </span>
            </div>
            <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-arrows-rotate text-sm"></i>
            </div>
        </div>

        <!-- Card 4: Selesai -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block mb-1">
                    Selesai
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['selesai'] }}
                </span>
            </div>
            <div class="w-9 h-9 rounded-full bg-[#EAFCEB] text-[#06612B] flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-sm"></i>
            </div>
        </div>

    </div>

    <!-- GRAFIK MINGGUAN SECTION -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm tracking-tight">
                Tren Pengaduan Mingguan
            </h3>
            <span class="text-xs text-slate-400 font-medium">
                Minggu Ini
            </span>
        </div>

        <!-- BAR CHART MINGGUAN VISUAL -->
        <div class="h-48 flex items-end justify-between gap-2 sm:gap-6 pt-6 pb-2 px-2 border-b border-slate-100">
            @foreach ($trenMingguan as $tren)
                <div class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="w-full bg-[#80EE82]/40 group-hover:bg-[#06612B] rounded-t-lg transition-all relative"
                         style="height: {{ $tren['nilai'] }}%">
                        <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded font-bold transition-opacity whitespace-nowrap z-10 pointer-events-none">
                            {{ $tren['nilai'] }} Laporan
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 group-hover:text-slate-900">
                        {{ $tren['hari'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TABEL PENGADUAN TERBARU PERLU VERIFIKASI -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden space-y-4 p-6">
        <div class="flex items-center justify-between pb-2">
            <div>
                <h3 class="font-bold text-slate-900 text-sm tracking-tight">
                    Pengaduan Terbaru Perlu Verifikasi
                </h3>
                <p class="text-xs text-slate-400 font-normal mt-0.5">
                    Laporan masuk dari warga yang memerlukan verifikasi tim admin.
                </p>
            </div>
            <a href="{{ route('admin.pengaduan.kelola') }}" 
               class="text-xs font-bold text-[#06612B] hover:underline flex items-center gap-1">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4">No. Tiket</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Pelapor</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Judul Masalah</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @foreach ($perluVerifikasi as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $item['nomor_tiket'] }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $item['tanggal'] }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $item['nama_pelapor'] }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $item['kategori'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate text-slate-800">
                                {{ $item['judul'] }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200/60 uppercase">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('admin.pengaduan.kelola') }}" 
                                   class="bg-[#80EE82] hover:bg-[#6ed970] text-[#06612B] font-bold text-[11px] px-3.5 py-1.5 rounded-xl transition-all shadow-sm inline-flex items-center gap-1">
                                    <span>Verifikasi</span>
                                    <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
