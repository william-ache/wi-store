@extends('layouts.admin')

@section('title', 'Configuración Visual')
@section('subtitle', 'Configuración')
@section('header_title', 'Ajustes Visuales')

@section('content')
@include('partials.settings.css')

<div class="space-y-6">

    <!-- Tabs de Navegación -->
    <div class="flex overflow-x-auto gap-2 pb-2 hide-scrollbar">
        <button type="button" onclick="showTab('comercio')" id="tab-comercio"
                class="tab-btn active px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2 bg-primary text-white font-black shadow-md shadow-primary/20 border-primary">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Datos Comerciales
        </button>
        <button type="button" onclick="showTab('colores')" id="tab-colores"
                class="tab-btn px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
            Apariencia & Activos
        </button>
        <button type="button" onclick="showTab('seguridad')" id="tab-seguridad"
                class="tab-btn px-4 py-2.5 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Seguridad
        </button>
    </div>

    <!-- Formulario de Configuración Principal -->
    <form action="/{{ $shop->slug }}/admin/settings" method="POST" enctype="multipart/form-data"
          class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-4 md:p-5 shadow-sm space-y-3.5 transition-colors duration-300">
        @csrf
        @method('PUT')

        <!-- TAB 1: IDENTIDAD COMERCIAL -->
        <div id="content-comercio" class="tab-content active space-y-3.5 pt-0.5">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

                        <!-- Categoría de la Tienda -->
                        <div class="space-y-0.5">
                            <label for="shop_category" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Categoría de la Tienda</label>
                            <select id="shop_category" name="shop_category" 
                                    class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold"
                                    onchange="updateShopCategoryIcon(this.value)">
                                <option value="">Selecciona una categoría</option>
                                <option value="gastronomia" {{ old('shop_category', $shop->shop_category) == 'gastronomia' ? 'selected' : '' }}>🍽️ Gastronomía</option>
                                <option value="moda_estilo" {{ old('shop_category', $shop->shop_category) == 'moda_estilo' ? 'selected' : '' }}>👗 Moda y Estilo</option>
                                <option value="detalles_regalos" {{ old('shop_category', $shop->shop_category) == 'detalles_regalos' ? 'selected' : '' }}>🎁 Detalles y Regalos</option>
                                <option value="servicios" {{ old('shop_category', $shop->shop_category) == 'servicios' ? 'selected' : '' }}>🔧 Servicios</option>
                                <option value="otros" {{ old('shop_category', $shop->shop_category) == 'otros' ? 'selected' : '' }}>📦 Otros</option>
                            </select>
                            <input type="hidden" id="shop_category_icon" name="shop_category_icon" value="{{ old('shop_category_icon', $shop->shop_category_icon) }}">
                        </div>

                        <!-- WhatsApp de Pedidos -->
                        <div class="space-y-0.5 col-span-1 sm:col-span-2">
                            <label for="whatsapp_number" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">WhatsApp de Pedidos (Soporta Múltiples Números)</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" required placeholder="e.g. 584120000000 o Pedidos:584121111111, Soporte:584122222222">
                            <p class="text-[9px] text-slate-450 dark:text-slate-500 font-medium leading-normal mt-0.5">
                                Si tienes un solo número, colócalo directamente (ej: <code>584120000000</code>). Para múltiples números, colócalos separados por comas y con etiquetas opcionales (ej: <code>Ventas:584121111111, Soporte:584122222222</code>).
                            </p>
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
                                <span id="maps-resolving" class="text-[9px] text-primary font-bold flex items-center gap-1" style="display: none;">
                                    <svg class="animate-spin w-2.5 h-2.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Resolviendo...
                                </span>
                            </div>
                            <input type="text" id="google_maps_link" name="google_maps_link"
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium"
                                   value="{{ old('google_maps_link', $shop->google_maps_link ?? '') }}"
                                   placeholder="https://maps.app.goo.gl/...">
                        </div>
                    </div>

                    <!-- Redes Sociales y Contacto -->
                    <div class="border-t border-slate-200 dark:border-slate-800/80 pt-3.5 mt-3.5 space-y-3">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/80"></span>Redes Sociales
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Facebook -->
                            <div class="space-y-0.5">
                                <label for="facebook" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Facebook URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-facebook-f"></i></span>
                                    <input type="text" id="facebook" name="facebook" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('facebook', $shop->facebook) }}" placeholder="https://facebook.com/pagina">
                                </div>
                            </div>
                            <!-- Instagram -->
                            <div class="space-y-0.5">
                                <label for="instagram" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Instagram URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-instagram"></i></span>
                                    <input type="text" id="instagram" name="instagram" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('instagram', $shop->instagram) }}" placeholder="https://instagram.com/usuario">
                                </div>
                            </div>
                            <!-- TikTok -->
                            <div class="space-y-0.5">
                                <label for="tiktok" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">TikTok URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-tiktok"></i></span>
                                    <input type="text" id="tiktok" name="tiktok" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('tiktok', $shop->tiktok) }}" placeholder="https://tiktok.com/@usuario">
                                </div>
                            </div>
                            <!-- X / Twitter -->
                            <div class="space-y-0.5">
                                <label for="x_twitter" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">X (Twitter) URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 w-4 h-4 flex items-center justify-center pointer-events-none">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="x_twitter" name="x_twitter" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('x_twitter', $shop->x_twitter) }}" placeholder="https://x.com/usuario">
                                </div>
                            </div>
                            <!-- Telegram -->
                            <div class="space-y-0.5">
                                <label for="telegram" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Telegram URL / Usuario</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-telegram-plane"></i></span>
                                    <input type="text" id="telegram" name="telegram" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('telegram', $shop->telegram) }}" placeholder="https://t.me/usuario o @usuario">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto Adicional -->
                    <div class="border-t border-slate-200 dark:border-slate-800/80 pt-3.5 mt-3.5 space-y-3">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/80"></span>Canales de Contacto Alternativos
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Teléfono para llamadas -->
                            <div class="space-y-0.5">
                                <label for="contact_phone" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Teléfono (Llamadas)</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fas fa-phone-alt"></i></span>
                                    <input type="text" id="contact_phone" name="contact_phone" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('contact_phone', $shop->contact_phone) }}" placeholder="e.g. +584120000000">
                                </div>
                            </div>
                            <!-- Teléfono para SMS -->
                            <div class="space-y-0.5">
                                <label for="contact_sms" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Teléfono (SMS / Mensajes)</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fas fa-comment-sms"></i></span>
                                    <input type="text" id="contact_sms" name="contact_sms" 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('contact_sms', $shop->contact_sms) }}" placeholder="e.g. +584120000000">
                                </div>
                            </div>
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

                        <div class="space-y-0.5">
                            <label for="base_currency" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Tasa monetaria</label>
                            <div class="flex gap-2 items-center">
                                <div class="w-[45%]">
                                    <select id="base_currency" name="base_currency"
                                            class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2 py-1.5 text-[11px] text-slate-800 dark:text-slate-250 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold select2-enable"
                                            onchange="fetchExchangeRate()">
                                        <option value="USD" {{ old('base_currency', $shop->base_currency) === 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('base_currency', $shop->base_currency) === 'EUR' ? 'selected' : '' }}>EUR</option>
                                    </select>
                                </div>
                                <div class="relative w-[55%] flex items-center">
                                    <input type="text" name="exchange_rate" id="exchange_rate"
                                           value="{{ old('exchange_rate', $shop->exchange_rate) }}"
                                           class="w-full border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] transition-all shadow-sm font-bold h-[32px] bg-slate-50 dark:bg-slate-850/80 text-slate-500 dark:text-slate-400 cursor-not-allowed select-none focus:outline-none"
                                           placeholder="Tasa oficial" readonly>
                                    <div id="exchange-loading" class="absolute right-2 top-2" style="display: none;">
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
                            <button type="button" onclick="getGPSLocation()"
                                    class="text-[9px] font-bold text-primary hover:brightness-105 flex items-center gap-1 transition-all active:scale-95 duration-200">
                                <span id="gps-icon" class="flex items-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v4M12 18v4M4 12H2M22 12h-4"></path></svg>
                                    Usar GPS
                                </span>
                                <span id="gps-loading" x-cloak class="flex items-center gap-0.5" style="display: none;">
                                    <svg class="animate-spin w-2.5 h-2.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Localizando...
                                </span>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2.5">
                            <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-850 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-750">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase shrink-0">LAT</span>
                                <input type="text" id="latitude" name="latitude"
                                       value="{{ old('latitude', $shop->latitude ?? '') }}"
                                       class="w-full bg-transparent border-0 p-0 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-0 font-medium"
                                       placeholder="10.4806">
                            </div>
                            <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-850 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-750">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase shrink-0">LNG</span>
                                <input type="text" id="longitude" name="longitude"
                                       value="{{ old('longitude', $shop->longitude ?? '') }}"
                                       class="w-full bg-transparent border-0 p-0 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-0 font-medium"
                                       placeholder="-66.9036">
                            </div>
                        </div>
                    </div>

                    <!-- Opciones de Servicio -->
                    <div class="bg-white dark:bg-slate-900/60 p-3.5 rounded-xl border border-slate-150 dark:border-slate-800 space-y-2.5 shadow-sm mt-3">
                        <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">Opciones de Servicio Disponibles</span>
                        
                        <div class="grid grid-cols-1 gap-2">
                            <!-- Comer aquí -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/40 dark:bg-emerald-950/5 border border-emerald-100/50 dark:border-emerald-900/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-utensils"></i>
                                    </span>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Comer aquí</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">Permitir pedidos para mesa</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="has_dine_in" value="0">
                                    <input type="checkbox" name="has_dine_in" value="1" class="sr-only peer" {{ old('has_dine_in', $shop->has_dine_in) ? 'checked' : '' }}>
                                    <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                </label>
                            </div>

                            <!-- Recoger -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-amber-50/40 dark:bg-amber-950/5 border border-amber-100/50 dark:border-amber-900/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-shopping-bag"></i>
                                    </span>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Recoger</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">Permitir pedidos para llevar</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="has_pickup" value="0">
                                    <input type="checkbox" name="has_pickup" value="1" class="sr-only peer" {{ old('has_pickup', $shop->has_pickup) ? 'checked' : '' }}>
                                    <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-500"></div>
                                </label>
                            </div>

                            <!-- Entrega a domicilio -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-blue-50/40 dark:bg-blue-950/5 border border-blue-100/50 dark:border-blue-900/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-motorcycle"></i>
                                    </span>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Entrega a domicilio</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">Permitir envíos delivery</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="has_delivery" value="0">
                                    <input type="checkbox" name="has_delivery" value="1" class="sr-only peer" {{ old('has_delivery', $shop->has_delivery) ? 'checked' : '' }}>
                                    <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-500"></div>
                                </label>
                            </div>

                            <!-- Envío gratis -->
                            <div class="flex flex-col p-2.5 rounded-xl bg-violet-50/40 dark:bg-violet-950/5 border border-violet-100/50 dark:border-violet-900/20 space-y-2.5" x-data="{ enableFreeShipping: {{ old('enable_free_shipping', $shop->enable_free_shipping ?? 0) ? 'true' : 'false' }} }">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-violet-100 dark:bg-violet-950/40 text-violet-600 dark:text-violet-400 flex items-center justify-center text-xs">
                                            <i class="fas fa-gift"></i>
                                        </span>
                                        <div>
                                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Envío Gratis</div>
                                            <div class="text-[9px] text-slate-400 dark:text-slate-500">Ofrecer delivery gratuito a partir de un subtotal</div>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer select-none">
                                        <input type="hidden" name="enable_free_shipping" value="0">
                                        <input type="checkbox" name="enable_free_shipping" value="1" class="sr-only peer" @change="enableFreeShipping = $event.target.checked" :checked="enableFreeShipping" {{ old('enable_free_shipping', $shop->enable_free_shipping ?? 0) ? 'checked' : '' }}>
                                        <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-violet-500"></div>
                                    </label>
                                </div>
                                
                                <div x-show="enableFreeShipping" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-150" class="pl-9 pr-2 space-y-1">
                                    <label for="free_shipping_min_amount" class="text-[9px] font-bold text-slate-600 dark:text-slate-400 block uppercase tracking-wider">Monto Mínimo de Compra</label>
                                    <div class="relative flex items-center">
                                        <span class="absolute left-2.5 text-slate-450 text-[10px] font-black">$</span>
                                        <input type="number" step="0.01" id="free_shipping_min_amount" name="free_shipping_min_amount" 
                                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-lg pl-6 pr-2 py-1 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all font-semibold" 
                                               placeholder="10.00" value="{{ old('free_shipping_min_amount', $shop->free_shipping_min_amount) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios y Comodidades (Amenities) -->
                    <div class="bg-white dark:bg-slate-900/60 p-3.5 rounded-xl border border-slate-150 dark:border-slate-800 space-y-2.5 shadow-sm mt-3">
                        <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">Servicios & Comodidades del Local</span>
                        
                        <div class="grid grid-cols-1 gap-2.5">
                            @php
                                $dbAmenities = $shop->amenities ?? [];
                                $amenitiesList = [
                                    'wifi' => [
                                        'label' => 'Wi-Fi',
                                        'desc' => 'Internet inalámbrico para clientes',
                                        'icon' => 'fas fa-wifi',
                                        'color' => 'blue',
                                        'default' => 'Gratuito'
                                    ],
                                    'parking' => [
                                        'label' => 'Estacionamiento',
                                        'desc' => 'Parqueo para vehículos',
                                        'icon' => 'fas fa-parking',
                                        'color' => 'emerald',
                                        'default' => 'Gratuito'
                                    ],
                                    'restrooms' => [
                                        'label' => 'Baños públicos',
                                        'desc' => 'Sanitarios disponibles',
                                        'icon' => 'fas fa-restroom',
                                        'color' => 'teal',
                                        'default' => 'Gratuito'
                                    ],
                                    'pet_friendly' => [
                                        'label' => 'Pet Friendly',
                                        'desc' => 'Se permiten mascotas',
                                        'icon' => 'fas fa-paw',
                                        'color' => 'indigo',
                                        'default' => 'Sí'
                                    ],
                                    'kids_menu' => [
                                        'label' => 'Menú para Niños',
                                        'desc' => 'Opciones especiales infantiles',
                                        'icon' => 'fas fa-child',
                                        'color' => 'rose',
                                        'default' => 'Disponible'
                                    ],
                                    'reservations' => [
                                        'label' => 'Reservas / Bajo Pedido',
                                        'desc' => 'Platos bajo pedido o mesa reservada',
                                        'icon' => 'fas fa-calendar-alt',
                                        'color' => 'amber',
                                        'default' => 'Bajo pedido'
                                    ],
                                ];
                            @endphp

                            @foreach($amenitiesList as $key => $item)
                                @php
                                    $isEnabled = isset($dbAmenities[$key]['enabled']) ? (bool)$dbAmenities[$key]['enabled'] : false;
                                    $value = isset($dbAmenities[$key]['value']) ? $dbAmenities[$key]['value'] : $item['default'];
                                    
                                    $colorClasses = [
                                        'blue' => 'bg-blue-50/80 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border-blue-100/60 dark:border-blue-900/30 peer-checked:bg-blue-500',
                                        'emerald' => 'bg-emerald-50/80 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border-emerald-100/60 dark:border-emerald-900/30 peer-checked:bg-emerald-500',
                                        'teal' => 'bg-teal-50/80 dark:bg-teal-950/20 text-teal-600 dark:text-teal-400 border-teal-100/60 dark:border-teal-900/30 peer-checked:bg-teal-500',
                                        'indigo' => 'bg-indigo-50/80 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-100/60 dark:border-indigo-900/30 peer-checked:bg-indigo-500',
                                        'rose' => 'bg-rose-50/80 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border-rose-100/60 dark:border-rose-900/30 peer-checked:bg-rose-500',
                                        'amber' => 'bg-amber-50/80 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border-amber-100/60 dark:border-amber-900/30 peer-checked:bg-amber-500',
                                    ][$item['color']];

                                    $btnColor = [
                                        'blue' => 'peer-checked:bg-blue-500',
                                        'emerald' => 'peer-checked:bg-emerald-500',
                                        'teal' => 'peer-checked:bg-teal-500',
                                        'indigo' => 'peer-checked:bg-indigo-500',
                                        'rose' => 'peer-checked:bg-rose-500',
                                        'amber' => 'peer-checked:bg-amber-500',
                                    ][$item['color']];
                                @endphp
                                <div class="flex flex-col p-2.5 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/20 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs {{ explode(' ', $colorClasses)[0] }} {{ explode(' ', $colorClasses)[2] }}">
                                                <i class="{{ $item['icon'] }}"></i>
                                            </span>
                                            <div>
                                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">{{ $item['label'] }}</div>
                                                <div class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">{{ $item['desc'] }}</div>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer select-none">
                                            <input type="hidden" name="amenities[{{ $key }}][enabled]" value="0">
                                            <input type="checkbox" name="amenities[{{ $key }}][enabled]" value="1" class="sr-only peer" {{ $isEnabled ? 'checked' : '' }}>
                                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all {{ $btnColor }}"></div>
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2 pl-9">
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 shrink-0">Etiqueta:</span>
                                        <input type="text" name="amenities[{{ $key }}][value]" value="{{ $value }}" placeholder="Ej: {{ $item['default'] }}"
                                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-lg px-2 py-0.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold shadow-inner">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Horario de Trabajo -->
                    @php
                        $currentHours = old('work_hours', $shop->work_hours);
                        // Decodificar si es string JSON
                        if (is_string($currentHours)) {
                            $decoded = json_decode($currentHours, true);
                            if ($decoded !== null) {
                                $currentHours = $decoded;
                            }
                        }
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
                        $scheduleData = $isCustom && isset($currentHours['schedule']) ? $currentHours['schedule'] : $defaultSchedule;
                    @endphp

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Horario de Trabajo</label>
                            <button type="button"
                                    onclick="toggleWorkHoursType()"
                                    class="text-[8px] font-bold px-1.5 py-0.5 rounded transition-all border bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700">
                                <span id="work-hours-toggle-text">Avanzado</span>
                            </button>
                        </div>

                        <!-- Input Simple -->
                        <div id="work-hours-simple" style="display: {{ $isCustom ? 'none' : 'block' }};">
                            <input type="text" name="work_hours_simple"
                                   value="{{ $simpleText }}"
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium"
                                   placeholder="Ej: Lun - Sab, 8am a 6pm">
                        </div>

                        <!-- Constructor Custom -->
                        <div id="work-hours-custom" style="display: {{ $isCustom ? 'block' : 'none' }};"
                             class="bg-slate-50 dark:bg-slate-950 rounded-xl p-2.5 shadow-inner border border-slate-200 dark:border-slate-850 mt-1 transition-colors max-h-[140px] overflow-y-auto custom-scrollbar">
                            <div class="space-y-1.5">
                                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                    @php
                                        $daySchedule = $scheduleData[$day] ?? ['closed' => false, 'open' => '08:00', 'close' => '18:00'];
                                    @endphp
                                    <div class="flex items-center gap-1.5 pb-1.5 border-b border-slate-200 dark:border-slate-800/80 last:border-0 last:pb-0">
                                        <div class="w-14 shrink-0">
                                            <span class="text-[10px] font-bold text-slate-800 dark:text-slate-250">{{ $day }}</span>
                                        </div>
                                        <label class="flex items-center gap-1 cursor-pointer shrink-0">
                                            <input type="checkbox" name="schedule[{{ $day }}][closed]" value="1" {{ $daySchedule['closed'] ? 'checked' : '' }} class="w-3 h-3 rounded border-slate-300 text-primary focus:ring-primary bg-white dark:bg-slate-800 cursor-pointer">
                                            <span class="text-[9px] font-semibold text-slate-450 dark:text-slate-500">Cerrado</span>
                                        </label>
                                        <div class="flex items-center gap-1 flex-grow {{ $daySchedule['closed'] ? 'opacity-30 pointer-events-none' : '' }}">
                                            <input type="time" name="schedule[{{ $day }}][open]" value="{{ $daySchedule['open'] }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 rounded px-1 py-0.5 text-[9px] font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                                            <span class="text-slate-400 text-[9px] font-bold">-</span>
                                            <input type="time" name="schedule[{{ $day }}][close]" value="{{ $daySchedule['close'] }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 rounded px-1 py-0.5 text-[9px] font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="work_hours_type" id="work_hours_type" value="{{ $isCustom ? 'custom' : 'simple' }}">
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="space-y-1">
                        @php
                            $paymentMethods = $shop->payment_methods ? json_decode($shop->payment_methods, true) : [];
                            if (empty($paymentMethods)) {
                                $paymentMethods = [
                                    'Efectivo' => ['active' => true, 'details' => ''],
                                    'Pago Móvil' => ['active' => true, 'details' => '']
                                ];
                            }
                            $availableMethods = [
                                'Transferencia' => ['color' => 'bg-slate-600 text-white border-slate-600 shadow-sm', 'placeholder' => 'Banco, Número de Cuenta, Titular, RIF...'],
                                'Pago Móvil' => ['color' => 'bg-teal-500 text-white border-teal-500 shadow-sm', 'placeholder' => 'Banco, Teléfono, Cédula...'],
                                'Efectivo' => ['color' => 'bg-emerald-600 text-white border-emerald-600 shadow-sm', 'placeholder' => 'Detalles (ej: Traer sencillo, Se acepta cambio...)'],
                                'Zelle' => ['color' => 'bg-purple-600 text-white border-purple-600 shadow-sm', 'placeholder' => 'Correo de Zelle, Nombre...'],
                                'Binance' => ['color' => 'bg-yellow-500 text-white border-yellow-500 shadow-sm', 'placeholder' => 'Pay ID, Correo, USDT...'],
                                'PayPal' => ['color' => 'bg-blue-600 text-white border-blue-600 shadow-sm', 'placeholder' => 'Correo de cuenta...'],
                                'Punto de Venta' => ['color' => 'bg-indigo-500 text-white border-indigo-500 shadow-sm', 'placeholder' => 'Detalles (ej: Pago directo al retirar/recibir...)']
                            ];
                        @endphp
                        <label class="text-[10px] font-bold text-slate-700 dark:text-slate-300 block mb-0.5">Métodos de Pago</label>
                        <div class="flex flex-wrap gap-1">
                            @foreach($availableMethods as $name => $config)
                                @php
                                    $isActive = isset($paymentMethods[$name]) && $paymentMethods[$name]['active'];
                                @endphp
                                <button type="button"
                                        onclick="togglePaymentMethod('{{ $name }}')"
                                        class="{{ $isActive ? $config['color'] : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-750 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm' }} px-2 py-0.5 rounded-lg border text-[9px] font-bold transition-all duration-300 select-none flex items-center gap-1 focus:outline-none">
                                    @if($isActive)
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    @endif
                                    <span>{{ $name }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Detalle de Datos de Pago -->
                        <div class="mt-3.5 space-y-2" id="payment-details">
                            <label class="text-[10px] font-black text-primary uppercase tracking-widest block">Instrucciones / Datos de Pago</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-[180px] overflow-y-auto custom-scrollbar p-0.5">
                                @foreach($availableMethods as $name => $config)
                                    @php
                                        $isActive = isset($paymentMethods[$name]) && $paymentMethods[$name]['active'];
                                        $details = isset($paymentMethods[$name]) ? ($paymentMethods[$name]['details'] ?? '') : '';
                                    @endphp
                                    <div id="payment-{{ $name }}" class="{{ $isActive ? '' : 'hidden' }} bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-2.5 rounded-xl space-y-1 shadow-sm transition hover:shadow-md">
                                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-200 block">{{ $name }}</span>
                                        <textarea
                                            name="payment_details[{{ $name }}]"
                                            placeholder="{{ $config['placeholder'] }}"
                                            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-lg px-2 py-1 text-[10px] text-slate-800 dark:text-slate-200 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold"
                                            rows="2"
                                        >{{ $details }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <input type="hidden" name="payment_methods" id="payment_methods_json" value="{!! json_encode($paymentMethods) !!}">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: SEGURIDAD -->
        <div id="content-seguridad" class="tab-content space-y-4 pt-1">
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
    <div id="content-comercio-shortlink" class="mt-6 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2rem] p-6 md:p-8 shadow-sm relative overflow-hidden transition-colors duration-300">
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
                            onclick="copyShortLink('{{ url('/l/' . $shortLink->code) }}')"
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
        <div id="toast-notification" class="fixed bottom-6 left-1/2 -translate-x-1/2 md:left-auto md:right-8 md:-translate-x-0 z-50 pointer-events-none"
             style="display: none;">
            <div class="bg-slate-900 text-white text-xs md:text-sm font-semibold py-3.5 px-6 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-800">
                <span class="text-emerald-400">✨</span>
                ¡Enlace copiado al portapapeles! Listo para compartir.
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @include('partials.settings.js')
@endpush
@endsection
