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
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAF8;
        }
        /* Subtle Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-slate-800 antialiased selection:bg-brand-medium selection:text-white">

    <!-- NAVBAR HEADER (Tidak ditampilkan pada halaman Login & Auth) -->
    @unless(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('portal') || request()->routeIs('admin.login'))
    <header class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            @php
                $brandLink = route('beranda');
                if (Auth::check()) {
                    $brandLink = Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard');
                }
            @endphp
            <!-- Logo & Brand Name -->
            <a href="{{ $brandLink }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Subang" class="w-10 h-10 sm:w-11 sm:h-11 object-contain group-hover:scale-105 transition-transform duration-200">
                <span class="font-bold text-xl tracking-tight text-slate-900 group-hover:text-brand-dark transition-colors">
                    Desa Sagalaherang
                </span>
            </a>

            <!-- Navigation Links & Right Actions (Hanya ditampilkan selain di Beranda) -->
            @unless(request()->routeIs('beranda'))
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="relative font-medium text-sm transition-colors py-2 {{ request()->routeIs('dashboard') ? 'text-brand-dark font-semibold' : 'text-slate-500 hover:text-brand-dark' }}">
                    Beranda
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-dark rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('pengaduan.lacak') }}" class="relative font-medium text-sm transition-colors py-2 {{ request()->routeIs('pengaduan.lacak') ? 'text-brand-dark font-semibold' : 'text-slate-500 hover:text-brand-dark' }}">
                    Lacak
                    @if(request()->routeIs('pengaduan.lacak'))
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-dark rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('riwayat') }}" class="relative font-medium text-sm transition-colors py-2 {{ request()->routeIs('riwayat') ? 'text-brand-dark font-semibold' : 'text-slate-500 hover:text-brand-dark' }}">
                    Riwayat
                    @if(request()->routeIs('riwayat'))
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-dark rounded-full"></span>
                    @endif
                </a>
            </nav>

            <!-- Right Actions: User Profile Avatar -->
            <div class="flex items-center gap-4">
                <a href="{{ route('profil') }}" class="flex items-center gap-2 group" title="Profil Saya">
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center group-hover:border-brand-dark transition-colors shadow-2xs">
                        <img src="{{ Auth::check() ? Auth::user()->foto_profil_url : 'https://ui-avatars.com/api/?name=User&background=06612B&color=fff' }}" alt="Foto Profil" class="w-full h-full object-cover">
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
    <footer class="bg-white border-t border-slate-200 mt-auto py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs font-medium text-slate-500">
            © 2024 Desa Sagalaherang. Layanan Masyarakat Digital.
        </div>
    </footer>

    <!-- SUBTLE SCROLL REVEAL SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');
            if (!reveals.length) return;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -30px 0px'
            });

            reveals.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
