<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Data - Admin Desa Sagalaherang</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Engine with Console Warning Filter -->
    <script>
        (function() {
            const origWarn = console.warn;
            console.warn = function(...args) {
                if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com')) return;
                origWarn.apply(console, args);
            };
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#06612B',
                            medium: '#0B8A3E',
                            light: '#80EE82',
                            lightbg: '#EAFCEB',
                            graybg: '#F5F7F5'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAF8;
        }
    </style>
</head>
<body class="min-h-screen bg-[#F8FAF8] text-slate-800 antialiased p-4 sm:p-6">

    <div class="max-w-350 mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- SIDEBAR KIRI: ADMIN PANEL -->
        <aside class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col justify-between min-h-[calc(100vh-48px)]">
            
            <div>
                <!-- HEADER BRANDING ADMIN PANEL -->
                <div class="flex items-center gap-3 pb-6 border-b border-slate-100">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Subang" class="w-10 h-10 object-contain">
                    <div>
                        <h1 class="font-bold text-[#06612B] text-base leading-tight">
                            Admin Panel
                        </h1>
                        <p class="text-[11px] text-slate-400 font-medium">
                            Desa Sagalaherang
                        </p>
                    </div>
                </div>

                <!-- NAVIGATION MENU -->
                <nav class="space-y-1.5 mt-6">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-solid fa-table-cells-large text-slate-400 text-sm"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('admin.pengaduan.kelola') }}" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-regular fa-file-lines text-slate-400 text-sm"></i>
                        <span>Laporan</span>
                    </a>

                    <!-- Statistik (Active) -->
                    <a href="{{ route('admin.statistik') }}" 
                       class="bg-[#80EE82] text-slate-900 font-bold text-xs px-4 py-3 rounded-xl flex items-center gap-3 shadow-xs transition-all">
                        <i class="fa-solid fa-chart-column text-slate-900 text-sm"></i>
                        <span>Statistik</span>
                    </a>
                </nav>
            </div>

            <!-- BOTTOM SECTION SIDEBAR (mt-auto) -->
            <div class="mt-auto space-y-3 pt-6 border-t border-slate-100">

                <!-- Tombol Logout -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-start gap-2.5 px-3 py-2.5 text-xs font-semibold text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                        <i class="fa-solid fa-right-from-bracket text-xs text-slate-400"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- KONTEN UTAMA KANAN (REKAPITULASI DATA & LAPORAN) -->
        <main class="lg:col-span-9 space-y-6">
            
            <!-- TOP HEADER AREA -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Rekapitulasi Data & Laporan
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
                        Kelola, analisis, dan unduh data pengaduan masyarakat.
                    </p>
                </div>
            </div>

            <!-- FILTER BAR CARD -->
            <form action="{{ route('admin.statistik') }}" method="GET" class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                
                <!-- Filter Rentang Waktu -->
                <div>
                    <label for="rentang" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        RENTANG WAKTU
                    </label>
                    <select id="rentang" 
                            name="rentang" 
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-[#06612B] cursor-pointer">
                        <option value="bulan_ini" {{ $rentangWaktu === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini ({{ now()->translatedFormat('M Y') }})</option>
                        <option value="bulan_lalu" {{ $rentangWaktu === 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu ({{ now()->subMonth()->translatedFormat('M Y') }})</option>
                        <option value="tahun_ini" {{ $rentangWaktu === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini ({{ now()->year }})</option>
                        <option value="semua" {{ $rentangWaktu === 'semua' ? 'selected' : '' }}>Semua Waktu</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <label for="kategori" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        KATEGORI
                    </label>
                    <select id="kategori" 
                            name="kategori" 
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-[#06612B] cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($allKategori as $kat)
                            <option value="{{ $kat->id }}" {{ (string)$kategoriId === (string)$kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <label for="status" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        STATUS
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-[#06612B] cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ $status === 'menunggu' ? 'selected' : '' }}>Menunggu Proses</option>
                        <option value="diproses" {{ $status === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Tombol Terapkan Filter -->
                <div>
                    <button type="submit" 
                            class="w-full bg-[#80EE82] hover:bg-[#6ed970] text-slate-900 font-bold text-xs py-2.5 rounded-xl shadow-xs transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Terapkan Filter</span>
                    </button>
                </div>

            </form>

            <!-- 4 METRIC STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: Total Pengaduan -->
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block mb-1">
                            Total Pengaduan
                        </span>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">
                            {{ $metrics['total_pengaduan'] }}
                        </span>
                        <span class="text-[10px] text-emerald-600 font-semibold block mt-1">
                            {{ $metrics['total_growth'] }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-inbox text-sm"></i>
                    </div>
                </div>

                <!-- Card 2: Menunggu Proses -->
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block mb-1">
                            Menunggu Proses
                        </span>
                        <span class="text-3xl font-extrabold text-amber-600 tracking-tight">
                            {{ $metrics['menunggu_proses'] }}
                        </span>
                        <span class="text-[10px] text-amber-600 font-semibold block mt-1">
                            {{ $metrics['menunggu_note'] }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center">
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
                        <span class="text-[10px] text-slate-500 font-medium block mt-1">
                            {{ $metrics['diproses_note'] }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                        <i class="fa-solid fa-rotate text-sm"></i>
                    </div>
                </div>

                <!-- Card 4: Selesai Ditangani -->
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block mb-1">
                            Selesai Ditangani
                        </span>
                        <span class="text-3xl font-extrabold text-emerald-600 tracking-tight">
                            {{ $metrics['selesai_ditangani'] }}
                        </span>
                        <span class="text-[10px] text-emerald-600 font-semibold block mt-1">
                            {{ $metrics['resolusi_rate'] }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-regular fa-circle-check text-sm"></i>
                    </div>
                </div>

            </div>

            <!-- CHARTS GRID: DONUT CHART & GROUPED BAR CHART -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                
                <!-- CHARTS 1: DONUT CHART PENGADUAN BY CATEGORY (Lg 6 cols) -->
                <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">
                        Pengaduan by Category
                    </h3>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6 my-auto py-4">
                        <!-- SVG Donut Chart Visual -->
                        <div class="relative w-48 h-48 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <!-- Background Circle -->
                                <path class="text-slate-100 stroke-current" stroke-width="6" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                
                                @php
                                    $currentOffset = 0;
                                @endphp
                                @foreach($kategoriChart as $katChart)
                                    @if($katChart['persen'] > 0)
                                        <path stroke="{{ $katChart['warna'] }}" stroke-dasharray="{{ $katChart['persen'] }}, 100" stroke-dashoffset="-{{ $currentOffset }}" stroke-width="6" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        @php
                                            $currentOffset += $katChart['persen'];
                                        @endphp
                                    @endif
                                @endforeach
                            </svg>
                        </div>

                        <!-- Donut Legend -->
                        <div class="space-y-2 text-xs w-full sm:w-auto">
                            @foreach($kategoriChart as $katChart)
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-xs inline-block" style="background-color: {{ $katChart['warna'] }}"></span>
                                    <span class="text-slate-600 font-medium">{{ $katChart['nama'] }} ({{ $katChart['persen'] }}%)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- CHARTS 2: GROUPED BAR CHART RESOLUTION STATUS BY MONTH (Lg 6 cols) -->
                <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-900">
                            Resolution Status by Month
                        </h3>

                        <!-- Legend Bar -->
                        <div class="flex items-center gap-4 text-[11px]">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-xs bg-slate-200"></span>
                                <span class="text-slate-500 font-medium">Masuk</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-xs bg-[#06612B]"></span>
                                <span class="text-slate-500 font-medium">Selesai</span>
                            </div>
                        </div>
                    </div>

                    @php
                        $maxVal = 1;
                        foreach ($resolutionChart as $res) {
                            if ($res['masuk'] > $maxVal) $maxVal = $res['masuk'];
                            if ($res['selesai'] > $maxVal) $maxVal = $res['selesai'];
                        }
                    @endphp

                    <!-- Grouped Bar Chart Visual -->
                    <div>
                        <div class="flex items-end justify-between gap-4 h-48 pt-4 border-b border-slate-100 pb-2">
                            @foreach($resolutionChart as $res)
                                @php
                                    $heightMasuk = $maxVal > 0 ? max(10, round(($res['masuk'] / $maxVal) * 100)) : 10;
                                    $heightSelesai = $maxVal > 0 ? max(10, round(($res['selesai'] / $maxVal) * 100)) : 10;
                                @endphp
                                <div class="w-full flex items-end justify-center gap-1.5 h-full">
                                    <div class="w-4 bg-slate-200 rounded-t-xs" style="height: {{ $res['masuk'] > 0 ? $heightMasuk.'%' : '4px' }}" title="Masuk: {{ $res['masuk'] }}"></div>
                                    <div class="w-4 bg-[#06612B] rounded-t-xs" style="height: {{ $res['selesai'] > 0 ? $heightSelesai.'%' : '4px' }}" title="Selesai: {{ $res['selesai'] }}"></div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between gap-4 pt-2">
                            @foreach($resolutionChart as $res)
                                <span class="w-full text-center text-[11px] font-semibold text-slate-500">{{ $res['bulan'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <!-- DETAIL DATA PENGADUAN TABLE CARD -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
                    <h3 class="text-base font-bold text-slate-900">
                        Detail Data Pengaduan
                    </h3>
                </div>

                <!-- TABLE CONTENT -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase border-b border-slate-100 pb-3">
                                <th class="py-3 px-4">ID</th>
                                <th class="py-3 px-4">TANGGAL</th>
                                <th class="py-3 px-4">PELAPOR</th>
                                <th class="py-3 px-4">KATEGORI</th>
                                <th class="py-3 px-4">JUDUL</th>
                                <th class="py-3 px-4">STATUS</th>
                                <th class="py-3 px-4 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse ($detailData as $item)
                                @php
                                    $badgeClass = match ($item->status) {
                                        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                                        'selesai' => 'bg-emerald-50 text-[#06612B] border-emerald-200/60',
                                        'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                        default => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                        #{{ $item->nomor_tiket }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                        {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800 whitespace-nowrap">
                                        {{ $item->nama_pelapor }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                        {{ $item->kategori->nama ?? 'Umum' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate">
                                        {{ $item->judul }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="{{ $badgeClass }} font-bold text-[10px] uppercase px-2.5 py-0.5 rounded-full inline-block border">
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <a href="{{ route('admin.pengaduan.show', ['id' => $item->id]) }}" 
                                           class="text-[#06612B] hover:text-[#044920] text-sm p-1.5 transition-colors inline-block" 
                                           title="Lihat Detail">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 px-4 text-center text-slate-400">
                                        Belum ada data pengaduan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION FOOTER -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-3 border-t border-slate-100">
                    <span class="text-xs text-slate-400 font-medium">
                        Menampilkan {{ $detailData->firstItem() ?? 0 }}-{{ $detailData->lastItem() ?? 0 }} dari {{ $detailData->total() }} data
                    </span>

                    <div class="flex items-center gap-1 text-xs font-semibold">
                        {{-- Tombol Previous --}}
                        @if ($detailData->onFirstPage())
                            <span class="w-7 h-7 rounded-lg border border-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">&lt;</span>
                        @else
                            <a href="{{ $detailData->previousPageUrl() }}" class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center">&lt;</a>
                        @endif

                        {{-- Nomor Halaman (Windowing / Smart Pagination) --}}
                        @php
                            $currentPage = $detailData->currentPage();
                            $lastPage = $detailData->lastPage();
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($lastPage, $currentPage + 1);
                        @endphp

                        {{-- Halaman Pertama --}}
                        @if ($startPage > 1)
                            <a href="{{ $detailData->url(1) }}" class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center">1</a>
                            @if ($startPage > 2)
                                <span class="px-1 text-slate-400">...</span>
                            @endif
                        @endif

                        {{-- Halaman Sekitar --}}
                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <span class="w-7 h-7 rounded-lg bg-[#80EE82] text-slate-900 font-bold flex items-center justify-center">{{ $page }}</span>
                            @else
                                <a href="{{ $detailData->url($page) }}" class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Halaman Terakhir --}}
                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span class="px-1 text-slate-400">...</span>
                            @endif
                            <a href="{{ $detailData->url($lastPage) }}" class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center">{{ $lastPage }}</a>
                        @endif

                        {{-- Tombol Next --}}
                        @if ($detailData->hasMorePages())
                            <a href="{{ $detailData->nextPageUrl() }}" class="w-7 h-7 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center">&gt;</a>
                        @else
                            <span class="w-7 h-7 rounded-lg border border-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">&gt;</span>
                        @endif
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <footer class="pt-6 border-t border-slate-200/80 text-center text-xs font-medium text-slate-500">
                © 2024 Desa Sagalaherang. Layanan Masyarakat Digital.
            </footer>

        </main>

    </div>

</body>
</html>
