<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Desa Sagalaherang</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
                            peach: '#FFC0B4',
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
                    <div class="w-10 h-10 rounded-xl bg-[#06612B] text-[#80EE82] flex items-center justify-center shadow-md shadow-emerald-900/10">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2L3 9v11a1 1 0 001 1h16a1 1 0 001-1V9l-9-7zm0 2.84L18.5 10H5.5L12 4.84zM5 12h14v7H5v-7z"/>
                        </svg>
                    </div>
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
                    <!-- Dashboard (Active) -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-[#80EE82] text-slate-900 font-bold text-xs px-4 py-3 rounded-xl flex items-center gap-3 shadow-xs transition-all">
                        <i class="fa-solid fa-table-cells-large text-slate-900 text-sm"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Verifikasi Pengaduan -->
                    <a href="#" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-regular fa-square-check text-slate-400 text-sm"></i>
                        <span>Verifikasi Pengaduan</span>
                    </a>

                    <!-- Laporan -->
                    <a href="#" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-regular fa-file-lines text-slate-400 text-sm"></i>
                        <span>Laporan</span>
                    </a>

                    <!-- Statistik -->
                    <a href="#" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-solid fa-chart-column text-slate-400 text-sm"></i>
                        <span>Statistik</span>
                    </a>

                </nav>
            </div>

            <!-- BOTTOM SECTION SIDEBAR (mt-auto) -->
            <div class="mt-auto space-y-3 pt-6 border-t border-slate-100">

                <!-- Tombol Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-start gap-2.5 px-3 py-2.5 text-xs font-semibold text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                        <i class="fa-solid fa-right-from-bracket text-xs text-slate-400"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- KONTEN UTAMA KANAN (DASHBOARD OVERVIEW) -->
        <main class="lg:col-span-9 space-y-6">
            
            <!-- TOP HEADER AREA -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Dashboard Overview
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
                        Selamat datang kembali, Admin.
                    </p>
                </div>

                <!-- Admin Profile Card Badge -->
                <div class="bg-white rounded-full border border-slate-100 shadow-sm p-1.5 pr-5 flex items-center gap-3 self-start sm:self-auto">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop" 
                         alt="Admin Profile" 
                         class="w-9 h-9 rounded-full object-cover border border-slate-100">
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs">
                            {{ $adminUser ? $adminUser->nama : 'Budi Santoso' }}
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
                        <span class="text-3xl font-extrabold text-rose-600 tracking-tight">
                            {{ $metrics['belum_diverifikasi'] }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center">
                        <i class="fa-regular fa-calendar-xmark text-sm"></i>
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
                    <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-rotate text-sm"></i>
                    </div>
                </div>

                <!-- Card 4: Selesai -->
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block mb-1">
                            Selesai
                        </span>
                        <span class="text-3xl font-extrabold text-emerald-600 tracking-tight">
                            {{ $metrics['selesai'] }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-regular fa-circle-check text-sm"></i>
                    </div>
                </div>

            </div>

            <!-- GRID KONTEN: TREN MINGGUAN & PENGADUAN TERBARU PERLU VERIFIKASI -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                
                <!-- KOLOM KIRI: TREN PENGADUAN MINGGUAN -->
                <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <h3 class="text-base font-bold text-slate-900 mb-6">
                        Tren Pengaduan Mingguan
                    </h3>

                    <!-- BAR CHART VISUAL -->
                    <div>
                        <div class="flex items-end justify-between gap-2 h-56 pt-6 border-b border-slate-100 pb-2">
                            @foreach ($trenMingguan as $item)
                                <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                                    <div class="w-full bg-[#80EE82] hover:bg-[#68d86a] rounded-t-lg transition-all duration-300" 
                                         style="height: {{ $item['nilai'] }}%;"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between gap-2 pt-2">
                            @foreach ($trenMingguan as $item)
                                <span class="w-full text-center text-[11px] font-semibold text-slate-500">
                                    {{ $item['hari'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: PENGADUAN TERBARU PERLU VERIFIKASI -->
                <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
                    
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-900">
                            Pengaduan Terbaru Perlu Verifikasi
                        </h3>
                        <a href="#" class="text-xs font-semibold text-[#06612B] hover:underline">
                            Lihat Semua
                        </a>
                    </div>

                    <!-- TABEL PENGADUAN -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] font-bold text-slate-400 uppercase border-b border-slate-100 pb-3">
                                    <th class="py-2.5 px-3">Tanggal</th>
                                    <th class="py-2.5 px-3">Nama Warga</th>
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach ($perluVerifikasi as $item)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-3.5 px-3 text-slate-600 font-normal whitespace-nowrap">
                                            {{ $item['tanggal'] ?? '-' }}
                                        </td>
                                        <td class="py-3.5 px-3 font-bold text-slate-900 whitespace-nowrap">
                                            {{ $item['nama_warga'] ?? ($item['nama_pelapor'] ?? 'Warga') }}
                                        </td>
                                        <td class="py-3.5 px-3 whitespace-nowrap">
                                            <span class="{{ $item['badge_class'] ?? 'bg-emerald-50 text-emerald-700 border-emerald-100' }} font-semibold text-[10px] px-2.5 py-0.5 rounded-full inline-block border">
                                                {{ $item['kategori'] ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-3 text-right whitespace-nowrap">
                                            <a href="{{ route('admin.pengaduan.kelola') }}" 
                                               class="bg-[#80EE82] hover:bg-[#6ed970] text-[#06612B] font-bold text-xs px-3.5 py-1.5 rounded-lg transition-all inline-block shadow-xs">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </main>

    </div>

</body>
</html>
