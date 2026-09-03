<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda - Desa Sagalaherang')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
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
<body class="min-h-screen flex flex-col text-slate-800 antialiased selection:bg-brand-medium selection:text-white">

    <!-- NAVBAR HEADER (Tidak ditampilkan pada halaman Login & Auth) -->
    @unless(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('portal') || request()->routeIs('admin.login'))
    <header class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Logo & Brand Name -->
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-brand-dark flex items-center justify-center text-white font-bold shadow-sm shadow-brand-dark/20 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6 fill-current text-brand-light" viewBox="0 0 24 24">
                        <path d="M12 2L3 9v11a1 1 0 001 1h16a1 1 0 001-1V9l-9-7zm0 2.84L18.5 10H5.5L12 4.84zM5 12h14v7H5v-7z"/>
                    </svg>
                </div>
                <span class="font-bold text-xl tracking-tight text-slate-900 group-hover:text-brand-dark transition-colors">
                    Desa Sagalaherang
                </span>
            </a>

            <!-- Navigation Links & Right Actions (Hanya ditampilkan selain di Beranda) -->
            @unless(request()->routeIs('beranda'))
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('beranda') }}" class="relative font-medium text-sm transition-colors py-2 {{ request()->routeIs('beranda') ? 'text-brand-dark font-semibold' : 'text-slate-500 hover:text-slate-800' }}">
                    Beranda
                    @if(request()->routeIs('beranda'))
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-dark rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('pengaduan.lacak') }}" class="relative font-medium text-sm transition-colors py-2 {{ request()->routeIs('pengaduan.lacak') ? 'text-brand-dark font-semibold' : 'text-slate-500 hover:text-brand-dark' }}">
                    Lacak
                    @if(request()->routeIs('pengaduan.lacak'))
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-dark rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('riwayat') }}" class="relative font-medium text-sm transition-colors py-2 {{ request()->routeIs('riwayat') || request()->routeIs('dashboard') ? 'text-brand-dark font-semibold' : 'text-slate-500 hover:text-brand-dark' }}">
                    Riwayat
                    @if(request()->routeIs('riwayat') || request()->routeIs('dashboard'))
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-dark rounded-full"></span>
                    @endif
                </a>
            </nav>

            <!-- Right Actions: Bell Notification & User Profile Avatar -->
            <div class="flex items-center gap-5">
                <button type="button" class="text-slate-500 hover:text-brand-dark transition-colors p-2 rounded-full hover:bg-slate-100 relative" title="Notifikasi">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
                </button>
                <a href="{{ route('profil') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center group-hover:border-brand-dark transition-colors">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop" alt="User Profile" class="w-full h-full object-cover">
                    </div>
                </a>
            </div>
            @endunless
        </div>
    </header>
    @endunless

    <!-- MAIN CONTENT AREA -->
    <main class="grow w-full">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-auto py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-500">
            <div>
                © 2024 Desa Sagalaherang. Layanan Masyarakat Digital.
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('kontak') }}" class="hover:text-brand-dark transition-colors">Kontak</a>
                <a href="{{ route('kebijakan-privasi') }}" class="hover:text-brand-dark transition-colors">Kebijakan Privasi</a>
                <a href="{{ route('bantuan') }}" class="hover:text-brand-dark transition-colors">Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>
