@extends('layouts.admin')

@section('title', 'Rekapitulasi Data & Statistik - Admin Desa Sagalaherang')

@section('content')
<div class="space-y-6">

    <!-- HEADER TITLE & PRINT ACTION BUTTON -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Rekapitulasi Data & Laporan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
                Kelola, analisis, dan unduh data pengaduan masyarakat secara berkala.
            </p>
        </div>

        <button type="button" 
                onclick="window.print()" 
                class="bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs px-5 py-2.5 rounded-full shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center justify-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-print text-xs"></i>
            <span>Cetak Laporan Bulanan</span>
        </button>
    </div>

    <!-- FILTER BAR SECTION (GRID 4 KOLOM) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <form action="{{ route('admin.statistik') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            
            <!-- Filter 1: Rentang Waktu -->
            <div>
                <label for="rentang" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">
                    Rentang Waktu
                </label>
                <select id="rentang" name="rentang" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:border-[#06612B] cursor-pointer">
                    <option value="bulan_ini">Bulan Ini (Okt 2024)</option>
                    <option value="bulan_lalu">Bulan Lalu (Sep 2024)</option>
                    <option value="tahun_ini">Tahun Ini (2024)</option>
                </select>
            </div>

            <!-- Filter 2: Kategori -->
            <div>
                <label for="kategori" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">
                    Kategori
                </label>
                <select id="kategori" name="kategori" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:border-[#06612B] cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="infrastruktur">Infrastruktur & Jalan</option>
                    <option value="pelayanan">Pelayanan Publik</option>
                    <option value="kebersihan">Kebersihan & Lingkungan</option>
                    <option value="keamanan">Keamanan & Ketertiban</option>
                </select>
            </div>

            <!-- Filter 3: Status -->
            <div>
                <label for="status" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">
                    Status
                </label>
                <select id="status" name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:border-[#06612B] cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu Process</option>
                    <option value="diproses">Sedang Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <!-- Filter 4: Tombol Terapkan -->
            <div>
                <button type="submit" class="w-full bg-[#80EE82] hover:bg-[#6ed970] text-[#06612B] font-bold text-xs py-2.5 px-4 rounded-xl transition-all shadow-sm">
                    Terapkan Filter
                </button>
            </div>

        </form>
    </div>

    <!-- 4 METRIC STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Pengaduan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-1">
                    Total Pengaduan
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['total_pengaduan'] }}
                </span>
                <span class="text-[10px] font-semibold text-emerald-600 block mt-1">
                    {{ $metrics['total_growth'] }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#06612B] flex items-center justify-center">
                <i class="fa-solid fa-folder-open text-base"></i>
            </div>
        </div>

        <!-- Card 2: Menunggu Proses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-1">
                    Menunggu Proses
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['menunggu_proses'] }}
                </span>
                <span class="text-[10px] font-semibold text-amber-600 block mt-1">
                    {{ $metrics['menunggu_note'] }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fa-regular fa-clock text-base"></i>
            </div>
        </div>

        <!-- Card 3: Sedang Diproses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-1">
                    Sedang Diproses
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['sedang_diproses'] }}
                </span>
                <span class="text-[10px] font-semibold text-blue-600 block mt-1">
                    {{ $metrics['diproses_note'] }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-arrows-rotate text-base"></i>
            </div>
        </div>

        <!-- Card 4: Selesai Ditangani -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 block mb-1">
                    Selesai Ditangani
                </span>
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $metrics['selesai_ditangani'] }}
                </span>
                <span class="text-[10px] font-semibold text-[#06612B] block mt-1">
                    {{ $metrics['selesai_note'] }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-[#EAFCEB] text-[#06612B] flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-base"></i>
            </div>
        </div>

    </div>

    <!-- GRID GRAFIK VISUAL (2 KOLOM) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- DONUT CHART: PENGADUAN BY CATEGORY (LG:COL-SPAN-5) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-sm tracking-tight">
                Pengaduan by Category
            </h3>

            <!-- Donut Chart Visual SVG -->
            <div class="flex items-center justify-center py-4 relative">
                <svg class="w-44 h-44 -rotate-90 transform" viewBox="0 0 36 36">
                    <path class="text-slate-100" stroke-width="3.8" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <!-- Segment 1: Infrastruktur (45%) -->
                    <path class="text-[#06612B]" stroke-dasharray="45, 100" stroke-width="3.8" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <!-- Segment 2: Layanan Publik (25%) -->
                    <path class="text-[#80EE82]" stroke-dasharray="25, 100" stroke-dashoffset="-45" stroke-width="3.8" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <!-- Segment 3: Keamanan (15%) -->
                    <path class="text-blue-500" stroke-dasharray="15, 100" stroke-dashoffset="-70" stroke-width="3.8" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <!-- Segment 4: Lingkungan (10%) -->
                    <path class="text-amber-400" stroke-dasharray="10, 100" stroke-dashoffset="-85" stroke-width="3.8" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                </svg>
                <div class="absolute text-center">
                    <span class="text-2xl font-black text-slate-900 block">142</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Laporan</span>
                </div>
            </div>

            <!-- Legend List -->
            <div class="grid grid-cols-2 gap-2.5 text-xs pt-2 border-t border-slate-100">
                @foreach ($kategoriChart as $item)
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $item['warna'] }}"></span>
                        <span class="text-slate-600 font-medium truncate">{{ $item['nama'] }}</span>
                        <span class="font-bold text-slate-900 ml-auto">{{ $item['persen'] }}%</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- GROUPED BAR CHART: RESOLUTION STATUS BY MONTH (LG:COL-SPAN-7) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm tracking-tight">
                    Resolution Status by Month
                </h3>
                <div class="flex items-center gap-4 text-xs font-semibold">
                    <span class="flex items-center gap-1.5 text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#06612B]"></span>
                        Masuk
                    </span>
                    <span class="flex items-center gap-1.5 text-slate-600">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#80EE82]"></span>
                        Selesai
                    </span>
                </div>
            </div>

            <!-- Grouped Bar Chart Visual SVG / Flex -->
            <div class="h-48 flex items-end justify-between gap-4 sm:gap-8 pt-6 pb-2 px-4 border-b border-slate-100">
                @foreach ($resolutionChart as $bar)
                    <div class="flex-1 flex items-end justify-center gap-1.5 h-full">
                        <!-- Bar Masuk -->
                        <div class="w-4 sm:w-6 bg-[#06612B] rounded-t-md transition-all relative group" style="height: {{ ($bar['masuk'] / 45) * 100 }}%">
                            <div class="opacity-0 group-hover:opacity-100 absolute -top-7 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[9px] py-0.5 px-1.5 rounded font-bold transition-opacity whitespace-nowrap z-10 pointer-events-none">
                                {{ $bar['masuk'] }} Masuk
                            </div>
                        </div>
                        <!-- Bar Selesai -->
                        <div class="w-4 sm:w-6 bg-[#80EE82] rounded-t-md transition-all relative group" style="height: {{ ($bar['selesai'] / 45) * 100 }}%">
                            <div class="opacity-0 group-hover:opacity-100 absolute -top-7 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[9px] py-0.5 px-1.5 rounded font-bold transition-opacity whitespace-nowrap z-10 pointer-events-none">
                                {{ $bar['selesai'] }} Selesai
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between px-4 text-xs font-semibold text-slate-500">
                @foreach ($resolutionChart as $bar)
                    <span class="flex-1 text-center">{{ $bar['bulan'] }}</span>
                @endforeach
            </div>
        </div>

    </div>

    <!-- DETAIL DATA PENGADUAN TABLE SECTION -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden space-y-4 p-6">
        
        <!-- Table Header & Action Export Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-bold text-slate-900 text-sm tracking-tight">
                    Detail Data Rekapitulasi Pengaduan
                </h3>
                <p class="text-xs text-slate-400 font-normal mt-0.5">
                    Daftar seluruh laporan masyarakat Desa Sagalaherang.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" class="border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs px-3.5 py-2 rounded-xl transition-all flex items-center gap-1.5">
                    <i class="fa-regular fa-file-pdf text-rose-500"></i>
                    <span>Export PDF</span>
                </button>
                <button type="button" class="border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold text-xs px-3.5 py-2 rounded-xl transition-all flex items-center gap-1.5">
                    <i class="fa-regular fa-file-excel text-emerald-600"></i>
                    <span>Export Excel</span>
                </button>
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Pelapor</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Judul</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @foreach ($rekapTable as $row)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $row['id'] }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $row['tanggal'] }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $row['pelapor'] }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $row['kategori'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate text-slate-800">
                                {{ $row['judul'] }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if ($row['status'] === 'MENUNGGU')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200/60 uppercase">MENUNGGU</span>
                                @elseif ($row['status'] === 'DIPROSES')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200/60 uppercase">DIPROSES</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#EAFCEB] text-[#06612B] border border-emerald-200/60 uppercase">SELESAI</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('admin.pengaduan.kelola') }}" 
                                   class="text-slate-400 hover:text-[#06612B] transition-colors p-1.5 rounded-lg hover:bg-slate-100 inline-block" 
                                   title="Lihat Detail">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PAGINATION FOOTER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-3 border-t border-slate-100 text-xs">
            <span class="text-slate-500 font-medium">
                Menampilkan 1-3 dari 142 data
            </span>
            <div class="flex items-center gap-1.5 self-start sm:self-auto font-semibold">
                <button type="button" class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-400 hover:bg-slate-50 disabled:opacity-50" disabled>&lt;</button>
                <button type="button" class="px-3 py-1.5 bg-[#06612B] text-white rounded-lg">1</button>
                <button type="button" class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50">2</button>
                <button type="button" class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50">3</button>
                <span class="px-2 text-slate-400">...</span>
                <button type="button" class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50">&gt;</button>
            </div>
        </div>

    </div>

</div>
@endsection
