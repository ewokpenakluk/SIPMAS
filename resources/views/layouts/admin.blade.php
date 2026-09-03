<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Desa Sagalaherang')</title>
    
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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAF8;
        }
    </style>
</head>
<body class="min-h-screen bg-[#F8FAF8] text-slate-800 antialiased selection:bg-[#06612B] selection:text-white">

    <!-- ADMIN CONTAINER LAYOUT -->
    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- REUSABLE SIDEBAR ADMIN -->
        @include('admin.components.sidebar')

        <!-- MAIN CONTENT AREA -->
        <main class="grow p-4 sm:p-6 lg:p-8 max-w-7xl w-full">
            @yield('content')
        </main>

    </div>

</body>
</html>
