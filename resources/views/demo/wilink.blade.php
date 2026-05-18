<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sabores Y&B - Enlaces Biográficos</title>
    
    <!-- Tailwind CSS & Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
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

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #2d4a36;
            background-image: linear-gradient(135deg, #1e3a1f 0%, #365314 100%);
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Neo-Brutalist Shadow Custom Transition */
        .neo-btn {
            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .neo-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #000000;
        }
        .neo-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #000000;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-0 md:p-6 overflow-x-hidden select-none">

    <!-- Barra Flotante de Retorno a WIStore (Siempre Visible) -->
    <div class="fixed top-4 left-4 z-[9999]">
        <a href="/" class="flex items-center gap-2 bg-slate-900/95 backdrop-blur-md text-white text-xs font-bold px-4 py-2.5 rounded-full border border-slate-800/80 shadow-2xl hover:bg-slate-800 transition active:scale-95">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Volver a WIStore</span>
        </a>
    </div>

    <!-- CONTENEDOR HÍBRIDO -->
    <!-- PC: Mockup de Teléfono con fondo verde oliva en escritorio -->
    <!-- MÓVIL: Full viewport de la demo -->
    <div class="relative w-full max-w-md md:max-w-[400px] h-screen md:h-[820px] bg-gradient-to-b from-[#fef475] to-[#82ca25] shadow-2xl md:rounded-[3.2rem] md:border-[10px] border-slate-900 overflow-y-auto scrollbar-none flex flex-col justify-between p-6 pb-8">
        
        <!-- PC: Muesca de Bocina de Teléfono -->
        <div class="hidden md:block absolute top-3 left-1/2 -translate-x-1/2 w-32 h-6 bg-slate-900 rounded-b-2xl z-50"></div>
        
        <div>
            <!-- 1. Cabecera con Botones Superiores -->
            <div class="flex justify-between items-center mt-3 md:mt-6 mb-8">
                <!-- Botón de Preferencias / Sol (Neo-brutalist sutil) -->
                <button class="w-9 h-9 bg-white border-2 border-slate-900 rounded-full flex items-center justify-center shadow-[2px_2px_0px_0px_#000] active:translate-y-0.5 active:shadow-none transition-all">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </button>

                <!-- Botón Compartir -->
                <button class="w-9 h-9 bg-white border-2 border-slate-900 rounded-full flex items-center justify-center shadow-[2px_2px_0px_0px_#000] active:translate-y-0.5 active:shadow-none transition-all">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                </button>
            </div>

            <!-- 2. Logo Circular y Detalles de Marca -->
            <div class="flex flex-col items-center text-center px-4">
                <!-- Círculo del Logo -->
                <div class="w-24 h-24 rounded-full border-[3px] border-emerald-500 bg-white shadow-lg overflow-hidden flex items-center justify-center p-2 mb-4">
                    <!-- SVG Logo Sabores Y&B -->
                    <svg viewBox="0 0 100 100" class="w-full h-full text-emerald-600">
                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4" />
                        <path d="M30 45 Q50 20 70 45" fill="none" stroke="#f59e0b" stroke-width="8" stroke-linecap="round" />
                        <path d="M30 45 L70 45 Q50 65 30 45" fill="#f59e0b" stroke="#f59e0b" stroke-width="2" stroke-linejoin="round" />
                        <text x="50" y="80" text-anchor="middle" font-family="'Outfit', sans-serif" font-weight="900" font-size="16" fill="#1e3a1f">Y&B</text>
                    </svg>
                </div>

                <!-- Nombre y Descripción -->
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Sabores Y&B</h1>
                <p class="text-xs text-slate-800 font-semibold max-w-sm mt-2 leading-relaxed px-2 bg-slate-900/5 py-1.5 rounded-2xl">
                    Sabores Y&B es una empresa venezolana dedicada a ofrecer las más deliciosas y auténticas empanadas artesanales.
                </p>

                <!-- Iconos de Redes Sociales Rápidos -->
                <div class="flex items-center justify-center gap-4 mt-5 text-slate-900">
                    <a href="#" class="hover:scale-110 active:scale-95 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    </a>
                    <a href="#" class="hover:scale-110 active:scale-95 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </a>
                    <a href="#" class="hover:scale-110 active:scale-95 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 12a4 4 0 1 0 4 4V4h5.2a3 3 0 0 0 3-3V1h-1.3A6.2 6.2 0 0 1 14 6.7V12a4 4 0 0 1-5 0z"></path></svg>
                    </a>
                    <a href="#" class="hover:scale-110 active:scale-95 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="#" class="hover:scale-110 active:scale-95 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                </div>
            </div>

            <!-- 3. Lista de Enlaces en Estilo Neo-Brutalista (Screenshot Fiel) -->
            <div class="mt-8 space-y-4 px-2">
                <!-- Enlace 1: Sitio Web -->
                <a href="#" class="neo-btn flex items-center justify-between bg-white border-[2.5px] border-slate-900 rounded-[1.25rem] p-3.5 shadow-[4px_4px_0px_0px_#000] text-emerald-600 font-bold text-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center">
                            🌐
                        </span>
                        <span>Visita el sitio web de Sabores Y&B</span>
                    </div>
                    <span class="text-slate-400 text-xs">•••</span>
                </a>

                <!-- Enlace 2: WhatsApp -->
                <a href="#" class="neo-btn flex items-center justify-between bg-white border-[2.5px] border-slate-900 rounded-[1.25rem] p-3.5 shadow-[4px_4px_0px_0px_#000] text-emerald-600 font-bold text-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-emerald-500 font-black">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </span>
                        <span>WhatsApp</span>
                    </div>
                    <span class="text-slate-400 text-xs">•••</span>
                </a>

                <!-- Enlace 3: Google Maps -->
                <a href="#" class="neo-btn flex items-center justify-between bg-white border-[2.5px] border-slate-900 rounded-[1.25rem] p-3.5 shadow-[4px_4px_0px_0px_#000] text-emerald-600 font-bold text-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center">
                            📍
                        </span>
                        <div class="flex flex-col text-left">
                            <span>Google Maps</span>
                            <span class="text-[9px] text-slate-400 font-semibold -mt-0.5">Empanadas sabores Y&B</span>
                        </div>
                    </div>
                    <span class="text-slate-400 text-xs">•••</span>
                </a>

                <!-- Enlace 4: TikTok -->
                <a href="#" class="neo-btn flex items-center justify-between bg-white border-[2.5px] border-slate-900 rounded-[1.25rem] p-3.5 shadow-[4px_4px_0px_0px_#000] text-emerald-600 font-bold text-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center font-black text-slate-900">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 12a4 4 0 1 0 4 4V4h5.2a3 3 0 0 0 3-3V1h-1.3A6.2 6.2 0 0 1 14 6.7V12a4 4 0 0 1-5 0z"></path></svg>
                        </span>
                        <span>TikTok</span>
                    </div>
                    <span class="text-slate-400 text-xs">•••</span>
                </a>

                <!-- Enlace 5: Instagram -->
                <a href="#" class="neo-btn flex items-center justify-between bg-white border-[2.5px] border-slate-900 rounded-[1.25rem] p-3.5 shadow-[4px_4px_0px_0px_#000] text-emerald-600 font-bold text-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center font-black text-pink-600">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path></svg>
                        </span>
                        <span>Instagram</span>
                    </div>
                    <span class="text-slate-400 text-xs">•••</span>
                </a>

                <!-- Enlace 6: Facebook -->
                <a href="#" class="neo-btn flex items-center justify-between bg-white border-[2.5px] border-slate-900 rounded-[1.25rem] p-3.5 shadow-[4px_4px_0px_0px_#000] text-emerald-600 font-bold text-sm">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center font-black text-blue-600">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </span>
                        <span>Pagina de Facebook</span>
                    </div>
                    <span class="text-slate-400 text-xs">•••</span>
                </a>
            </div>
        </div>

        <!-- 4. Pie de Página de la Demo -->
        <div class="flex flex-col items-center gap-4 mt-8">
            <!-- Botón Únete / Crear propio -->
            <a href="/" class="bg-white hover:bg-slate-50 text-slate-800 text-[11px] font-black uppercase tracking-wider py-2.5 px-6 rounded-full border-2 border-slate-900 shadow-[2px_2px_0px_0px_#000] active:translate-y-0.5 active:shadow-none transition-all">
                Únete a sabores.yb en WIStore
            </a>
            
            <!-- Links Legales mínimos de Linktree -->
            <div class="flex flex-wrap items-center justify-center gap-2.5 text-[8px] text-slate-700/80 font-bold uppercase tracking-wider">
                <span>Preferencia de Cookies</span>
                <span>•</span>
                <span>Reportar</span>
                <span>•</span>
                <span>Privacidad</span>
                <span>•</span>
                <span>Explorar</span>
            </div>
        </div>

    </div>

    <!-- QR Sutil del Teléfono en PC -->
    <div class="hidden md:flex absolute bottom-8 right-8 flex-col items-center gap-1.5 text-white/50 text-[10px] uppercase font-bold tracking-widest bg-black/20 p-3.5 rounded-3xl backdrop-blur-sm border border-white/10">
        <svg class="text-white opacity-60 mb-1" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><path d="M7 17h.01M17 7h.01M7 7h.01M17 17h.01"></path></svg>
        <span>Vista Móvil</span>
    </div>

</body>
</html>
