@php
    $shortLinkHost = str_replace(['http://', 'https://'], '', rtrim(config('app.url'), '/'));
@endphp

<div class="pt-3 mt-1 border-t border-slate-100 dark:border-slate-800/80 space-y-3">
    <div>
        <span class="text-[9px] font-bold uppercase tracking-wider text-primary/80 bg-primary/10 px-2 py-0.5 rounded-full border border-primary/15">
            Marketing
        </span>
        <h5 class="text-[11px] font-black text-slate-800 dark:text-slate-100 mt-2 mb-0.5">
            Enlace corto personalizado
        </h5>
        <p class="text-[9px] text-slate-450 dark:text-slate-500 font-medium leading-relaxed">
            Palabra clave fácil de recordar para compartir tu menú en Instagram, TikTok o tarjetas.
        </p>
    </div>

    @if($shortLink = $shop->shortLinks()->first())
        <div class="rounded-xl border border-slate-200/80 dark:border-slate-750 ui-inset p-2.5 space-y-2">
            <span class="text-[9px] uppercase font-extrabold text-slate-400 dark:text-slate-500 tracking-wider">Enlace activo</span>
            <div class="flex flex-col sm:flex-row items-stretch gap-2">
                <div class="flex-grow ui-surface border border-slate-200 dark:border-slate-750 rounded-lg px-2.5 py-1.5 flex items-center justify-between text-[10px] text-slate-800 dark:text-slate-200 font-bold select-all overflow-x-auto">
                    <span>{{ $shortLinkHost }}/l/{{ $shortLink->code }}</span>
                    <span class="text-[8px] bg-slate-100 dark:bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded font-semibold shrink-0 ml-2">Activo</span>
                </div>
                <button type="button"
                        onclick="copyShortLink('{{ url('/l/' . $shortLink->code) }}')"
                        class="bg-primary hover:brightness-105 text-white font-extrabold px-3 py-1.5 rounded-lg flex items-center justify-center gap-1.5 active:scale-95 transition text-[10px] shrink-0 shadow-sm shadow-primary/10">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copiar
                </button>
            </div>
            <span class="inline-flex items-center gap-1 text-[9px] text-slate-500 dark:text-slate-400 font-bold py-0.5 px-2 rounded ui-surface border border-slate-200 dark:border-slate-700">
                📊 {{ $shortLink->clicks_count }} {{ $shortLink->clicks_count == 1 ? 'visita' : 'visitas' }}
            </span>
        </div>
    @endif

    <div class="space-y-2">
        <div class="space-y-0.5">
            <label for="code" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Palabra clave o prefijo corto</label>
            <div class="flex items-stretch rounded-xl border border-slate-200 dark:border-slate-750 overflow-hidden focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/15 transition shadow-sm ui-inset">
                <span class="bg-slate-100 dark:bg-slate-900 border-r border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 px-2.5 py-1.5 flex items-center text-[10px] font-bold select-none shrink-0">
                    {{ $shortLinkHost }}/l/
                </span>
                <input type="text"
                       id="code"
                       name="code"
                       form="shop-short-link-form"
                       value="{{ old('code', $shop->shortLinks()->first()?->code) }}"
                       placeholder="ej: {{ $shop->slug }}"
                       required
                       class="w-full px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-100 font-bold placeholder-slate-400 focus:outline-none bg-transparent">
            </div>
            @error('code')
                <span class="text-red-500 text-[9px] mt-0.5 block font-semibold">{{ $message }}</span>
            @enderror
            <p class="text-[9px] text-slate-450 dark:text-slate-500 font-medium">
                Sin espacios ni caracteres especiales. Ej: ys, detallitos, regalos.
            </p>
        </div>
        <button type="submit"
                form="shop-short-link-form"
                class="bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white font-extrabold py-2 px-4 rounded-xl transition text-[10px] active:scale-[0.98] w-full sm:w-auto">
            Guardar enlace corto
        </button>
    </div>
</div>

<div id="toast-notification" class="fixed bottom-6 left-1/2 -translate-x-1/2 md:left-auto md:right-8 md:-translate-x-0 z-50 pointer-events-none"
     style="display: none;">
    <div class="bg-slate-900 text-white text-xs font-semibold py-3 px-5 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-800">
        <span class="text-emerald-400">✨</span>
        ¡Enlace copiado al portapapeles!
    </div>
</div>
