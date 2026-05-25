<!DOCTYPE html>
<html lang="es" class="wistore-ui wistore-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tienda No Disponible - WIStore</title>
    
    <!-- Marquee Animation Styles -->
    <style>
        @keyframes marquee-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes marquee-right {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        .animate-marquee-left {
            display: flex;
            width: max-content;
            animation: marquee-left 45s linear infinite;
        }
        .animate-marquee-right {
            display: flex;
            width: max-content;
            animation: marquee-right 45s linear infinite;
        }
    </style>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('partials.global.wistore-scrollbar')
    @include('partials.landing.landing-scrollbar')
    <style>
body {
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
/* GPU hardware acceleration for ultra smooth scrolling on heavy blurs */
        .gpu-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: transform;
        }
        .blur-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: filter;
        }
        [x-cloak] { display: none !important; }

        /* Wave morphing animations */
        @keyframes wave-1 {
            0%, 100% {
                d: path("M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800");
            }
            33% {
                d: path("M-100,130 C170,260 430,-60 820,170 C1180,530 1330,860 1500,830");
            }
            66% {
                d: path("M-100,70 C230,340 370,-140 780,230 C1220,470 1270,940 1500,770");
            }
        }
        @keyframes wave-2 {
            0%, 100% {
                d: path("M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950");
            }
            33% {
                d: path("M-50,170 C280,360 470,90 920,360 C1270,780 1230,1010 1600,920");
            }
            66% {
                d: path("M-50,230 C220,440 530,10 880,440 C1330,720 1170,1090 1600,980");
            }
        }
        @keyframes wave-3 {
            0%, 100% {
                d: path("M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000");
            }
            50% {
                d: path("M1500,-20 C1070,180 970,470 630,570 C170,730 30,1070 -200,1030");
            }
        }
        @keyframes wave-4 {
            0%, 100% {
                d: path("M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100");
            }
            33% {
                d: path("M1550,80 C1120,280 870,370 530,670 C70,1030 -70,870 -250,1130");
            }
            66% {
                d: path("M1550,20 C1180,220 930,430 470,730 C130,970 -130,930 -250,1070");
            }
        }
        @keyframes wave-5 {
            0%, 100% {
                d: path("M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300");
            }
            50% {
                d: path("M-100,770 C330,570 470,930 870,830 C1330,670 1370,230 1600,270");
            }
        }

        .animate-wave-1 {
            animation: wave-1 8s ease-in-out infinite;
        }
        .animate-wave-2 {
            animation: wave-2 10s ease-in-out infinite;
        }
        .animate-wave-3 {
            animation: wave-3 12s ease-in-out infinite;
        }
        .animate-wave-4 {
            animation: wave-4 14s ease-in-out infinite;
        }
        .animate-wave-5 {
            animation: wave-5 16s ease-in-out infinite;
        }

        .mask-marquee {
            mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
        }
    </style>
