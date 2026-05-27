@php
    $milestones = [
        [
            'tone' => 'purple',
            'index' => 1,
            'icon' => 'fa-screwdriver-wrench',
            'holo_icon' => 'fa-screwdriver-wrench',
            'quarter' => 'Q1 2026',
            'status' => 'En desarrollo',
            'status_class' => 'text-cyan-300/90',
            'tag_bg' => 'bg-purple-500/15 border-purple-400/30 text-purple-200',
            'title' => 'Nuevas funciones',
            'desc' => 'Módulos y mejoras continuas en el panel: más herramientas para vender, gestionar pedidos y hacer crecer tu tienda sin depender de otras apps.',
        ],
        [
            'tone' => 'cyan',
            'index' => 2,
            'icon' => 'fa-motorcycle',
            'holo_icon' => 'fa-motorcycle',
            'quarter' => 'Q2 2026',
            'status' => 'Planificado',
            'status_class' => 'text-slate-400',
            'tag_bg' => 'bg-cyan-500/15 border-cyan-400/30 text-cyan-200',
            'title' => 'Delivery integrado',
            'desc' => 'Sistema de envíos dentro de la plataforma: zonas, tarifas, seguimiento y pedidos delivery conectados a tu menú y WhatsApp.',
        ],
        [
            'tone' => 'indigo',
            'index' => 3,
            'icon' => 'fa-wand-magic-sparkles',
            'holo_icon' => 'fa-wand-magic-sparkles',
            'quarter' => 'Q3 2026',
            'status' => 'Planificado',
            'status_class' => 'text-slate-400',
            'tag_bg' => 'bg-indigo-500/15 border-indigo-400/30 text-indigo-200',
            'title' => 'Integración con IA',
            'desc' => 'Asistente inteligente en tu panel: genera banners y anuncios, consulta estadísticas en lenguaje natural y recibe resúmenes automáticos de tu negocio.',
        ],
        [
            'tone' => 'pink',
            'index' => 4,
            'icon' => 'fa-building-columns',
            'holo_icon' => 'fa-building-columns',
            'quarter' => 'Q4 2026',
            'status' => 'Planificado',
            'status_class' => 'text-slate-400',
            'tag_bg' => 'bg-fuchsia-500/15 border-fuchsia-400/30 text-fuchsia-200',
            'title' => 'Afiliación bancaria',
            'desc' => 'Integración con banca nacional e internacional para cobrar con más métodos, validaciones automáticas y conciliación desde tu panel.',
        ],
        [
            'tone' => 'yellow',
            'index' => 5,
            'icon' => 'fa-map-location-dot',
            'holo_icon' => 'fa-map-location-dot',
            'quarter' => 'Q1 2027',
            'status' => 'Expansión',
            'status_class' => 'text-yellow-200/90',
            'tag_bg' => 'bg-yellow-500/15 border-yellow-400/30 text-yellow-200',
            'title' => 'Colombia',
            'desc' => 'Lanzamiento en el mercado colombiano: tiendas en COP, pagos locales, pedidos por WhatsApp y menú digital adaptado a la región.',
            'extra' => true,
        ],
    ];
@endphp

@include('partials.landing.roadmap-styles')

