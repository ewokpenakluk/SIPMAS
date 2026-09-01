@extends('layouts.app')

@section('title', 'Riwayat Pengaduan - Desa Sagalaherang')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- HEADING & FILTER BAR SECTION -->
    <section class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#06612B] tracking-tight">
                Riwayat Pengaduan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
                Pantau status laporan dan aspirasi yang telah Anda sampaikan.
            </p>
        </div>

        <!-- SEARCH & DROPDOWN FILTER FORM -->
        <form action="{{ route('riwayat') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search Nomor Tiket -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Cari nomor tiket..." 
                       class="w-full sm:w-60 pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
            </div>

            <!-- Dropdown Filter Status -->
            <div class="relative">
                <select name="status" 
                        onchange="this.form.submit()" 
                        class="w-full sm:w-auto appearance-none pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:outline-none focus:border-[#06612B] cursor-pointer transition-all">
                    <option value="">Semua Status</option>
                    <option value="SELESAI" {{ ($statusFilter ?? '') === 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                    <option value="DIPROSES" {{ ($statusFilter ?? '') === 'DIPROSES' ? 'selected' : '' }}>Diproses</option>
                    <option value="MENUNGGU" {{ ($statusFilter ?? '') === 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                    <option value="DITOLAK" {{ ($statusFilter ?? '') === 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
        </form>
    </section>

    <!-- TABEL RIWAYAT PENGADUAN CARD -->
    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Table Header -->
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-xs font-bold text-slate-600">
                        <th class="py-4 px-6">Nomor Tiket</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse ($sampleRiwayat as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Nomor Tiket -->
                            <td class="py-4 px-6 font-bold text-slate-900 whitespace-nowrap">
                                {{ $item['nomor_tiket'] }}
                            </td>

                            <!-- Tanggal -->
                            <td class="py-4 px-6 text-slate-600 font-normal whitespace-nowrap">
                                {{ $item['tanggal'] }}
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-6 text-slate-600 font-normal whitespace-nowrap">
                                {{ $item['kategori'] }}
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="{{ $item['badge_class'] }} font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full inline-block border">
                                    {{ $item['status'] }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <a href="{{ route('pengaduan.lacak', ['tiket' => $item['raw_tiket']]) }}" 
                                   class="border border-[#06612B] text-[#06612B] hover:bg-[#EAFCEB] font-semibold text-xs px-4 py-1.5 rounded-lg transition-all inline-block">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                                Belum ada riwayat pengaduan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
