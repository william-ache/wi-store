@props(['shop'])

<div class="w-full bg-slate-900/60 border border-slate-800/80 rounded-[1.5rem] overflow-hidden shadow-xl transition duration-300 hover:border-purple-500/40 hover:shadow-[0_0_30px_rgba(168,85,247,0.12)] flex flex-col justify-between group/card backdrop-blur-sm">
    <div class="p-1.5 pb-0">
        <div class="h-36 w-full overflow-hidden relative rounded-xl bg-slate-800">
            @if ($shop->cover_path)
                <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/' . $shop->cover_path) }}"
                     alt="{{ $shop->name }}"
                     class="w-full h-full object-cover transform group-hover/card:scale-105 transition-transform duration-700"
                     loading="lazy">
            @else
                <div class="w-full h-full bg-gradient-to-tr from-purple-900 to-indigo-900 flex items-center justify-center text-purple-300 text-sm font-black tracking-widest">
                    WIStore
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
            <div class="absolute bottom-2 left-3 w-14 h-14 rounded-full border-2 border-slate-900 bg-white overflow-hidden shadow-lg z-10">
                <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : ($shop->logo_path ? asset('storage/' . $shop->logo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($shop->name) . '&background=a855f7&color=fff') }}"
                     alt="Logo" class="w-full h-full object-cover" loading="lazy">
            </div>
            @if (!empty($shop->category))
                <span class="absolute top-2 right-2 text-[9px] font-black uppercase tracking-wider bg-black/50 text-purple-200 px-2 py-1 rounded-full border border-purple-500/30 backdrop-blur-sm">
                    {{ $shop->category }}
                </span>
            @endif
        </div>
    </div>
    <div class="pt-3 px-4 pb-4 flex-grow flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-black text-white leading-tight line-clamp-1">{{ $shop->name }}</h3>
            @if (!empty($shop->zone))
                <p class="text-[11px] text-cyan-300/80 font-semibold mt-1 flex items-center gap-1">
                    <i class="fas fa-map-marker-alt text-[10px] opacity-70"></i>
                    {{ $shop->zone }}
                </p>
            @endif
            @if (!empty($shop->has_cashea) || !empty($shop->has_krece))
                <p class="mt-2 inline-flex flex-wrap items-center gap-2">
                    @if (!empty($shop->has_cashea))
                        <span class="inline-flex items-center">
                            <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-5 w-5 rounded-md object-contain" title="Cashea disponible">
                        </span>
                    @endif
                    @if (!empty($shop->has_krece))
                        <span class="inline-flex items-center">
                            <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-5 w-5 rounded-md object-contain" title="Krece disponible">
                        </span>
                    @endif
                </p>
            @endif
            <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                {{ $shop->description ?: 'Menú digital con pedidos por WhatsApp.' }}
            </p>
        </div>
        <div class="mt-4">
            <a href="/{{ $shop->slug }}"
               class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-purple-600/80 to-cyan-600/70 hover:from-purple-500 hover:to-cyan-500 text-white font-extrabold py-3 rounded-xl transition-all duration-300 text-sm shadow-lg shadow-purple-500/10">
                <span>Ver menú</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</div>
