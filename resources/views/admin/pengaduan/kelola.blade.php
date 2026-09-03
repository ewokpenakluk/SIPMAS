@extends('layouts.admin')

@section('title', 'Verifikasi Laporan - Admin Desa Sagalaherang')

@section('content')
<div class="space-y-6">

    <!-- LINK KEMBALI & TOP STATUS BADGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" 
               class="text-xs font-semibold text-slate-500 hover:text-[#06612B] inline-flex items-center gap-1.5 mb-2 group transition-colors">
                <i class="fa-solid fa-arrow-left text-[11px] group-hover:-translate-x-0.5 transition-transform"></i>
                <span>Kembali ke Daftar Laporan</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Verifikasi Laporan</span>
                <span class="text-[#06612B]">#{{ $laporan['nomor_tiket'] }}</span>
            </h1>
        </div>

        <!-- Status Badge Indicator Top Right -->
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-slate-500">Status Laporan:</span>
            <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200/60 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                <span>{{ strtoupper($laporan['status_label']) }}</span>
            </span>
        </div>
    </div>

    <!-- NOTIFIKASI SUCCESS / ERROR -->
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- GRID KONTEN 2 KOLOM (DETAIL LAPORAN & TINDAKAN ADMIN) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- KOLOM KIRI: DETAIL LAPORAN & BUKTI FOTO (LG:COL-SPAN-7) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- KARTU INFORMASI PELAPOR & ISI DETAIL PENGADUAN -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-600">
                            <i class="fa-regular fa-user text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">
                                {{ $laporan['nama_pelapor'] }}
                            </h3>
                            <span class="text-[11px] text-slate-400 font-medium">
                                Pelapor • NIK 3213XXXXXXXXXXXX
                            </span>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">
                        {{ $laporan['kategori'] }}
                    </span>
                </div>

                <!-- Detail Lokasi & Waktu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">
                            Tanggal Kejadian / Lapor
                        </span>
                        <span class="font-semibold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-check text-slate-400"></i>
                            <span>{{ $laporan['tanggal_dilaporkan'] }}</span>
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">
                            Lokasi Kejadian
                        </span>
                        <span class="font-semibold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-rose-500"></i>
                            <span>{{ $laporan['lokasi'] }}</span>
                        </span>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="space-y-2 pt-2">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                        Deskripsi Permasalahan
                    </h4>
                    <p class="text-xs text-slate-700 leading-relaxed font-normal bg-white p-4 rounded-xl border border-slate-100">
                        {{ $laporan['deskripsi'] }}
                    </p>
                </div>

                <!-- Lampiran Foto Bukti -->
                <div class="space-y-2 pt-2">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                        Foto Bukti Kejadian
                    </h4>
                    <div class="rounded-2xl overflow-hidden border border-slate-100 shadow-sm max-h-80 bg-slate-100 group relative">
                        <img src="{{ $laporan['bukti_foto'] }}" 
                             alt="Bukti Pengaduan" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN: FORM TINDAKAN ADMIN & AUDIT TIMELINE (LG:COL-SPAN-5) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- KARTU FORM TINDAKAN & TANGGAPAN ADMIN -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-extrabold text-slate-900 text-sm tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-[#06612B] fa-user-shield text-base text-[#06612B]"></i>
                        <span>Tindakan & Respon Admin</span>
                    </h3>
                    <p class="text-xs text-slate-400 font-normal mt-0.5">
                        Pilih status terbaru dan berikan tanggapan resmi.
                    </p>
                </div>

                <!-- FORM UPDATE STATUS & TANGGAPAN -->
                <form action="{{ route('admin.pengaduan.update', ['id' => $laporan['id']]) }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Update Status Select -->
                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Ubah Status Pengaduan
                        </label>
                        <select id="status" 
                                name="status" 
                                required 
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] cursor-pointer">
                            <option value="menunggu" {{ $laporan['status'] === 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                            <option value="diproses" {{ $laporan['status'] === 'diproses' ? 'selected' : '' }}>🔄 Sedang Diproses Tim</option>
                            <option value="selesai" {{ $laporan['status'] === 'selesai' ? 'selected' : '' }}>✅ Selesai Ditangani</option>
                            <option value="ditolak" {{ $laporan['status'] === 'ditolak' ? 'selected' : '' }}>❌ Ditolak / Tidak Valid</option>
                        </select>
                    </div>

                    <!-- Input Tanggapan Resmi -->
                    <div>
                        <label for="tanggapan" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Tulis Tanggapan Resmi Admin
                        </label>
                        <textarea id="tanggapan" 
                                  name="tanggapan" 
                                  rows="4" 
                                  required 
                                  placeholder="Tuliskan catatan tindak lanjut atau tanggapan resmi dari pihak desa untuk masyarakat..." 
                                  class="w-full p-3.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] resize-none"></textarea>
                    </div>

                    <!-- Action Submit Buttons -->
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" 
                                name="action" 
                                value="simpan" 
                                class="w-full bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs py-3 px-4 rounded-xl shadow-sm transition-all text-center">
                            Simpan Update
                        </button>
                        
                        <button type="submit" 
                                name="action" 
                                value="tolak" 
                                class="border border-rose-200 text-rose-600 hover:bg-rose-50 font-semibold text-xs py-3 px-4 rounded-xl transition-all text-center">
                            Tolak Laporan
                        </button>
                    </div>
                </form>
            </div>

            <!-- KARTU AUDIT LOG & HISTORI PERUBAHAN STATUS -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                    <span>Audit Log & Histori Status</span>
                </h3>

                <div class="relative pl-6 space-y-4 border-l-2 border-slate-100 text-xs">
                    @foreach ($laporan['riwayat_perubahan'] as $riwayat)
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0.5 w-3.5 h-3.5 rounded-full bg-[#80EE82] border-2 border-white ring-2 ring-emerald-500/20"></span>
                            <h5 class="font-bold text-slate-900">
                                {{ $riwayat['judul'] }}
                            </h5>
                            <span class="text-[11px] text-slate-400 font-normal block">
                                Oleh: {{ $riwayat['oleh'] }} • {{ $riwayat['waktu'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
