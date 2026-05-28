<div class="flex flex-col items-center justify-center mb-10 space-y-6">
    <div class="text-center w-full max-w-2xl">
        <span class="text-[10px] font-black uppercase tracking-widest text-purple-700 bg-purple-50 border border-purple-200 px-3 py-1 rounded-full">Tiendas reales</span>
        <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-4">Explora menús de ejemplo</h2>
        <p class="text-sm md:text-base text-slate-600 mt-2 leading-relaxed">
            Busca por nombre o toca una categoría. Luego pulsa <strong class="text-slate-900">Ver menú</strong> para entrar.
        </p>
    </div>

    <div class="w-full max-w-3xl space-y-4">
        <div class="relative">
            <label for="landing-shop-search" class="sr-only">Buscar tienda por nombre</label>
            <input id="landing-shop-search" type="search" x-model="searchQuery"
                   placeholder="¿Qué tienda buscas? Ej: sabores, regalos..."
                   autocomplete="off"
                   class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 pl-12 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-500/15 transition-all shadow-sm">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" aria-hidden="true"></i>
            <button type="button" x-show="searchQuery.trim() !== ''" @click="searchQuery = ''"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 text-xs font-bold px-2 py-1 rounded-lg bg-slate-100">
                Borrar
            </button>
        </div>

        <div class="flex gap-2 overflow-x-auto flex-nowrap scrollbar-none py-1 justify-start md:justify-center">
            @php
                $categoryFilters = [
                    'Todos' => ['icon' => '✨', 'label' => 'Todas'],
                    'Gastronomía' => ['icon' => '🍽️', 'label' => 'Comida'],
                    'Moda y Estilo' => ['icon' => '👗', 'label' => 'Moda'],
                    'Detalles y Regalos' => ['icon' => '🎁', 'label' => 'Regalos'],
                    'Servicios' => ['icon' => '🔧', 'label' => 'Servicios'],
                    'Otros' => ['icon' => '📦', 'label' => 'Otros'],
                ];
            @endphp
            @foreach ($categoryFilters as $cat => $meta)
                <button type="button" @click="setCategory('{{ $cat }}')"
                        :class="activeCategory === '{{ $cat }}' ? 'landing-category-pill is-active' : ''"
                        class="landing-category-pill shrink-0 text-xs font-bold px-4 py-2.5 rounded-full border border-slate-200 text-slate-600 bg-white transition-all flex items-center gap-1.5 shadow-sm">
                    <span>{{ $meta['icon'] }}</span>
                    <span>{{ $meta['label'] }}</span>
                </button>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
            <a :href="marketplaceUrl" href="{{ route('tiendas.index') }}"
               class="inline-flex items-center gap-2 landing-plan-btn text-white text-xs font-black px-5 py-2.5 rounded-xl shadow-lg">
                <i class="fas fa-th-large text-[10px]"></i>
                Ver marketplace completo
            </a>
            <p class="text-xs text-slate-500" x-show="!isFiltering">
                <span class="text-purple-600 font-bold">{{ $shopsCount }}</span> tiendas activas
            </p>
            <p class="text-xs text-slate-500" x-show="isFiltering" x-cloak>
                <span class="text-cyan-600 font-bold" x-text="filteredCount"></span> resultado(s) encontrado(s)
            </p>
            <div class="flex gap-2" x-show="!isFiltering">
                <button type="button" @click="showCarousel = false"
                        :class="!showCarousel ? 'bg-purple-100 text-purple-700 border-purple-300' : 'bg-white text-slate-600 border-slate-200'"
                        class="text-[11px] font-bold px-3 py-1.5 rounded-full border transition-all">
                    <i class="fas fa-th-large mr-1"></i> Cuadrícula
                </button>
                <button type="button" @click="showCarousel = true"
                        :class="showCarousel ? 'bg-purple-100 text-purple-700 border-purple-300' : 'bg-white text-slate-600 border-slate-200'"
                        class="text-[11px] font-bold px-3 py-1.5 rounded-full border transition-all">
                    <i class="fas fa-play mr-1"></i> En movimiento
                </button>
            </div>
        </div>
    </div>
</div>
