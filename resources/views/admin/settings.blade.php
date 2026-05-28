@extends('layouts.admin')

@section('title', 'Configuración Visual')
@section('subtitle', 'Configuración')
@section('header_title', 'Ajustes Visuales')

@section('content')
@include('partials.settings.css')

@php
    $showAdvancedSettings = in_array($shop->plan ?? 'standard', ['premium', 'vip', 'free_trial'], true);
@endphp

<div class="settings-page space-y-5 md:space-y-6 max-w-5xl lg:max-w-6xl">

    <!-- Tabs de Navegación -->
    <div class="settings-tabs flex overflow-x-auto gap-2 md:gap-2.5 pb-2 hide-scrollbar">
        <button type="button" onclick="showTab('comercio')" id="tab-comercio"
                class="tab-btn active px-4 py-2.5 md:px-5 md:py-3 rounded-xl text-xs md:text-sm transition-all whitespace-nowrap border flex items-center gap-2 bg-primary text-white font-black shadow-md shadow-primary/20 border-primary">
            <svg class="w-4 h-4 md:w-[1.125rem] md:h-[1.125rem]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Datos Comerciales
        </button>
        <button type="button" onclick="showTab('colores')" id="tab-colores"
                class="tab-btn px-4 py-2.5 md:px-5 md:py-3 rounded-xl text-xs md:text-sm transition-all whitespace-nowrap border flex items-center gap-2 ui-surface text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm">
            <svg class="w-4 h-4 md:w-[1.125rem] md:h-[1.125rem]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
            Apariencia & Activos
        </button>
        @if($showAdvancedSettings)
        <button type="button" onclick="showTab('avanzado')" id="tab-avanzado"
                class="tab-btn px-4 py-2.5 md:px-5 md:py-3 rounded-xl text-xs md:text-sm transition-all whitespace-nowrap border flex items-center gap-2 ui-surface text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm">
            <svg class="w-4 h-4 md:w-[1.125rem] md:h-[1.125rem]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            Ajustes Avanzados
        </button>
        @endif
        <button type="button" onclick="showTab('seguridad')" id="tab-seguridad"
                class="tab-btn px-4 py-2.5 md:px-5 md:py-3 rounded-xl text-xs md:text-sm transition-all whitespace-nowrap border flex items-center gap-2 ui-surface text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm">
            <svg class="w-4 h-4 md:w-[1.125rem] md:h-[1.125rem]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Seguridad
        </button>
    </div>



    <!-- Formulario de Configuración Principal -->
    <form action="/{{ $shop->slug }}/admin/settings" method="POST" enctype="multipart/form-data"
          class="settings-form-card ui-card rounded-3xl p-4 md:p-6 lg:p-7 shadow-sm space-y-3.5 md:space-y-5 transition-colors duration-300">
        @csrf
        @method('PUT')

        @include('partials.settings.comercio-tab')

        <!-- TAB 2: APARIENCIA & ACTIVOS -->
        <div id="content-colores" class="tab-content space-y-3 pt-1"
             x-data="{ sections: { colores: true, modulos: {{ count($shop->enabled_modules ?? []) > 3 ? 'true' : 'false' }} }, openPanel: 'colores', togglePanel(id) { this.openPanel = this.openPanel === id ? null : id; }, enableSection(id) { this.sections[id] = true; this.openPanel = id; } }">
            <p class="text-[11px] md:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                Colores y módulos del panel. Activa cada bloque cuando quieras editarlo.
            </p>

            <x-settings-section id="colores" title="Colores de marca" subtitle="Primario, secundario y fondo del catálogo." icon="🎨" :optional="false">
                    <div class="grid grid-cols-3 gap-3 md:gap-4 max-w-lg lg:max-w-xl">
                        <!-- Color Primario -->
                        <div class="ui-card border rounded-xl p-3 flex flex-col items-center gap-2 shadow-sm">
                            <span class="text-[9px] font-black text-slate-500 dark:text-slate-450 uppercase tracking-widest">Primario</span>
                            <div class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 dark:border-slate-700 shadow-md cursor-pointer hover:scale-105 transition-transform duration-200">
                                <div class="absolute inset-0" id="preview-primary" style="background-color: {{ $shop->color_primary ?? '#E60067' }}"></div>
                                <input type="color" id="color_primary" name="color_primary" value="{{ $shop->color_primary ?? '#E60067' }}"
                                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                       oninput="updateColorPreview('color_primary', 'preview-primary')">
                            </div>
                            <span class="text-[9px] text-slate-400 font-mono">{{ $shop->color_primary ?? '#E60067' }}</span>
                        </div>

                        <!-- Color Secundario -->
                        <div class="ui-card border rounded-xl p-3 flex flex-col items-center gap-2 shadow-sm">
                            <span class="text-[9px] font-black text-slate-500 dark:text-slate-450 uppercase tracking-widest">Secundario</span>
                            <div class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 dark:border-slate-700 shadow-md cursor-pointer hover:scale-105 transition-transform duration-200">
                                <div class="absolute inset-0" id="preview-secondary" style="background-color: {{ $shop->color_secondary ?? '#C6A100' }}"></div>
                                <input type="color" id="color_secondary" name="color_secondary" value="{{ $shop->color_secondary ?? '#C6A100' }}"
                                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                       oninput="updateColorPreview('color_secondary', 'preview-secondary')">
                            </div>
                            <span class="text-[9px] text-slate-400 font-mono">{{ $shop->color_secondary ?? '#C6A100' }}</span>
                        </div>

                        <!-- Color de Fondo -->
                        <div class="ui-card border rounded-xl p-3 flex flex-col items-center gap-2 shadow-sm">
                            <span class="text-[9px] font-black text-slate-500 dark:text-slate-450 uppercase tracking-widest">Fondo</span>
                            <div class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 dark:border-slate-700 shadow-md cursor-pointer hover:scale-105 transition-transform duration-200">
                                <div class="absolute inset-0" id="preview-background" style="background-color: {{ $shop->color_background ?? '#0b0f19' }}"></div>
                                <input type="color" id="color_background" name="color_background" value="{{ $shop->color_background ?? '#0b0f19' }}"
                                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                       oninput="updateColorPreview('color_background', 'preview-background')">
                            </div>
                            <span class="text-[9px] text-slate-400 font-mono">{{ $shop->color_background ?? '#0b0f19' }}</span>
                        </div>
                    </div>
            </x-settings-section>

            <x-settings-section id="modulos" title="Módulos del menú admin" subtitle="Elige qué secciones verás en el panel lateral." icon="🧩">
                    @php
                        $modules = $shop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals'];
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <!-- Categorías -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                📦
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Categorías</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Agrupador de productos</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="categories" class="sr-only peer" {{ in_array('categories', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Productos -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                🍔
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Productos</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Catálogo de productos</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="products" class="sr-only peer" {{ in_array('products', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Pedidos -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                📋
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Pedidos</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Pedidos de clientes</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="orders" class="sr-only peer" {{ in_array('orders', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Clientes -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                👥
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Clientes</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Base de datos de clientes</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="clients" class="sr-only peer" {{ in_array('clients', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Facturas -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                🧾
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Facturas</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Comprobantes y reportes de facturación</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="invoices" class="sr-only peer" {{ in_array('invoices', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Delivery -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                🛵
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Delivery</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Tarifas de envío y motorizados</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="delivery" class="sr-only peer" {{ in_array('delivery', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Analítica -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                📊
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Analítica</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Estadísticas y reportes de ventas</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="analytics" class="sr-only peer" {{ in_array('analytics', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Referidos -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                🔗
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Referidos</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Enlaces de recomendación y promotores</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="referrals" class="sr-only peer" {{ in_array('referrals', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <!-- Marketing -->
                    <div class="flex items-center justify-between p-2 rounded-xl ui-card shadow-sm animate-fade-in">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">
                                📢
                            </span>
                            <div>
                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-250">Marketing</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500">Banners y avisos del menú</div>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="enabled_modules[]" value="announcements" class="sr-only peer" {{ in_array('announcements', $modules) ? 'checked' : '' }}>
                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                    </div>
            </x-settings-section>
        </div>
        @if($showAdvancedSettings)
        <!-- TAB 4: AJUSTES AVANZADOS -->
        <div id="content-avanzado" class="tab-content space-y-4 pt-1 hidden">
            <div>
                <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                    Ajustes Avanzados
                </span>
                <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                    Dominio Personalizado y Tracking Pixels
                </h3>
                <p class="text-xs text-slate-400 dark:text-slate-500">
                    Configura tu propio dominio web y vincula tus píxeles de seguimiento para analizar el tráfico de clientes en tu menú digital.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Columna Izquierda: Dominio Personalizado -->
                <div class="space-y-3.5 ui-inset p-4 rounded-2xl border border-slate-100 dark:border-slate-800/80 flex flex-col justify-between">
                    <div class="space-y-3.5">
                        <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/80"></span>Dominio Personalizado
                        </h4>
                        <div class="space-y-1">
                            <label for="custom_domain" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Tu Dominio Web</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-3 text-slate-400 text-xs"><i class="fas fa-globe"></i></span>
                                <input type="text" id="custom_domain" name="custom_domain" 
                                       class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                       value="{{ old('custom_domain', $shop->custom_domain) }}" placeholder="e.g. mi-tienda.com">
                            </div>
                            <span class="text-[9px] text-slate-400 dark:text-slate-500 block leading-normal mt-1">
                                Apunta un CNAME de tu dominio a <strong class="text-primary">cname.wi-store.com</strong> y regístralo aquí para personalizar la dirección de tu tienda digital.
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Pixeles de Seguimiento -->
                <div class="space-y-3.5 ui-inset p-4 rounded-2xl border border-slate-100 dark:border-slate-800/80">
                    <h4 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary/80"></span>Tracking & Analítica Pixels
                    </h4>
                    
                    <!-- Facebook Pixel -->
                    <div class="space-y-1">
                        <label for="facebook_pixel_id" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Facebook Pixel ID</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-450 text-xs"><i class="fab fa-facebook-f"></i></span>
                            <input type="text" id="facebook_pixel_id" name="facebook_pixel_id" 
                                   class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('facebook_pixel_id', $shop->facebook_pixel_id) }}" placeholder="e.g. 123456789012345">
                        </div>
                    </div>

                    <!-- TikTok Pixel -->
                    <div class="space-y-1">
                        <label for="tiktok_pixel_id" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">TikTok Pixel ID</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-450 text-xs"><i class="fab fa-tiktok"></i></span>
                            <input type="text" id="tiktok_pixel_id" name="tiktok_pixel_id" 
                                   class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('tiktok_pixel_id', $shop->tiktok_pixel_id) }}" placeholder="e.g. C1234567890ABC">
                        </div>
                    </div>

                    <!-- Google Analytics ID -->
                    <div class="space-y-1">
                        <label for="google_analytics_id" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Google Analytics (G-XXXXX)</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-450 text-xs"><i class="fab fa-google"></i></span>
                            <input type="text" id="google_analytics_id" name="google_analytics_id" 
                                   class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('google_analytics_id', $shop->google_analytics_id) }}" placeholder="e.g. G-ABC123XYZ">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pasarelas de Pago Directo (Automático) -->
            <div class="mt-6">
                <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                    Suscripción Negocio
                </span>
                <h4 class="text-xs md:text-sm font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                    Pasarelas de Pago Directo (Conciliación Automática)
                </h4>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mb-4 leading-relaxed">
                    Activa pasarelas de pago para cobrar directamente en tu menú digital. Si se configuran, tus clientes podrán pagar en línea al instante.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Stripe Card -->
                    <div class="ui-inset p-5 rounded-3xl border border-slate-100 dark:border-slate-800/80 space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fab fa-stripe text-indigo-500 text-lg"></i> Stripe Credit Cards
                                </span>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="checkbox" name="stripe_enabled" value="1" class="sr-only peer" {{ $shop->stripe_enabled ? 'checked' : '' }}>
                                    <div class="relative w-[30px] h-[16px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[1px] after:left-[1px] after:bg-white after:rounded-full after:h-[14px] after:w-[14px] after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-normal">
                                Permite cobros con tarjetas de crédito Visa, Mastercard y American Express de forma segura e inmediata.
                            </p>
                        </div>
                        <div class="space-y-2">
                            <div class="space-y-1">
                                <label for="stripe_publishable_key" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Stripe Publishable Key</label>
                                <input type="text" id="stripe_publishable_key" name="stripe_publishable_key" class="w-full ui-field border rounded-xl px-3 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('stripe_publishable_key', $shop->stripe_publishable_key) }}" placeholder="pk_test_...">
                            </div>
                            <div class="space-y-1">
                                <label for="stripe_secret_key" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Stripe Secret Key</label>
                                <input type="password" id="stripe_secret_key" name="stripe_secret_key" class="w-full ui-field border rounded-xl px-3 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('stripe_secret_key', $shop->stripe_secret_key) }}" placeholder="sk_test_...">
                            </div>
                        </div>
                    </div>

                    <!-- Binance Pay Card -->
                    <div class="ui-inset p-5 rounded-3xl border border-slate-100 dark:border-slate-800/80 space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-coins text-amber-500 text-sm"></i> Binance Pay (USDT)
                                </span>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="checkbox" name="binance_enabled" value="1" class="sr-only peer" {{ $shop->binance_enabled ? 'checked' : '' }}>
                                    <div class="relative w-[30px] h-[16px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[1px] after:left-[1px] after:bg-white after:rounded-full after:h-[14px] after:w-[14px] after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-normal">
                                Recibe criptomonedas directamente en tu cuenta de Binance Merchant a través de un código QR dinámico.
                            </p>
                        </div>
                        <div class="space-y-2">
                            <div class="space-y-1">
                                <label for="binance_api_key" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Binance API Key</label>
                                <input type="text" id="binance_api_key" name="binance_api_key" class="w-full ui-field border rounded-xl px-3 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('binance_api_key', $shop->binance_api_key) }}" placeholder="API Key...">
                            </div>
                            <div class="space-y-1">
                                <label for="binance_secret_key" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Binance Secret Key</label>
                                <input type="password" id="binance_secret_key" name="binance_secret_key" class="w-full ui-field border rounded-xl px-3 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('binance_secret_key', $shop->binance_secret_key) }}" placeholder="Secret Key...">
                            </div>
                        </div>
                    </div>

                    <!-- Pago Móvil Direct Card -->
                    <div class="ui-inset p-5 rounded-3xl border border-slate-100 dark:border-slate-800/80 space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <i class="fas fa-mobile-alt text-teal-500 text-sm"></i> Pago Móvil Directo
                                </span>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="checkbox" name="pagomovil_enabled" value="1" class="sr-only peer" {{ $shop->pagomovil_enabled ? 'checked' : '' }}>
                                    <div class="relative w-[30px] h-[16px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:peer-checked:after:translate-x-[14px] peer-toggle after:content-none after:absolute after:top-[1px] after:left-[1px] after:bg-white after:rounded-full after:h-[14px] after:w-[14px] after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-normal">
                                Solicita y registra el número de referencia del Pago Móvil para conciliar y procesar tus ventas en bolívares de inmediato.
                            </p>
                        </div>
                        <div class="space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label for="pagomovil_bank" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Banco</label>
                                    <input type="text" id="pagomovil_bank" name="pagomovil_bank" class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('pagomovil_bank', $shop->pagomovil_bank) }}" placeholder="e.g. Banesco">
                                </div>
                                <div class="space-y-1">
                                    <label for="pagomovil_id" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Cédula / RIF</label>
                                    <input type="text" id="pagomovil_id" name="pagomovil_id" class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('pagomovil_id', $shop->pagomovil_id) }}" placeholder="e.g. V-12345678">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label for="pagomovil_phone" class="text-[9px] font-bold text-slate-655 dark:text-slate-350">Teléfono Pago Móvil</label>
                                <input type="text" id="pagomovil_phone" name="pagomovil_phone" class="w-full ui-field border rounded-xl px-3 py-1.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold" value="{{ old('pagomovil_phone', $shop->pagomovil_phone) }}" placeholder="e.g. 04125556677">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endif

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
                           class="w-full ui-inset border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold @error('password') border-red-500 @enderror" 
                           placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <span class="text-red-500 text-[10px] font-bold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar Nueva Contraseña -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="text-xs font-bold text-slate-700 dark:text-slate-300">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full ui-inset border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" 
                           placeholder="Repite la contraseña">
                </div>
            </div>
        </div>

        <!-- Botón de Guardado Global -->
        <div class="settings-save-bar pt-4 md:pt-5 mt-2 pb-2 border-t border-slate-100 dark:border-slate-800/80">
            <button type="submit" class="settings-save-btn w-full bg-primary hover:brightness-105 text-white font-extrabold py-3.5 md:py-4 rounded-2xl transition shadow-lg shadow-primary/20 text-sm md:text-base active:scale-[0.99]">
                Guardar configuración
            </button>
        </div>
    </form>

    <form id="shop-short-link-form" action="/{{ $shop->slug }}/admin/settings/short-link" method="POST" class="hidden">
        @csrf
    </form>
</div>

@push('scripts')
    @include('partials.settings.js')
@endpush
@endsection
