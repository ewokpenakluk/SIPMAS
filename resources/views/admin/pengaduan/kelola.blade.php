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

    <div class="max-w-350 mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
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
                    <a href="{{ route('admin.statistik') }}" 
                       class="text-slate-600 hover:bg-slate-50 hover:text-[#06612B] font-medium text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-colors">
                        <i class="fa-solid fa-chart-column text-slate-400 text-sm"></i>
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

            <!-- LIVE SEARCH BAR TIKET PENGADUAN -->
            <div class="relative z-30" id="liveSearchContainer">
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-xs focus-within:ring-2 focus-within:ring-[#06612B]/20 focus-within:border-[#06612B] transition-all">
                    <div class="flex items-center px-4 py-3 gap-3">
                        <div class="text-[#06612B] flex items-center justify-center">
                            <i id="searchIcon" class="fa-solid fa-magnifying-glass text-sm"></i>
                            <i id="searchSpinner" class="fa-solid fa-circle-notch fa-spin text-sm hidden text-emerald-600"></i>
                        </div>
                        <input type="text" 
                               id="liveSearchInput" 
                               autocomplete="off"
                               placeholder="Cari tiket pengaduan (contoh: ADU-2026..., nama warga, atau judul masalah)..." 
                               class="w-full text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 bg-transparent focus:outline-none font-medium">
                        
                        <button type="button" 
                                id="clearSearchBtn" 
                                class="hidden text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100 transition-all text-xs"
                                title="Bersihkan pencarian">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>

                        <div class="hidden sm:flex items-center gap-1.5 pl-3 border-l border-slate-200 text-[10px] text-slate-400 font-semibold uppercase">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Live Search</span>
                        </div>
                    </div>
                </div>

                <!-- FLOATING DROPDOWN HASIL PENCARIAN -->
                <div id="searchResultsDropdown" 
                     class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden z-50 transition-all divide-y divide-slate-100">
                    <div class="p-3 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
                        <span id="resultsCount">Hasil Pencarian</span>
                        <span class="text-[10px] text-slate-400">Klik untuk langsung membuka laporan</span>
                    </div>
                    <div id="searchResultsList" class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                        <!-- Item hasil pencarian akan dirender melalui JavaScript -->
                    </div>
                </div>
            </div>

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
                        <div class="bg-slate-50 rounded-xl border border-slate-100 overflow-hidden p-3">
                            @if (!empty($laporan['bukti_foto']))
                                <a href="{{ $laporan['bukti_foto'] }}" target="_blank" title="Klik untuk memperbesar gambar" class="block group relative w-full overflow-hidden rounded-xl border border-slate-200 bg-white">
                                    <img src="{{ $laporan['bukti_foto'] }}" 
                                         alt="Bukti Foto Pengaduan" 
                                         class="w-full max-h-72 object-contain mx-auto group-hover:scale-[1.02] transition-transform duration-200">
                                    <div class="absolute inset-0 bg-slate-900/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <span class="bg-slate-900/80 text-white text-[11px] font-semibold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm">
                                            <i class="fa-solid fa-up-right-and-down-left-from-center text-[10px]"></i>
                                            <span>Lihat Ukuran Penuh</span>
                                        </span>
                                    </div>
                                </a>
                            @else
                                <div class="w-full py-8 text-center text-slate-400 bg-white rounded-xl border border-dashed border-slate-200">
                                    <i class="fa-regular fa-image text-3xl mb-1 block"></i>
                                    <span class="text-xs font-medium">Tidak ada foto bukti yang dilampirkan</span>
                                </div>
                            @endif
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

    <!-- SCRIPT LIVE SEARCH PENGADUAN -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('liveSearchInput');
            const searchIcon = document.getElementById('searchIcon');
            const searchSpinner = document.getElementById('searchSpinner');
            const clearBtn = document.getElementById('clearSearchBtn');
            const dropdown = document.getElementById('searchResultsDropdown');
            const resultsList = document.getElementById('searchResultsList');
            const resultsCount = document.getElementById('resultsCount');

            let debounceTimer = null;

            function showLoading(isLoading) {
                if (isLoading) {
                    searchIcon.classList.add('hidden');
                    searchSpinner.classList.remove('hidden');
                } else {
                    searchIcon.classList.remove('hidden');
                    searchSpinner.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                
                if (query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                    dropdown.classList.add('hidden');
                    return;
                }

                clearTimeout(debounceTimer);
                showLoading(true);

                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('admin.pengaduan.search.live') }}?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        showLoading(false);
                        renderResults(data, query);
                    })
                    .catch(err => {
                        showLoading(false);
                        console.error('Live search error:', err);
                    });
                }, 200);
            });

            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                clearBtn.classList.add('hidden');
                dropdown.classList.add('hidden');
                searchInput.focus();
            });

            function renderResults(items, query) {
                resultsList.innerHTML = '';

                if (!items || items.length === 0) {
                    resultsCount.textContent = 'Tidak ada hasil';
                    resultsList.innerHTML = `
                        <div class="py-8 px-4 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-2xl mb-1.5 block text-slate-300"></i>
                            <p class="text-xs font-semibold text-slate-700">Tiket tidak ditemukan</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada pengaduan dengan kata kunci "<b>${escapeHtml(query)}</b>"</p>
                        </div>
                    `;
                    dropdown.classList.remove('hidden');
                    return;
                }

                resultsCount.textContent = `Ditemukan ${items.length} Pengaduan`;

                items.forEach(item => {
                    const a = document.createElement('a');
                    a.href = item.url;
                    a.className = 'block p-3.5 hover:bg-slate-50 transition-colors flex items-center justify-between gap-3 group';

                    a.innerHTML = `
                        <div class="flex items-start gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-[#06612B] flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-[#06612B] group-hover:text-white transition-colors">
                                <i class="fa-solid fa-file-invoice text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-extrabold text-xs text-slate-900 group-hover:text-[#06612B] transition-colors">${escapeHtml(item.nomor_tiket)}</span>
                                    <span class="${item.badge_class} font-bold text-[9px] uppercase px-2 py-0.5 rounded-full border">${escapeHtml(item.status)}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">${escapeHtml(item.tanggal)}</span>
                                </div>
                                <h4 class="text-xs font-semibold text-slate-700 truncate mt-0.5">${escapeHtml(item.judul || 'Pengaduan Warga')}</h4>
                                <p class="text-[11px] text-slate-400 truncate">Pelapor: <span class="text-slate-600 font-medium">${escapeHtml(item.nama_pelapor)}</span> • Kategori: <span class="text-slate-600">${escapeHtml(item.kategori)}</span></p>
                            </div>
                        </div>
                        <div class="shrink-0 text-slate-300 group-hover:text-[#06612B] group-hover:translate-x-0.5 transition-all">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                    `;

                    resultsList.appendChild(a);
                });

                dropdown.classList.remove('hidden');
            }

            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Tutup dropdown saat klik di luar container
            document.addEventListener('click', (e) => {
                const container = document.getElementById('liveSearchContainer');
                if (container && !container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>
