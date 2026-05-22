<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>WIStore - La plataforma de catálogos digitales para WhatsApp y Telegram</title>
    
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

    <style>
        html {
            scroll-behavior: smooth;
            scrollbar-width: thin;
            scrollbar-color: #a855f7 #070913;
        }
        body {
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .hero-gradient {
            background: radial-gradient(circle at 50% 10%, rgba(99, 102, 241, 0.18) 0%, rgba(0, 0, 0, 0) 50%),
                        radial-gradient(circle at 10% 80%, rgba(79, 70, 229, 0.08) 0%, rgba(0, 0, 0, 0) 40%);
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #070913;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #a855f7 0%, #22d3ee 100%);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #c084fc 0%, #67e8f9 100%);
        }

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

        /* Animaciones fluidas de ondas/olas (morphing) para las curvas SVG del fondo */
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

        /* Máscara de transparencia gradual para los extremos del carrusel de tiendas */
        .mask-marquee {
            mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
        }
    </style>
</head>
<body class="bg-[#070913] text-gray-100 min-h-screen selection:bg-brand-500 selection:text-white relative" x-data="{ isMobileMenuOpen: false }">

    <!-- ============================================== -->
    <!-- CAPA DE FONDO GLOBAL (Base Canvas & Neón)      -->
    <!-- ============================================== -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        
        <!-- 1. Destellos de Luz (Auras/Glows) -->
        <!-- Glow Top Right (Hero Area) -->
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated"></div>
        
        <!-- Glow Middle Left (Tiendas Area) -->
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] blur-accelerated"></div>

        <!-- Glow Bottom Center (Precios Area) -->
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated"></div>

        <!-- 2. Ondas Fluidas de Neón (SVG Abstract Mesh) - Atenuado para Legibilidad -->
        <svg class="absolute inset-0 w-full h-full opacity-20 pointer-events-none z-0" preserveAspectRatio="none" viewBox="0 0 1440 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Gradiente Cian a Morado -->
                <linearGradient id="neonGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.8" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#a855f7" stop-opacity="0" />
                </linearGradient>
                <!-- Gradiente Morado a Rosa -->
                <linearGradient id="neonGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                    <stop offset="50%" stop-color="#ec4899" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0" />
                </linearGradient>
            </defs>

            <!-- Curvas Bezier Entrelazadas imitando estelas de luz animadas como olas/ondas -->
            <path class="animate-wave-1" d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800" stroke="url(#neonGradient1)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path class="animate-wave-2" d="M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path class="animate-wave-3" d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000" stroke="url(#neonGradient2)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path class="animate-wave-4" d="M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100" stroke="url(#neonGradient2)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path class="animate-wave-5" d="M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.4" />
        </svg>
    </div>

    <!-- Header / Navbar (Híbrido Inteligente) -->
    <header class="border-b border-gray-800/50 bg-[#070913]/85 backdrop-blur-lg sticky top-0 z-50">
        <!-- El contenedor se ensancha en escritorio y se achica en móvil -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 group transition-transform duration-300 active:scale-95">
                <span class="text-xl md:text-2xl font-black tracking-tight text-white uppercase">
                    WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span>
                </span>
            </a>
            
            <!-- EN ESCRITORIO: Links de Navegación con Alto Contraste (WCAG Compliant) -->
            <nav class="hidden md:flex items-center gap-8" x-data="{ openDropdown: false }" @click.away="openDropdown = false">
                <a href="#explorar" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">Explorar Tiendas</a>
                <a href="#como-funciona" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">¿Cómo funciona?</a>
                
                <a href="#precios" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">Planes</a>

                <a href="/login" class="text-sm font-bold text-slate-100 hover:text-cyan-400 transition-colors duration-200">Iniciar Sesión</a>
                <a href="#precios" class="bg-brand-600 hover:bg-brand-555 hover:scale-[1.03] text-white text-sm font-black px-5 py-2.5 rounded-xl shadow-md shadow-brand-600/30 transition-all duration-300">
                    Crear mi Menú
                </a>
            </nav>

            <!-- EN MÓVIL: Botones Rápidos iOS-style con Dropdown de Planes -->
            <div class="flex items-center gap-2 md:hidden">
                <a href="/login" class="text-xs font-bold text-slate-200 hover:text-white px-2.5 py-1.5 rounded-lg">Log In</a>

                <a href="#precios" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-black px-3.5 py-2 rounded-xl shadow-md transition whitespace-nowrap">
                    Planes
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (Premium 3D Asymmetric Layout) -->
    <section class="relative pt-16 md:pt-24 pb-20 md:pb-36 px-4 max-w-7xl mx-auto overflow-hidden z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-12 items-center">
            
            <!-- COLUMNA IZQUIERDA: Propuesta de Valor y CTAs -->
            <div class="lg:col-span-6 text-center lg:text-left space-y-8">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-slate-900/60 border border-purple-500/40 shadow-[0_0_15px_rgba(168,85,247,0.2)] backdrop-blur-md">
                    <span class="text-[11px] md:text-xs font-bold text-white tracking-wide">⚡ 0% Comisiones por Venta</span>
                </div>
                
                <!-- Título Principal -->
                <h1 class="text-4xl md:text-6xl lg:text-[4.5rem] font-extrabold tracking-tight text-white leading-[1.1]">
                    Vende en automático con tu <br class="hidden lg:block" />
                    <span class="block mt-2 bg-gradient-to-r from-indigo-400 via-purple-400 via-pink-400 to-cyan-400 bg-clip-text text-transparent pb-2">
                        Menú Digital
                    </span>
                </h1>
                
                <!-- Descripción -->
                <p class="text-base md:text-lg text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed font-light">
                    Personaliza tu logotipo, edita los 3 colores principales de tu identidad en tiempo real y recibe todos tus pedidos de forma estructurada directamente a tu WhatsApp o Telegram. ¡Todo listo en menos de 3 minutos!
                </p>
                
                <!-- Botones Principales con Espaciado Generoso y Mayor Peso Visual -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 pt-6">
                    <a href="#precios" class="w-full sm:w-auto text-center bg-purple-600 hover:bg-purple-500 hover:scale-[1.02] text-white font-black px-10 py-4 rounded-2xl shadow-[0_0_25px_rgba(147,51,234,0.4)] transition-all duration-300 text-sm md:text-base">
                        Empezar Catálogo Gratis
                    </a>
                    <a href="#explorar" class="w-full sm:w-auto text-center border border-white/10 bg-white/5 hover:bg-white/10 hover:scale-[1.02] backdrop-blur-sm text-white font-extrabold px-10 py-4 rounded-2xl transition-all duration-300 text-sm md:text-base sm:ml-2">
                        Explorar Tiendas
                    </a>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Mockup Interactivo de Tableta Flotante (Aireado con Excelente Jerarquía) -->
            <div class="lg:col-span-6 relative flex justify-center items-center py-12 lg:py-16 lg:pl-12 mt-8 lg:mt-0">
                
                <!-- Sticker Circular Flotante -->
                <div class="absolute -top-4 left-0 md:left-10 z-30 bg-gradient-to-br from-purple-500 to-cyan-500 w-24 h-24 md:w-28 md:h-28 rounded-full flex items-center justify-center p-3 shadow-2xl animate-[bounce_4s_infinite] transform -rotate-12 border-4 border-[#070913]">
                    <span class="text-white text-[11px] md:text-xs font-black text-center leading-tight shadow-black drop-shadow-md">
                        0%<br>Comisiones<br>por Venta
                    </span>
                </div>

                <!-- Mockup de Tableta 3D -->
                <div class="relative w-full max-w-[380px] lg:max-w-[420px] aspect-[3/4.2] bg-slate-900 border-[8px] md:border-[10px] border-slate-800 rounded-[2.5rem] md:rounded-[3rem] p-4 md:p-5 shadow-[0_0_50px_rgba(0,0,0,0.5)] transform hover:rotate-1 hover:scale-105 transition-all duration-500 ease-out overflow-hidden flex flex-col bg-gradient-to-b from-slate-800 to-slate-950 group">
                    
                    <!-- Brillo Metálico del Borde -->
                    <div class="absolute inset-0 rounded-[2rem] border border-white/5 pointer-events-none"></div>

                    <!-- Pantalla Interna -->
                    <div class="flex-1 bg-slate-50 rounded-[1.5rem] md:rounded-[2rem] overflow-hidden flex flex-col relative shadow-inner">
                        
                        <!-- Muesca de la Cámara -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-5 bg-slate-900 rounded-b-xl z-20"></div>

                        <!-- Cabecera YS Detallitos -->
                        <div class="bg-gradient-to-br from-rose-100 via-pink-50 to-amber-50 p-6 pt-10 text-center relative border-b border-rose-100">
                            <!-- Logo Circular -->
                            <div class="w-16 h-16 mx-auto bg-white rounded-full p-1 shadow-lg border-2 border-white flex items-center justify-center mb-3 transform group-hover:scale-110 transition-transform duration-500">
                                <span class="font-black text-rose-500 text-xl tracking-tighter">YS</span>
                            </div>
                            <h3 class="text-xl font-black text-slate-800">YS Detallitos</h3>
                            <!-- 5 Estrellas -->
                            <div class="flex items-center justify-center gap-1 text-yellow-400 mt-1.5">
                                <svg class="w-4 h-4 fill-current drop-shadow-sm" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 fill-current drop-shadow-sm" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 fill-current drop-shadow-sm" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 fill-current drop-shadow-sm" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 fill-current drop-shadow-sm" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                        </div>
                        
                        <!-- Categorías Rejilla 3 Columnas -->
                        <div class="p-4 md:p-5 flex-1 flex flex-col relative bg-slate-50">
                            <!-- Overlay de gradiente inferior para simular scroll -->
                            <div class="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-slate-50 to-transparent pointer-events-none z-10"></div>
                            
                            <h4 class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="h-px bg-slate-200 flex-1"></span>
                                Catálogo
                                <span class="h-px bg-slate-200 flex-1"></span>
                            </h4>
                            
                            <div class="grid grid-cols-3 gap-2.5 md:gap-3">
                                <!-- Tarjeta 1 -->
                                <div class="bg-white rounded-xl p-2 md:p-3 shadow-sm border border-slate-100 flex flex-col items-center text-center hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 mb-2 md:mb-3 text-lg md:text-xl">🎁</div>
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-600 mb-2 md:mb-3 leading-tight flex-1">Regalos<br>Especiales</span>
                                    <button class="w-full py-1.5 md:py-2 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase rounded-lg hover:bg-rose-100 transition-colors">Entrar</button>
                                </div>
                                <!-- Tarjeta 2 -->
                                <div class="bg-white rounded-xl p-2 md:p-3 shadow-sm border border-slate-100 flex flex-col items-center text-center hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 mb-2 md:mb-3 text-lg md:text-xl">🎈</div>
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-600 mb-2 md:mb-3 leading-tight flex-1">Arreglos<br>con Globos</span>
                                    <button class="w-full py-1.5 md:py-2 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase rounded-lg hover:bg-rose-100 transition-colors">Entrar</button>
                                </div>
                                <!-- Tarjeta 3 -->
                                <div class="bg-white rounded-xl p-2 md:p-3 shadow-sm border border-slate-100 flex flex-col items-center text-center hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 mb-2 md:mb-3 text-lg md:text-xl">💐</div>
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-600 mb-2 md:mb-3 leading-tight flex-1">Ramos y<br>Flores</span>
                                    <button class="w-full py-1.5 md:py-2 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase rounded-lg hover:bg-rose-100 transition-colors">Entrar</button>
                                </div>
                                <!-- Tarjeta 4 -->
                                <div class="bg-white rounded-xl p-2 md:p-3 shadow-sm border border-slate-100 flex flex-col items-center text-center hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-500 mb-2 md:mb-3 text-lg md:text-xl">🍫</div>
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-600 mb-2 md:mb-3 leading-tight flex-1">Cajas de<br>Dulces</span>
                                    <button class="w-full py-1.5 md:py-2 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase rounded-lg hover:bg-rose-100 transition-colors">Entrar</button>
                                </div>
                                <!-- Tarjeta 5 -->
                                <div class="bg-white rounded-xl p-2 md:p-3 shadow-sm border border-slate-100 flex flex-col items-center text-center hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-2 md:mb-3 text-lg md:text-xl">🧸</div>
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-600 mb-2 md:mb-3 leading-tight flex-1">Peluches<br>Grandes</span>
                                    <button class="w-full py-1.5 md:py-2 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase rounded-lg hover:bg-rose-100 transition-colors">Entrar</button>
                                </div>
                                <!-- Tarjeta 6 -->
                                <div class="bg-white rounded-xl p-2 md:p-3 shadow-sm border border-slate-100 flex flex-col items-center text-center hover:border-pink-200 hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 mb-2 md:mb-3 text-lg md:text-xl">🌟</div>
                                    <span class="text-[9px] md:text-[10px] font-bold text-slate-600 mb-2 md:mb-3 leading-tight flex-1">Nuevos<br>Llegados</span>
                                    <button class="w-full py-1.5 md:py-2 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase rounded-lg hover:bg-rose-100 transition-colors">Entrar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- SECCIÓN EXPLORADOR DE TIENDAS (Premium Grid/Carrusel) -->
    @php
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
        <!-- Luces de fondo opcionales para continuidad -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Cabecera de la Sección con Buscador y Filtros -->
            <div class="flex flex-col items-center justify-center mb-12 space-y-6">
                <!-- Título -->
                <div class="text-center w-full">
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Explora Tiendas Afiliadas</h2>
                    <p class="text-sm text-slate-400 mt-1.5">Compra de forma directa en los mejores catálogos de WIStore.</p>
                </div>

                <!-- Buscador y Filtros -->
                <div class="w-full max-w-4xl flex flex-col gap-5 items-center justify-center">
                    <!-- Formulario Buscador Compacto -->
                    <form @submit.prevent="" class="w-full max-w-md flex gap-2 shrink-0 justify-center">
                        <div class="relative flex-grow">
                            <input type="text" x-model="searchQuery" placeholder="Buscar tienda..." 
                                   class="w-full bg-slate-900/80 border border-slate-800 rounded-2xl px-4 py-3 pl-10 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all shadow-inner">
                            <svg class="absolute left-3 top-3.5 text-slate-500" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                    </form>

                    <!-- Filtros Píldoras Táctiles -->
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
                
                <!-- Mensaje de No Resultados -->
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

    <!-- SECCIÓN CÓMO FUNCIONA (Estilo Bloques Neón) -->
    <section id="como-funciona" class="py-20 md:py-28 relative overflow-hidden z-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Cabecera Centrada -->
            <div class="mb-16 md:mb-20 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight">¿Cómo funciona WIStore?</h2>
                <p class="text-sm md:text-base text-slate-400 mt-3 max-w-xl mx-auto">Crea tu menú interactivo de marca blanca y recibe pedidos en WhatsApp o Telegram en 3 pasos sencillos.</p>
            </div>

            <!-- 3 Bloques Numéricos (Horizontal en PC) - Limpieza de Ruido Visual -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                <!-- Paso 1 -->
                <div class="bg-slate-900/15 border border-white/5 p-10 md:p-12 rounded-[2.5rem] flex flex-col items-center text-center relative hover:border-purple-500/40 hover:bg-purple-950/5 transition-all duration-300 group">
                    <!-- Número Escondido Decorativo -->
                    <span class="absolute top-4 right-6 text-6xl font-black text-white/[0.015] group-hover:text-purple-500/5 transition-colors select-none">1</span>
                    
                    <!-- Icono Neón -->
                    <div class="w-20 h-20 rounded-full bg-slate-950 border border-slate-800 shadow-[0_0_30px_rgba(168,85,247,0.15)] group-hover:shadow-[0_0_40px_rgba(168,85,247,0.35)] flex items-center justify-center mb-6 relative transition-all duration-300">
                        <div class="absolute inset-0 bg-purple-500/20 rounded-full blur-md"></div>
                        <svg class="w-8 h-8 text-purple-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    
                    <h4 class="text-lg font-black text-white mb-3">Registra tus Productos</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">Ingresa tus categorías, sube imágenes, agrega descripciones atractivas y define tus precios de venta.</p>
                </div>

                <!-- Paso 2 -->
                <div class="bg-slate-900/15 border border-white/5 p-10 md:p-12 rounded-[2.5rem] flex flex-col items-center text-center relative hover:border-cyan-500/40 hover:bg-cyan-950/5 transition-all duration-300 group">
                    <span class="absolute top-4 right-6 text-6xl font-black text-white/[0.015] group-hover:text-cyan-500/5 transition-colors select-none">2</span>
                    
                    <!-- Icono Neón -->
                    <div class="w-20 h-20 rounded-full bg-slate-950 border border-slate-800 shadow-[0_0_30px_rgba(34,211,238,0.15)] group-hover:shadow-[0_0_40px_rgba(34,211,238,0.35)] flex items-center justify-center mb-6 relative transition-all duration-300">
                        <div class="absolute inset-0 bg-cyan-500/20 rounded-full blur-md"></div>
                        <svg class="w-8 h-8 text-cyan-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    
                    <h4 class="text-lg font-black text-white mb-3">Elige tus Colores</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">Define los 3 colores principales de tu identidad visual, sube tu logo y portada para adaptar el catálogo a tu marca.</p>
                </div>

                <!-- Paso 3 -->
                <div class="bg-slate-900/15 border border-white/5 p-10 md:p-12 rounded-[2.5rem] flex flex-col items-center text-center relative hover:border-pink-500/40 hover:bg-pink-950/5 transition-all duration-300 group">
                    <span class="absolute top-4 right-6 text-6xl font-black text-white/[0.015] group-hover:text-pink-500/5 transition-colors select-none">3</span>
                    
                    <!-- Icono Neón -->
                    <div class="w-20 h-20 rounded-full bg-slate-950 border border-slate-800 shadow-[0_0_30px_rgba(236,72,153,0.15)] group-hover:shadow-[0_0_40px_rgba(236,72,153,0.35)] flex items-center justify-center mb-6 relative transition-all duration-300">
                        <div class="absolute inset-0 bg-pink-500/20 rounded-full blur-md"></div>
                        <svg class="w-8 h-8 text-pink-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    
                    <h4 class="text-lg font-black text-white mb-3">Recibe Pedidos Directos</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">Comparte tu enlace y tus clientes podrán enviarte pedidos estructurados directamente a tu WhatsApp o Telegram, sin comisiones.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRECIOS (Glassmorphic Dark Premium) -->
    <section id="precios" class="py-20 md:py-28 border-t border-white/5 relative overflow-hidden" 
             :class="openModal ? 'z-50' : 'z-10'"
             x-data="{ 
                 openModal: false, 
                 selectedPlan: null, 
                 billingPeriod: 'monthly',
                 exchangeRate: null,
                 loadingRate: true,
                 init() {
                     fetch('https://ve.dolarapi.com/v1/dolares/oficial')
                         .then(r => r.json())
                         .then(data => {
                             this.exchangeRate = data.promedio;
                             this.loadingRate = false;
                         })
                         .catch(err => {
                             console.error('Error fetching BCV rate:', err);
                             this.loadingRate = false;
                         });
                 }
             }">
        
        <!-- Orbes de luz de fondo para el fondo oscuro -->
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none blur-accelerated"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none blur-accelerated"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Cabecera de Precios -->
            <div class="text-center mb-12 md:mb-16">
                <span class="bg-purple-600/20 text-purple-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.2)]">
                    Planes Flexibles
                </span>
                <span class="inline-flex items-center gap-1.5 bg-emerald-600/20 text-emerald-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)] mt-2 sm:mt-0 sm:ml-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" x-show="!loadingRate"></span>
                    <span x-text="exchangeRate ? 'Tasa BCV: ' + Number(exchangeRate).toFixed(2) + ' Bs. 🇻🇪' : (loadingRate ? 'Cargando Tasa... 🇻🇪' : 'Tasa Oficial BCV 🇻🇪')">Tasa Oficial BCV 🇻🇪</span>
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">Precios que impulsan tu negocio</h2>
                <p class="text-sm md:text-base text-slate-400 mt-3 max-w-xl mx-auto leading-relaxed">Selecciona la solución ideal para digitalizar tu marca, aumentar tus ventas y conectar de forma directa con tus clientes.</p>
                
                <!-- Billing Cycle Toggle Switch -->
                <div class="mt-8 flex justify-center items-center gap-4 relative z-10">
                    <button @click="billingPeriod = 'monthly'" 
                            class="text-xs font-black tracking-wider uppercase transition-all duration-350 cursor-pointer focus:outline-none" 
                            :class="billingPeriod === 'monthly' ? 'text-cyan-400' : 'text-slate-500 hover:text-slate-300'">
                        Pago Mensual
                    </button>
                    <button @click="billingPeriod = billingPeriod === 'monthly' ? 'yearly' : 'monthly'" 
                            class="w-14 h-7 rounded-full bg-purple-950/80 border border-purple-500/40 p-1 flex items-center transition-all duration-300 relative focus:outline-none shadow-[0_0_15px_rgba(139,92,246,0.15)] hover:border-purple-400/60"
                            aria-label="Alternar ciclo de facturación">
                        <div class="w-5 h-5 rounded-full bg-gradient-to-r from-purple-400 to-cyan-400 shadow-[0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 transform" 
                             :class="billingPeriod === 'yearly' ? 'translate-x-7' : 'translate-x-0'"></div>
                    </button>
                    <button @click="billingPeriod = 'yearly'" 
                            class="text-xs font-black tracking-wider uppercase flex items-center gap-2 transition-all duration-350 cursor-pointer focus:outline-none" 
                            :class="billingPeriod === 'yearly' ? 'text-cyan-400' : 'text-slate-500 hover:text-slate-300'">
                        <span>Pago Anual</span>
                        <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[9px] font-black uppercase px-2 py-0.5 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.1)]">Ahorra hasta 30% 🎉</span>
                    </button>
                </div>

                <!-- Botón Único de Comparativa Técnica -->
                <div class="mt-8 relative z-10">
                    <a href="{{ route('planes.comparativa') }}" class="inline-flex items-center gap-2 bg-[#0d1127]/60 hover:bg-slate-800/80 text-cyan-400 hover:text-cyan-300 font-extrabold px-8 py-4 rounded-2xl border border-white/10 hover:border-cyan-500/30 transition-all duration-300 text-xs md:text-sm shadow-xl group">
                        <span>Ver Tabla Comparativa Técnica Completa</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            
            <!-- Grid de 3 Columnas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch justify-center">

                <!-- PLAN 2: Plan Standard -->
                <div id="plan-standard" class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-3xl p-6 flex flex-col justify-between shadow-2xl relative transition duration-300 hover:-translate-y-2 hover:border-white/20 group">
                    <div>
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-black text-white uppercase tracking-wider">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-400">Standard</span></h3>
                            <span class="bg-gradient-to-r from-sky-500 to-cyan-400 text-slate-950 text-[8px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full shadow-[0_0_14px_rgba(14,165,233,0.5)] animate-pulse shrink-0">⚡ 7 Días</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2 leading-relaxed">Ideal para pequeños negocios y emprendedores que desean digitalizarse.</p>
                        
                        <!-- Banner prueba gratis -->
                        <div class="mt-3 rounded-2xl bg-gradient-to-r from-sky-500/15 via-cyan-500/10 to-sky-500/15 border border-sky-500/30 p-3 shadow-[0_0_18px_rgba(14,165,233,0.12)] flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center shrink-0">
                                <span class="text-sm">🎁</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-sky-300 uppercase tracking-wider leading-tight">¡Incluye 7 Días de Prueba Gratis!</p>
                                <p class="text-[9px] text-slate-500 mt-0.5">Sin tarjeta. Sin compromisos. Cancela cuando quieras.</p>
                            </div>
                        </div>
                        
                        <!-- Precio Dinámico -->
                        <div class="my-6">
                            <!-- Monthly Price -->
                            <div x-show="billingPeriod === 'monthly'" x-transition class="space-y-1">
                                <div class="text-3xl font-black text-white flex items-baseline gap-1">
                                    $14.99 <span class="text-[10px] font-bold text-slate-500">/ mes</span>
                                </div>
                                <span x-show="exchangeRate" class="text-[11px] text-emerald-400 font-bold block mt-0.5" x-transition>
                                    <span x-text="(14.99 * exchangeRate).toFixed(2)"></span> Bs. <span class="text-[9px] text-slate-500">/ mes</span>
                                </span>
                                <span class="bg-cyan-500/10 text-cyan-400 border border-cyan-500/25 text-[8px] font-extrabold uppercase px-2.5 py-0.5 rounded-full inline-block mt-1 hover:scale-105 transition-all duration-200 cursor-pointer" @click="billingPeriod = 'yearly'">
                                    Ahorra 20% con Pago Anual 🎉
                                </span>
                            </div>
                            <!-- Yearly Price -->
                            <div x-show="billingPeriod === 'yearly'" x-transition class="space-y-1">
                                <div class="text-3xl font-black text-white flex items-baseline gap-1">
                                    $11.99 <span class="text-[10px] font-bold text-cyan-400">/ mes equivalent</span>
                                </div>
                                <span x-show="exchangeRate" class="text-[11px] text-emerald-400 font-bold block mt-0.5" x-transition>
                                    <span x-text="(11.99 * exchangeRate).toFixed(2)"></span> Bs. <span class="text-[9px] text-slate-500">/ mes</span>
                                </span>
                                <span class="text-[9px] text-slate-400 block font-semibold">
                                    Facturado anualmente ($143.90/año<span x-show="exchangeRate" class="text-emerald-400/90"> / <span x-text="(143.90 * exchangeRate).toFixed(2)"></span> Bs.</span>)
                                </span>
                                <span class="bg-cyan-500/10 text-cyan-400 border border-cyan-500/25 text-[8px] font-extrabold uppercase px-2 py-0.5 rounded-full inline-block">Ahorra 20%</span>
                            </div>
                        </div>

                        <!-- Beneficios -->
                        <ul class="space-y-3.5 text-[11px] text-slate-300 border-t border-white/10 pt-5">
                            <li class="flex items-start gap-2.5">
                                <svg class="text-sky-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Productos y categorías <strong>ilimitados</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-sky-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Pedidos ilimitados a WhatsApp o Telegram.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-sky-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Personalización visual completa de tu marca.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-sky-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Soporte prioritario por WhatsApp.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <div class="mt-8 flex flex-col gap-2.5">
                        <a href="/register" class="block w-full text-center bg-slate-800/60 hover:bg-slate-700 text-white font-extrabold py-3 rounded-xl transition-all duration-300 text-xs shadow-sm">
                            Comenzar Standard (7 Días Gratis)
                        </a>
                        <button @click="selectedPlan = 'standard'; openModal = true" class="mt-1 text-center text-sky-400 hover:text-sky-300 font-bold text-[9px] uppercase tracking-wide flex items-center justify-center gap-1 transition-colors focus:outline-none">
                            Detalles Técnicos <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>

                <!-- PLAN 3: Plan Premium (EL DESTACADO con Corona y Aura) -->
                <div id="plan-premium" class="relative rounded-3xl p-[2px] bg-gradient-to-b from-purple-500 via-cyan-500 to-purple-600 shadow-[0_0_30px_rgba(168,85,247,0.3)] transition-transform duration-300 hover:-translate-y-2 flex flex-col">
                    <!-- Badge Flotante "✨ RECOMENDADO" -->
                    <span class="absolute -top-4 right-6 bg-purple-600 text-white text-[9px] uppercase font-black tracking-widest px-4.5 py-1.5 rounded-full shadow-[0_0_15px_rgba(168,85,247,0.6)] select-none z-10">
                        ✨ RECOMENDADO
                    </span>

                    <div class="bg-[#0d1127] rounded-[1.4rem] p-6 flex flex-col justify-between h-full relative overflow-hidden flex-grow">
                        <!-- Destello interno -->
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-purple-500/20 rounded-full blur-2xl"></div>

                        <div class="relative z-10">
                            <h3 class="text-lg font-black text-white uppercase tracking-wider">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Premium</span></h3>
                            <p class="text-[11px] text-slate-300 mt-2 leading-relaxed">Nuestra solución corporativa con insignia VIP y marca blanca completa.</p>
                            
                            <!-- Precio Dinámico -->
                            <div class="my-6">
                                <!-- Monthly Price -->
                                <div x-show="billingPeriod === 'monthly'" x-transition class="space-y-1">
                                    <div class="text-3xl font-black text-white flex items-baseline gap-1">
                                        $24.99 <span class="text-[10px] font-bold text-purple-300">/ mes</span>
                                    </div>
                                    <span x-show="exchangeRate" class="text-[11px] text-emerald-400 font-bold block mt-0.5" x-transition>
                                        <span x-text="(24.99 * exchangeRate).toFixed(2)"></span> Bs. <span class="text-[9px] text-slate-500">/ mes</span>
                                    </span>
                                    <span class="bg-purple-500/20 text-purple-400 border border-purple-500/25 text-[8px] font-extrabold uppercase px-2.5 py-0.5 rounded-full inline-block mt-1 hover:scale-105 transition-all duration-200 cursor-pointer" @click="billingPeriod = 'yearly'">
                                        Ahorra 30% con Pago Anual 🎉
                                    </span>
                                </div>
                                <!-- Yearly Price -->
                                <div x-show="billingPeriod === 'yearly'" x-transition class="space-y-1">
                                    <div class="text-3xl font-black text-white flex items-baseline gap-1">
                                        $17.49 <span class="text-[10px] font-bold text-cyan-400">/ mes equivalent</span>
                                    </div>
                                    <span x-show="exchangeRate" class="text-[11px] text-emerald-400 font-bold block mt-0.5" x-transition>
                                        <span x-text="(17.49 * exchangeRate).toFixed(2)"></span> Bs. <span class="text-[9px] text-slate-500">/ mes</span>
                                    </span>
                                    <span class="text-[9px] text-slate-400 block font-semibold">
                                        Facturado anualmente ($209.92/año<span x-show="exchangeRate" class="text-emerald-400/90"> / <span x-text="(209.92 * exchangeRate).toFixed(2)"></span> Bs.</span>)
                                    </span>
                                    <span class="bg-purple-500/20 text-purple-400 border border-purple-500/25 text-[8px] font-extrabold uppercase px-2 py-0.5 rounded-full inline-block">Ahorra 30%</span>
                                </div>
                            </div>

                            <!-- Beneficios -->
                            <ul class="space-y-3.5 text-[11px] text-slate-200 border-t border-purple-500/20 pt-5">
                                <li class="flex items-start gap-2.5">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span>Todo lo incluido en el Plan Standard.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span><strong>Insignia VIP Corona Premium</strong> en tienda.</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span><strong>Métodos de Pago Inteligentes</strong> (Pago Móvil / Zelle).</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span><strong>Soporte VIP corporativo 24/7</strong> dedicado.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- CTA -->
                        <div class="mt-8 flex flex-col gap-2.5 relative z-10">
                            <a href="/register" class="block w-full text-center bg-purple-600 hover:bg-purple-500 text-white font-extrabold py-3 rounded-xl transition-all duration-300 text-xs shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                                Comenzar Premium
                            </a>
                            <button @click="selectedPlan = 'premium'; openModal = true" class="mt-1 text-center text-cyan-400 hover:text-cyan-300 font-bold text-[9px] uppercase tracking-wide flex items-center justify-center gap-1 transition-colors focus:outline-none">
                                Detalles Técnicos <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- PLAN 4: Plan Custom / Personalizado -->
                <div id="plan-custom" class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-3xl p-6 flex flex-col justify-between shadow-2xl relative transition duration-300 hover:-translate-y-2 hover:border-white/20 group">
                    <div>
                        <h3 class="text-lg font-black text-white uppercase tracking-wider">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-400">Custom</span></h3>
                        <p class="text-[11px] text-slate-400 mt-2 leading-relaxed">Desarrollo a medida, integración de dominios y bases de datos dedicadas.</p>
                        
                        <!-- Precio -->
                        <div class="my-6">
                            <div class="text-2xl font-black text-white tracking-tight">A Medida</div>
                            <span class="text-[9px] text-slate-450 block mt-2 font-semibold">Cotización bajo requerimientos</span>
                        </div>

                        <!-- Beneficios -->
                        <ul class="space-y-3.5 text-[11px] text-slate-300 border-t border-white/10 pt-5 leading-relaxed">
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Código independiente exclusivo y BD dedicada.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Módulos de Clientes y Empleados (Roles/CRM).</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Integración con dominios web propios (`.com`).</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Ingeniería de software a la medida.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <div class="mt-8 flex flex-col gap-2.5">
                        <a href="https://wa.me/584121305420?text=Hola,%20deseo%20una%2520asesoría%20sobre%20el%20Plan%20Custom%20de%20WIStore" target="_blank" class="block w-full text-center bg-slate-800/60 hover:bg-slate-700 text-white font-extrabold py-3 rounded-xl transition-all duration-300 text-xs shadow-sm">
                            Cotizar Proyecto
                        </a>
                        <button @click="selectedPlan = 'custom'; openModal = true" class="mt-1 text-center text-pink-400 hover:text-pink-300 font-bold text-[9px] uppercase tracking-wide flex items-center justify-center gap-1 transition-colors focus:outline-none">
                            Detalles Técnicos <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Cláusula de Limitación -->
            <div class="mt-16 text-center max-w-4xl mx-auto">
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed font-semibold px-4">
                    ⚠️ Los planes Standard y Premium incluyen 7 días de prueba gratuita. Estos planes cubren soporte operativo del sistema base y no incluyen funciones personalizadas. El desarrollo a medida se gestiona exclusivamente bajo el plan Custom previo acuerdo comercial.
                </p>
            </div>

            <!-- MODAL DETALLES DEL PLAN (Alpine.js) -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-6" x-cloak>
                <!-- Backdrop con Blur -->
                <div x-show="openModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="openModal = false" 
                     class="fixed inset-0 bg-[#070913]/90 backdrop-blur-md"></div>

                <!-- Contenedor del Modal -->
                <div x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                     class="bg-[#0d1127] border border-white/10 rounded-[2rem] w-full max-w-2xl max-h-[85vh] overflow-y-auto relative z-10 shadow-[0_0_50px_rgba(168,85,247,0.15)] scrollbar-thin">
                    
                    <!-- Botón de Cerrar -->
                    <button @click="openModal = false" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 border border-white/10 hover:border-rose-500/50 hover:bg-rose-500/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors focus:outline-none z-20">
                        <i class="fas fa-times text-sm"></i>
                    </button>

                    <!-- CONTENIDO PRUEBA GRATIS -->
                    <div x-show="selectedPlan === 'free_trial'" class="p-6 md:p-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-white uppercase">Prueba <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Gratis</span></h3>
                                <p class="text-xs text-indigo-400 font-bold uppercase tracking-wider">Plan Inicial • 7 Días de Prueba</p>
                            </div>
                        </div>

                        <p class="text-xs md:text-sm text-slate-300 leading-relaxed">
                            Una excelente manera de experimentar las capacidades base de la plataforma. Crea tu catálogo, añade productos clave y prueba el flujo de pedidos hacia tu WhatsApp de forma totalmente gratuita por 7 días.
                        </p>

                        <div class="border-t border-white/5 pt-6 space-y-4">
                            <h4 class="text-xs uppercase font-black text-slate-200 tracking-wider">¿Qué incluye este plan?</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-300">
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-400 mt-0.5"></i>
                                    <span>Enlace único corto (wistore.com/tu-marca)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-400 mt-0.5"></i>
                                    <span>Hasta 15 productos activos en catálogo</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-400 mt-0.5"></i>
                                    <span>Pedidos ilimitados estructurados a WhatsApp</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-400 mt-0.5"></i>
                                    <span>Personalización de marca básica</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-5 flex items-center justify-between gap-4 mt-6">
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Acceso inmediato sin tarjeta</p>
                                <p class="text-lg font-black text-white">$0.00 USD / 7 días</p>
                            </div>
                            <a href="/register" class="bg-indigo-500 hover:bg-indigo-400 text-white font-black px-6 py-3 rounded-xl text-xs transition-colors shadow-lg">
                                Probar Gratis
                            </a>
                        </div>
                    </div>

                    <!-- CONTENIDO PLAN STANDARD -->
                    <div x-show="selectedPlan === 'standard'" class="p-6 md:p-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400">
                                <i class="fas fa-award text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-white uppercase">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-400">Standard</span></h3>
                                <p class="text-xs text-sky-400 font-bold uppercase tracking-wider">Plan Emprendedor • $14.99/mes o $11.99/mes anual</p>
                            </div>
                        </div>

                        <p class="text-xs md:text-sm text-slate-300 leading-relaxed">
                            Perfecto para marcas en expansión que necesitan un catálogo profesional interactivo y con capacidad de carga ilimitada de productos. Recibe pedidos perfectamente estructurados directo en WhatsApp o Telegram sin pagar comisiones por ventas.
                        </p>

                        <div class="border-t border-white/5 pt-6 space-y-4">
                            <h4 class="text-xs uppercase font-black text-slate-200 tracking-wider">¿Qué incluye este plan?</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-300">
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-sky-400 mt-0.5"></i>
                                    <span>Productos y categorías <strong>ilimitados</strong></span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-sky-400 mt-0.5"></i>
                                    <span>Pedidos estructurados directos a WhatsApp o Telegram</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-sky-400 mt-0.5"></i>
                                    <span>Código QR dinámico autogenerado</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-sky-400 mt-0.5"></i>
                                    <span>Soporte prioritario por WhatsApp</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-sky-400 mt-0.5"></i>
                                    <span>Personalización completa de colores y logos</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-sky-400 mt-0.5"></i>
                                    <span>Panel administrativo básico de órdenes</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-[#0c152b] border border-sky-500/20 rounded-2xl p-5 flex items-center justify-between gap-4 mt-6">
                            <div>
                                <p class="text-xs text-sky-300 font-semibold" x-text="billingPeriod === 'yearly' ? 'Frecuencia de pago anual (Ahorra 20%)' : 'Frecuencia de pago mensual'"></p>
                                <p class="text-lg font-black text-white" x-text="billingPeriod === 'yearly' ? '$143.90 USD / año ($11.99/mes)' : '$14.99 USD / mes'"></p>
                            </div>
                            <a href="/register" class="bg-sky-500 hover:bg-sky-400 text-slate-950 font-black px-6 py-3 rounded-xl text-xs transition-colors shadow-lg">
                                Adquirir Standard
                            </a>
                        </div>
                    </div>

                    <!-- CONTENIDO PLAN PREMIUM -->
                    <div x-show="selectedPlan === 'premium'" class="p-6 md:p-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                                <i class="fas fa-crown text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-white uppercase">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Premium</span></h3>
                                <p class="text-xs text-purple-400 font-bold uppercase tracking-wider">Plan VIP • $24.99/mes o $17.49/mes anual</p>
                            </div>
                        </div>

                        <p class="text-xs md:text-sm text-slate-300 leading-relaxed">
                            Nuestra solución VIP definitiva. Oculta las marcas de WIStore con una experiencia completamente limpia e integra métodos de pago inteligentes venezolanos y extranjeros (Pago Móvil, Zelle). Cuenta con un canal exclusivo de soporte técnico corporativo 24/7 y la prestigiosa Insignia Corona VIP.
                        </p>

                        <div class="border-t border-white/5 pt-6 space-y-4">
                            <h4 class="text-xs uppercase font-black text-slate-200 tracking-wider">¿Qué incluye este plan?</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-300">
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-purple-400 mt-0.5"></i>
                                    <span>Todo lo incluido en el Plan Standard</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-purple-400 mt-0.5"></i>
                                    <span><strong>Insignia VIP Corona Premium</strong> en tienda</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-purple-400 mt-0.5"></i>
                                    <span><strong>Métodos de Pago Inteligentes</strong> (Pago Móvil / Zelle)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-purple-400 mt-0.5"></i>
                                    <span><strong>Soporte VIP corporativo 24/7</strong> dedicado</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-purple-400 mt-0.5"></i>
                                    <span>Carga ultra rápida e infraestructura optimizada</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-purple-400 mt-0.5"></i>
                                    <span>Experiencia limpia sin anuncios de plataforma</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-purple-900/15 border border-purple-500/20 rounded-2xl p-5 flex items-center justify-between gap-4 mt-6">
                            <div>
                                <p class="text-xs text-purple-300 font-semibold" x-text="billingPeriod === 'yearly' ? 'Frecuencia de pago anual (Ahorra 30%)' : 'Frecuencia de pago mensual'"></p>
                                <p class="text-lg font-black text-white" x-text="billingPeriod === 'yearly' ? '$209.92 USD / año ($17.49/mes)' : '$24.99 USD / mes'"></p>
                            </div>
                            <a href="/register" class="bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-black px-6 py-3 rounded-xl text-xs transition-colors shadow-lg">
                                Adquirir Premium
                            </a>
                        </div>
                    </div>

                    <!-- CONTENIDO PLAN CUSTOM -->
                    <div x-show="selectedPlan === 'custom'" class="p-6 md:p-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-400">
                                <i class="fas fa-cogs text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-white uppercase">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-400">Custom</span></h3>
                                <p class="text-xs text-pink-400 font-bold uppercase tracking-wider">Desarrollo a Medida e Infraestructura dedicada</p>
                            </div>
                        </div>

                        <p class="text-xs md:text-sm text-slate-300 leading-relaxed">
                            Pensado para corporaciones, franquicias consolidadas y marcas que necesitan un desarrollo tecnológico robusto, bases de datos aisladas MySQL para el máximo rendimiento y control de datos, y módulos avanzados a la medida del negocio.
                        </p>

                        <div class="border-t border-white/5 pt-6 space-y-4">
                            <h4 class="text-xs uppercase font-black text-slate-200 tracking-wider">¿Qué incluye este plan?</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-300">
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-400 mt-0.5"></i>
                                    <span>Código independiente exclusivo y BD dedicada</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-400 mt-0.5"></i>
                                    <span>Módulo de Clientes y Empleados (roles y CRM)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-400 mt-0.5"></i>
                                    <span>Integración con dominios web propios (`.com`)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-400 mt-0.5"></i>
                                    <span>Ingeniería de software a medida y soporte de infraestructura</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white/[0.02] border border-white/5 rounded-2xl p-5 flex items-center justify-between gap-4 mt-6">
                            <div>
                                <p class="text-xs text-slate-400 font-semibold">Presupuesto adaptado a requerimientos</p>
                                <p class="text-lg font-black text-white">Precio a convenir</p>
                            </div>
                            <a href="https://wa.me/584121305420?text=Hola!%20Deseo%20cotizar%20el%20plan%20Custom%20de%20WIStore%20para%20mi%20negocio" target="_blank" class="bg-pink-600 hover:bg-pink-500 text-white font-black px-6 py-3 rounded-xl text-xs transition-colors shadow-lg">
                                Cotizar por WhatsApp
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- VS COMPETENCIA (WIStore vs El Resto) -->
    <section id="vs-competencia" class="py-20 md:py-28 border-t border-white/5 relative overflow-hidden z-10">
        
        <!-- Orbe de luz de fondo -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-500/5 rounded-full blur-[150px] pointer-events-none blur-accelerated"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Cabecera de Competencia -->
            <div class="text-center mb-16 md:mb-20">
                <span class="bg-rose-600/20 text-rose-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-rose-500/30 shadow-[0_0_15px_rgba(244,63,94,0.2)]">
                    La Diferencia WIStore
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">WIStore vs La Competencia</h2>
                <p class="text-sm md:text-base text-slate-400 mt-3 max-w-2xl mx-auto leading-relaxed">No pagues por funciones limitadas en plataformas extranjeras. Descubre por qué somos la opción más inteligente y rentable para tu negocio en Venezuela.</p>
            </div>

            <!-- Grid de Comparativas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-stretch justify-center">

                <!-- COMPARATIVA 1: Plan Standard vs Linktree -->
                <div class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl relative transition duration-300 hover:border-white/20">
                    <div class="p-6 md:p-8 bg-gradient-to-b from-cyan-900/20 to-transparent border-b border-white/5">
                        <h3 class="text-xl font-black text-white text-center flex items-center justify-center gap-3">
                            <span class="uppercase">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Standard</span></span> 
                            <span class="text-slate-500 text-sm">vs</span> 
                            <span class="text-slate-300">Linktree</span>
                        </h3>
                    </div>
                    
                    <div class="p-0">
                        <table class="w-full text-left border-collapse text-xs md:text-sm">
                            <thead>
                                <tr>
                                    <th class="p-4 border-b border-white/5 w-1/3 text-slate-400 font-semibold bg-white/[0.02]">Característica</th>
                                    <th class="p-4 border-b border-white/5 w-1/3 text-center font-black text-cyan-400 bg-cyan-900/10">Plan Standard</th>
                                    <th class="p-4 border-b border-white/5 w-1/3 text-center text-slate-400 font-semibold bg-white/[0.02]">Linktree (Pro)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-300">
                                <tr>
                                    <td class="p-4 font-medium">Precio Mensual</td>
                                    <td class="p-4 text-center bg-cyan-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            $14.99 / mes
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-xs font-bold">—</span>
                                            $24 / mes
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Personalización Visual</td>
                                    <td class="p-4 text-center bg-cyan-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Total (Tu Marca)
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Limitada
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                     <td class="p-4 font-medium">Integración WhatsApp</td>
                                    <td class="p-4 text-center bg-cyan-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Nativo + Flotante
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Solo básico
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Atención y Soporte</td>
                                    <td class="p-4 text-center bg-cyan-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Local Prioritario
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Solo Inglés
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Velocidad de Carga</td>
                                    <td class="p-4 text-center bg-cyan-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Ultra Rápida
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Promedio
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- COMPARATIVA 2: Plan Premium vs PideFacil -->
                <div class="bg-[#0d1127]/60 backdrop-blur-md border border-purple-500/20 rounded-[2rem] overflow-hidden shadow-[0_0_30px_rgba(168,85,247,0.15)] relative transition duration-300 hover:border-purple-500/40">
                    <!-- Destello -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="p-6 md:p-8 bg-gradient-to-b from-purple-900/20 to-transparent border-b border-white/5 relative z-10">
                        <h3 class="text-xl font-black text-white text-center flex items-center justify-center gap-3">
                            <span class="uppercase">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Premium</span></span> 
                            <span class="text-slate-500 text-sm">vs</span> 
                            <span class="text-slate-300">PideFacil</span>
                        </h3>
                    </div>
                    
                    <div class="p-0 relative z-10">
                        <table class="w-full text-left border-collapse text-xs md:text-sm">
                            <thead>
                                <tr>
                                    <th class="p-4 border-b border-white/5 w-1/3 text-slate-400 font-semibold bg-white/[0.02]">Característica</th>
                                    <th class="p-4 border-b border-white/5 w-1/3 text-center font-black text-purple-400 bg-purple-900/10">Plan Premium</th>
                                    <th class="p-4 border-b border-white/5 w-1/3 text-center text-slate-400 font-semibold bg-white/[0.02]">PideFacil</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-300">
                                <tr>
                                    <td class="p-4 font-medium">Comisiones por Venta</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            0% Comisiones
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            2% - 5% por transacción
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Precio Mensual</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            $24.99 / mes
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-xs font-bold">—</span>
                                            Desde $35 / mes
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Límite de Productos</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Ilimitado
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Limitado por Plan
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Enlace Biográfico</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Incluye Plan Standard
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            No incluye
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Experiencia / Interfaz</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Híbrida y Rápida
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Genérica
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                        <li><a href="#vs-competencia" class="text-slate-400 hover:text-cyan-400 transition-colors font-semibold">Comparativa con la Competencia</a></li>
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
                            <i class="fas fa-envelope text-cyan-400 w-4"></i>
                            <span>(Próximamente)</span>
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

</body>
</html>
