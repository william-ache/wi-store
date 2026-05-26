@props(['shop', 'ariaHidden' => false])

@php
    $rating = (float) ($shop->display_rating ?? 0);
    $fullStars = min(5, max(0, (int) round($rating)));
    $reviewsCount = (int) ($shop->display_reviews_count ?? 0);
@endphp

<div
    @if ($ariaHidden) aria-hidden="true" @endif
    class="w-[260px] lg:w-[280px] shrink-0 bg-slate-900/50 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-2xl transition duration-300 hover:border-purple-500/30 flex flex-col justify-between group/card backdrop-blur-sm">
    <div class="p-1.5 pb-0">
        <div class="h-32 w-full overflow-hidden relative rounded-xl bg-slate-800">
            @if ($shop->cover_path)
                <img src="{{ $shop->coverUrl() }}"
                    alt="{{ $shop->name }}"
                    class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700"
                    loading="lazy" decoding="async">
            @else
                <div
                    class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-400 text-sm font-black tracking-widest select-none">
                    WISTORE</div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

            <div
                class="absolute bottom-2 left-3 w-12 h-12 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                <img src="{{ $shop->logoUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($shop->name) . '&background=a855f7&color=fff' }}"
                    alt="Logo" class="w-full h-full object-cover" loading="lazy" decoding="async">
            </div>
        </div>
    </div>

    <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
        <div>
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-base font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
                <div class="flex flex-col items-end shrink-0 pt-0.5">
                    <div class="flex items-center gap-0.5">
                        @for ($star = 1; $star <= 5; $star++)
                            <svg class="w-3 h-3 {{ $star <= $fullStars ? 'text-yellow-400 fill-current' : 'text-slate-600 fill-current' }}"
                                viewBox="0 0 20 20" aria-hidden="true">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    @if ($reviewsCount > 0)
                        <span class="text-[9px] text-slate-500 font-semibold mt-0.5">{{ $rating }} · {{ $reviewsCount }} {{ $reviewsCount === 1 ? 'opinión' : 'opiniones' }}</span>
                    @endif
                </div>
            </div>
            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                {{ $shop->description ?: 'Catálogo oficial de marca blanca en WIStore.' }}
            </p>
        </div>

        <div class="mt-4">
            <a href="/{{ $shop->slug }}"
                class="block w-full text-center bg-slate-800/50 hover:bg-purple-600 text-white font-bold py-2.5 rounded-xl transition-all duration-300 text-[11px] shadow-sm">
                Entrar a la Tienda
            </a>
        </div>
    </div>
</div>
