<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - Admin Desa Sagalaherang</title>
    
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

    <div class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- SIDEBAR KIRI: ADMIN PANEL -->
        <aside class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col justify-between min-h-[calc(100vh-48px)]">
            
            <div>
                <!-- HEADER BRANDING ADMIN PANEL -->
                <div class="flex items-center gap-3 pb-6 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-[#06612B] text-[#80EE82] flex items-center justify-center font-bold shadow-md shadow-emerald-900/10">
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
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-solid fa-table-cells-large text-slate-400 text-sm"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Laporan (Active) -->
                    <a href="{{ route('admin.pengaduan.kelola') }}" 
                       class="bg-[#80EE82] text-slate-900 font-bold text-xs px-4 py-3 rounded-xl flex items-center gap-3 shadow-xs transition-all">
                        <i class="fa-regular fa-file-lines text-slate-900 text-sm"></i>
                        <span>Laporan</span>
                    </a>

                    <!-- Statistik -->
                    <a href="#" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-solid fa-chart-column text-slate-400 text-sm"></i>
                        <span>Statistik</span>
                    </a>

                    <!-- Pengaturan -->
                    <a href="#" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-solid fa-gear text-slate-400 text-sm"></i>
                        <span>Pengaturan</span>
                    </a>
                </nav>
            </div>

            <!-- BOTTOM SECTION SIDEBAR (mt-auto) -->
            <div class="mt-auto space-y-3 pt-6 border-t border-slate-100">
                <!-- Tombol + Buat Laporan -->
                <a href="{{ route('pengaduan.buat') }}" 
                   class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3.5 px-4 rounded-full flex items-center justify-center gap-2 shadow-sm transition-all hover:shadow-md active:scale-[0.99]">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Buat Laporan</span>
                </a>

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

        <!-- KONTEN UTAMA KANAN (KELOLA PENGADUAN) -->
        <main class="lg:col-span-9 space-y-6">
            
            <!-- HEADER TOP AREA -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-xs font-semibold text-[#06612B] hover:underline inline-flex items-center gap-1.5 mb-1">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Kembali ke Daftar Laporan</span>
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Verifikasi Laporan #{{ $laporan['nomor_tiket'] }}
                    </h1>
                </div>

                <!-- Status Saat Ini Pill (Top Right) -->
                <div class="self-start sm:self-auto">
                    <span class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 text-xs font-semibold px-4 py-2 rounded-full border border-slate-200 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Status Saat Ini : {{ $laporan['status_label'] }}</span>
                    </span>
                </div>
            </div>

            <!-- SUCCESS ALERT -->
            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- GRID 2 KOLOM: DETAIL PENGADUAN & TINDAKAN ADMIN -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                
                <!-- KARTU KIRI: DETAIL PENGADUAN (Md 7 cols) -->
                <div class="md:col-span-7 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                    
                    <h2 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
                        Detail Pengaduan
                    </h2>

                    <!-- Meta Grid 2 Columns -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-medium block mb-1">Nama Pelapor</span>
                            <span class="font-bold text-slate-900 text-xs sm:text-sm">
                                {{ $laporan['nama_pelapor'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block mb-1">Kategori</span>
                            <span class="font-bold text-slate-900 text-xs sm:text-sm">
                                {{ $laporan['kategori'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block mb-1">Tanggal Dilaporkan</span>
                            <span class="font-semibold text-slate-800">
                                {{ $laporan['tanggal_dilaporkan'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block mb-1">Lokasi Kejadian</span>
                            <span class="font-semibold text-slate-800">
                                {{ $laporan['lokasi'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Box Deskripsi Lengkap -->
                    <div>
                        <span class="text-xs font-bold text-slate-800 mb-1.5 block">
                            Deskripsi Lengkap
                        </span>
                        <div class="bg-slate-50 rounded-xl p-4 text-xs text-slate-700 leading-relaxed border border-slate-100 font-normal">
                            {{ $laporan['deskripsi'] }}
                        </div>
                    </div>

                    <!-- Box Bukti Foto -->
                    <div>
                        <span class="text-xs font-bold text-slate-800 mb-2 block">
                            Bukti Foto
                        </span>
                        <div class="bg-slate-50 rounded-xl border border-slate-100 overflow-hidden flex items-center justify-center p-3">
                            <div class="w-full max-h-60 rounded-xl overflow-hidden bg-white border border-slate-200 flex items-center justify-center p-6">
                                <div class="text-center py-4">
                                    <div class="w-20 h-20 rounded-2xl bg-[#06612B] text-[#80EE82] flex items-center justify-center mx-auto mb-2 shadow-md">
                                        <svg class="w-12 h-12 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2L3 9v11a1 1 0 001 1h16a1 1 0 001-1V9l-9-7zm0 2.84L18.5 10H5.5L12 4.84zM5 12h14v7H5v-7z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-[#06612B] block">Desa Sagalaherang</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- KARTU KANAN: TINDAKAN ADMIN (Md 5 cols) -->
                <div class="md:col-span-5 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                    
                    <div class="flex items-center gap-2 text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
                        <i class="fa-regular fa-pen-to-square text-[#06612B]"></i>
                        <span>Tindakan Admin</span>
                    </div>

                    <form action="{{ route('admin.pengaduan.update', ['id' => $laporan['id']]) }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Field Ubah Status -->
                        <div>
                            <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Ubah Status
                            </label>
                            <div class="relative">
                                <select id="status" 
                                        name="status" 
                                        class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] cursor-pointer appearance-none">
                                    <option value="menunggu" {{ $laporan['status'] == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diproses">Sedang Diproses</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Field Tulis Tanggapan Resmi -->
                        <div>
                            <label for="pesan" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Tulis Tanggapan Resmi
                            </label>
                            <textarea id="pesan" 
                                      name="pesan" 
                                      rows="4" 
                                      placeholder="Masukkan tanggapan yang akan dikirim ke pelapor..." 
                                      class="w-full p-3 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all resize-none"></textarea>
                        </div>

                        <!-- Tombol Action 1: Simpan Update (Full-width Green) -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3.5 rounded-full flex items-center justify-center gap-2 shadow-sm transition-all hover:shadow-md active:scale-[0.99]">
                                <i class="fa-regular fa-floppy-disk text-xs"></i>
                                <span>Simpan Update</span>
                            </button>
                        </div>
                    </form>

                    <!-- Tombol Action 2: Tolak Laporan (Outline Red) -->
                    <form action="{{ route('admin.pengaduan.update', ['id' => $laporan['id']]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="ditolak">
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin menolak laporan ini?')" 
                                class="w-full border border-rose-500 text-rose-600 hover:bg-rose-50 font-semibold text-xs py-3 rounded-full flex items-center justify-center transition-all">
                            <span>Tolak Laporan</span>
                        </button>
                    </form>

                </div>

            </div>

            <!-- KARTU BAWAH: RIWAYAT PERUBAHAN (AUDIT LOG TIMELINE) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                
                <div class="flex items-center gap-2 text-base font-bold text-slate-900 pb-2">
                    <i class="fa-solid fa-rotate-left text-[#06612B]"></i>
                    <span>Riwayat Perubahan</span>
                </div>

                <!-- Timeline List -->
                <div class="space-y-3">
                    @foreach ($laporan['riwayat_perubahan'] as $riwayat)
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center justify-between gap-4 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                <div>
                                    <h4 class="font-bold text-xs text-slate-900">
                                        {{ $riwayat['judul'] }}
                                    </h4>
                                    <p class="text-[11px] text-slate-500 font-normal mt-0.5">
                                        Oleh: {{ $riwayat['oleh'] }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-medium whitespace-nowrap">
                                {{ $riwayat['waktu'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- FOOTER -->
            <footer class="pt-6 border-t border-slate-200/80 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-500">
                <div>
                    © 2024 Desa Sagalaherang. Layanan Masyarakat Digital.
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('kontak') }}" class="hover:text-brand-dark transition-colors">Kontak</a>
                    <a href="{{ route('kebijakan-privasi') }}" class="hover:text-brand-dark transition-colors">Kebijakan Privasi</a>
                    <a href="{{ route('bantuan') }}" class="hover:text-brand-dark transition-colors">Bantuan</a>
                </div>
            </footer>

        </main>

    </div>

</body>
</html>