<section id="roadmap" class="py-16 md:py-24 mt-12 md:mt-16 relative z-10 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-10 md:mb-12">
            <span class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-purple-200/90 bg-purple-500/10 border border-purple-400/30 px-4 py-1.5 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse"></span>
                Roadmap 2026 – 2028
            </span>
            <h2 class="text-2xl md:text-4xl font-black text-white tracking-tight mt-4">
                Lo que viene en WI-Store
            </h2>
            <p class="text-sm md:text-base text-slate-300 mt-3 max-w-xl mx-auto leading-relaxed">
                Hoja de ruta 2026–2028: prioridades del equipo para hacer la plataforma más completa, conectada y regional.
            </p>
        </div>

        <div class="roadmap-scene">
            {{-- Escena desktop --}}
            <div class="roadmap-desktop roadmap-path-wrap">
                <svg class="roadmap-path-svg" viewBox="0 0 960 760" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
                    <defs>
                        <linearGradient id="roadmapPathGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#a855f7" />
                            <stop offset="22%" stop-color="#22d3ee" />
                            <stop offset="44%" stop-color="#818cf8" />
                            <stop offset="66%" stop-color="#e879f9" />
                            <stop offset="82%" stop-color="#facc15" />
                            <stop offset="100%" stop-color="#94a3b8" />
                        </linearGradient>
                        <filter id="roadmapPathBlur" x="-50%" y="-50%" width="200%" height="200%">
                            <feGaussianBlur stdDeviation="7" result="blur" />
                            <feMerge>
                                <feMergeNode in="blur" />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>
                    </defs>
                    {{-- Ruta: púrpura → cyan → índigo → rosa → amarilla --}}
                    <path class="roadmap-path-glow"
                        d="M 100 95
                           C 165 90, 205 175, 168 295
                           C 135 415, 155 495, 215 515
                           C 295 535, 375 375, 415 275
                           C 515 155, 615 195, 695 295
                           C 775 375, 815 515, 855 575
                           C 885 635, 915 695, 935 715" />
                    <path class="roadmap-path-core"
                        d="M 100 95
                           C 165 90, 205 175, 168 295
                           C 135 415, 155 495, 215 515
                           C 295 535, 375 375, 415 275
                           C 515 155, 615 195, 695 295
                           C 775 375, 815 515, 855 575
                           C 885 635, 915 695, 935 715" />
                </svg>

                @foreach ($milestones as $m)
                    @include('partials.landing.roadmap-milestone-card', ['m' => $m])
                @endforeach
            </div>

            {{-- Timeline móvil: ondas centrales + tarjetas alternadas --}}
            <div class="roadmap-mobile">
                <div class="roadmap-mobile-wave">
                    <svg class="roadmap-mobile-svg" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                        <defs>
                            <linearGradient id="roadmapMobileGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#a855f7" />
                                <stop offset="20%" stop-color="#22d3ee" />
                                <stop offset="40%" stop-color="#818cf8" />
                                <stop offset="60%" stop-color="#e879f9" />
                                <stop offset="80%" stop-color="#facc15" />
                                <stop offset="100%" stop-color="#94a3b8" />
                            </linearGradient>
                            <filter id="roadmapMobileBlur" x="-20%" y="-5%" width="140%" height="110%">
                                <feGaussianBlur stdDeviation="1.8" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                        </defs>
                        <path class="roadmap-mobile-path-glow"
                            d="M 50 0.5
                               C 16 3.5, 16 7.5, 50 11
                               C 84 14.5, 84 18.5, 50 22
                               C 16 25.5, 16 29.5, 50 33
                               C 84 36.5, 84 40.5, 50 44
                               C 16 47.5, 16 51.5, 50 55
                               C 84 58.5, 84 62.5, 50 66
                               C 16 69.5, 16 73.5, 50 77
                               C 84 80.5, 84 84.5, 50 88
                               C 16 91.5, 16 95.5, 50 99" />
                        <path class="roadmap-mobile-path-core"
                            d="M 50 0.5
                               C 16 3.5, 16 7.5, 50 11
                               C 84 14.5, 84 18.5, 50 22
                               C 16 25.5, 16 29.5, 50 33
                               C 84 36.5, 84 40.5, 50 44
                               C 16 47.5, 16 51.5, 50 55
                               C 84 58.5, 84 62.5, 50 66
                               C 16 69.5, 16 73.5, 50 77
                               C 84 80.5, 84 84.5, 50 88
                               C 16 91.5, 16 95.5, 50 99" />
                    </svg>

                    <div class="roadmap-mobile-steps">
                        @foreach ($milestones as $m)
                            @include('partials.landing.roadmap-milestone-card-mobile', ['m' => $m])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-[10px] md:text-[11px] text-slate-500 mt-8 max-w-lg mx-auto leading-relaxed">
            Fechas orientativas · el roadmap puede ajustarse según feedback de comercios WI-Store.
        </p>
    </div>
</section>
