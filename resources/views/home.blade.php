<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @include('partials.seo.head', ['seo' => \App\Support\SeoMeta::forLanding()])

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.motion-styles')

    {{-- Estilos below-the-fold (ondas SVG, planes premium). No bloquean LCP del hero. --}}
    <style>
        .blur-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: filter;
        }

        @keyframes premium-glow {

            0%,
            100% {
                box-shadow: 0 0 12px rgba(251, 191, 36, 0.5), 0 0 25px rgba(251, 191, 36, 0.25), inset 0 0 10px rgba(251, 191, 36, 0.3);
                border-color: #FBBF24;
            }

            50% {
                box-shadow: 0 0 25px rgba(251, 191, 36, 0.9), 0 0 50px rgba(251, 191, 36, 0.5), inset 0 0 20px rgba(251, 191, 36, 0.6);
                border-color: #F59E0B;
            }
        }

        @keyframes float-crown {

            0%,
            100% {
                transform: translate(-50%, 0) rotate(0deg);
                filter: drop-shadow(0 4px 6px rgba(251, 191, 36, 0.7));
            }

            50% {
                transform: translate(-50%, -6px) rotate(2deg);
                filter: drop-shadow(0 10px 15px rgba(251, 191, 36, 0.95));
            }
        }

        .premium-border-glow {
            animation: premium-glow 3s infinite ease-in-out !important;
            border-color: #FBBF24 !important;
        }

        .float-crown-animation {
            animation: float-crown 3s infinite ease-in-out;
        }

        .text-gold-gradient {
            background: linear-gradient(135deg, #FFE885 0%, #F5B041 40%, #F39C12 70%, #D4AC0D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* Máscara de transparencia gradual para los extremos del carrusel de tiendas */
        .mask-marquee {
            mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, white 15%, white 85%, transparent);
        }
    </style>
    @include('partials.landing.ux-styles')
</head>

<body class="bg-white text-slate-800 min-h-screen pb-8 md:pb-0 selection:bg-brand-500 selection:text-white relative"
    x-data="landingPage()" x-init="init()">

    @include('partials.landing.ambient-background')

    @include('partials.landing.landing-header')

    @include('partials.landing.ux-chrome')

    @include('partials.landing.hero')

    @include('partials.landing.why-wistore')

    {{-- SECCIÓN EXPLORADOR DE TIENDAS / Tiendas reales (oculta temporalmente)
    @php
        $shopsCount = $shopsWithCategories->count();
        $carouselShops = $featuredCarouselShops ?? collect();
        $carouselCount = $carouselShops->count();
        $padMarqueeRow = static function (\Illuminate\Support\Collection $row, int $min = 8): \Illuminate\Support\Collection {
            $row = $row->values();
            if ($row->isEmpty()) {
                return $row;
            }
            $expanded = collect();
            while ($expanded->count() < $min) {
                $expanded = $expanded->concat($row);
            }
            return $expanded;
        };
        $row1Source = $carouselShops->take(5)->values();
        $row2Source = $carouselShops->slice(5, 5)->values();
        if ($row2Source->isEmpty() && $row1Source->isNotEmpty()) {
            $row2Source = $row1Source->reverse()->values();
        }
        $row1 = $padMarqueeRow($row1Source);
        $row2 = $padMarqueeRow($row2Source);
    @endphp

    <section id="explorar" class="py-16 md:py-24 relative overflow-hidden z-10">
        <div class="landing-section-glow top-8 right-0 w-[28rem] h-[28rem] bg-purple-400/10" aria-hidden="true"></div>
        <div class="landing-section-glow bottom-0 left-[-5%] w-80 h-80 bg-cyan-400/9" aria-hidden="true"></div>

        <div class="landing-container relative z-10">

            @include('partials.landing.explore-header')

            <!-- Vista cuadrícula (predeterminada) -->
            <div x-show="!isFiltering && !showCarousel" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @forelse($shopsWithCategories as $shop)
                    @include('partials.landing.shop-card', ['shop' => $shop])
                @empty
                    <div class="col-span-full text-center py-16 rounded-[2rem] border border-dashed border-slate-300 bg-slate-50">
                        <p class="text-4xl mb-3">🏪</p>
                        <p class="text-slate-900 font-bold">Pronto verás tiendas de ejemplo aquí</p>
                        <p class="text-slate-500 text-sm mt-2">Mientras tanto, crea la tuya en minutos.</p>
                        <a href="/register" class="inline-block mt-6 bg-purple-600 hover:bg-purple-500 text-white font-black px-6 py-3 rounded-xl text-sm">Crear mi tienda</a>
                    </div>
                @endforelse
            </div>

            <!-- MODO ANIMADO (MARQUEE 2 FILAS) -->
            <div x-show="!isFiltering && showCarousel" class="space-y-6" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100">

                @if ($carouselCount === 0)
                    <div class="text-center py-14 rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 px-6">
                        <p class="text-3xl mb-2">👑</p>
                        <p class="text-slate-900 font-bold">Top tiendas Negocio</p>
                        <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto">Pronto verás aquí las tiendas del plan Negocio mejor valoradas por sus clientes.</p>
                    </div>
                @else
                <p class="text-center text-[11px] text-slate-500 font-semibold mb-1">
                    <span class="text-amber-600 font-black">{{ $carouselCount }}</span> tiendas Negocio · mejor calificación y opiniones
                </p>
                <!-- Fila 1: ciclo infinito → -->
                <div class="overflow-hidden w-full relative py-2 mask-marquee">
                    <div class="landing-marquee-track landing-marquee-track--left gap-6">
                        @foreach ($row1 as $shop)
                            @include('partials.landing.shop-carousel-card', ['shop' => $shop])
                        @endforeach
                        @foreach ($row1 as $shop)
                            @include('partials.landing.shop-carousel-card', ['shop' => $shop, 'ariaHidden' => true])
                        @endforeach
                    </div>
                </div>

                @if ($row2->isNotEmpty())
                <!-- Fila 2: ciclo infinito ← -->
                <div class="overflow-hidden w-full relative py-2 mask-marquee">
                    <div class="landing-marquee-track landing-marquee-track--right gap-6">
                        @foreach ($row2 as $shop)
                            @include('partials.landing.shop-carousel-card', ['shop' => $shop])
                        @endforeach
                        @foreach ($row2 as $shop)
                            @include('partials.landing.shop-carousel-card', ['shop' => $shop, 'ariaHidden' => true])
                        @endforeach
                    </div>
                </div>
                @endif
                @endif
            </div>

            <!-- MODO FILTRADO (ESTÁTICO EN RECIPIENTE GRID) -->
            <div x-show="isFiltering" class="py-6" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100" style="display: none;">

                <!-- Mensaje de No Resultados -->
                <div x-show="!hasResults"
                    class="w-full text-center py-20 bg-slate-50 border border-slate-200 rounded-[2rem] px-6 max-w-lg mx-auto"
                    x-transition>
                    <div
                        class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-purple-200 shadow-sm">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <h3 class="text-slate-900 font-extrabold text-lg">No se encontraron tiendas</h3>
                    <p class="text-slate-500 text-xs mt-2 leading-relaxed">No encontramos catálogos oficiales que
                        coincidan con "<span class="text-purple-600 font-bold" x-text="searchQuery"></span>" o con la
                        categoría seleccionada.</p>
                    <button type="button" @click="clearFilters()"
                        class="mt-6 bg-purple-600 hover:bg-purple-500 text-white font-extrabold px-6 py-2.5 rounded-full text-xs transition active:scale-95 shadow-[0_0_15px_rgba(147,51,234,0.3)]">
                        Restablecer filtros
                    </button>
                </div>

                <div x-show="hasResults" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($shopsWithCategories as $shop)
                        <div x-show="matchesFilter('{{ addslashes($shop->name) }}', '{{ addslashes($shop->description) }}', '{{ addslashes($shop->category) }}')"
                            class="w-full landing-shop-card rounded-[1.5rem] overflow-hidden flex flex-col justify-between group/card">
                            <div class="p-1.5 pb-0">
                                <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                    @if ($shop->cover_path)
                                        <img src="{{ $shop->coverUrl() }}"
                                            alt="{{ $shop->name }}"
                                            width="400"
                                            height="128"
                                            loading="lazy"
                                            decoding="async"
                                            class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700">
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">
                                            WI-STORE</div>
                                    @endif
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent">
                                    </div>

                                    <div
                                        class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                        <img src="{{ $shop->logoUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($shop->name) . '&background=a855f7&color=fff' }}"
                                            alt="Logo de {{ $shop->name }}"
                                            width="48"
                                            height="48"
                                            loading="lazy"
                                            decoding="async"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="text-base font-black text-slate-900 leading-tight line-clamp-1">
                                            {{ $shop->name }}</h3>
                                        <div class="flex items-center gap-0.5 shrink-0 pt-0.5">
                                            @for ($star = 1; $star <= 5; $star++)
                                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        {{ $shop->description ?: 'Catálogo oficial de marca blanca en WI-Store.' }}</p>
                                </div>

                                <div class="mt-4">
                                    <a href="/{{ $shop->slug }}"
                                        class="block w-full text-center bg-slate-100 hover:bg-gradient-to-r hover:from-purple-600 hover:to-cyan-500 hover:text-white text-slate-700 font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm border border-slate-200 hover:border-transparent">
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
    --}}

    @include('partials.landing.how-it-works')

    <!-- PRECIOS -->
    <section id="precios" class="landing-dark-zone py-12 md:py-16 relative overflow-hidden"
        :class="openModal ? 'z-50' : 'z-10'" x-data="{
            openModal: false,
            selectedPlan: null,
            billingPeriod: 'monthly'
        }">

        <div class="landing-container relative z-10">

            <!-- Cabecera de Precios -->
            <div class="text-center mb-4 md:mb-5">
                <span
                    class="landing-plan-badge text-[9px] uppercase font-black tracking-widest px-3 py-1 rounded-full">
                    Planes
                </span>
                <h2 class="text-2xl md:text-3xl font-black text-white mt-2 tracking-tight">Planes para escalar tu gestión</h2>
                <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto leading-snug">
                    <strong class="text-slate-200">Emprendedor</strong> para ordenar tu operación · <strong class="text-slate-200">Negocio</strong> con panel completo y módulos avanzados.
                </p>
            </div>

            @include('partials.landing.pricing-billing-toggle')

            <div class="landing-pricing-grid max-w-4xl mx-auto">

                @include('partials.landing.pricing-cards')

            </div>

            @include('partials.landing.bcv-rate-badge', [
                'compact' => true,
                'class' => 'landing-bcv-in-dark mt-8 md:mt-10',
            ])

            <div class="mt-6 md:mt-8 text-center">
                <a href="{{ route('planes.comparativa') }}"
                    class="inline-flex items-center gap-2 landing-plan-btn text-white font-extrabold px-6 py-3 rounded-xl text-xs uppercase tracking-wide transition-all hover:brightness-110">
                    Ver más detalle de los planes
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

                <!-- PLAN 4: Plan Custom / Personalizado -->
                <div id="plan-custom"
                    class="hidden bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-3xl p-6 flex flex-col justify-between shadow-2xl relative transition duration-300 hover:-translate-y-2 hover:border-white/20 group">
                    <div>
                        <h3 class="text-lg font-black text-white uppercase tracking-wider">Plan <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-400">Custom</span>
                        </h3>
                        <div
                            class="mt-3 inline-flex items-center gap-2 rounded-full border border-pink-500/20 bg-pink-500/10 px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-pink-200 shadow-[0_0_15px_rgba(236,72,153,0.12)]">
                            <span class="text-[11px]">🏦</span>
                            <span>Tasa BCV</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-3 leading-relaxed">Desarrollo a medida, integración de
                            dominios y bases de datos dedicadas.</p>

                        <!-- Precio -->
                        <div class="my-6">
                            <div class="text-2xl font-black text-white tracking-tight">A Medida</div>
                            <span class="text-[9px] text-slate-450 block mt-2 font-semibold">Cotización bajo
                                requerimientos</span>
                        </div>

                        <!-- Beneficios -->
                        <ul
                            class="space-y-3.5 text-[11px] text-slate-300 border-t border-white/10 pt-5 leading-relaxed">
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                <span>Código independiente exclusivo y BD dedicada.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                <span>Módulos de Clientes y Empleados (Roles/CRM).</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                <span>Integración con dominios web propios (`.com`).</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="text-pink-400 shrink-0 mt-0.5 w-3.5 h-3.5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                <span>Ingeniería de software a la medida.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <div class="mt-8 flex flex-col gap-2.5">
                        <a href="https://wa.me/584121305420?text=Hola,%20deseo%20una%2520asesoría%20sobre%20el%20Plan%20Custom%20de%20WI-Store"
                            target="_blank"
                            class="block w-full text-center bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white font-extrabold py-3 rounded-xl transition-all duration-300 text-xs shadow-sm shadow-pink-500/30">
                            Cotizar Proyecto
                        </a>
                        <button @click="selectedPlan = 'custom'; openModal = true"
                            class="mt-1 text-center text-pink-300 hover:text-pink-200 font-bold text-[9px] uppercase tracking-wide flex items-center justify-center gap-1 transition-colors focus:outline-none">
                            Detalles Técnicos <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>

            <!-- MODAL DETALLES DEL PLAN (Alpine.js) -->
            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-6" x-cloak>
                <!-- Backdrop con Blur -->
                <div x-show="openModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="openModal = false"
                    class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"></div>

                <!-- Contenedor del Modal -->
                <div x-show="openModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                    class="bg-white border border-slate-200 rounded-[2rem] w-full max-w-2xl max-h-[85vh] overflow-y-auto relative z-10 shadow-2xl shadow-purple-500/10 scrollbar-thin">

                    <!-- Botón de Cerrar -->
                    <button @click="openModal = false"
                        class="absolute top-6 right-6 w-8 h-8 rounded-full bg-slate-100 border border-slate-200 hover:border-rose-300 hover:bg-rose-50 flex items-center justify-center text-slate-500 hover:text-rose-600 transition-colors focus:outline-none z-20">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                    <p class="absolute top-7 left-6 md:left-10 text-[10px] font-black uppercase tracking-widest text-purple-600/80 z-20 pointer-events-none"
                        x-show="selectedPlan">Detalle del plan</p>

                    <!-- CONTENIDO PRUEBA GRATIS -->
                    <div x-show="selectedPlan === 'free_trial'" class="p-6 md:p-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 rounded-2xl bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-slate-900 uppercase">Prueba <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Gratis</span>
                                </h3>
                                <p class="text-xs text-indigo-600 font-bold uppercase tracking-wider">Plan Inicial • {{ $wiStoreTrialDays }}
                                    Días de Prueba</p>
                            </div>
                        </div>

                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                            Activa tu gestión digital sin costo: centraliza pedidos, organiza tu inventario y prueba el
                            panel administrativo con venta integrada por WhatsApp durante {{ $wiStoreTrialDays }} días.
                        </p>

                        <div class="border-t border-slate-200 pt-6 space-y-4">
                            <h4 class="text-xs uppercase font-black text-slate-800 tracking-wider">¿Qué incluye este
                                plan?</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600">
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-600 mt-0.5"></i>
                                    <span>Enlace único corto (wi-store.com/tu-marca)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-600 mt-0.5"></i>
                                    <span>{{ \App\Support\PlanCatalog::formatLimit($wiStoreTrialLimits['max_products'] ?? null, 'producto', 'productos') }} en tu inventario</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-600 mt-0.5"></i>
                                    <span>Pedidos ilimitados estructurados a WhatsApp</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-indigo-600 mt-0.5"></i>
                                    <span>Personalización de marca básica</span>
                                </li>
                            </ul>
                        </div>

                        <div
                            class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex items-center justify-between gap-4 mt-6">
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">{{ $wiStoreTrialDisclaimer }}</p>
                                <p class="text-lg font-black text-slate-900">$0.00 USD / {{ $wiStoreTrialDays }} días</p>
                            </div>
                            <a href="/register"
                                class="bg-indigo-600 hover:bg-indigo-500 text-white font-black px-6 py-3 rounded-xl text-xs transition-colors shadow-lg">
                                Probar Gratis
                            </a>
                        </div>
                    </div>

                    <!-- CONTENIDO PLAN STANDARD / EMPRENDEDOR -->
                    @include('partials.planes.plan-modal-body', ['planKey' => 'standard'])

                    <!-- CONTENIDO PLAN PREMIUM / NEGOCIO -->
                    @include('partials.planes.plan-modal-body', ['planKey' => 'premium'])

                    <!-- CONTENIDO PLAN CUSTOM -->
                    <div x-show="selectedPlan === 'custom'" class="p-6 md:p-10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 rounded-2xl bg-pink-100 border border-pink-200 flex items-center justify-center text-pink-600">
                                <i class="fas fa-cogs text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl md:text-2xl font-black text-slate-900 uppercase">Plan <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-500">Custom</span>
                                </h3>
                                <p class="text-xs text-pink-600 font-bold uppercase tracking-wider">Desarrollo a Medida
                                    e Infraestructura dedicada</p>
                            </div>
                        </div>

                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                            Pensado para corporaciones, franquicias consolidadas y marcas que necesitan un desarrollo
                            tecnológico robusto, bases de datos aisladas MySQL para el máximo rendimiento y control de
                            datos, y módulos avanzados a la medida del negocio.
                        </p>

                        <div class="border-t border-slate-200 pt-6 space-y-4">
                            <h4 class="text-xs uppercase font-black text-slate-800 tracking-wider">¿Qué incluye este
                                plan?</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600">
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-600 mt-0.5"></i>
                                    <span>Código independiente exclusivo y BD dedicada</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-600 mt-0.5"></i>
                                    <span>Módulo de Clientes y Empleados (roles y CRM)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-600 mt-0.5"></i>
                                    <span>Integración con dominios web propios (`.com`)</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <i class="fas fa-check text-pink-600 mt-0.5"></i>
                                    <span>Ingeniería de software a medida y soporte de infraestructura</span>
                                </li>
                            </ul>
                        </div>

                        <div
                            class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex items-center justify-between gap-4 mt-6">
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">Presupuesto adaptado a requerimientos
                                </p>
                                <p class="text-lg font-black text-slate-900">Precio a convenir</p>
                            </div>
                            <a href="https://wa.me/584121305420?text=Hola!%20Deseo%20cotizar%20el%20plan%20Custom%20de%20WI-Store%20para%20mi%20negocio"
                                target="_blank"
                                class="bg-pink-600 hover:bg-pink-500 text-white font-black px-6 py-3 rounded-xl text-xs transition-colors shadow-lg">
                                Cotizar por WhatsApp
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('partials.landing.faq')

    {{-- Roadmap oculto temporalmente — descomentar para publicar: @include('partials.landing.roadmap-2026') --}}

    <!-- VS COMPETENCIA (WI-Store vs El Resto) -->
    <section id="vs-competencia" class="hidden py-20 md:py-28 border-t border-white/5 relative overflow-hidden z-10">

        <!-- Orbe de luz de fondo -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-500/5 rounded-full blur-[150px] pointer-events-none blur-accelerated">
        </div>

        <div class="landing-container relative z-10">

            <!-- Cabecera de Competencia -->
            <div class="text-center mb-16 md:mb-20">
                <span
                    class="bg-rose-600/20 text-rose-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-rose-500/30 shadow-[0_0_15px_rgba(244,63,94,0.2)]">
                    La Diferencia WI-Store
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">WI-Store vs La Competencia
                </h2>
                <p class="text-sm md:text-base text-slate-400 mt-3 max-w-2xl mx-auto leading-relaxed">No pagues por
                    funciones limitadas en plataformas extranjeras. Descubre por qué somos la opción más inteligente y
                    rentable para tu negocio en Venezuela.</p>
            </div>

            <!-- Grid de Comparativas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-stretch justify-center">

                <!-- COMPARATIVA 1: Ventajas Clave de Nuestra Solución -->
                <div
                    class="bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl relative transition duration-300 hover:border-white/20">
                    <div class="p-6 md:p-8 bg-gradient-to-b from-cyan-900/20 to-transparent border-b border-white/5">
                        <h3 class="text-xl font-black text-white text-center">
                            Ventajas Clave de Nuestra Solución
                        </h3>
                        <p class="text-sm text-slate-400 text-center mt-3 max-w-xl mx-auto leading-relaxed">
                            Experiencia de Usuario Superior, diseño de nivel internacional, soporte humano y
                            escalabilidad para que tu negocio crezca sin cambiar de plataforma.
                        </p>
                    </div>

                    <div class="p-6 md:p-8 space-y-6">
                        <div
                            class="rounded-3xl bg-white/5 border border-cyan-500/20 p-5 shadow-[0_0_20px_rgba(14,165,233,0.12)]">
                            <h4 class="text-sm font-black text-white uppercase tracking-[0.24em] mb-3">Experiencia de
                                Usuario Superior (PWA)</h4>
                            <p class="text-slate-300 text-sm leading-relaxed">Al no requerir una instalación
                                tradicional desde tiendas de aplicaciones, se elimina la fricción para el usuario final.
                                El cliente solo escanea, añade a su pantalla de inicio si lo desea, y compra al instante
                                con una velocidad de carga brutal.</p>
                        </div>

                        <div
                            class="rounded-3xl bg-white/5 border border-cyan-500/20 p-5 shadow-[0_0_20px_rgba(14,165,233,0.12)]">
                            <h4 class="text-sm font-black text-white uppercase tracking-[0.24em] mb-3">Estética que
                                Eleva la Marca</h4>
                            <p class="text-slate-300 text-sm leading-relaxed">No es solo una vitrina de venta: es una
                                plataforma de nivel internacional que eleva la imagen de tu operación, ya seas PYME o
                                empresa consolidada.</p>
                        </div>

                        <div
                            class="rounded-3xl bg-white/5 border border-cyan-500/20 p-5 shadow-[0_0_20px_rgba(14,165,233,0.12)]">
                            <h4 class="text-sm font-black text-white uppercase tracking-[0.24em] mb-3">Soporte Humano y
                                Adaptabilidad</h4>
                            <p class="text-slate-300 text-sm leading-relaxed">Frente a la rigidez de las plataformas
                                masivas, ofrecemos un acompañamiento real con soporte VIP dedicado y la flexibilidad de
                                moldear los planes y costos según las necesidades técnicas operativas de cada cliente.
                            </p>
                        </div>

                        <div
                            class="rounded-3xl bg-white/5 border border-cyan-500/20 p-5 shadow-[0_0_20px_rgba(14,165,233,0.12)]">
                            <h4 class="text-sm font-black text-white uppercase tracking-[0.24em] mb-3">Preparado para
                                el Crecimiento</h4>
                            <p class="text-slate-300 text-sm leading-relaxed">Con el Plan Custom y la ingeniería a la
                                medida, el cliente no tiene que cambiar de plataforma cuando su negocio crezca; nuestro
                                ecosistema escala con él, ofreciéndole bases de datos dedicadas y herramientas de
                                gestión avanzada.</p>
                        </div>
                    </div>
                </div>

                <!-- COMPARATIVA 2: Plan Negocio vs PideFacil -->
                <div
                    class="bg-[#0d1127]/60 backdrop-blur-md border border-purple-500/20 rounded-[2rem] overflow-hidden shadow-[0_0_30px_rgba(168,85,247,0.15)] relative transition duration-300 hover:border-purple-500/40">
                    <!-- Destello -->
                    <div
                        class="absolute -top-10 -right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl pointer-events-none">
                    </div>

                    <div
                        class="p-6 md:p-8 bg-gradient-to-b from-purple-900/20 to-transparent border-b border-white/5 relative z-10">
                        <h3 class="text-xl font-black text-white text-center flex items-center justify-center gap-3">
                            <span class="uppercase">Plan <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Negocio</span></span>
                            <span class="text-slate-500 text-sm">vs</span>
                            <span class="text-slate-300">PideFacil</span>
                        </h3>
                    </div>

                    <div class="p-0 relative z-10">
                        <table class="w-full text-left border-collapse text-xs md:text-sm">
                            <thead>
                                <tr>
                                    <th
                                        class="p-4 border-b border-white/5 w-1/3 text-slate-400 font-semibold bg-white/[0.02]">
                                        Característica</th>
                                    <th
                                        class="p-4 border-b border-white/5 w-1/3 text-center font-black text-purple-400 bg-purple-900/10">
                                        Plan Negocio</th>
                                    <th
                                        class="p-4 border-b border-white/5 w-1/3 text-center text-slate-400 font-semibold bg-white/[0.02]">
                                        PideFacil</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-300">
                                <tr>
                                    <td class="p-4 font-medium">Comisiones por Venta</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            0% Comisiones
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            2% - 5% por transacción
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Precio Mensual</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            {{ $wiStorePostTrialMonthly }} / mes
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-xs font-bold">—</span>
                                            Desde $35 / mes
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Límite de Productos</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Ilimitado
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            Limitado por Plan
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Enlace Biográfico</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Incluye Plan Emprendedor
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
                                            No incluye
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-medium">Experiencia / Interfaz</td>
                                    <td class="p-4 text-center bg-purple-900/10">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-slate-200 justify-center font-bold">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black">✓</span>
                                            Híbrida y Rápida
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-400 justify-center">
                                            <span
                                                class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-800 text-slate-500 text-[10px] font-black">—</span>
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

    @include('partials.landing.final-cta')

    <!-- FOOTER -->
    <footer class="landing-dark-zone landing-footer relative z-10 mt-8 md:mt-10 pt-8 pb-10 overflow-x-clip" aria-labelledby="footer-heading">
        <div class="landing-container">
            <h2 id="footer-heading" class="sr-only">Información y enlaces de WI-Store</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-16">
                <!-- Columna 1: Brand & Bio -->
                <div class="col-span-1 md:col-span-1 space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-black text-white tracking-wider uppercase">WI<span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        Plataforma SaaS de gestión comercial para PYMES en Venezuela. Centraliza pedidos, clientes e
                        inventario en un panel administrativo con venta integrada por WhatsApp o Telegram, sin comisiones
                        por venta.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="javascript:void(0)"
                            class="w-9 h-9 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 hover:border-purple-400/40 flex items-center justify-center text-slate-400 hover:text-cyan-400 transition-all duration-300"
                            title="Facebook">
                            <i class="fab fa-facebook-f text-xs"></i>
                        </a>
                        <a href="javascript:void(0)"
                            class="w-9 h-9 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 hover:border-purple-400/40 flex items-center justify-center text-slate-400 hover:text-cyan-400 transition-all duration-300"
                            title="Instagram">
                            <i class="fab fa-instagram text-xs"></i>
                        </a>
                        <a href="javascript:void(0)"
                            class="w-9 h-9 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 hover:border-purple-400/40 flex items-center justify-center text-slate-400 hover:text-cyan-400 transition-all duration-300"
                            title="TikTok">
                            <i class="fab fa-tiktok text-xs"></i>
                        </a>
                        <a href="javascript:void(0)"
                            class="w-9 h-9 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 hover:border-purple-400/40 flex items-center justify-center text-slate-400 hover:text-cyan-400 transition-all duration-300"
                            title="YouTube">
                            <i class="fab fa-youtube text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Columna 2: Ecosistema -->
                <div class="space-y-4">
                    <h3 class="text-xs uppercase font-black tracking-widest text-white">Ecosistema</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('tiendas.index') }}" class="text-slate-400 hover:text-cyan-400 transition-colors">Marketplace de tiendas</a></li>
                        {{-- <li><a href="#explorar" class="text-slate-400 hover:text-cyan-400 transition-colors">Vista previa</a></li> --}}
                        <li><a href="#como-funciona"
                                class="text-slate-400 hover:text-cyan-400 transition-colors">¿Cómo funciona?</a></li>
                        <li><a href="#precios" class="text-slate-400 hover:text-cyan-400 transition-colors">Planes de
                                Precios</a></li>
                        <li><a href="{{ route('planes.comparativa') }}"
                                class="text-slate-400 hover:text-cyan-400 transition-colors">Comparativa de Planes</a>
                        </li>
                    </ul>
                </div>

                <!-- Columna 3: Administración -->
                <div class="space-y-4">
                    <h3 class="text-xs uppercase font-black tracking-widest text-white">Administración</h3>
                    <div class="pt-1">
                        <a href="/login"
                            class="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white/15 text-purple-300 font-extrabold px-3.5 py-2 rounded-xl border border-purple-400/30 hover:border-cyan-400/40 transition-all duration-300 text-[10px] uppercase tracking-wider">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </div>
                </div>

                <!-- Columna 4: Contacto directo -->
                <div class="space-y-4">
                    <h3 class="text-xs uppercase font-black tracking-widest text-white">Contacto directo</h3>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-envelope text-cyan-400 w-4 shrink-0"></i>
                            @include('partials.global.support-email', ['class' => 'text-xs text-slate-400 hover:text-cyan-400 transition-colors break-all', 'icon' => false])
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
            <div
                class="border-t border-white/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>© 2026 WI-Store. Todos los derechos reservados.</p>
                <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
                    <a href="mailto:{{ $wiStoreSupportEmail }}" class="hover:text-cyan-400 transition-colors">{{ $wiStoreSupportEmail }}</a>
                    <span class="hidden sm:inline text-slate-600">•</span>
                    <a href="{{ route('legal.privacidad') }}" class="hover:text-slate-200 transition-colors">Políticas y Privacidad</a>
                    <span class="text-slate-600">•</span>
                    <a href="{{ route('contacto') }}" class="hover:text-slate-200 transition-colors">Contacto</a>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.landing.back-to-top')
    @include('partials.landing.ux-script')
    @include('partials.public.chat')
</body>

</html>
