@php
    $hex = config('current_shop')->color_primary ?? '#E60067';
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $rgbColor = "$r-$g-$b";
@endphp

<!-- MODAL COMPARTIR CATÁLOGO CON CÓDIGO QR -->
<div x-data="{
    show: false,
    copied: false,
    shopUrl: '{{ request()->getSchemeAndHttpHost() . '/' . config('current_shop')->slug }}',

    copyUrl() {
        navigator.clipboard.writeText(this.shopUrl);
        this.copied = true;
        setTimeout(() => this.copied = false, 2000);

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '¡Enlace copiado al portapapeles!',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    },

    async downloadQR() {
        try {
            let qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&color={{ $rgbColor }}&margin=15&data=' + encodeURIComponent(this.shopUrl);
            const response = await fetch(qrUrl);
            const blob = await response.blob();
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'QR_Catalogo_{{ config('current_shop')->slug }}.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '¡Descarga iniciada exitosamente!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        } catch(e) {
            console.error('Error al descargar QR con blob, usando fallback:', e);
            window.open('https://api.qrserver.com/v1/create-qr-code/?size=600x600&color={{ $rgbColor }}&margin=15&data=' + encodeURIComponent(this.shopUrl), '_blank');
        }
    }
}"
@open-qr-modal.window="show = true"
x-show="show"
x-cloak
class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <div x-show="show"
         x-transition.opacity.duration.300ms
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
         @click="show = false"></div>

    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative ui-card rounded-[28px] shadow-2xl w-full max-w-md overflow-hidden flex flex-col transition-colors duration-300 z-10 border border-slate-100 dark:border-slate-800">

        <!-- Cabecera con color de marca -->
        <div class="accent-surface px-6 pt-6 pb-5 relative shrink-0">
            <button @click="show = false"
                    class="absolute top-4 right-4 w-9 h-9 flex items-center justify-center rounded-full accent-subtle-bg hover:brightness-110 accent-icon-btn transition-all duration-200 cursor-pointer border border-white/10">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="pr-10">
                <h3 class="text-xl font-extrabold tracking-tight leading-tight">
                    Compartir catálogo
                </h3>
                <p class="text-xs font-semibold accent-muted mt-0.5 truncate">
                    {{ config('current_shop')->name ?? config('current_shop')->slug }}
                </p>
            </div>
        </div>

        <div class="px-6 pb-6 pt-5 flex flex-col">
            <!-- Código QR -->
            <div class="flex justify-center mb-5">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-center">
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=250x250&color={{ $rgbColor }}&margin=10&data=' + encodeURIComponent(shopUrl)"
                         alt="Código QR"
                         class="w-44 h-44 sm:w-48 sm:h-48 object-contain select-none pointer-events-none">
                </div>
            </div>

            <!-- Aviso personalización próxima -->
            <div class="mb-4 flex items-start gap-2.5 rounded-xl border border-primary/15 bg-primary/5 px-3.5 py-3">
                <span class="text-base shrink-0 leading-none mt-0.5">✨</span>
                <p class="text-[11px] leading-relaxed text-[var(--ui-text-muted)] font-medium">
                    <span class="font-bold text-[var(--ui-text)]">Próximamente:</span> podrás personalizar colores, logo y estilo de tu código QR.
                </p>
            </div>

            <!-- Enlace + copiar -->
            <div class="flex items-center gap-2.5 bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800/80 rounded-xl px-3.5 py-3 w-full">
                <div class="flex-grow text-[var(--ui-text-muted)] text-[11px] sm:text-xs font-semibold truncate select-all"
                     x-text="shopUrl"></div>
                <button @click="copyUrl()"
                        class="flex items-center gap-1 text-primary hover:opacity-85 text-xs font-extrabold tracking-wide transition-all shrink-0 cursor-pointer">
                    <svg x-show="!copied" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <svg x-show="copied" x-cloak width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-emerald-500">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span x-text="copied ? 'Copiado' : 'Copiar'">Copiar</span>
                </button>
            </div>

            <!-- Descargar QR compacto -->
            <div class="mt-4 flex justify-center">
                <button @click="downloadQR()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[var(--ui-text)] text-[var(--ui-surface)] hover:opacity-90 text-xs font-bold transition-all active:scale-[0.98] cursor-pointer shadow-sm">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Descargar QR
                </button>
            </div>
        </div>
    </div>
</div>
