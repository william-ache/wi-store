@if($testimonials->isNotEmpty())
@include('partials.landing.testimonials-carousel-script')
<section id="testimonios" class="py-14 md:py-20 mt-10 md:mt-14 relative z-10 overflow-hidden bg-white/45 backdrop-blur-[2px]"
    x-data="landingTestimonialsCarousel({{ \Illuminate\Support\Js::from($testimonials) }})">
    <div class="landing-section-glow top-0 right-[15%] w-80 h-80 bg-amber-400/12" aria-hidden="true"></div>
    <div class="landing-section-glow bottom-0 left-[10%] w-[24rem] h-[24rem] bg-purple-400/16" aria-hidden="true"></div>
    <div class="landing-container relative z-10">
        <div class="text-center mb-8 md:mb-10">
            <span class="text-[10px] font-black uppercase tracking-widest text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full">
                Comercios reales
            </span>
            <h2 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight mt-3">Lo que dicen quienes usan WI-Store</h2>
            <p class="text-sm text-slate-600 mt-2 max-w-xl mx-auto">Negocios que calificaron la plataforma después de centralizar pedidos y operación con WI-Store.</p>
        </div>

        {{-- Filtro por estrellas --}}
        <div class="flex flex-wrap items-center justify-center gap-2 mb-8">
            <button type="button" @click="setFilter('all')"
                :class="starFilter === 'all' ? 'landing-step-pill is-active' : ''"
                class="landing-step-pill text-[11px] font-bold px-3 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white transition-all">
                Todas
            </button>
            @foreach ([5, 4, 3, 2, 1] as $stars)
                <button type="button" @click="setFilter('{{ $stars }}')"
                    :class="starFilter === '{{ $stars }}' ? 'landing-step-pill is-active' : ''"
                    class="landing-step-pill text-[11px] font-bold px-3 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white transition-all inline-flex items-center gap-1">
                    {{ $stars }}
                    <i class="fas fa-star text-[9px] text-amber-400"></i>
                </button>
            @endforeach
        </div>

        <div x-show="filtered.length === 0" x-cloak class="text-center py-12 rounded-2xl border border-dashed border-slate-300 bg-slate-50">
            <p class="text-slate-500 text-sm">No hay reseñas con esa calificación todavía.</p>
        </div>

        <div x-show="filtered.length > 0" class="relative flex flex-col items-center">
            <div class="w-[260px] lg:w-[280px] shrink-0">
                <template x-for="(item, index) in filtered" :key="item.id">
                <article x-show="slide === index"
                    x-transition:enter="landing-motion-enter"
                    x-transition:enter-start="opacity-0 translate-x-6 scale-[0.98]"
                    x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                    x-transition:leave="landing-motion-leave"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                        class="w-full landing-shop-card rounded-[1.5rem] overflow-hidden flex flex-col group/card">
                        <div class="p-1.5 pb-0">
                            <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
                                <template x-if="item.shop_cover">
                                    <img :src="item.shop_cover"
                                        :alt="item.shop_name"
                                        class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700"
                                        loading="lazy" decoding="async" width="280" height="128">
                                </template>
                                <template x-if="!item.shop_cover">
                                    <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">
                                        WI-STORE
                                    </div>
                                </template>
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
                                <div class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                                    <img :src="item.shop_logo"
                                        :alt="item.shop_name"
                                        class="w-full h-full object-cover"
                                        loading="lazy" decoding="async" width="48" height="48">
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 px-4 pb-4 flex-grow flex flex-col">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="text-base font-black text-slate-900 leading-tight line-clamp-1" x-text="item.shop_name"></h3>
                                <div class="flex items-center gap-0.5 shrink-0" :aria-label="item.rating + ' de 5 estrellas'">
                                    <template x-for="star in 5" :key="'card-' + item.id + '-' + star">
                                        <i class="fas fa-star text-[10px]" :class="star <= item.rating ? 'text-amber-400' : 'text-slate-600'"></i>
                                    </template>
                                </div>
                            </div>

                            <p class="text-xs font-black text-slate-800 leading-snug line-clamp-2 mb-1.5" x-text="item.title"></p>
                            <p class="text-[10px] text-slate-500 leading-relaxed line-clamp-3 mb-2" x-text="item.comment"></p>
                            <p class="text-[9px] text-slate-500 font-semibold" x-text="item.created_at"></p>

                            <template x-if="item.shop_slug">
                                <a :href="'/' + item.shop_slug"
                                    class="mt-4 block w-full text-center bg-slate-100 hover:bg-gradient-to-r hover:from-purple-600 hover:to-cyan-500 hover:text-white text-slate-700 font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] border border-slate-200 hover:border-transparent">
                                    Ver tienda
                                </a>
                            </template>
                        </div>
                    </article>
                </template>
            </div>

            <div x-show="filtered.length > 1" class="flex items-center justify-center gap-4 mt-6">
                <button type="button" @click="prev()" class="w-10 h-10 rounded-full border border-slate-200 bg-white hover:bg-purple-50 text-slate-700 hover:text-purple-700 transition-all shadow-sm" aria-label="Anterior">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <span class="text-[11px] font-bold text-slate-400 tabular-nums" x-text="(slide + 1) + ' / ' + filtered.length"></span>
                <button type="button" @click="next()" class="w-10 h-10 rounded-full border border-slate-200 bg-white hover:bg-purple-50 text-slate-700 hover:text-purple-700 transition-all shadow-sm" aria-label="Siguiente">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</section>
@endif
