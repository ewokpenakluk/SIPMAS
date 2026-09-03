<!-- SIDEBAR ADMIN CONTAINER -->
<aside class="w-full md:w-64 bg-white border-r border-slate-100 p-5 flex flex-col shrink-0">
    
    <!-- TOP LOGO & BRAND -->
    <div class="flex items-center gap-3 pb-6 border-b border-slate-100">
        <div class="w-10 h-10 rounded-xl bg-[#06612B] text-[#80EE82] flex items-center justify-center font-bold shadow-sm shadow-emerald-900/20">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M12 2L3 9v11a1 1 0 001 1h16a1 1 0 001-1V9l-9-7zm0 2.84L18.5 10H5.5L12 4.84zM5 12h14v7H5v-7z"/>
            </svg>
        </div>
        <div>
            <h2 class="font-extrabold text-slate-900 text-sm tracking-tight leading-tight">
                Desa Sagalaherang
            </h2>
            <span class="text-[11px] text-slate-400 font-medium">
                Admin Panel
            </span>
        </div>
    </div>

    <!-- PROFIL ADMIN TERMASUK LOGGED-IN USER -->
    <div class="py-5 border-b border-slate-100">
        <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
            <div class="w-10 h-10 rounded-full overflow-hidden border border-emerald-500/30 bg-emerald-100 shrink-0">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=256&auto=format&fit=crop" 
                     alt="Admin Avatar" 
                     class="w-full h-full object-cover">
            </div>
            <div class="overflow-hidden">
                <h3 class="font-bold text-slate-900 text-xs truncate">
                    {{ Auth::user()->nama ?? 'Budi Santoso' }}
                </h3>
                <span class="text-[10px] text-emerald-700 font-semibold block uppercase tracking-wider">
                    {{ Auth::user()->peran ?? 'Kepala Desa' }}
                </span>
            </div>
        </div>
    </div>

    <!-- MENU NAVIGASI ADMIN -->
    <nav class="py-6 space-y-1.5 grow">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 block mb-2">
            Menu Utama
        </span>

        <!-- Menu 1: Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="font-semibold text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#80EE82]/30 text-[#06612B] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-[#06612B]' }}">
            <i class="fa-solid fa-chart-line text-sm {{ request()->routeIs('admin.dashboard') ? 'text-[#06612B]' : 'text-slate-400' }}"></i>
            <span>Dashboard</span>
        </a>

        <!-- Menu 2: Verifikasi Pengaduan -->
        <a href="{{ route('admin.pengaduan.kelola') }}" 
           class="font-semibold text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-all {{ request()->routeIs('admin.pengaduan.*') ? 'bg-[#80EE82]/30 text-[#06612B] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-[#06612B]' }}">
            <i class="fa-regular fa-square-check text-sm {{ request()->routeIs('admin.pengaduan.*') ? 'text-[#06612B]' : 'text-slate-400' }}"></i>
            <span>Verifikasi Pengaduan</span>
        </a>

        <!-- Menu 3: Statistik & Rekapitulasi Data -->
        <a href="{{ route('admin.statistik') }}" 
           class="font-semibold text-xs px-4 py-3 rounded-xl flex items-center gap-3 transition-all {{ request()->routeIs('admin.statistik') ? 'bg-[#80EE82]/30 text-[#06612B] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-[#06612B]' }}">
            <i class="fa-solid fa-chart-column text-sm {{ request()->routeIs('admin.statistik') ? 'text-[#06612B]' : 'text-slate-400' }}"></i>
            <span>Statistik & Rekapitulasi</span>
        </a>
    </nav>

    <!-- BOTTOM SECTION SIDEBAR (mt-auto): LOGOUT -->
    <div class="mt-auto pt-6 border-t border-slate-100">
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
