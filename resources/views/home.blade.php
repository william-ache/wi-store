<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>WIStore - La plataforma de catálogos digitales para WhatsApp</title>
    
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
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
    </style>
</head>
<body class="bg-[#070913] text-gray-100 min-h-screen selection:bg-brand-500 selection:text-white relative" x-data="{ isMobileMenuOpen: false }">

    <!-- Fondo Global Neon con Líneas Fluidas -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[70vw] h-[70vw] rounded-full bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-[#a855f7]/20 via-transparent to-transparent blur-[120px]"></div>
        <div class="absolute -bottom-[20%] -right-[10%] w-[70vw] h-[70vw] rounded-full bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-[#22d3ee]/20 via-transparent to-transparent blur-[120px]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 60px, rgba(168,85,247,0.15) 60px, rgba(168,85,247,0.15) 61px, transparent 61px, transparent 120px, rgba(34,211,238,0.15) 120px, rgba(34,211,238,0.15) 121px);"></div>
    </div>

    <!-- Header / Navbar (Híbrido Inteligente) -->
    <header class="border-b border-gray-800/50 bg-[#070913]/70 backdrop-blur-md sticky top-0 z-50">
        <!-- El contenedor se ensancha en escritorio y se achica en móvil -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="text-xl md:text-2xl font-black tracking-tight text-white">
                    WI<span class="text-brand-500">Store</span>
                </span>
                <span class="bg-brand-500/10 text-brand-400 text-[9px] uppercase font-bold px-2.5 py-0.5 rounded-full border border-brand-500/20">
                    SaaS Multi-tenant
                </span>
            </a>
            
            <!-- EN ESCRITORIO: Links de Navegación -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#explorar" class="text-sm font-semibold text-gray-300 hover:text-white transition">Explorar Tiendas</a>
                <a href="#como-funciona" class="text-sm font-semibold text-gray-300 hover:text-white transition">¿Cómo funciona?</a>
                <a href="#precios" class="text-sm font-semibold text-gray-300 hover:text-white transition">Precios</a>
                <a href="/login" class="text-sm font-semibold text-gray-300 hover:text-white transition">Iniciar Sesión</a>
                <a href="/register" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-black px-4 py-2.5 rounded-xl shadow-md shadow-brand-600/20 transition">
                    Crear mi Menú
                </a>
            </nav>

            <!-- EN MÓVIL: Botones Rápidos iOS-style -->
            <div class="flex items-center gap-2 md:hidden">
                <a href="/login" class="text-xs font-bold text-gray-300 hover:text-white px-2.5 py-1.5 rounded-lg">Log In</a>
                <a href="/register" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-black px-3.5 py-2 rounded-xl shadow-md transition">
                    Crear Tienda
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (Premium 3D Asymmetric Layout) -->
    <section class="relative pt-12 md:pt-20 pb-20 md:pb-32 px-4 max-w-7xl mx-auto overflow-hidden z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
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
                    Personaliza tu logotipo, edita los 3 colores principales de tu identidad en tiempo real y recibe todos tus pedidos de forma estructurada directamente a tu WhatsApp. ¡Todo listo en menos de 3 minutos!
                </p>
                
                <!-- Botones Principales -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-5 pt-4">
                    <a href="/register" class="w-full sm:w-auto text-center bg-purple-600 hover:bg-purple-500 text-white font-bold px-8 py-4 rounded-2xl shadow-[0_0_20px_rgba(147,51,234,0.4)] transition-all duration-300 hover:-translate-y-1 text-sm md:text-base">
                        Empezar Catálogo Gratis
                    </a>
                    <a href="#explorar" class="w-full sm:w-auto text-center border border-white/10 bg-white/5 hover:bg-white/10 backdrop-blur-sm text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 hover:-translate-y-1 text-sm md:text-base">
                        Explorar Tiendas
                    </a>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Mockup Interactivo de Tableta Flotante -->
            <div class="lg:col-span-6 relative flex justify-center items-center py-8 lg:py-0 mt-8 lg:mt-0">
                
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
    <section id="explorar" class="py-16 md:py-24 bg-[#070913] relative overflow-hidden z-10">
        <!-- Luces de fondo opcionales para continuidad -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Cabecera de la Sección con Buscador y Filtros -->
            <div class="flex flex-col lg:flex-row gap-6 items-center justify-between mb-12">
                <!-- Título Izquierda -->
                <div class="text-center lg:text-left w-full lg:w-auto">
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Explora Tiendas Afiliadas</h2>
                    <p class="text-sm text-slate-400 mt-1.5">Compra de forma directa en los mejores catálogos de WIStore.</p>
                </div>

                <!-- Buscador y Filtros Derecha -->
                <div class="w-full lg:w-auto flex flex-col md:flex-row gap-4 items-center">
                    <!-- Formulario Buscador Compacto -->
                    <form action="{{ route('home') }}#explorar" method="GET" class="w-full md:w-64 lg:w-72 flex gap-2 shrink-0">
                        <div class="relative flex-grow">
                            <input type="text" name="search" placeholder="Buscar tienda..." 
                                   value="{{ request('search') }}"
                                   class="w-full bg-slate-900/80 border border-slate-800 rounded-2xl px-4 py-3 pl-10 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all shadow-inner">
                            <svg class="absolute left-3 top-3.5 text-slate-500" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white text-xs font-black px-4 rounded-2xl transition active:scale-95 shrink-0 shadow-[0_0_10px_rgba(147,51,234,0.3)]">
                            Buscar
                        </button>
                    </form>

                    <!-- Filtros Píldoras Táctiles -->
                    <div class="w-full md:w-auto flex gap-2 overflow-x-auto flex-nowrap whitespace-nowrap scrollbar-none py-1">
                        <button class="bg-purple-600/20 text-purple-400 text-[11px] font-black px-4 py-2.5 rounded-full border border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.15)]">Todos</button>
                        <button class="bg-slate-900 text-slate-400 text-[11px] font-bold px-4 py-2.5 rounded-full border border-slate-800 hover:border-slate-700 hover:text-white transition">Gastronomía</button>
                        <button class="bg-slate-900 text-slate-400 text-[11px] font-bold px-4 py-2.5 rounded-full border border-slate-800 hover:border-slate-700 hover:text-white transition">Moda y Estilo</button>
                        <button class="bg-slate-900 text-slate-400 text-[11px] font-bold px-4 py-2.5 rounded-full border border-slate-800 hover:border-slate-700 hover:text-white transition">Detalles y Regalos</button>
                    </div>
                </div>
            </div>

            <!-- CARRUSEL DE TARJETAS (Grid 3 Columnas en PC) -->
            <div x-data="{ 
                scrollLeft() {
                    this.$refs.carousel.scrollBy({ left: -340, behavior: 'smooth' });
                },
                scrollRight() {
                    this.$refs.carousel.scrollBy({ left: 340, behavior: 'smooth' });
                }
            }" class="relative group">
                
                <!-- Flechas de Navegación -->
                <button @click="scrollLeft()" class="absolute -left-5 top-1/2 -translate-y-1/2 z-30 w-10 h-10 bg-slate-900/90 backdrop-blur-md text-white border border-slate-800 rounded-full hidden lg:flex items-center justify-center shadow-xl hover:bg-purple-600 hover:border-purple-500 transition-all active:scale-95 opacity-0 group-hover:opacity-100 duration-300">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>

                <button @click="scrollRight()" class="absolute -right-5 top-1/2 -translate-y-1/2 z-30 w-10 h-10 bg-slate-900/90 backdrop-blur-md text-white border border-slate-800 rounded-full hidden lg:flex items-center justify-center shadow-xl hover:bg-purple-600 hover:border-purple-500 transition-all active:scale-95 opacity-0 group-hover:opacity-100 duration-300">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

                <!-- Contenedor Horizontal Carrusel / Grid -->
                <div x-ref="carousel" class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible gap-6 scroll-smooth snap-x snap-mandatory scrollbar-none pb-6">
                    @forelse($shops as $shop)
                        <!-- Tarjeta de Tienda -->
                        <div class="w-[300px] lg:w-auto shrink-0 snap-start bg-slate-900/50 border border-slate-800/80 rounded-[2rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
                            
                            <!-- Foto de Portada con Esquinas Redondeadas Internas -->
                            <div class="p-2 pb-0">
                                <div class="h-40 w-full overflow-hidden relative rounded-[1.5rem] bg-slate-800">
                                    @if($shop->cover_path)
                                        <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="{{ $shop->name }}" class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-lg font-black tracking-widest select-none">WISTORE</div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                                    <!-- Logo Circular Flotante a la Izquierda -->
                                    <div class="absolute bottom-3 left-4 w-14 h-14 rounded-full border-4 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                        <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/'.$shop->logo_path) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=a855f7&color=fff') }}" alt="Logo" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>

                            <!-- Contenido de la Tarjeta -->
                            <div class="pt-4 px-5 pb-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="text-lg font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                                        <!-- Estrellas -->
                                        <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">{{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}</p>
                                </div>

                                <div class="space-y-4 mt-4">
                                    <!-- Badges grises -->
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(explode(',', $shop->payment_methods ?: 'Pago Móvil,Zelle') as $method)
                                            <span class="bg-slate-800 text-slate-300 text-[9px] font-bold px-2 py-1 rounded-md">{{ trim($method) }}</span>
                                        @endforeach
                                    </div>

                                    <!-- Botón Entrar -->
                                    <a href="/{{ $shop->slug }}" class="block w-full text-center bg-slate-800/50 hover:bg-slate-700 text-white font-bold py-3.5 rounded-xl transition-all duration-300 text-xs shadow-sm">
                                        Entrar a la Tienda
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full lg:col-span-3 text-center py-16">
                            <p class="text-slate-500 text-sm">No se encontraron tiendas registradas de momento.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </section>

    <!-- SECCIÓN CÓMO FUNCIONA (Estilo Bloques Neón) -->
    <section id="como-funciona" class="py-20 md:py-28 bg-[#070913] relative overflow-hidden z-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Cabecera Centrada -->
            <div class="mb-16 md:mb-20 text-center">
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight">¿Cómo funciona WIStore?</h2>
                <p class="text-sm md:text-base text-slate-400 mt-3 max-w-xl mx-auto">Crea tu menú interactivo de marca blanca y recibe pedidos en WhatsApp en 3 pasos sencillos.</p>
            </div>

            <!-- 3 Bloques Numéricos (Horizontal en PC) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                <!-- Paso 1 -->
                <div class="bg-slate-900/40 border border-slate-800/80 p-8 md:p-10 rounded-[2.5rem] flex flex-col items-center text-center relative hover:border-purple-500/30 transition-colors group">
                    <!-- Número Escondido Decorativo -->
                    <span class="absolute top-4 right-6 text-6xl font-black text-white/[0.02] group-hover:text-purple-500/5 transition-colors select-none">1</span>
                    
                    <!-- Icono Neón -->
                    <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 shadow-[0_0_30px_rgba(168,85,247,0.15)] group-hover:shadow-[0_0_40px_rgba(168,85,247,0.3)] flex items-center justify-center mb-6 relative">
                        <div class="absolute inset-0 bg-purple-500/20 rounded-full blur-md"></div>
                        <svg class="w-8 h-8 text-purple-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    
                    <h4 class="text-lg font-black text-white mb-3">Registra tus Productos</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">Ingresa tus categorías, sube imágenes, agrega descripciones atractivas y define tus precios de venta.</p>
                </div>

                <!-- Paso 2 -->
                <div class="bg-slate-900/40 border border-slate-800/80 p-8 md:p-10 rounded-[2.5rem] flex flex-col items-center text-center relative hover:border-cyan-500/30 transition-colors group">
                    <span class="absolute top-4 right-6 text-6xl font-black text-white/[0.02] group-hover:text-cyan-500/5 transition-colors select-none">2</span>
                    
                    <!-- Icono Neón -->
                    <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 shadow-[0_0_30px_rgba(34,211,238,0.15)] group-hover:shadow-[0_0_40px_rgba(34,211,238,0.3)] flex items-center justify-center mb-6 relative">
                        <div class="absolute inset-0 bg-cyan-500/20 rounded-full blur-md"></div>
                        <svg class="w-8 h-8 text-cyan-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    
                    <h4 class="text-lg font-black text-white mb-3">Elige tus Colores</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">Define los 3 colores principales de tu identidad visual, sube tu logo y portada para adaptar el catálogo a tu marca.</p>
                </div>

                <!-- Paso 3 -->
                <div class="bg-slate-900/40 border border-slate-800/80 p-8 md:p-10 rounded-[2.5rem] flex flex-col items-center text-center relative hover:border-pink-500/30 transition-colors group">
                    <span class="absolute top-4 right-6 text-6xl font-black text-white/[0.02] group-hover:text-pink-500/5 transition-colors select-none">3</span>
                    
                    <!-- Icono Neón -->
                    <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 shadow-[0_0_30px_rgba(236,72,153,0.15)] group-hover:shadow-[0_0_40px_rgba(236,72,153,0.3)] flex items-center justify-center mb-6 relative">
                        <div class="absolute inset-0 bg-pink-500/20 rounded-full blur-md"></div>
                        <svg class="w-8 h-8 text-pink-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    
                    <h4 class="text-lg font-black text-white mb-3">Recibe Pedidos Directos</h4>
                    <p class="text-sm text-slate-400 leading-relaxed">Comparte tu enlace y tus clientes podrán enviarte pedidos estructurados directamente a tu WhatsApp, sin comisiones.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRECIOS (Glassmorphic Dark Premium) -->
    <section id="precios" class="py-20 md:py-28 border-t border-white/5 bg-[#070913] relative overflow-hidden z-10">
        
        <!-- Orbes de luz de fondo para el fondo oscuro -->
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Cabecera de Precios -->
            <div class="text-center mb-16 md:mb-20">
                <span class="bg-purple-600/20 text-purple-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.2)]">
                    Planes Flexibles
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">Precios que impulsan tu negocio</h2>
                <p class="text-sm md:text-base text-slate-400 mt-3 max-w-xl mx-auto leading-relaxed">Selecciona la solución ideal para digitalizar tu marca, aumentar tus ventas y conectar de forma directa con tus clientes.</p>
            </div>
            
            <!-- Grid de 4 Columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch justify-center">

                <!-- PLAN 1: WILink Pro -->
                <div class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-3xl p-6 md:p-8 flex flex-col justify-between shadow-2xl relative transition duration-300 hover:-translate-y-2 hover:border-white/20 group">
                    <div>
                        <h3 class="text-xl font-black text-white">WILink Pro</h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Tu árbol de enlaces biográficos personalizado.</p>
                        
                        <!-- Precio -->
                        <div class="my-6">
                            <div class="text-4xl font-black text-white flex items-baseline gap-1">10$ <span class="text-sm font-medium text-slate-500">/ mes</span></div>
                            <span class="text-[10px] text-slate-400 block mt-1 font-semibold">Pagadero en Bs. a tasa oficial</span>
                        </div>

                        <!-- Beneficios -->
                        <ul class="space-y-4 text-xs text-slate-300 border-t border-white/10 pt-6">
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Enlace corto único (wistore.com/l/tu-marca).</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Botones personalizados ilimitados a Redes Sociales.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Botón directo a WhatsApp y Google Maps.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Personalización visual básica.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <div class="mt-8 flex flex-col gap-3">
                        <a href="/register" class="block w-full text-center bg-slate-800/60 hover:bg-slate-700 text-white font-extrabold py-3.5 rounded-xl transition-all duration-300 text-xs shadow-sm">
                            Adquirir WILink
                        </a>
                        <a href="/demo-wilink" class="block w-full text-center border-b border-white/10 hover:border-white/30 text-slate-400 hover:text-white font-bold py-2 transition-all duration-300 text-xs">
                            Ver DEMO
                        </a>
                    </div>
                </div>

                <!-- PLAN 2: WIMenu Premium (EL DESTACADO) -->
                <div class="relative rounded-3xl p-[2px] bg-gradient-to-b from-purple-500 via-cyan-500 to-purple-600 shadow-[0_0_30px_rgba(168,85,247,0.3)] transition-transform duration-300 hover:-translate-y-2">
                    <!-- Badge Flotante "✨ RECOMENDADO" -->
                    <span class="absolute -top-4 -right-2 bg-purple-600 text-white text-[9px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full shadow-[0_0_15px_rgba(168,85,247,0.6)] transform rotate-3 select-none z-10">
                        ✨ RECOMENDADO
                    </span>

                    <div class="bg-[#0d1127] rounded-[1.4rem] p-6 md:p-8 flex flex-col justify-between h-full relative overflow-hidden">
                        <!-- Destello interno -->
                        <div class="absolute -top-20 -right-20 w-40 h-40 bg-purple-500/20 rounded-full blur-2xl"></div>

                        <div class="relative z-10">
                            <h3 class="text-xl font-black text-white">WIMenu Premium</h3>
                            <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">Menú digital interactivo con pedidos directos a WhatsApp + WILink incluido.</p>
                            
                            <!-- Precio -->
                            <div class="my-6">
                                <div class="text-4xl font-black text-white flex items-baseline gap-1">25$ <span class="text-sm font-medium text-purple-300">/ mes</span></div>
                                <span class="text-[10px] text-slate-400 block mt-1 font-semibold">Pagadero en Bs. a tasa oficial</span>
                            </div>

                            <!-- Beneficios -->
                            <ul class="space-y-4 text-xs text-slate-200 border-t border-purple-500/20 pt-6">
                                <li class="flex items-start gap-3">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span>Catálogo con <strong>productos ilimitados</strong>.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span><strong>Interfaz Híbrida Inteligente</strong> (Web/App).</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span>Personalización total de marca (colores/logo).</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span><strong>Pedidos directo a tu WhatsApp</strong> (0% comisiones).</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="text-purple-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span><span class="text-cyan-400 font-bold">INCLUYE WILink Pro</span> (Ahorras 5$).</span>
                                </li>
                            </ul>
                        </div>

                        <!-- CTA -->
                        <div class="mt-8 flex flex-col gap-3 relative z-10">
                            <a href="/register" class="block w-full text-center bg-purple-600 hover:bg-purple-500 text-white font-extrabold py-3.5 rounded-xl transition-all duration-300 text-xs shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                                Comenzar WIMenu
                            </a>
                            <a href="/ys-detallitos" class="block w-full text-center border-b border-white/10 hover:border-white/30 text-slate-300 hover:text-white font-bold py-2 transition-all duration-300 text-xs">
                                Ver DEMO
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PLAN 3: WIAdmin Enterprise -->
                <div class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-3xl p-6 md:p-8 flex flex-col justify-between shadow-2xl relative transition duration-300 hover:-translate-y-2 hover:border-white/20 group">
                    <div>
                        <h3 class="text-xl font-black text-white">WIAdmin Enterprise</h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">El sistema definitivo para el control total.</p>
                        
                        <!-- Precio -->
                        <div class="my-6">
                            <div class="text-4xl font-black text-white flex items-baseline gap-1">45$ <span class="text-sm font-medium text-slate-500">/ mes</span></div>
                            <span class="text-[10px] text-slate-400 block mt-1 font-semibold">Pagadero en Bs. a tasa oficial</span>
                        </div>

                        <!-- Beneficios -->
                        <ul class="space-y-4 text-xs text-slate-300 border-t border-white/10 pt-6">
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span><strong>Todo lo incluido en WIMenu.</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span><strong>Módulo de Clientes:</strong> Base de datos y fidelización.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span><strong>Módulo de Empleados:</strong> Roles y permisos.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Panel Avanzado de Órdenes y Estadísticas.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <div class="mt-8 flex flex-col gap-3">
                        <a href="/register" class="block w-full text-center bg-slate-800/60 hover:bg-slate-700 text-white font-extrabold py-3.5 rounded-xl transition-all duration-300 text-xs shadow-sm">
                            Contactar WIAdmin
                        </a>
                        <a href="/ys-detallitos/admin/dashboard" class="block w-full text-center border-b border-white/10 hover:border-white/30 text-slate-400 hover:text-white font-bold py-2 transition-all duration-300 text-xs">
                            Ver DEMO
                        </a>
                    </div>
                </div>

                <!-- PLAN 4: WICustom -->
                <div class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-3xl p-6 md:p-8 flex flex-col justify-between shadow-2xl relative transition duration-300 hover:-translate-y-2 hover:border-white/20 group">
                    <div>
                        <h3 class="text-xl font-black text-white">WICustom</h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Tu ecosistema de software a medida.</p>
                        
                        <!-- Precio -->
                        <div class="my-6">
                            <div class="text-3xl font-black text-white">Personalizado</div>
                            <span class="text-[10px] text-slate-400 block mt-1 font-semibold">Precio a Convenir</span>
                        </div>

                        <!-- Beneficios -->
                        <ul class="space-y-4 text-xs text-slate-300 border-t border-white/10 pt-6">
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Código independiente exclusivo.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Base de datos MySQL dedicada.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Desarrollo de módulos desde cero.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-cyan-400 shrink-0 mt-0.5 w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                <span>Integración con dominios/pasarelas propias.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <div class="mt-8 flex flex-col gap-3">
                        <a href="https://wa.me/584120000000?text=Hola..." target="_blank" class="block w-full text-center bg-slate-800/60 hover:bg-slate-700 text-white font-extrabold py-3.5 rounded-xl transition-all duration-300 text-xs shadow-sm">
                            Cotizar Proyecto
                        </a>
                        <a href="/demo-custom" class="block w-full text-center border-b border-white/10 hover:border-white/30 text-slate-400 hover:text-white font-bold py-2 transition-all duration-300 text-xs">
                            Ver DEMO
                        </a>
                    </div>
                </div>

            </div>

            <!-- Cláusula de Limitación y Cintillo Informativo -->
            <div class="mt-16 text-center max-w-4xl mx-auto space-y-6">
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed font-semibold px-4">
                    ⚠️ Los planes WILink, WIMenu y WIAdmin cubren soporte operativo del sistema base y no incluyen funciones personalizadas. El desarrollo a medida se gestiona exclusivamente bajo el plan WICustom previo acuerdo comercial.
                </p>
                <!-- Cintillo Informativo de Restauración de Demos -->
                <div class="inline-flex justify-center bg-[#1e1136]/80 backdrop-blur-md border border-purple-500/30 px-6 py-4 rounded-2xl shadow-[0_0_20px_rgba(168,85,247,0.15)] mx-auto">
                    <p class="text-[10px] md:text-xs text-purple-300 flex items-center justify-center gap-2 font-black tracking-[0.1em] uppercase">
                        🔄 LOS DATOS DE LAS DEMOS SE RESTAURAN AUTOMÁTICAMENTE CADA 12 HORAS PARA MANTENER EL SISTEMA LIMPIO.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-gray-800/80 bg-[#070a12] py-8 text-center text-xs text-gray-500">
        <p class="font-extrabold text-white text-sm">WIStore</p>
        <p class="mt-1">© 2026 Todos los derechos reservados. Diseñado por Wydex.</p>
    </footer>

</body>
</html>
