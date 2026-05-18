<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Comparativa de Planes - WIStore</title>
    
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
    </style>
</head>
<body class="bg-[#070913] text-gray-100 min-h-screen selection:bg-purple-500 selection:text-white relative">

    <!-- ============================================== -->
    <!-- CAPA DE FONDO GLOBAL (Base Canvas & Neón)      -->
    <!-- ============================================== -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] blur-accelerated"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated"></div>

        <svg class="absolute inset-0 w-full h-full opacity-40" preserveAspectRatio="none" viewBox="0 0 1440 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            <path d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800" stroke="url(#neonGradient1)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000" stroke="url(#neonGradient2)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100" stroke="url(#neonGradient2)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path d="M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.4" />
        </svg>
    </div>

    <!-- Botón Flotante Volver -->
    <a href="{{ route('home') }}#precios" class="fixed top-6 left-6 md:top-8 md:left-8 z-50 bg-[#0d1127]/80 backdrop-blur-md border border-white/10 hover:border-purple-500/50 text-white font-bold px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2 transition-all duration-300 text-xs md:text-sm group">
        <i class="fas fa-arrow-left text-purple-400 group-hover:-translate-x-1 transition-transform"></i>
        <span>Volver al Inicio</span>
    </a>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="relative z-10 py-24 md:py-32 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        
        <!-- Cabecera -->
        <div class="text-center mb-16">
            <span class="bg-cyan-600/20 text-cyan-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-cyan-500/30 shadow-[0_0_15px_rgba(34,211,238,0.2)]">
                Detalles Técnicos
            </span>
            <span class="inline-flex items-center gap-1 bg-emerald-600/20 text-emerald-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)] mt-2 sm:mt-0 sm:ml-2">
                Tasa Oficial BCV 🇻🇪
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">Comparativa de Planes</h1>
            <p class="text-sm md:text-base text-slate-400 mt-3 max-w-2xl mx-auto leading-relaxed">Conoce a fondo todas las características que incluye cada nivel y elige el que mejor se adapte a tu escala empresarial.</p>
        </div>

        <!-- Tabla Comparativa Glassmorphism -->
        <div class="overflow-x-auto pb-8 scrollbar-none rounded-[2rem] shadow-2xl border border-white/5 bg-[#0d1127]/40 backdrop-blur-xl">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr>
                        <th class="p-6 border-b border-white/10 w-1/4">
                            <h3 class="text-xl font-bold text-white">Características</h3>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/4 text-center">
                            <h3 class="text-lg font-black text-white uppercase">WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">-Link</span></h3>
                            <p class="text-xs text-slate-400 mt-1">8.99$ / mes</p>
                            <span class="text-[9px] text-slate-500 block mt-0.5 font-semibold">(Tasa BCV)</span>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/4 text-center bg-purple-900/10 relative">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-purple-500 to-cyan-500"></div>
                            <h3 class="text-lg font-black text-white flex items-center justify-center gap-1.5 uppercase">WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">-Menu</span> <i class="fas fa-star text-yellow-400 text-xs"></i></h3>
                            <p class="text-xs text-purple-300 mt-1">24.99$ / mes</p>
                            <span class="text-[9px] text-purple-400/80 block mt-0.5 font-semibold">(Tasa BCV)</span>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/4 text-center">
                            <h3 class="text-lg font-black text-white uppercase">WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">-Admin/Custom</span></h3>
                            <p class="text-xs text-slate-400 mt-1">A convenir</p>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-300 divide-y divide-white/5">
                    <!-- Categoría: Tienda y Catálogo -->
                    <tr class="bg-white/[0.02]">
                        <td colspan="4" class="p-4 font-black text-xs uppercase tracking-widest text-cyan-400">Tienda y Catálogo</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Árbol de Enlaces Biográficos</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Catálogo Interactivo Híbrido</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Productos y Categorías</td>
                        <td class="p-4 border-l border-white/5 text-center text-slate-500">-</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 font-bold text-white">Ilimitados</td>
                        <td class="p-4 border-l border-white/5 text-center font-bold text-white">Ilimitados</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Carrito y Pedidos a WhatsApp/Telegram</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Comisiones por Venta</td>
                        <td class="p-4 border-l border-white/5 text-center text-slate-500">-</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 font-black text-emerald-400">0%</td>
                        <td class="p-4 border-l border-white/5 text-center font-black text-emerald-400">0%</td>
                    </tr>

                    <!-- Categoría: Personalización -->
                    <tr class="bg-white/[0.02]">
                        <td colspan="4" class="p-4 font-black text-xs uppercase tracking-widest text-pink-400">Personalización e Identidad</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Enlace Corto Único</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Edición de Colores / Logo</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs">Básica</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs font-bold text-white">Completa (3 Tokens)</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">100% A medida</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Dominio Propio (ej: mitienda.com)</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>

                    <!-- Categoría: Gestión y Administración -->
                    <tr class="bg-white/[0.02]">
                        <td colspan="4" class="p-4 font-black text-xs uppercase tracking-widest text-purple-400">Gestión y Arquitectura</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Base de Datos de Clientes</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Roles y Permisos de Empleados</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-times text-rose-500/50 text-lg"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-lg"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Panel de Estadísticas y Analítica</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs">Visitas</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs">Visitas</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Avanzado (Ventas/Pedidos)</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Infraestructura Independiente</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs">SaaS Compartido</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs">SaaS Compartido</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-emerald-400">Servidor y BD Dedicada</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Soporte Técnico</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs">Tickets (24h)</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs">Prioritario (12h)</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Directo y Dedicado (24/7)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- CTA Inferior -->
        <div class="mt-16 text-center">
            <h2 class="text-2xl font-black text-white mb-6">¿Listo para impulsar tus ventas con el mejor ecosistema digital?</h2>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/register" class="bg-purple-600 hover:bg-purple-500 text-white font-extrabold px-8 py-4 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.4)] transition-all duration-300 hover:-translate-y-1">
                    Comenzar con WIMenu
                </a>
                <a href="https://wa.me/584121305420?text=Hola,%20deseo%20una%20asesoría%20sobre%20los%20planes%20de%20WIStore" target="_blank" class="bg-transparent border border-white/20 hover:bg-white/10 text-white font-bold px-8 py-4 rounded-xl transition-all duration-300">
                    Contactar a un Asesor
                </a>
            </div>
        </div>

    </main>
</body>
</html>
