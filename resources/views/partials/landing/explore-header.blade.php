<div class="flex flex-col items-center justify-center mb-10 space-y-6">
    <div class="text-center w-full max-w-2xl">
        <span class="text-[10px] font-black uppercase tracking-widest text-purple-300 bg-purple-500/10 border border-purple-500/25 px-3 py-1 rounded-full">Tiendas reales</span>
        <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight mt-4">Explora menús de ejemplo</h2>
        <p class="text-sm md:text-base text-slate-400 mt-2 leading-relaxed">
            Busca por nombre o toca una categoría. Luego pulsa <strong class="text-white">Ver menú</strong> para entrar.
        </p>
    </div>

    <div class="w-full max-w-3xl space-y-4">
        <div class="relative">
            <input type="search" x-model="searchQuery"
                   placeholder="¿Qué tienda buscas? Ej: sabores, regalos..."
                   class="w-full bg-slate-900/90 border border-slate-700 rounded-2xl px-5 py-4 pl-12 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all shadow-inner">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
            <button type="button" x-show="searchQuery.trim() !== ''" @click="searchQuery = ''"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-xs font-bold px-2 py-1 rounded-lg bg-slate-800">
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
                        class="landing-category-pill shrink-0 text-xs font-bold px-4 py-2.5 rounded-full border border-slate-700 text-slate-400 transition-all flex items-center gap-1.5">
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
                <span class="text-purple-300 font-bold">{{ $shopsCount }}</span> tiendas activas
            </p>
            <p class="text-xs text-slate-500" x-show="isFiltering" x-cloak>
                <span class="text-cyan-300 font-bold" x-text="filteredCount"></span> resultado(s) encontrado(s)
            </p>
            <div class="flex gap-2" x-show="!isFiltering">
                <button type="button" @click="showCarousel = false"
                        :class="!showCarousel ? 'bg-purple-600/30 text-purple-200 border-purple-500/40' : 'bg-slate-900 text-slate-400 border-slate-700'"
                        class="text-[11px] font-bold px-3 py-1.5 rounded-full border transition-all">
                    <i class="fas fa-th-large mr-1"></i> Cuadrícula
                </button>
                <button type="button" @click="showCarousel = true"
                        :class="showCarousel ? 'bg-purple-600/30 text-purple-200 border-purple-500/40' : 'bg-slate-900 text-slate-400 border-slate-700'"
                        class="text-[11px] font-bold px-3 py-1.5 rounded-full border transition-all">
                    <i class="fas fa-play mr-1"></i> En movimiento
                </button>
            </div>
        </div>
    </div>
</div>
