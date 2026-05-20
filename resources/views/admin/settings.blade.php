@extends('layouts.admin')

@section('title', 'Configuración Visual')
@section('subtitle', 'Configuración')
@section('header_title', 'Ajustes Visuales')

@section('content')
<style>
    /* Compact Select2 Custom overrides for settings view */
    .select2-container--default .select2-selection--single {
        height: 32px !important;
        padding: 0 0.4rem !important;
        border-radius: 0.75rem !important;
        background-color: #ffffff !important;
    }
    .dark .select2-container--default .select2-selection--single {
        background-color: #0f172a !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 11px !important;
        line-height: 30px !important;
        font-weight: 600 !important;
        padding-left: 0.25rem !important;
    }
</style>
<div x-data="{ activeTab: 'comercio', colorPrimary: '{{ old('color_primary', $shop->color_primary ?? '#E60067') }}', colorSecondary: '{{ old('color_secondary', $shop->color_secondary ?? '#0B132B') }}', colorBackground: '{{ old('color_background', $shop->color_background ?? '#FFFFFF') }}' }" class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 text-xs font-semibold p-4 rounded-2xl border border-emerald-100 dark:border-emerald-900/50 transition-colors">
            {{ session('success') }}
        </div>
    @endif    <!-- Tabs de Navegación -->
    <div class="flex overflow-x-auto gap-2 pb-2 hide-scrollbar">
        <button type="button" @click="activeTab = 'comercio'" 
                :class="activeTab === 'comercio' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Datos Comerciales
        </button>
        <button type="button" @click="activeTab = 'colores'" 
                :class="activeTab === 'colores' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
            Apariencia & Activos
        </button>
        <button type="button" @click="activeTab = 'enlaces'" 
                :class="activeTab === 'enlaces' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
            Marketing y Enlaces
        </button>
        <button type="button" @click="activeTab = 'seguridad'" 
                :class="activeTab === 'seguridad' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Seguridad
        </button>
    </div>

    <!-- Formulario de Configuración Principal -->
    <form action="/{{ $shop->slug }}/admin/settings" method="POST" enctype="multipart/form-data" 
          class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-4 md:p-5 shadow-sm space-y-3.5 transition-colors duration-300" 
          x-show="activeTab !== 'enlaces'" x-cloak>
        @csrf
        @method('PUT')

        <!-- TAB 1: IDENTIDAD COMERCIAL -->
        <div x-show="activeTab === 'comercio'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3.5 pt-0.5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800/80 pb-3 mb-1">
                <div>
                    <h3 class="text-sm md:text-base font-black text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="bg-primary/10 text-primary text-[9px] uppercase font-extrabold tracking-wider px-2 py-0.5 rounded-md border border-primary/20">
                            Comercio
                        </span>
                        Datos del Comercio
                    </h3>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">
                        Personaliza la información pública que se mostrará en tu catálogo digital.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{
                googleMapsLink: '{{ old('google_maps_link', $shop->google_maps_link ?? '') }}',
                latitude: '{{ old('latitude', $shop->latitude ?? '') }}',
                longitude: '{{ old('longitude', $shop->longitude ?? '') }}',
                gpsLoading: false,
                mapsResolving: false,

                // Parse/Extract coordinates from Google Maps Link
                async extractCoords() {
                    if (!this.googleMapsLink) return;
                    
                    let urlToParse = this.googleMapsLink.trim();
                    
                    // If it is a shortened google link, resolve it via our server
                    if (urlToParse.includes('maps.app.goo.gl') || urlToParse.includes('goo.gl/maps')) {
                        this.mapsResolving = true;
                        try {
                            let response = await fetch('/{{ $shop->slug }}/admin/settings/resolve-url', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                },
                                body: JSON.stringify({ url: urlToParse })
                            });
                            let data = await response.json();
                            if (data.url) {
                                urlToParse = data.url;
                            }
                        } catch (e) {
                            console.error('Error resolving map url', e);
                        } finally {
                            this.mapsResolving = false;
                        }
                    }

                    // Extract coordinates patterns:
                    // 1. @10.4806,-66.9036
                    let atMatch = urlToParse.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
                    let lat = null, lng = null;

                    if (atMatch) {
                        lat = atMatch[1];
                        lng = atMatch[2];
                    } else {
                        // 2. !3d10.4806!4d-66.9036
                        let dMatch = urlToParse.match(/!3d(-?\d+\.\d+).*?!4d(-?\d+\.\d+)/);
                        if (dMatch) {
                            lat = dMatch[1];
                            lng = dMatch[2];
                        } else {
                            // 3. q=10.4806,-66.9036 or ll=10.4806,-66.9036
                            let qMatch = urlToParse.match(/[?&](q|ll)=(-?\d+\.\d+),(-?\d+\.\d+)/);
                            if (qMatch) {
                                lat = qMatch[2];
                                lng = qMatch[3];
                            }
                        }
                    }

                    if (lat && lng) {
                        this.latitude = parseFloat(lat).toFixed(6);
                        this.longitude = parseFloat(lng).toFixed(6);
                        
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        
                        Toast.fire({
                            icon: 'success',
                            title: 'Coordenadas Extraídas',
                            text: 'Se han obtenido latitud y longitud desde el enlace.'
                        });
                    } else {
                        // If no coordinates could be parsed and we resolved, show a warning toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                        
                        Toast.fire({
                            icon: 'info',
                            title: 'Enlace Registrado',
                            text: 'Para sincronizar geolocalización, asegúrate de que el enlace incluya coordenadas o usa el botón GPS.'
                        });
                    }
                },

                // Get browser GPS coordinates
                getGPSLocation() {
                    if (!navigator.geolocation) {
                        Swal.fire({
                            icon: 'error',
                            title: 'GPS no soportado',
                            text: 'Tu navegador o dispositivo no soporta la geolocalización.'
                        });
                        return;
                    }

                    this.gpsLoading = true;
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.latitude = position.coords.latitude.toFixed(6);
                            this.longitude = position.coords.longitude.toFixed(6);
                            this.gpsLoading = false;

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            
                            Toast.fire({
                                icon: 'success',
                                title: 'GPS Sincronizado',
                                text: 'Se han establecido las coordenadas actuales.'
                            });

                            // Generate google maps link if empty
                            if (!this.googleMapsLink) {
                                this.googleMapsLink = `https://www.google.com/maps?q=${this.latitude},${this.longitude}`;
                            }
                        },
                        (error) => {
                            this.gpsLoading = false;
                            let msg = 'No se pudo obtener la ubicación.';
                            if (error.code === error.PERMISSION_DENIED) {
                                msg = 'Permiso denegado. Por favor, concede acceso al GPS en tu navegador.';
                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                msg = 'La ubicación física no está disponible en este momento.';
                            } else if (error.code === error.TIMEOUT) {
                                msg = 'Tiempo de espera agotado al intentar conectar con el satélite GPS.';
                            }

                            Swal.fire({
                                icon: 'warning',
                                title: 'Ubicación no obtenida',
                                text: msg
                            });
                        },
                        { enableHighAccuracy: true, timeout: 8000 }
                    );
                }
            }">
                <!-- Columna Izquierda: Información Básica del Comercio -->
                <div class="space-y-3 bg-slate-50/50 dark:bg-slate-950/40 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
                    <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-primary/80"></span>Información Básica</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Nombre de la Empresa -->
                        <div class="space-y-0.5">
                            <label for="name" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Nombre de la Empresa</label>
                            <input type="text" id="name" name="name" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('name', $shop->name) }}" required>
                        </div>

                        <!-- WhatsApp de Pedidos -->
                        <div class="space-y-0.5">
                            <label for="whatsapp_number" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">WhatsApp (Formato Internacional)</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" required placeholder="e.g. 584120000000">
                        </div>
                    </div>

                    <!-- Descripción/Eslogan -->
                    <div class="space-y-0.5">
                        <label for="description" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Descripción o Eslogan</label>
                        <textarea id="description" name="description" 
                                  class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                  rows="2">{{ old('description', $shop->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Ubicación -->
                        <div class="space-y-0.5">
                            <label for="address" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Dirección Física</label>
                            <input type="text" id="address" name="address" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                   value="{{ old('address', $shop->address) }}">
                        </div>

                        <!-- Google Maps -->
                        <div class="space-y-0.5">
                            <div class="flex items-center justify-between">
                                <label for="google_maps_link" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Enlace de Google Maps</label>
                                <span x-show="mapsResolving" class="text-[9px] text-primary font-bold flex items-center gap-1" style="display: none;">
                                    <svg class="animate-spin w-2.5 h-2.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Resolviendo...
                                </span>
                            </div>
                            <input type="url" id="google_maps_link" name="google_maps_link" 
                                   x-model="googleMapsLink"
                                   @input.debounce.500ms="extractCoords()"
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                   placeholder="https://maps.google.com/...">
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Configuración Operativa, Delivery e Impuestos -->
                <div class="space-y-3 bg-slate-50/50 dark:bg-slate-950/40 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
                    <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-secondary/80"></span>Operaciones & Delivery</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Tasa de Delivery por Km -->
                        <div class="space-y-0.5">
                            <label for="delivery_rate_per_km" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Delivery por Km</label>
                            <input type="number" step="0.01" id="delivery_rate_per_km" name="delivery_rate_per_km" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                   placeholder="0.00" value="{{ old('delivery_rate_per_km', $shop->delivery_rate_per_km) }}">
                        </div>

                        <!-- Tasa Monetaria -->
                        <div class="space-y-0.5" x-data="{
                            baseCurrency: '{{ old('base_currency', $shop->base_currency) }}',
                            exchangeRate: '{{ old('exchange_rate', $shop->exchange_rate) }}',
                            isLoading: false,
                            async fetchRate() {
                                if (this.baseCurrency === 'USD') {
                                    this.isLoading = true;
                                    try {
                                        let res = await fetch('https://dolarapi.com/v1/dolares/oficial');
                                        let data = await res.json();
                                        this.exchangeRate = '$' + data.venta + ' ARS';
                                    } catch (e) {
                                        console.error('Error fetching rate', e);
                                    }
                                    this.isLoading = false;
                                } else if (this.baseCurrency === 'EUR') {
                                    this.isLoading = true;
                                    try {
                                        let res = await fetch('https://dolarapi.com/v1/cotizaciones/eur');
                                        let data = await res.json();
                                        this.exchangeRate = '€' + data.venta + ' ARS';
                                    } catch (e) {
                                        console.error('Error fetching rate', e);
                                    }
                                    this.isLoading = false;
                                } else if (this.baseCurrency !== 'VES') {
                                    this.exchangeRate = '';
                                }
                            }
                        }" x-init="if(!exchangeRate && (baseCurrency === 'USD' || baseCurrency === 'EUR')) fetchRate()">
                            <label for="base_currency" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Tasa monetaria</label>
                            <div class="flex gap-2 items-center">
                                <div class="w-[45%]" x-init="
                                    $nextTick(() => {
                                        let select = $('#base_currency');
                                        select.select2({
                                            minimumResultsForSearch: -1,
                                            width: '100%'
                                        });
                                        select.on('change', (e) => {
                                            baseCurrency = e.target.value;
                                            fetchRate();
                                        });
                                        $watch('baseCurrency', value => {
                                            select.val(value).trigger('change.select2');
                                        });
                                    });
                                }">
                                    <select id="base_currency" name="base_currency" x-model="baseCurrency"
                                            class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2 py-1.5 text-[11px] text-slate-800 dark:text-slate-250 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold select2-enable">
                                        <option value="" disabled>Moneda</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="VES">VES</option>
                                        <option value="COP">COP</option>
                                    </select>
                                </div>
                                <div class="relative w-[55%] flex items-center">
                                    <input type="text" name="exchange_rate" x-model="exchangeRate" 
                                           :readonly="baseCurrency === 'USD' || baseCurrency === 'EUR'" 
                                           :class="(baseCurrency === 'USD' || baseCurrency === 'EUR') ? 'bg-slate-100 dark:bg-slate-800/80 text-slate-500 cursor-not-allowed' : 'bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:border-primary focus:ring-primary focus:ring-1 focus:outline-none'" 
                                           class="w-full border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] transition-all shadow-sm font-bold h-[32px]" 
                                           placeholder="Ej: Bs. 39.50">
                                    <div x-show="isLoading" class="absolute right-2 top-2" style="display: none;">
                                        <svg class="animate-spin h-3.5 w-3.5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coordenadas del Local (Lat / Lng) para cálculo de distancia -->
                    <div class="bg-white dark:bg-slate-900/60 p-2.5 rounded-xl border border-slate-150 dark:border-slate-800 space-y-1.5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Geolocalización (Distancia Delivery)</span>
                            <button type="button" @click="getGPSLocation()" 
                                    class="text-[9px] font-bold text-primary hover:brightness-105 flex items-center gap-1 transition-all active:scale-95 duration-200">
                                <span x-show="!gpsLoading" class="flex items-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v4M12 18v4M4 12H2M22 12h-4"></path></svg>
                                    Usar GPS
                                </span>
                                <span x-show="gpsLoading" x-cloak class="flex items-center gap-0.5">
                                    <svg class="animate-spin w-2.5 h-2.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Localizando...
                                </span>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2.5">
                            <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-850 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-750">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase shrink-0">LAT</span>
                                <input type="text" id="latitude" name="latitude" x-model="latitude"
                                       class="w-full bg-transparent border-0 p-0 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-0 font-medium" 
                                       placeholder="10.4806">
                            </div>
                            <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-850 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-750">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase shrink-0">LNG</span>
                                <input type="text" id="longitude" name="longitude" x-model="longitude"
                                       class="w-full bg-transparent border-0 p-0 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-0 font-medium" 
                                       placeholder="-66.9036">
                            </div>
                        </div>
                    </div>

                    <!-- Horario de Trabajo -->
                    @php
                        $currentHours = old('work_hours', $shop->work_hours);
                        $defaultSchedule = [
                            'Lunes' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Martes' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Miércoles' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Jueves' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Viernes' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Sábado' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Domingo' => ['closed' => true, 'open' => '08:00', 'close' => '18:00'],
                        ];
                        $isCustom = is_array($currentHours) && isset($currentHours['type']) && $currentHours['type'] === 'custom';
                        $simpleText = is_array($currentHours) && isset($currentHours['type']) && $currentHours['type'] === 'simple' 
                                        ? $currentHours['text'] 
                                        : (!is_array($currentHours) ? $currentHours : '');
                        $scheduleData = $isCustom ? $currentHours['schedule'] : $defaultSchedule;
                    @endphp
                    
                    <div class="space-y-1" 
                         x-data="{ 
                              type: '{{ $isCustom ? 'custom' : 'simple' }}',
                              text: '{{ addslashes($simpleText ?? '') }}',
                              schedule: {{ json_encode($scheduleData) }},
                              days: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']
                          }">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Horario de Trabajo</label>
                            <button type="button" 
                                    @click="type = type === 'simple' ? 'custom' : 'simple'"
                                    class="text-[8px] font-bold px-1.5 py-0.5 rounded transition-all border bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700">
                                <span x-show="type === 'simple'">Avanzado</span>
                                <span x-show="type === 'custom'" x-cloak>Texto Simple</span>
                            </button>
                        </div>
                        
                        <!-- Input Simple -->
                        <div x-show="type === 'simple'" x-collapse>
                            <input type="text" x-model="text" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                   placeholder="Ej: Lun - Sab, 8am a 6pm">
                        </div>

                        <!-- Constructor Custom -->
                        <div x-show="type === 'custom'" x-collapse x-cloak 
                             class="bg-slate-50 dark:bg-slate-950 rounded-xl p-2.5 shadow-inner border border-slate-200 dark:border-slate-850 mt-1 transition-colors max-h-[140px] overflow-y-auto custom-scrollbar">
                            <div class="space-y-1.5">
                                <template x-for="day in days" :key="day">
                                    <div class="flex items-center gap-1.5 pb-1.5 border-b border-slate-200 dark:border-slate-800/80 last:border-0 last:pb-0">
                                        <div class="w-14 shrink-0">
                                            <span class="text-[10px] font-bold text-slate-800 dark:text-slate-250" x-text="day"></span>
                                        </div>
                                        <label class="flex items-center gap-1 cursor-pointer shrink-0">
                                            <input type="checkbox" x-model="schedule[day].closed" class="w-3 h-3 rounded border-slate-300 text-primary focus:ring-primary bg-white dark:bg-slate-800 cursor-pointer">
                                            <span class="text-[9px] font-semibold text-slate-400 dark:text-slate-500">Cerrado</span>
                                        </label>
                                        <div class="flex items-center gap-1 flex-grow" :class="schedule[day].closed ? 'opacity-30 pointer-events-none' : ''">
                                            <input type="time" x-model="schedule[day].open" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 rounded px-1 py-0.5 text-[9px] font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                                            <span class="text-slate-400 text-[9px] font-bold">-</span>
                                            <input type="time" x-model="schedule[day].close" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 rounded px-1 py-0.5 text-[9px] font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <input type="hidden" name="work_hours" :value="JSON.stringify({ type: type, text: text, schedule: schedule })">
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="space-y-1" 
                         x-data="{ 
                              methods: '{{ old('payment_methods', $shop->payment_methods ?? '') }}'.split(',').map(i => i.trim()).filter(i => i),
                              availableMethods: [
                                  {name: 'Transferencia', color: 'bg-slate-600 text-white border-slate-600 shadow-sm'},
                                  {name: 'Pago Móvil', color: 'bg-teal-500 text-white border-teal-500 shadow-sm'},
                                  {name: 'Efectivo', color: 'bg-emerald-600 text-white border-emerald-600 shadow-sm'},
                                  {name: 'Zelle', color: 'bg-purple-600 text-white border-purple-600 shadow-sm'},
                                  {name: 'Binance', color: 'bg-yellow-500 text-white border-yellow-500 shadow-sm'},
                                  {name: 'PayPal', color: 'bg-blue-600 text-white border-blue-600 shadow-sm'},
                                  {name: 'Punto de Venta', color: 'bg-indigo-500 text-white border-indigo-500 shadow-sm'}
                              ],
                              toggle(methodName) {
                                  if (this.methods.includes(methodName)) {
                                      this.methods = this.methods.filter(m => m !== methodName);
                                  } else {
                                      this.methods.push(methodName);
                                  }
                              }
                          }">
                        <label class="text-[10px] font-bold text-slate-700 dark:text-slate-300 block mb-0.5">Métodos de Pago</label>
                        <div class="flex flex-wrap gap-1">
                            <template x-for="item in availableMethods" :key="item.name">
                                <button type="button" 
                                        @click="toggle(item.name)"
                                        :class="methods.includes(item.name) ? item.color : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-750 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm'"
                                        class="px-2 py-0.5 rounded-lg border text-[9px] font-bold transition-all duration-300 select-none flex items-center gap-1 focus:outline-none">
                                    <svg x-show="methods.includes(item.name)" class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span x-text="item.name"></span>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="payment_methods" :value="methods.join(', ')">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: APARIENCIA Y ACTIVOS VISUALES -->
        <div x-show="activeTab === 'colores'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4 pt-1">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800/80 pb-3 mb-1">
                <div>
                    <h3 class="text-sm md:text-base font-black text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="bg-primary/10 text-primary text-[9px] uppercase font-extrabold tracking-wider px-2 py-0.5 rounded-md border border-primary/20">
                            Apariencia
                        </span>
                        Diseño y Activos Visuales
                    </h3>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">
                        Personaliza los colores principales de tu catálogo y sube los logotipos e imágenes de tu tienda.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">
                <!-- Columna Izquierda (Controles): Colores y Multimedia (col-span-7) -->
                <div class="lg:col-span-7 space-y-4 flex flex-col justify-between">
                    
                    <!-- Sub-Bloque: Paleta de Colores -->
                    <div class="space-y-2.5 bg-slate-50/50 dark:bg-slate-950/40 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800/80 flex-grow">
                        <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1.5 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/85"></span>
                            Paleta de Colores
                        </h4>
                        <div class="space-y-2">
                            <!-- Color Primario -->
                            <div class="flex items-center justify-between bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-3 rounded-2xl shadow-sm hover:border-primary/20 transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="relative shrink-0 w-11 h-11 rounded-full border-2 border-white dark:border-slate-850 shadow cursor-pointer transition active:scale-95 duration-200" 
                                         :style="'background-color: ' + colorPrimary"
                                         onclick="document.getElementById('color_primary').click()">
                                        <input type="color" id="color_primary" name="color_primary" x-model="colorPrimary" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                    </div>
                                    <div class="text-left">
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-100 block">Color Principal</span>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 block leading-tight">Botones, acciones y acentos</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase shrink-0">HEX</span>
                                    <input type="text" x-model="colorPrimary" class="w-20 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-xl px-2 py-1 text-[10px] font-black text-slate-800 dark:text-slate-250 focus:outline-none uppercase text-center h-[28px] focus:border-primary focus:ring-1 focus:ring-primary shadow-sm transition-all">
                                </div>
                            </div>

                            <!-- Color Secundario -->
                            <div class="flex items-center justify-between bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-3 rounded-2xl shadow-sm hover:border-secondary/20 transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="relative shrink-0 w-11 h-11 rounded-full border-2 border-white dark:border-slate-850 shadow cursor-pointer transition active:scale-95 duration-200" 
                                         :style="'background-color: ' + colorSecondary"
                                         onclick="document.getElementById('color_secondary').click()">
                                        <input type="color" id="color_secondary" name="color_secondary" x-model="colorSecondary" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                    </div>
                                    <div class="text-left">
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-100 block">Color Secundario</span>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 block leading-tight">Títulos, badges y textos principales</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase shrink-0">HEX</span>
                                    <input type="text" x-model="colorSecondary" class="w-20 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-xl px-2 py-1 text-[10px] font-black text-slate-800 dark:text-slate-250 focus:outline-none uppercase text-center h-[28px] focus:border-primary focus:ring-1 focus:ring-primary shadow-sm transition-all">
                                </div>
                            </div>

                            <!-- Color de Fondo -->
                            <div class="flex items-center justify-between bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-3 rounded-2xl shadow-sm hover:border-slate-350 dark:hover:border-slate-700 transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="relative shrink-0 w-11 h-11 rounded-full border-2 border-white dark:border-slate-850 shadow cursor-pointer transition active:scale-95 duration-200" 
                                         :style="'background-color: ' + colorBackground"
                                         onclick="document.getElementById('color_background').click()">
                                        <input type="color" id="color_background" name="color_background" x-model="colorBackground" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                    </div>
                                    <div class="text-left">
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-100 block">Fondo del Menú</span>
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 block leading-tight">Fondo general del catálogo</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase shrink-0">HEX</span>
                                    <input type="text" x-model="colorBackground" class="w-20 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-xl px-2 py-1 text-[10px] font-black text-slate-800 dark:text-slate-250 focus:outline-none uppercase text-center h-[28px] focus:border-primary focus:ring-1 focus:ring-primary shadow-sm transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-Bloque: Activos Visuales -->
                    <div class="space-y-2.5 bg-slate-50/50 dark:bg-slate-950/40 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-800/80 shrink-0">
                        <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1.5 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary/85"></span>
                            Activos Visuales
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Cargar Logo -->
                            <div class="border border-dashed border-slate-200 dark:border-slate-750 p-2.5 rounded-2xl hover:border-primary/50 transition-colors duration-300 bg-white dark:bg-slate-900 flex items-center gap-3 relative min-h-[75px] cursor-pointer shadow-sm shadow-slate-100/50" onclick="document.getElementById('logo-input').click()">
                                <input type="file" name="logo" accept="image/*" class="hidden" id="logo-input" onchange="previewImage(this, 'logo-preview')">
                                <div class="w-11 h-11 rounded-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                    @if($shop->logo_path)
                                        <img id="logo-preview" src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path) }}" alt="Logo" class="w-full h-full object-cover">
                                    @else
                                        <svg id="logo-preview-placeholder" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                                        <img id="logo-preview" class="w-full h-full object-cover hidden">
                                    @endif
                                </div>
                                <div class="flex-grow text-left">
                                    <span class="text-[10px] font-black text-slate-800 dark:text-slate-150 block leading-tight">Logo Comercial</span>
                                    <span class="text-[8px] text-slate-400 dark:text-slate-500 block mt-0.5">500x500px</span>
                                    <span class="inline-block mt-1 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 text-slate-650 dark:text-slate-350 text-[8px] font-bold px-1.5 py-0.5 rounded shadow-sm hover:brightness-105 transition-all">Cambiar</span>
                                </div>
                            </div>

                            <!-- Cargar Portada -->
                            <div class="border border-dashed border-slate-200 dark:border-slate-750 p-2.5 rounded-2xl hover:border-primary/50 transition-colors duration-300 bg-white dark:bg-slate-900 flex items-center gap-3 relative min-h-[75px] cursor-pointer shadow-sm shadow-slate-100/50" onclick="document.getElementById('cover-input').click()">
                                <input type="file" name="cover" accept="image/*" class="hidden" id="cover-input" onchange="previewImage(this, 'cover-preview')">
                                <div class="w-16 h-11 rounded-lg bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-750 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                    @if($shop->cover_path)
                                        <img id="cover-preview" src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="Portada" class="w-full h-full object-cover">
                                    @else
                                        <svg id="cover-preview-placeholder" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                        <img id="cover-preview" class="w-full h-full object-cover hidden">
                                    @endif
                                </div>
                                <div class="flex-grow text-left">
                                    <span class="text-[10px] font-black text-slate-800 dark:text-slate-150 block leading-tight">Portada / Banner</span>
                                    <span class="text-[8px] text-slate-400 dark:text-slate-500 block mt-0.5">1200x480px</span>
                                    <span class="inline-block mt-1 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 text-slate-650 dark:text-slate-350 text-[8px] font-bold px-1.5 py-0.5 rounded shadow-sm hover:brightness-105 transition-all">Cambiar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha (Smartphone Mockup): col-span-5 -->
                <div class="lg:col-span-5 flex flex-col items-center justify-center p-4 bg-slate-50/50 dark:bg-slate-950/20 border border-slate-100 dark:border-slate-800/85 rounded-3xl min-h-[350px]">
                    <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2.5 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Simulador de Catálogo en Vivo
                    </span>
                    
                    <!-- Smartphone Mockup Container -->
                    <div class="w-[215px] bg-slate-900 dark:bg-slate-950 p-2 rounded-[2.2rem] shadow-xl border-4 border-slate-800/90 select-none transform scale-95 origin-center">
                        <div class="bg-white dark:bg-slate-900 rounded-[1.8rem] overflow-hidden relative min-h-[340px] flex flex-col justify-between transition-colors duration-300"
                             :style="'background-color: ' + colorBackground">
                            
                            <!-- Cover Banner inside mockup -->
                            <div class="relative h-18 bg-slate-800 overflow-hidden shrink-0 shadow-inner">
                                @if($shop->cover_path)
                                    <img id="mock-cover-preview" src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="Mock Portada" class="w-full h-full object-cover">
                                @else
                                    <div id="mock-cover-preview-placeholder" class="w-full h-full bg-slate-700 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                    </div>
                                    <img id="mock-cover-preview" class="w-full h-full object-cover hidden">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-transparent"></div>
                            </div>
                            
                            <!-- Logo inside mockup (overlapping banner) -->
                            <div class="absolute top-[46px] left-1/2 -translate-x-1/2 w-10 h-10 rounded-full border-2 border-white dark:border-slate-850 bg-white dark:bg-slate-900 shadow overflow-hidden z-20">
                                @if($shop->logo_path)
                                    <img id="mock-logo-preview" src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path) }}" alt="Mock Logo" class="w-full h-full object-cover">
                                @else
                                    <div id="mock-logo-preview-placeholder" class="w-full h-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[7px] font-black text-slate-400 uppercase tracking-wider">Logo</div>
                                    <img id="mock-logo-preview" class="w-full h-full object-cover hidden">
                                @endif
                            </div>
                            
                            <!-- Store Information in mockup -->
                            <div class="pt-5 px-3 text-center shrink-0">
                                <h5 class="text-[10px] font-black tracking-tight leading-none truncate" :style="'color: ' + colorSecondary">
                                    {{ $shop->name }}
                                </h5>
                                <p class="text-[7.5px] text-slate-400 mt-0.5 flex items-center justify-center gap-0.5">
                                    <svg class="w-1.5 h-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                                    <span class="truncate">{{ Str::limit($shop->address ?? 'Ubicación Física', 20) }}</span>
                                </p>
                            </div>
                            
                            <!-- Horizontal category chips in mockup -->
                            <div class="flex gap-1 overflow-x-auto px-3 py-1.5 scrollbar-none shrink-0 mt-1 select-none">
                                <span class="px-2 py-0.5 rounded-full text-[7.5px] font-black text-white shrink-0 shadow-sm transition-colors duration-300"
                                      :style="'background-color: ' + colorPrimary">
                                    Todas
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[7.5px] font-bold bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-750 shrink-0 select-none shadow-sm">
                                    Bebidas
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[7.5px] font-bold bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-750 shrink-0 select-none shadow-sm">
                                    Platos
                                </span>
                            </div>
                            
                            <!-- Sample Product Card in mockup -->
                            <div class="px-3 pb-3.5 flex-grow flex flex-col justify-end mt-1">
                                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 p-2 rounded-2xl shadow-sm flex items-center justify-between gap-1.5 w-full">
                                    <div class="flex items-center gap-1.5 overflow-hidden">
                                        <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-750 flex items-center justify-center overflow-hidden shrink-0">
                                            <svg class="w-3 h-3 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                        </div>
                                        <div class="text-left overflow-hidden">
                                            <span class="text-[8.5px] font-black text-slate-850 dark:text-slate-200 block truncate leading-tight">Hamburguesa Criolla</span>
                                            <span class="text-[7.5px] text-slate-400 block leading-tight font-extrabold">$8.99</span>
                                        </div>
                                    </div>
                                    <button type="button" class="w-4.5 h-4.5 rounded-full text-white flex items-center justify-center shadow transition-all duration-300 shrink-0 cursor-default"
                                            :style="'background-color: ' + colorPrimary">
                                        <span class="text-[9px] font-black leading-none">+</span>
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: SEGURIDAD -->
        <div x-show="activeTab === 'seguridad'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4 pt-1">
            <div>
                <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                    Seguridad de la Cuenta
                </span>
                <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                    Cambiar Contraseña de Administrador
                </h3>
                <p class="text-xs text-slate-400 dark:text-slate-500">
                    Actualiza tu contraseña de acceso a este panel de administración. Déjala en blanco si no deseas cambiarla.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nueva Contraseña -->
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-bold text-slate-700 dark:text-slate-300">Nueva Contraseña</label>
                    <input type="password" id="password" name="password" 
                           class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold @error('password') border-red-500 @enderror" 
                           placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar Nueva Contraseña -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-bold text-slate-700 dark:text-slate-300">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" 
                           placeholder="Repite la contraseña">
                </div>
            </div>
        </div>

        <!-- Botón de Guardado Global -->
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80">
            <button type="submit" class="w-full bg-primary hover:brightness-105 text-white font-extrabold py-3.5 rounded-2xl transition shadow-lg shadow-primary/20 text-xs active:scale-[0.99]">
                Guardar Cambios Visuales
            </button>
        </div>
    </form>

    <!-- TAB 4: COMPONENTE GESTIÓN DE ENLACE CORTO -->
    <div x-show="activeTab === 'enlaces'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" 
         class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2rem] p-6 md:p-8 shadow-sm relative transition-colors duration-300" 
         x-data="{ showToast: false }">
        <div class="absolute -right-12 -top-12 w-28 h-28 bg-primary/5 rounded-full blur-xl"></div>

        <!-- Encabezado del Módulo -->
        <div class="mb-6">
            <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                Marketing y Redes
            </span>
            <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                Enlace Corto Personalizado
            </h3>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                Configura una palabra clave corta y fácil de recordar para compartir tu menú digital en Instagram, TikTok o tarjetas de presentación.
            </p>
        </div>

        @if(session('success_short_link'))
            <div class="bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 text-xs font-semibold p-4 rounded-xl border border-emerald-100 dark:border-emerald-900/50 mb-6 transition-colors">
                {{ session('success_short_link') }}
            </div>
        @endif

        <!-- A. COMPONENTE "COPIAR LINK" -->
        @if($shortLink = $shop->shortLinks()->first())
            <div class="bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-850 rounded-2xl p-4 md:p-6 mb-6 shadow-inner">
                <span class="text-[10px] uppercase font-extrabold text-slate-400 dark:text-slate-500 tracking-wider block mb-2">Enlace Corto Activo</span>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="flex-grow bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 flex items-center justify-between text-xs md:text-sm text-slate-800 dark:text-slate-200 font-bold select-all overflow-x-auto shadow-sm">
                        <span>{{ str_replace(['http://', 'https://'], '', url('/l/' . $shortLink->code)) }}</span>
                        <span class="text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded font-normal shrink-0 ml-2">Activo</span>
                    </div>
                    
                    <button type="button" 
                            @click="navigator.clipboard.writeText('{{ url('/l/' . $shortLink->code) }}'); showToast = true; setTimeout(() => { showToast = false }, 2500);"
                            class="bg-primary hover:brightness-105 text-white font-extrabold px-6 py-3 rounded-xl flex items-center justify-center gap-2 active:scale-95 transition text-xs shrink-0 shadow-md shadow-primary/10">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copiar Enlace
                    </button>
                </div>

                <!-- Métricas del Enlace -->
                <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold shadow-sm">
                        📊 {{ $shortLink->clicks_count }} {{ $shortLink->clicks_count == 1 ? 'visita' : 'visitas' }}
                    </span>
                    <span>Registrado desde el acortador interno.</span>
                </div>
            </div>
        @endif

        <!-- B. FORMULARIO DE ASIGNACIÓN -->
        <form action="/{{ $shop->slug }}/admin/settings/short-link" method="POST" class="space-y-4">
            @csrf
            <div class="form-group space-y-1.5">
                <label for="code" class="text-xs font-bold text-slate-700 dark:text-slate-300">Palabra clave o prefijo corto</label>
                
                <div class="flex items-stretch rounded-xl border border-slate-200 dark:border-slate-750 overflow-hidden focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15 transition shadow-sm bg-slate-50 dark:bg-slate-850 shadow-inner">
                    <span class="bg-slate-100 dark:bg-slate-900 border-r border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 px-4 py-3 flex items-center text-xs md:text-sm font-bold select-none shrink-0">
                        wistore.com/l/
                    </span>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code', $shop->shortLinks()->first()?->code) }}" 
                           placeholder="ej: {{ $shop->slug }}" 
                           required 
                           class="w-full px-4 py-3 text-xs md:text-sm text-slate-800 dark:text-slate-100 font-bold placeholder-slate-400 focus:outline-none bg-transparent">
                </div>

                @error('code')
                    <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                    Usa palabras simples, sin espacios ni caracteres especiales. Ej: 'ys', 'detallitos', 'regalos'.
                </p>
            </div>

            <button type="submit" 
                    class="bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white dark:text-slate-200 font-extrabold py-3.5 px-6 rounded-xl transition text-xs active:scale-[0.98] w-full sm:w-auto shadow shadow-slate-900/10">
                Guardar Enlace Corto
            </button>
        </form>

        <!-- TOAST NOTIFICATION FLOTANTE -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 md:left-auto md:right-8 md:-translate-x-0 z-50 pointer-events-none"
             x-show="showToast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 md:translate-y-0 md:translate-x-4"
             x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-4 md:translate-y-0 md:translate-x-4"
             style="display: none;">
            <div class="bg-slate-900 text-white text-xs md:text-sm font-semibold py-3.5 px-6 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-800">
                <span class="text-emerald-400">✨</span>
                ¡Enlace copiado al portapapeles! Listo para compartir.
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // 1. Update standard preview in the upload card
                var previewImg = document.getElementById(previewId);
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }
                
                // Hide standard placeholder svg if it exists
                var placeholder = document.getElementById(previewId + '-placeholder');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }

                // 2. Update live mockup preview in the smartphone simulator
                var mockPreviewId = 'mock-' + previewId;
                var mockPreviewImg = document.getElementById(mockPreviewId);
                if (mockPreviewImg) {
                    mockPreviewImg.src = e.target.result;
                    mockPreviewImg.classList.remove('hidden');
                }

                // Hide mockup placeholder if it exists
                var mockPlaceholder = document.getElementById(mockPreviewId + '-placeholder');
                if (mockPlaceholder) {
                    mockPlaceholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
