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
    @include('partials.marketplace.script')
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0e1228; -webkit-tap-highlight-color: transparent; }
        [x-cloak] { display: none !important; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-gray-100 min-h-screen selection:bg-purple-500 selection:text-white pb-28" x-data="marketplacePage()">

    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[600px] h-[600px] rounded-full bg-purple-500/12 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-cyan-500/8 blur-[120px]"></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-white/10 bg-[#0e1228]/85 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-white font-black uppercase tracking-tight shrink-0">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span>
            </a>
            <nav class="hidden md:flex items-center gap-5 text-sm font-bold" aria-label="Navegación principal">
                <a href="{{ route('tiendas.index') }}" class="text-cyan-300">Marketplace</a>
                <a href="{{ route('home') }}#precios" class="text-slate-300 hover:text-white transition-colors">Precios</a>
                <a href="{{ route('contacto') }}" class="text-slate-300 hover:text-white transition-colors">Contacto</a>
            </nav>
            <a href="/register" class="shrink-0 landing-plan-btn text-white text-xs font-black px-4 py-2.5 rounded-xl">Crear tienda</a>
        </div>
    </header>

    <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
            <div>
                <span class="landing-plan-badge text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-full">Marketplace</span>
                <h1 class="text-3xl md:text-4xl font-black text-white mt-3 tracking-tight">Descubre tiendas en WI-Store</h1>
                <p class="text-sm text-slate-400 mt-2 max-w-xl">
                    Busca por nombre, filtra por categoría, zona o tipo de servicio y entra al menú digital.
                </p>
            </div>
            <a href="{{ route('home') }}#explorar"
                class="inline-flex items-center gap-2 text-xs font-bold text-purple-300/90 hover:text-cyan-300 transition-colors">
                <i class="fas fa-arrow-left text-[10px]"></i> Volver a la landing
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 items-start">

            <!-- Filtros -->
            <aside class="lg:sticky lg:top-24 space-y-5 rounded-2xl border border-white/10 bg-white/[0.03] backdrop-blur-md p-5" aria-label="Filtros del marketplace">
                <div>
                    <label for="marketplace-search" class="text-[10px] font-black uppercase tracking-widest text-slate-300">Buscar</label>
                    <div class="relative mt-2">
                        <input id="marketplace-search" type="search" x-model="searchQuery" placeholder="Nombre, zona, categoría..."
                            autocomplete="off"
                            class="w-full bg-[#0c1024] border border-white/10 rounded-xl px-4 py-3 pl-10 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-purple-500/40">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-sm" aria-hidden="true"></i>
                    </div>
                </div>

                <div>
                    <p id="marketplace-filter-category" class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-2">Categoría</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Todos' => '✨', 'Gastronomía' => '🍽️', 'Moda y Estilo' => '👗', 'Detalles y Regalos' => '🎁', 'Servicios' => '🔧', 'Otros' => '📦'] as $cat => $icon)
                            <button type="button" @click="setCategory('{{ $cat }}')"
                                :class="activeCategory === '{{ $cat }}' ? 'landing-category-pill is-active' : ''"
                                class="landing-category-pill text-[11px] font-bold px-3 py-1.5 rounded-full border border-slate-700 text-slate-400 transition-all">
                                {{ $icon }} {{ $cat === 'Todos' ? 'Todas' : $cat }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-2">Zona</p>
                    <select x-model="activeZone"
                        class="w-full bg-[#0c1024] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500/40">
                        <option value="Todas">Todas las zonas</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone }}">{{ $zone }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-2">Servicio</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach (['Todos' => 'Todos', 'delivery' => 'Delivery', 'pickup' => 'Retiro', 'dine_in' => 'En local'] as $key => $label)
                            <button type="button" @click="setService('{{ $key }}')"
                                :class="activeService === '{{ $key }}' ? 'border-purple-500/40 bg-purple-500/15 text-purple-200' : 'border-white/10 text-slate-400 hover:border-white/20'"
                                class="text-[11px] font-bold px-2 py-2 rounded-xl border transition-all">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-2">Ordenar</p>
                    <select x-model="sortBy"
                        class="w-full bg-[#0c1024] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500/40">
                        <option value="recientes">Más recientes</option>
                        <option value="nombre">Nombre A–Z</option>
                        <option value="zona">Por zona</option>
                    </select>
                </div>

                <button type="button" x-show="isFiltering" x-cloak @click="clearFilters()"
                    class="w-full text-xs font-bold uppercase tracking-wide text-purple-300/90 hover:text-white py-2 rounded-xl border border-white/10 hover:border-purple-500/30 transition-colors">
                    Limpiar filtros
                </button>
            </aside>

            <!-- Resultados -->
            <section aria-labelledby="marketplace-results-heading">
                <h2 id="marketplace-results-heading" class="sr-only">Tiendas disponibles</h2>
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <p class="text-sm text-slate-400">
                        <span class="text-white font-black" x-text="filteredShops.length"></span>
                        de {{ $shopsCount }} tienda(s)
                        <span x-show="isFiltering" x-cloak class="text-purple-300/80"> · filtrado</span>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" x-show="filteredShops.length > 0">
                    <template x-for="shop in filteredShops" :key="shop.id">
                        <article class="landing-plan-card rounded-3xl overflow-hidden flex flex-col hover:-translate-y-0.5 transition-transform duration-300">
                            <div class="p-1.5 pb-0">
                                <div class="h-36 w-full overflow-hidden relative rounded-2xl bg-slate-800">
                                    <img :src="shop.cover_url || shop.logo_url" :alt="shop.name"
                                        class="w-full h-full object-cover" loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-transparent to-transparent"></div>
                                    <img :src="shop.logo_url" alt="" class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 object-cover bg-white">
                                    <span class="absolute top-2 right-2 text-[9px] font-black uppercase tracking-wider bg-black/50 text-purple-200 px-2 py-1 rounded-full border border-purple-500/30 backdrop-blur-sm" x-text="shop.category"></span>
                                    <span x-show="shop.plan === 'premium' || shop.plan === 'vip'" x-cloak
                                        class="absolute top-2 left-2 text-[9px] font-black uppercase bg-amber-500/20 text-amber-200 px-2 py-0.5 rounded-full border border-amber-500/30">
                                        Premium
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-lg font-black text-white leading-tight line-clamp-1" x-text="shop.name"></h3>
                                <p class="text-[11px] text-cyan-300/80 font-semibold mt-1 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[10px] opacity-70"></i>
                                    <span x-text="shop.zone"></span>
                                </p>
                                <p class="text-xs text-slate-400 mt-2 line-clamp-2 flex-grow" x-text="shop.description"></p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span x-show="shop.has_cashea" class="inline-flex items-center">
                                        <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-4 w-4 rounded-md object-contain">
                                    </span>
                                    <span x-show="shop.has_krece" class="inline-flex items-center">
                                        <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-4 w-4 rounded-md object-contain">
                                    </span>
                                    <span x-show="shop.has_delivery" class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">Delivery</span>
                                    <span x-show="shop.has_pickup" class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-md bg-purple-500/10 text-purple-200 border border-purple-500/20">Retiro</span>
                                    <span x-show="shop.has_dine_in" class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-md bg-cyan-500/10 text-cyan-200 border border-cyan-500/20">Local</span>
                                </div>
                                <a :href="shop.url"
                                    class="landing-plan-btn mt-4 block w-full text-center text-white font-extrabold py-2.5 rounded-xl text-xs">
                                    Ver menú
                                </a>
                            </div>
                        </article>
                    </template>
                </div>

                <div x-show="filteredShops.length === 0" x-cloak
                    class="text-center py-20 rounded-3xl border border-dashed border-slate-700 bg-slate-900/30">
                    <p class="text-4xl mb-3">🔍</p>
                    <p class="text-white font-black text-lg" role="status">No hay tiendas con esos filtros</p>
                    <p class="text-slate-400 text-sm mt-2 max-w-sm mx-auto">Prueba otra categoría, zona o borra la búsqueda.</p>
                    <button type="button" @click="clearFilters()"
                        class="mt-6 landing-plan-btn text-white font-black px-6 py-3 rounded-xl text-sm">
                        Ver todas las tiendas
                    </button>
                </div>
            </section>
        </div>
    </main>

    @include('partials.public.chat')
</body>
</html>
