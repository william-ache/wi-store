@php
    // Obtener el color primario de la tienda y convertirlo a RGB para personalizar el QR
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
    isTableQr: false,
    tableNumber: '',
    
    getQrUrl() {
        return this.isTableQr && this.tableNumber ? this.shopUrl + '?mesa=' + this.tableNumber : this.shopUrl;
    },
    
    copyUrl() {
        navigator.clipboard.writeText(this.getQrUrl());
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
    
    shareWhatsApp() {
        let text = encodeURIComponent('¡Hola! Te invito a ver nuestro catálogo digital aquí: ' + this.getQrUrl());
        window.open('https://api.whatsapp.com/send?text=' + text, '_blank');
    },
    
    shareFacebook() {
        let url = encodeURIComponent(this.getQrUrl());
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank');
    },
    
    shareInstagram() {
        navigator.clipboard.writeText(this.getQrUrl());
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '¡Enlace copiado para Instagram!',
            text: 'Se copió automáticamente. Pégalo en tu perfil o mensajes de Instagram.',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    },
    
    async downloadQR() {
        try {
            let qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&color={{ $rgbColor }}&margin=15&data=' + encodeURIComponent(this.getQrUrl());
            const response = await fetch(qrUrl);
            const blob = await response.blob();
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = this.isTableQr && this.tableNumber ? 'QR_Mesa_' + this.tableNumber + '_{{ config('current_shop')->slug }}.png' : 'QR_Catalogo_{{ config('current_shop')->slug }}.png';
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
            window.open('https://api.qrserver.com/v1/create-qr-code/?size=600x600&color={{ $rgbColor }}&margin=15&data=' + encodeURIComponent(this.getQrUrl()), '_blank');
        }
    }
}"
@open-qr-modal.window="show = true"
x-show="show"
x-cloak
class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <!-- Fondo de desenfoque oscuro -->
    <div x-show="show" 
         x-transition.opacity.duration.300ms 
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" 
         @click="show = false"></div>

    <!-- Contenedor del Modal -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative ui-card rounded-[32px] shadow-2xl w-full max-w-md overflow-hidden flex flex-col p-6 sm:p-8 transition-colors duration-300 z-10 border border-slate-100 dark:border-slate-800">
        
        <!-- Botón de Cerrar (X) -->
        <button @click="show = false" 
                class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 dark:bg-slate-800 dark:hover:bg-slate-700/80 dark:text-slate-400 dark:hover:text-slate-200 transition-all duration-200 cursor-pointer border border-slate-100/50 dark:border-slate-700/50">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Cabecera del Modal -->
        <div class="pr-12">
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                Compartir catálogo
            </h3>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 mt-0.5 lowercase truncate">
                {{ config('current_shop')->slug }}
            </p>
        </div>

        <!-- Contenedor del Código QR -->
        <div class="flex justify-center my-6">
            <div class="bg-white p-6 rounded-[28px] border border-slate-100/80 shadow-[0_12px_40px_rgba(0,0,0,0.04)] flex items-center justify-center transition-all duration-300 hover:shadow-[0_16px_50px_rgba(0,0,0,0.08)]">
                <!-- Código QR personalizado con el color primario exacto de la tienda -->
                <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=250x250&color={{ $rgbColor }}&margin=10&data=' + encodeURIComponent(getQrUrl())" 
                     alt="Código QR" 
                     class="w-48 h-48 sm:w-56 sm:h-56 object-contain select-none pointer-events-none">
            </div>
        </div>

        <!-- Selector de Código QR para Mesa (Dine-in) -->
        <div class="mb-4 bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/60 rounded-3xl p-4 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-200">Mapear Código QR a Mesa</span>
                    <span class="text-[11px] text-slate-400 dark:text-slate-500">Añade ?mesa=X al código para pedidos Dine-in</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="isTableQr" class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-primary" style="background-color: var(--color-primary, '#E60067')"></div>
                </label>
            </div>
            
            <div x-show="isTableQr" x-transition.duration.300ms class="mt-3 flex gap-2">
                <input type="number" 
                       x-model="tableNumber" 
                       placeholder="Nro de Mesa (ej: 4)" 
                       class="w-full ui-card border focus:border-primary dark:focus:border-primary focus:ring-1 focus:ring-primary text-slate-700 dark:text-slate-200 text-sm font-semibold rounded-[16px] px-4 py-2 transition-all outline-none">
            </div>
        </div>

        <!-- Campo del Enlace de Copiado -->
        <div class="flex items-center gap-2.5 bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800/80 rounded-[20px] px-4 py-3.5 w-full shadow-inner">
            <div class="flex-grow text-slate-500 dark:text-slate-300 text-[11px] sm:text-xs font-semibold truncate select-all" 
                 x-text="getQrUrl()"></div>
            
            <button @click="copyUrl()" 
                    class="flex items-center gap-1 text-primary hover:opacity-85 text-xs font-extrabold tracking-wide transition-all select-none shrink-0 cursor-pointer">
                <svg x-show="!copied" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
                <svg x-show="copied" x-cloak width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-emerald-500">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span x-text="copied ? 'Copiado' : 'Copiar'">Copiar</span>
            </button>
        </div>

        <!-- Botones de Redes Sociales / Descarga -->
        <div class="grid grid-cols-4 gap-3 mt-6">
            
            <!-- WhatsApp -->
            <button @click="shareWhatsApp()" 
                    class="flex flex-col items-center justify-center p-3 rounded-2xl gap-2 cursor-pointer transition-all hover:scale-105 active:scale-95 bg-[#e8f7f2] hover:bg-[#d6f2e8] border border-[#cbece0] dark:bg-emerald-950/20 dark:hover:bg-emerald-950/40 dark:border-emerald-900/30 text-[#099268] dark:text-[#2f9e44]">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white/70 dark:bg-slate-900 shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </div>
                <span class="text-[10px] sm:text-xs font-bold tracking-tight text-slate-700 dark:text-slate-300">WhatsApp</span>
            </button>
            
            <!-- Facebook -->
            <button @click="shareFacebook()" 
                    class="flex flex-col items-center justify-center p-3 rounded-2xl gap-2 cursor-pointer transition-all hover:scale-105 active:scale-95 bg-[#e7f5ff] hover:bg-[#d0ebff] border border-[#c3e3fc] dark:bg-blue-950/20 dark:hover:bg-blue-950/40 dark:border-blue-900/30 text-[#1971c2] dark:text-[#339af0]">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white/70 dark:bg-slate-900 shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                </div>
                <span class="text-[10px] sm:text-xs font-bold tracking-tight text-slate-700 dark:text-slate-300">Facebook</span>
            </button>
            
            <!-- Instagram -->
            <button @click="shareInstagram()" 
                    class="flex flex-col items-center justify-center p-3 rounded-2xl gap-2 cursor-pointer transition-all hover:scale-105 active:scale-95 bg-[#fff0f6] hover:bg-[#ffdeeb] border border-[#fcc2d7] dark:bg-rose-950/20 dark:hover:bg-rose-950/40 dark:border-rose-900/30 text-[#d6336c] dark:text-[#f783ac]">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white/70 dark:bg-slate-900 shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </div>
                <span class="text-[10px] sm:text-xs font-bold tracking-tight text-slate-700 dark:text-slate-300">Instagram</span>
            </button>
            
            <!-- Descargar -->
            <button @click="downloadQR()" 
                    class="flex flex-col items-center justify-center p-3 rounded-2xl gap-2 cursor-pointer transition-all hover:scale-105 active:scale-95 bg-[#f8f9fa] hover:bg-[#e9ecef] border border-[#dee2e6] dark:bg-slate-800/40 dark:hover:bg-slate-800/70 dark:border-slate-700/50 text-[#495057] dark:text-slate-300">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-white/70 dark:bg-slate-900 shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </div>
                <span class="text-[10px] sm:text-xs font-bold tracking-tight text-slate-700 dark:text-slate-300">Descargar</span>
            </button>
            
        </div>

        <!-- Mensaje de Información Instagram -->
        <p class="text-[10px] text-center text-slate-400 dark:text-slate-500 mt-6 leading-relaxed select-none">
            Instagram no permite compartir links directamente — se copia el enlace automáticamente.
        </p>

    </div>
</div>
