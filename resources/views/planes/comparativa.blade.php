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
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr>
                        <th class="p-6 border-b border-white/10 w-1/5">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Características</h3>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/5 text-center">
                            <h3 class="text-sm font-black text-white uppercase tracking-wider">Prueba <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Gratis</span></h3>
                            <p class="text-xs text-slate-350 mt-1">$0.00 <span class="text-[9px] text-slate-500">/ 7 días</span></p>
                            <span class="text-[8px] bg-indigo-500/15 text-indigo-400 border border-indigo-500/20 px-2 py-0.5 rounded-full inline-block mt-1.5 font-extrabold uppercase">Prueba 7d</span>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/5 text-center">
                            <h3 class="text-sm font-black text-white uppercase tracking-wider">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-400">Standard</span></h3>
                            <p class="text-xs text-slate-350 mt-1">$14.99 <span class="text-[9px] text-slate-500">/ mes</span></p>
                            <span class="text-[8px] bg-sky-500/15 text-sky-400 border border-sky-500/20 px-2 py-0.5 rounded-full inline-block mt-1.5 font-extrabold uppercase">Ahorra 15% anual</span>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/5 text-center bg-purple-900/10 relative">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-purple-500 to-cyan-500"></div>
                            <h3 class="text-sm font-black text-white flex items-center justify-center gap-1 uppercase tracking-wider">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Premium</span> <i class="fas fa-crown text-yellow-400 text-[10px]"></i></h3>
                            <p class="text-xs text-purple-300 mt-1">$24.99 <span class="text-[9px] text-purple-450">/ mes</span></p>
                            <span class="text-[8px] bg-purple-500/15 text-purple-400 border border-purple-500/20 px-2 py-0.5 rounded-full inline-block mt-1.5 font-extrabold uppercase">Ahorra 25% anual</span>
                        </th>
                        <th class="p-6 border-b border-white/10 border-l border-white/5 w-1/5 text-center">
                            <h3 class="text-sm font-black text-white uppercase tracking-wider">Plan <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-400">Custom</span></h3>
                            <p class="text-xs text-slate-350 mt-1">A Medida</p>
                            <span class="text-[8px] bg-pink-500/15 text-pink-400 border border-pink-500/20 px-2 py-0.5 rounded-full inline-block mt-1.5 font-extrabold uppercase">Personalizado</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-300 divide-y divide-white/5">
                    <!-- Categoría: Tienda y Catálogo -->
                    <tr class="bg-white/[0.02]">
                        <td colspan="5" class="p-4 font-black text-xs uppercase tracking-widest text-cyan-400">Tienda y Catálogo</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Enlace Único Corto</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Catálogo Interactivo</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Productos Activos</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-indigo-400">Hasta 15</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Ilimitados</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs font-bold text-white">Ilimitados</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Ilimitados</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Categorías de Productos</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-indigo-400">Hasta 3</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Ilimitados</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs font-bold text-white">Ilimitados</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Ilimitados</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Pedidos Directos a WhatsApp/Telegram</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Comisiones por Venta</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-indigo-400">0%</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-white">0%</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs font-black text-emerald-400">0%</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-white">0%</td>
                    </tr>

                    <!-- Categoría: Personalización -->
                    <tr class="bg-white/[0.02]">
                        <td colspan="5" class="p-4 font-black text-xs uppercase tracking-widest text-pink-400">Personalización e Identidad</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Carga de Logo y Portada</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Colores de Marca Personalizados</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-indigo-450">Paleta estándar</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-white font-bold">Completa (3 Tokens)</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs text-purple-300 font-bold">Completa (3 Tokens)</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-pink-400 font-black">A la Medida</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Insignia de Tienda Verificada VIP</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-slate-500">Opcional</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Dominio Propio (ej: mitienda.com)</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>

                    <!-- Categoría: Finanzas y Gestión -->
                    <tr class="bg-white/[0.02]">
                        <td colspan="5" class="p-4 font-black text-xs uppercase tracking-widest text-purple-400">Finanzas y Funciones Pro</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Métodos de Pago Inteligentes</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Carga Automática de Tasa del Día BCV</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-check text-purple-400 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-check text-cyan-400 text-base"></i></td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Infraestructura y Servidor</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-slate-400">SaaS Compartido</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-slate-350">SaaS Compartido</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs text-purple-300">SaaS Compartido</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-emerald-400">Servidor y BD Dedicada</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Acceso a Panel Super Admin</td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10"><i class="fas fa-times text-rose-500/50 text-base"></i></td>
                        <td class="p-4 border-l border-white/5 text-center text-xs font-bold text-white">Opcional</td>
                    </tr>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-4 pl-6 font-semibold">Soporte Técnico</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-slate-500">Tickets (48h)</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-slate-300">Prioritario (24h)</td>
                        <td class="p-4 border-l border-white/5 text-center bg-purple-900/10 text-xs text-purple-300 font-bold">VIP Dedicado (12h)</td>
                        <td class="p-4 border-l border-white/5 text-center text-xs text-pink-400 font-bold">Dedicado 24/7</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- CTA Inferior -->
        <div class="mt-16 text-center">
            <h2 class="text-2xl font-black text-white mb-6">¿Listo para impulsar tus ventas con el mejor ecosistema digital?</h2>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/register" class="bg-purple-600 hover:bg-purple-500 text-white font-extrabold px-8 py-4 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.4)] transition-all duration-300 hover:-translate-y-1">
                    Comenzar Gratis (7 días)
                </a>
                <a href="https://wa.me/584121305420?text=Hola,%20deseo%20una%20asesoría%20sobre%20los%20planes%20de%20WIStore" target="_blank" class="bg-transparent border border-white/20 hover:bg-white/10 text-white font-bold px-8 py-4 rounded-xl transition-all duration-300">
                    Contactar a un Asesor
                </a>
            </div>
        </div>

    </main>
    @include('partials.public.chat')
</body>
</html>
