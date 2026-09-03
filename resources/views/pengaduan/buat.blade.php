@extends('layouts.app')

@section('title', 'Ajukan Pengaduan - Desa Sagalaherang')

@section('content')
<div class="max-w-xl sm:max-w-2xl mx-auto px-4 py-8">

    <!-- LINK KEMBALI KE DASHBOARD -->
    <a href="{{ route('dashboard') }}" 
       class="text-xs font-semibold text-slate-600 hover:text-[#06612B] inline-flex items-center gap-1.5 mb-4 group transition-colors">
        <i class="fa-solid fa-arrow-left text-[11px] group-hover:-translate-x-0.5 transition-transform"></i>
        <span>Kembali ke Dashboard</span>
    </a>

    <!-- CARD FORM AJUKAN PENGADUAN CONTAINER -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-6">
        
        <!-- HEADER INSIDE CARD -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#06612B] tracking-tight">
                Ajukan Pengaduan Baru
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1 leading-relaxed">
                Sampaikan laporan permasalahan di lingkungan Anda untuk segera kami tindaklanjuti.
            </p>
        </div>

        <!-- ALERT ERROR -->
        @if ($errors->any())
            <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 text-xs">
                <div class="font-semibold mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Mohon lengkapi data form berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM AJUKAN PENGADUAN -->
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Field 1: Kategori Masalah -->
            <div>
                <label for="kategori_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Kategori Masalah
                </label>
                <div class="relative">
                    <select id="kategori_id" 
                            name="kategori_id" 
                            required 
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] appearance-none cursor-pointer">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Field 2: Deskripsi Masalah -->
            <div>
                <label for="deskripsi" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Deskripsi Masalah
                </label>
                <textarea id="deskripsi" 
                          name="deskripsi" 
                          rows="4" 
                          required 
                          placeholder="Ceritakan secara detail apa yang terjadi..." 
                          class="w-full p-3.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all resize-none">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Grid 2 Cols: Lokasi & Tanggal Kejadian -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Field 3: Lokasi / Alamat Kejadian -->
                <div>
                    <label for="lokasi" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Lokasi / Alamat Kejadian
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                        </div>
                        <input type="text" 
                               id="lokasi" 
                               name="lokasi" 
                               value="{{ old('lokasi') }}" 
                               required 
                               placeholder="Contoh: Jl. Raya Sagalaherang No. 10" 
                               class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                    </div>
                </div>

                <!-- Field 4: Tanggal Kejadian -->
                <div>
                    <label for="tanggal_kejadian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Tanggal Kejadian
                    </label>
                    <input type="date" 
                           id="tanggal_kejadian" 
                           name="tanggal_kejadian" 
                           value="{{ old('tanggal_kejadian', date('Y-m-d')) }}" 
                           required 
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-[#06612B] focus:ring-1 focus:ring-[#06612B] transition-all">
                </div>

            </div>

            <!-- Field 5: Unggah Foto Bukti -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Unggah Foto Bukti
                </label>
                
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center space-y-2 transition-all hover:border-[#06612B] group cursor-pointer"
                     onclick="document.getElementById('foto').click()">
                    
                    <div class="w-10 h-10 rounded-full bg-slate-200/80 group-hover:bg-[#EAFCEB] group-hover:text-[#06612B] text-slate-600 flex items-center justify-center mx-auto mb-2 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                    </div>

                    <span class="text-xs font-bold text-slate-700 block">
                        Tarik & Lepas foto ke sini
                    </span>
                    <span class="text-[11px] text-slate-400 font-normal block mb-2">
                        atau klik untuk memilih file (JPG/PNG max 5MB)
                    </span>

                    <button type="button" 
                            class="border border-[#06612B] text-[#06612B] group-hover:bg-[#06612B] group-hover:text-white font-semibold text-xs px-5 py-1.5 rounded-full transition-all inline-block">
                        Pilih File
                    </button>

                    <input type="file" 
                           id="foto" 
                           name="foto" 
                           accept="image/*" 
                           class="hidden" 
                           onchange="previewFileName(this)">
                </div>

                <div id="file-name-preview" class="mt-2 text-xs font-semibold text-[#06612B] hidden flex items-center gap-1.5">
                    <i class="fa-regular fa-image"></i>
                    <span id="file-name-text"></span>
                </div>
            </div>

            <!-- ACTION BUTTONS BOTTOM RIGHT -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <!-- Tombol Batal (Hijau Muda) -->
                <a href="{{ route('dashboard') }}" 
                   class="bg-[#80EE82] hover:bg-[#6ed970] text-[#06612B] font-semibold text-xs px-6 py-2.5 rounded-xl shadow-sm transition-all">
                    Batal
                </a>

                <!-- Tombol Kirim Pengaduan (Hijau Utama) -->
                <button type="submit" 
                        class="bg-[#06612B] hover:bg-[#044920] text-white font-semibold text-xs px-6 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-[0.99] flex items-center gap-2">
                    <span>Kirim Pengaduan</span>
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    function previewFileName(input) {
        const previewBox = document.getElementById('file-name-preview');
        const previewText = document.getElementById('file-name-text');
        
        if (input.files && input.files[0]) {
            previewText.textContent = input.files[0].name;
            previewBox.classList.remove('hidden');
        } else {
            previewBox.classList.add('hidden');
        }
    }
</script>
@endsection
