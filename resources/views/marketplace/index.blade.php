<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @include('partials.seo.head', ['seo' => \App\Support\SeoMeta::forMarketplace()])

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.ux-styles')
    @include('partials.landing.motion-styles')
    @include('partials.marketplace.script')
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #ffffff;
            color: #1e293b;
            -webkit-tap-highlight-color: transparent;
        }
        [x-cloak] { display: none !important; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
        .marketplace-filter-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.05);
        }
        .marketplace-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
        }
        .marketplace-field:focus {
            outline: none;
            border-color: rgba(147, 51, 234, 0.45);
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
            background: #ffffff;
        }
        .marketplace-service-pill {
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
        .marketplace-service-pill:hover {
            border-color: #cbd5e1;
        }
        .marketplace-service-pill.is-active {
            border-color: rgba(147, 51, 234, 0.4);
            background: rgba(147, 51, 234, 0.08);
            color: #6b21a8;
        }
        .landing-category-pill {
            border-color: #e2e8f0;
            color: #64748b;
        }
        .landing-category-pill:hover {
            border-color: #cbd5e1;
            color: #475569;
        }
    </style>
</head>
@php
    $landingNavExternal = true;
    $shopsWithCategories = $shopsWithCategories ?? collect();
@endphp
<body class="min-h-screen pb-28 relative overflow-x-hidden selection:bg-purple-200 selection:text-slate-900"
      x-data="marketplacePage()" x-init="init()">

    @include('partials.landing.page-hero-background')

    @include('partials.landing.landing-header')

    @include('partials.landing.ux-chrome')

    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
            <div>
                <span class="landing-plan-badge landing-plan-badge--emprendedor text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-full">Marketplace</span>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mt-3 tracking-tight">Descubre tiendas en WI-Store</h1>
                <p class="text-sm text-slate-500 mt-2 max-w-xl">
                    Busca por nombre, filtra por categoría, zona o tipo de servicio y entra al menú digital.
                </p>
            </div>
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-purple-700 hover:text-cyan-700 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-[10px]" aria-hidden="true"></i> Volver a la landing
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 items-start">

            <aside class="marketplace-filter-panel lg:sticky lg:top-24 space-y-5 rounded-2xl p-5" aria-label="Filtros del marketplace">
                <div>
                    <label for="marketplace-search" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Buscar</label>
                    <div class="relative mt-2">
                        <input id="marketplace-search" type="search" x-model="searchQuery" placeholder="Nombre, zona, categoría..."
                            autocomplete="off"
                            class="marketplace-field w-full rounded-xl px-4 py-3 pl-10 text-sm">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm" aria-hidden="true"></i>
                    </div>
                </div>

                <div>
                    <p id="marketplace-filter-category" class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Categoría</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Todos' => '✨', 'Gastronomía' => '🍽️', 'Moda y Estilo' => '👗', 'Detalles y Regalos' => '🎁', 'Servicios' => '🔧', 'Otros' => '📦'] as $cat => $icon)
                            <button type="button" @click="setCategory('{{ $cat }}')"
                                :class="activeCategory === '{{ $cat }}' ? 'landing-category-pill is-active' : ''"
                                class="landing-category-pill text-[11px] font-bold px-3 py-1.5 rounded-full border transition-all">
                                {{ $icon }} {{ $cat === 'Todos' ? 'Todas' : $cat }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Zona</p>
                    <select x-model="activeZone" class="marketplace-field w-full rounded-xl px-3 py-2.5 text-sm">
                        <option value="Todas">Todas las zonas</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone }}">{{ $zone }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Servicio</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach (['Todos' => 'Todos', 'delivery' => 'Delivery', 'pickup' => 'Retiro', 'dine_in' => 'En local'] as $key => $label)
                            <button type="button" @click="setService('{{ $key }}')"
                                :class="activeService === '{{ $key }}' ? 'marketplace-service-pill is-active' : 'marketplace-service-pill'"
                                class="text-[11px] font-bold px-2 py-2 rounded-xl transition-all">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Ordenar</p>
                    <select x-model="sortBy" class="marketplace-field w-full rounded-xl px-3 py-2.5 text-sm">
                        <option value="recientes">Más recientes</option>
                        <option value="nombre">Nombre A–Z</option>
                        <option value="zona">Por zona</option>
                    </select>
                </div>

                <button type="button" x-show="isFiltering" x-cloak @click="clearFilters()"
                    class="w-full text-xs font-bold uppercase tracking-wide text-purple-700 hover:text-purple-900 py-2 rounded-xl border border-purple-200 bg-purple-50/80 hover:bg-purple-50 transition-colors">
                    Limpiar filtros
                </button>
            </aside>

            <section aria-labelledby="marketplace-results-heading">
                <h2 id="marketplace-results-heading" class="sr-only">Tiendas disponibles</h2>
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <p class="text-sm text-slate-500">
                        <span class="text-slate-900 font-black" x-text="filteredShops.length"></span>
                        de {{ $shopsCount }} tienda(s)
                        <span x-show="isFiltering" x-cloak class="text-purple-600"> · filtrado</span>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" x-show="filteredShops.length > 0">
                    <template x-for="shop in filteredShops" :key="shop.id">
                        <article class="landing-plan-card rounded-3xl overflow-hidden flex flex-col border border-slate-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="p-1.5 pb-0">
                                <div class="h-36 w-full overflow-hidden relative rounded-2xl bg-slate-100">
                                    <img :src="shop.cover_url || shop.logo_url" :alt="shop.name"
                                        class="w-full h-full object-cover" loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent"></div>
                                    <img :src="shop.logo_url" alt="" class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-white object-cover bg-white shadow-sm">
                                    <span class="absolute top-2 right-2 text-[9px] font-black uppercase tracking-wider bg-white/90 text-purple-800 px-2 py-1 rounded-full border border-purple-200/80" x-text="shop.category"></span>
                                    <span x-show="shop.plan === 'premium' || shop.plan === 'vip'" x-cloak
                                        class="absolute top-2 left-2 text-[9px] font-black uppercase bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full border border-amber-200">
                                        Negocio
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 flex flex-col flex-grow bg-white">
                                <h3 class="text-lg font-black text-slate-900 leading-tight line-clamp-1" x-text="shop.name"></h3>
                                <p class="text-[11px] text-cyan-700 font-semibold mt-1 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[10px] opacity-70" aria-hidden="true"></i>
                                    <span x-text="shop.zone"></span>
                                </p>
                                <p class="text-xs text-slate-500 mt-2 line-clamp-2 flex-grow" x-text="shop.description"></p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span x-show="shop.has_cashea" class="inline-flex items-center">
                                        <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-4 w-4 rounded-md object-contain">
                                    </span>
                                    <span x-show="shop.has_krece" class="inline-flex items-center">
                                        <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-4 w-4 rounded-md object-contain">
                                    </span>
                                    <span x-show="shop.has_delivery" class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">Delivery</span>
                                    <span x-show="shop.has_pickup" class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 border border-purple-200">Retiro</span>
                                    <span x-show="shop.has_dine_in" class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-md bg-cyan-50 text-cyan-700 border border-cyan-200">Local</span>
                                </div>
                                <a :href="shop.url"
                                    class="landing-plan-btn landing-plan-btn--negocio mt-4 block w-full text-center text-white font-extrabold py-2.5 rounded-xl text-xs">
                                    Ver menú
                                </a>
                            </div>
                        </article>
                    </template>
                </div>

                <div x-show="filteredShops.length === 0" x-cloak
                    class="text-center py-20 rounded-3xl border border-dashed border-slate-300 bg-white/80">
                    <p class="text-4xl mb-3" aria-hidden="true">🔍</p>
                    <p class="text-slate-900 font-black text-lg" role="status">No hay tiendas con esos filtros</p>
                    <p class="text-slate-500 text-sm mt-2 max-w-sm mx-auto">Prueba otra categoría, zona o borra la búsqueda.</p>
                    <button type="button" @click="clearFilters()"
                        class="mt-6 landing-plan-btn landing-plan-btn--negocio text-white font-black px-6 py-3 rounded-xl text-sm">
                        Ver todas las tiendas
                    </button>
                </div>
            </section>
        </div>
    </main>

    @include('partials.public.chat')
</body>
</html>
