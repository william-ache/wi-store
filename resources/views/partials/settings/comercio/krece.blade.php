<div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-800">
    <div class="flex items-center gap-3 mb-3">
        <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-8 w-8 rounded-lg object-contain krece-logo-badge">
        <div>
            <p class="text-[11px] font-black text-slate-800 dark:text-slate-100">Krece · Cuotas</p>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-snug">
                Activa el badge en tu menú y configura QR o enlace de pago.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="bg-white dark:bg-slate-900 border krece-brand-border rounded-2xl p-3.5 space-y-3">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-black text-slate-800 dark:text-slate-200">Krece (QR en tienda)</span>
                <label class="relative inline-flex items-center cursor-pointer select-none shrink-0">
                    <input type="checkbox" name="krece_enabled" value="1" class="sr-only peer" {{ $shop->krece_enabled ? 'checked' : '' }}>
                    <div class="relative w-[30px] h-[16px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[1px] after:left-[1px] after:bg-white after:rounded-full after:h-[14px] after:w-[14px] after:transition-all peer-checked:krece-brand-bg peer-checked:after:bg-black"></div>
                </label>
            </div>
            <p class="text-[9px] text-slate-500 leading-normal">Sube el QR que te da Krece para que el cliente lo escanee al pagar.</p>
            @if ($shop->kreceQrUrl())
                <div class="flex items-start gap-2 p-2 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-100 dark:border-slate-800">
                    <img src="{{ $shop->kreceQrUrl() }}" alt="QR Krece" class="w-20 h-20 object-contain rounded-lg bg-white border border-slate-100">
                    <label class="flex items-center gap-1.5 text-[10px] font-bold text-rose-600 cursor-pointer">
                        <input type="checkbox" name="remove_krece_qr" value="1" class="rounded border-rose-300 text-rose-500">
                        Quitar QR
                    </label>
                </div>
            @endif
            <input type="file" name="krece_qr" accept="image/png,image/jpeg,image/webp"
                class="w-full text-[10px] text-slate-600 dark:text-slate-300 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:krece-brand-bg file:text-black">
        </div>

        <div class="bg-white dark:bg-slate-900 border krece-brand-border rounded-2xl p-3.5 space-y-3">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] font-black text-slate-800 dark:text-slate-200">Krece Link</span>
                <label class="relative inline-flex items-center cursor-pointer select-none shrink-0">
                    <input type="checkbox" name="krece_link_enabled" value="1" class="sr-only peer" {{ $shop->krece_link_enabled ? 'checked' : '' }}>
                    <div class="relative w-[30px] h-[16px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[1px] after:left-[1px] after:bg-white after:rounded-full after:h-[14px] after:w-[14px] after:transition-all peer-checked:krece-brand-bg peer-checked:after:bg-black"></div>
                </label>
            </div>
            <p class="text-[9px] text-slate-500 leading-normal">Enlace de pago para financiar en cuotas desde el checkout.</p>
            <div class="space-y-1">
                <label for="krece_link_url" class="text-[9px] font-bold text-slate-600 dark:text-slate-400">URL del enlace</label>
                <input type="url" id="krece_link_url" name="krece_link_url"
                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-[10px] text-slate-800 dark:text-slate-200 focus:outline-none focus:border-sky-300 focus:ring-1 focus:ring-sky-300/40 font-semibold"
                    value="{{ old('krece_link_url', $shop->krece_link_url) }}" placeholder="https://...">
            </div>
        </div>
    </div>
</div>