</head>
<body class="bg-[#070913] text-gray-100 min-h-screen selection:bg-brand-500 selection:text-white relative flex flex-col justify-between" x-data="{ isMobileMenuOpen: false }">

    <!-- CAPA DE FONDO GLOBAL (Base Canvas & Neón) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        <!-- 1. Destellos de Luz (Auras/Glows) -->
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] blur-accelerated"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated"></div>

        <!-- 2. Ondas Fluidas de Neón (SVG Abstract Mesh) -->
        <svg class="absolute inset-0 w-full h-full opacity-20 pointer-events-none z-0" preserveAspectRatio="none" viewBox="0 0 1440 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="neonGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.8" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#a855f7" stop-opacity="0" />
                </linearGradient>
                <linearGradient id="neonGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                    <stop offset="50%" stop-color="#ec4899" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0" />
                </linearGradient>
            </defs>
            <path class="animate-wave-1" d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800" stroke="url(#neonGradient1)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path class="animate-wave-2" d="M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path class="animate-wave-3" d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000" stroke="url(#neonGradient2)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path class="animate-wave-4" d="M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100" stroke="url(#neonGradient2)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path class="animate-wave-5" d="M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.4" />
        </svg>
    </div>

    <!-- Header / Navbar -->
    <header class="border-b border-gray-800/50 bg-[#070913]/85 backdrop-blur-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 group transition-transform duration-300 active:scale-95">
                <span class="text-xl md:text-2xl font-black tracking-tight text-white uppercase">
                    WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span>
                </span>
            </a>
            
            <nav class="hidden md:flex items-center gap-8" x-data="{ openDropdown: false }" @click.away="openDropdown = false">
                <a href="#explorar" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">Explorar Tiendas</a>
                <a href="#como-funciona" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">¿Cómo funciona?</a>
                <a href="#precios" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">Planes</a>
                

                <a href="/login" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">Iniciar Sesión</a>
                <a href="#precios" class="bg-brand-600 hover:bg-brand-555 hover:scale-[1.03] text-white text-sm font-black px-5 py-2.5 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-300">
                    Crear mi Menú
                </a>
            </nav>

            <div class="flex items-center gap-2 md:hidden" x-data="{ openMobileDropdown: false }" @click.away="openMobileDropdown = false">
                <a href="/login" class="text-xs font-bold text-slate-200 hover:text-white px-2.5 py-1.5 rounded-lg">Log In</a>


                <a href="#precios" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-black px-3.5 py-2 rounded-xl shadow-md transition whitespace-nowrap">
                    Planes
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-24 text-center max-w-4xl mx-auto z-10 relative">
        <div class="space-y-6 my-auto">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white uppercase leading-tight">
                ¡Lo sentimos!<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400 animate-pulse">
                    Esta tienda no está disponible
                </span><br>
                por el momento.
            </h1>
        </div>
    </main>

    <!-- SECCIÓN EXPLORADOR DE TIENDAS (Premium Grid/Carrusel) -->
    @php
        $shops = \App\Models\Shop::where('is_active', true)->latest()->get();

        $shopsWithCategories = $shops->map(function($shop) {
            $desc = strtolower($shop->name . ' ' . $shop->description);
            $category = 'Gastronomía'; // default
            if (str_contains($desc, 'detallito') || str_contains($desc, 'regalo') || str_contains($desc, 'detalle') || str_contains($desc, 'sorpresa') || str_contains($desc, 'taza') || str_contains($desc, 'globo') || str_contains($desc, 'flores')) {
                $category = 'Detalles y Regalos';
            } elseif (str_contains($desc, 'moda') || str_contains($desc, 'ropa') || str_contains($desc, 'estilo') || str_contains($desc, 'calzado') || str_contains($desc, 'boutique') || str_contains($desc, 'wear') || str_contains($desc, 'shoes')) {
                $category = 'Moda y Estilo';
            } elseif (str_contains($desc, 'comida') || str_contains($desc, 'restaurante') || str_contains($desc, 'gastronomia') || str_contains($desc, 'burger') || str_contains($desc, 'dulce') || str_contains($desc, 'bocado') || str_contains($desc, 'pizza') || str_contains($desc, 'cafe') || str_contains($desc, 'sushi')) {
                $category = 'Gastronomía';
            }
            $shop->category = $category;
            return $shop;
        });

        $shopsCount = count($shopsWithCategories);
        if ($shopsCount > 0) {
            $allShops = $shopsWithCategories;
            while (count($allShops) < 16) {
                $allShops = $allShops->concat($shopsWithCategories);
            }
            $half = ceil(count($allShops) / 2);
            $row1 = $allShops->slice(0, $half);
            $row2 = $allShops->slice($half);
        } else {
            $row1 = collect();
            $row2 = collect();
        }
    @endphp

    <section id="explorar" class="py-16 md:py-24 relative overflow-hidden z-10"
             x-data="{
                 searchQuery: '{{ request('search', '') }}',
                 activeCategory: 'Todos',
                 allShops: {{ json_encode($shopsWithCategories) }},
                 matchesFilter(name, description, category) {
                     const q = this.searchQuery.toLowerCase();
                     const matchesSearch = q === '' || 
                         name.toLowerCase().includes(q) || 
                         (description && description.toLowerCase().includes(q));
                     const matchesCategory = this.activeCategory === 'Todos' || category === this.activeCategory;
                     return matchesSearch && matchesCategory;
                 },
                 get hasResults() {
                     return this.allShops.some(shop => this.matchesFilter(shop.name, shop.description, shop.category));
                 },
                 get isFiltering() {
                     return this.searchQuery !== '' || this.activeCategory !== 'Todos';
                 }
             }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="flex flex-col items-center justify-center mb-12 space-y-6">
                <div class="text-center w-full">
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Explora Tiendas Afiliadas</h2>
                    <p class="text-sm text-slate-400 mt-1.5">Compra de forma directa en los mejores catálogos de WIStore.</p>
                </div>

                <div class="w-full max-w-4xl flex flex-col gap-5 items-center justify-center">
                    <form @submit.prevent="" class="w-full max-w-md flex gap-2 shrink-0 justify-center">
                        <div class="relative flex-grow">
                            <input type="text" x-model="searchQuery" placeholder="Buscar tienda..." 
                                   class="w-full bg-slate-900/80 border border-slate-800 rounded-2xl px-4 py-3 pl-10 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all shadow-inner">
                            <svg class="absolute left-3 top-3.5 text-slate-500" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                    </form>

                    <div class="w-full flex gap-2 overflow-x-auto flex-nowrap whitespace-nowrap scrollbar-none py-1 justify-center">
                        <button type="button" @click="activeCategory = 'Todos'" :class="activeCategory === 'Todos' ? 'bg-purple-600/20 text-purple-400 border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.15)]' : 'bg-slate-900 text-slate-400 border-slate-800 hover:border-slate-700 hover:text-white'" class="text-[11px] font-black px-4 py-2.5 rounded-full border transition-all duration-300">Todos</button>
                        <button type="button" @click="activeCategory = 'Gastronomía'" :class="activeCategory === 'Gastronomía' ? 'bg-purple-600/20 text-purple-400 border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.15)]' : 'bg-slate-900 text-slate-400 border-slate-800 hover:border-slate-700 hover:text-white'" class="text-[11px] font-bold px-4 py-2.5 rounded-full border transition-all duration-300">Gastronomía</button>
                        <button type="button" @click="activeCategory = 'Moda y Estilo'" :class="activeCategory === 'Moda y Estilo' ? 'bg-purple-600/20 text-purple-400 border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.15)]' : 'bg-slate-900 text-slate-400 border-slate-800 hover:border-slate-700 hover:text-white'" class="text-[11px] font-bold px-4 py-2.5 rounded-full border transition-all duration-300">Moda y Estilo</button>
                        <button type="button" @click="activeCategory = 'Detalles y Regalos'" :class="activeCategory === 'Detalles y Regalos' ? 'bg-purple-600/20 text-purple-400 border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.15)]' : 'bg-slate-900 text-slate-400 border-slate-800 hover:border-slate-700 hover:text-white'" class="text-[11px] font-bold px-4 py-2.5 rounded-full border transition-all duration-300">Detalles y Regalos</button>
                    </div>
                </div>
            </div>

            <!-- MODO ANIMADO (MARQUEE 2 FILAS) -->
            <div x-show="!isFiltering" class="space-y-6" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <!-- Fila 1: Izquierda -->
                <div class="overflow-hidden w-full relative py-2 mask-marquee">
                    <div class="animate-marquee-left flex gap-6 hover:[animation-play-state:paused]">
                        <div class="flex gap-6">
                            @foreach($row1 as $shop)
                                <div class="w-[260px] lg:w-[280px] shrink-0 bg-slate-900/50 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
                                    <div class="p-1.5 pb-0">
                                        <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                            @if($shop->cover_path)
                                                <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">WISTORE</div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                                            <div class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                                <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/'.$shop->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=a855f7&color=fff') }}" alt="Logo" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-base font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                                                <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}</p>
                                        </div>

                                        <div class="mt-4">
                                            <a href="/{{ $shop->slug }}" class="block w-full text-center bg-slate-800/50 hover:bg-purple-600 text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm">
                                                Entrar a la Tienda
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex gap-6" aria-hidden="true">
                            @foreach($row1 as $shop)
                                <div class="w-[260px] lg:w-[280px] shrink-0 bg-slate-900/50 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
                                    <div class="p-1.5 pb-0">
                                        <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                            @if($shop->cover_path)
                                                <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">WISTORE</div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                                            <div class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                                <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/'.$shop->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=a855f7&color=fff') }}" alt="Logo" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-base font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                                                <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}</p>
                                        </div>

                                        <div class="mt-4">
                                            <a href="/{{ $shop->slug }}" class="block w-full text-center bg-slate-800/50 hover:bg-purple-600 text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm">
                                                Entrar a la Tienda
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Fila 2: Derecha -->
                <div class="overflow-hidden w-full relative py-2 mask-marquee">
                    <div class="animate-marquee-right flex gap-6 hover:[animation-play-state:paused]">
                        <div class="flex gap-6">
                            @foreach($row2 as $shop)
                                <div class="w-[260px] lg:w-[280px] shrink-0 bg-slate-900/50 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
                                    <div class="p-1.5 pb-0">
                                        <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                            @if($shop->cover_path)
                                                <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">WISTORE</div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                                            <div class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                                <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/'.$shop->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=a855f7&color=fff') }}" alt="Logo" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-base font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                                                <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}</p>
                                        </div>

                                        <div class="mt-4">
                                            <a href="/{{ $shop->slug }}" class="block w-full text-center bg-slate-800/50 hover:bg-purple-600 text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm">
                                                Entrar a la Tienda
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex gap-6" aria-hidden="true">
                            @foreach($row2 as $shop)
                                <div class="w-[260px] lg:w-[280px] shrink-0 bg-slate-900/50 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
                                    <div class="p-1.5 pb-0">
                                        <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                            @if($shop->cover_path)
                                                <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">WISTORE</div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                                            <div class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                                <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/'.$shop->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=a855f7&color=fff') }}" alt="Logo" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-base font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                                                <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}</p>
                                        </div>

                                        <div class="mt-4">
                                            <a href="/{{ $shop->slug }}" class="block w-full text-center bg-slate-800/50 hover:bg-purple-600 text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm">
                                                Entrar a la Tienda
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODO FILTRADO (ESTÁTICO EN RECIPIENTE GRID) -->
            <div x-show="isFiltering" class="py-6" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">
                
                <div x-show="!hasResults" class="w-full text-center py-20 bg-slate-900/30 border border-slate-800/50 rounded-[2rem] backdrop-blur-sm px-6 max-w-lg mx-auto" x-transition>
                    <div class="w-16 h-16 bg-purple-500/10 text-purple-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-purple-500/20 shadow-[0_0_15px_rgba(168,85,247,0.1)]">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                    <h3 class="text-white font-extrabold text-lg">No se encontraron tiendas</h3>
                    <p class="text-slate-400 text-xs mt-2 leading-relaxed">No encontramos catálogos oficiales que coincidan con "<span class="text-purple-400 font-bold" x-text="searchQuery"></span>" o con la categoría seleccionada.</p>
                    <button type="button" @click="searchQuery = ''; activeCategory = 'Todos'" class="mt-6 bg-purple-600 hover:bg-purple-500 text-white font-extrabold px-6 py-2.5 rounded-full text-xs transition active:scale-95 shadow-[0_0_15px_rgba(147,51,234,0.3)]">
                        Restablecer filtros
                    </button>
                </div>

                <div x-show="hasResults" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($shopsWithCategories as $shop)
                        <div x-show="matchesFilter('{{ addslashes($shop->name) }}', '{{ addslashes($shop->description) }}', '{{ addslashes($shop->category) }}')" 
                             class="w-full bg-slate-900/50 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
                            <div class="p-1.5 pb-0">
                                <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                    @if($shop->cover_path)
                                        <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">WISTORE</div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                                    <div class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                        <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/'.$shop->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=a855f7&color=fff') }}" alt="Logo" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="text-base font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                                        <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                            @for($star = 1; $star <= 5; $star++)
                                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}</p>
                                </div>

                                <div class="mt-4">
                                    <a href="/{{ $shop->slug }}" class="block w-full text-center bg-slate-800/50 hover:bg-purple-600 text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm">
                                        Entrar a la Tienda
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full lg:col-span-4 text-center py-16">
                            <p class="text-slate-500 text-sm">No se encontraron tiendas registradas de momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-white/5 bg-transparent relative z-10 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-16">
                <!-- Columna 1: Brand & Bio -->
                <div class="col-span-1 md:col-span-1 space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-black text-white tracking-wider uppercase">WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        La plataforma B2B premium líder en digitalización de comercios en Venezuela. Crea tu catálogo inteligente interactivo con pedidos directos a WhatsApp o Telegram, libre de comisiones por venta.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="javascript:void(0)" class="w-9 h-9 rounded-full border border-white/5 bg-transparent hover:bg-white/5 hover:border-white/15 flex items-center justify-center text-slate-500 hover:text-slate-200 transition-all duration-300" title="Facebook">
                            <i class="fab fa-facebook-f text-xs"></i>
                        </a>
                        <a href="javascript:void(0)" class="w-9 h-9 rounded-full border border-white/5 bg-transparent hover:bg-white/5 hover:border-white/15 flex items-center justify-center text-slate-500 hover:text-slate-200 transition-all duration-300" title="Instagram">
                            <i class="fab fa-instagram text-xs"></i>
                        </a>
                        <a href="javascript:void(0)" class="w-9 h-9 rounded-full border border-white/5 bg-transparent hover:bg-white/5 hover:border-white/15 flex items-center justify-center text-slate-500 hover:text-slate-200 transition-all duration-300" title="TikTok">
                            <i class="fab fa-tiktok text-xs"></i>
                        </a>
                        <a href="javascript:void(0)" class="w-9 h-9 rounded-full border border-white/5 bg-transparent hover:bg-white/5 hover:border-white/15 flex items-center justify-center text-slate-500 hover:text-slate-200 transition-all duration-300" title="YouTube">
                            <i class="fab fa-youtube text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Columna 2: Ecosistema -->
                <div class="space-y-4">
                    <h4 class="text-xs uppercase font-black tracking-widest text-slate-200">Ecosistema</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#explorar" class="text-slate-400 hover:text-cyan-400 transition-colors">Explora Tiendas</a></li>
                        <li><a href="#como-funciona" class="text-slate-400 hover:text-cyan-400 transition-colors">¿Cómo funciona?</a></li>
                        <li><a href="#precios" class="text-slate-400 hover:text-cyan-400 transition-colors">Planes de Precios</a></li>
                        <li><a href="{{ route('planes.comparativa') }}" class="text-slate-400 hover:text-cyan-400 transition-colors">Comparativa de Planes</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Administración -->
                <div class="space-y-4">
                    <h4 class="text-xs uppercase font-black tracking-widest text-slate-200">Administración</h4>
                    <div class="pt-1">
                        <a href="/login" class="inline-flex items-center gap-1.5 bg-purple-600/20 hover:bg-purple-600/30 text-purple-300 font-extrabold px-3.5 py-2 rounded-xl border border-purple-500/30 hover:border-purple-500/50 hover:text-white transition-all duration-300 text-[10px] uppercase tracking-wider shadow-lg shadow-purple-500/5">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </div>
                </div>

                <!-- Columna 4: Contacto directo -->
                <div class="space-y-4">
                    <h4 class="text-xs uppercase font-black tracking-widest text-slate-200">Contacto Directo</h4>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-envelope text-cyan-400 w-4 shrink-0"></i>
                            @include('partials.global.support-email', ['class' => 'text-xs text-slate-400 hover:text-cyan-300 transition-colors break-all', 'icon' => false])
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-phone-alt text-purple-400 w-4"></i>
                            <span>+58 (412) 130-5420</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-map-marker-alt text-pink-400 w-4"></i>
                            <span>Aragua, Venezuela</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Area -->
            <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>© 2026 WIStore. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('legal.privacidad') }}" class="hover:text-white transition-colors">Políticas y Privacidad</a>
                    <span>•</span>
                    <a href="{{ route('contacto') }}" class="hover:text-white transition-colors">Contacto</a>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.public.chat')
</body>
</html>
