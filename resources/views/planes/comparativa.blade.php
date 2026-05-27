<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Comparativa de Planes - WI-Store</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.motion-styles')
    @include('partials.landing.ux-styles')
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
            background: #0e1228;
        }
        [x-cloak] { display: none !important; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-gray-100 min-h-screen selection:bg-purple-500 selection:text-white relative pb-28">

    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-purple-500/15 blur-[120px]"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-cyan-500/8 blur-[140px]"></div>
    </div>

    <a href="{{ route('home') }}#precios"
        class="fixed top-6 left-6 md:top-8 md:left-8 z-40 bg-[#0d1127]/80 backdrop-blur-md border border-white/10 hover:border-purple-500/40 text-white font-bold px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2 transition-all text-xs md:text-sm group">
        <i class="fas fa-arrow-left text-purple-400 group-hover:-translate-x-1 transition-transform"></i>
        <span>Volver al Inicio</span>
    </a>

    <main class="relative z-10 py-24 md:py-28 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">

        <div class="text-center mb-10">
            <span class="landing-plan-badge text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full">
                Detalle técnico
            </span>
            <h1 class="text-3xl md:text-4xl font-black text-white mt-4 tracking-tight">Comparativa de planes</h1>
            <p class="text-sm text-slate-400 mt-2 max-w-xl mx-auto leading-relaxed">
                Plan Standard (Emprendedor) y Plan Premium (Negocio). Precios en USD.
            </p>
        </div>

        <div class="mb-10">
            @include('partials.landing.bcv-colombia-highlight')
        </div>

        <div class="mb-10">
            @include('partials.landing.pricing-table')
        </div>

        @include('partials.planes.comparativa-specs')

        @include('partials.planes.comparativa-table')

        <div class="mt-14 text-center">
            <h2 class="text-xl md:text-2xl font-black text-white mb-5">¿Listo para digitalizar tu negocio?</h2>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="/register"
                    class="landing-plan-btn text-white font-extrabold px-8 py-3.5 rounded-xl text-sm transition-all hover:brightness-110">
                    Comenzar gratis
                </a>
                <a href="{{ route('contacto') }}"
                    class="px-8 py-3.5 rounded-xl border border-white/15 text-purple-300/90 hover:text-white hover:border-purple-500/30 font-bold text-sm transition-all">
                    Contactar soporte
                </a>
            
            </div>
            <p class="text-xs text-slate-500 mt-4">
                <a href="mailto:{{ $wiStoreSupportEmail }}" class="text-cyan-300/90 hover:text-cyan-200 font-bold">{{ $wiStoreSupportEmail }}</a>
            </p>
        </div>

    </main>

    @include('partials.public.chat')
</body>
</html>
