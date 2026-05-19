@extends('layouts.admin')

@section('title', 'Configuración Visual')
@section('subtitle', 'Configuración')
@section('header_title', 'Ajustes Visuales')

@section('content')
<div x-data="{ activeTab: 'comercio' }" class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 text-xs font-semibold p-4 rounded-2xl border border-emerald-100 dark:border-emerald-900/50 transition-colors">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs de Navegación -->
    <div class="flex overflow-x-auto gap-2 pb-2 hide-scrollbar">
        <button type="button" @click="activeTab = 'comercio'" 
                :class="activeTab === 'comercio' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-5 py-3 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Datos Comerciales
        </button>
        <button type="button" @click="activeTab = 'colores'" 
                :class="activeTab === 'colores' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-5 py-3 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
            Apariencia
        </button>
        <button type="button" @click="activeTab = 'imagenes'" 
                :class="activeTab === 'imagenes' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-5 py-3 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            Activos Visuales
        </button>
        <button type="button" @click="activeTab = 'enlaces'" 
                :class="activeTab === 'enlaces' ? 'bg-primary text-white font-black shadow-md shadow-primary/20 border-primary' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-850 hover:bg-slate-50 dark:hover:bg-slate-800/50 shadow-sm'" 
                class="px-5 py-3 rounded-xl text-xs transition-all whitespace-nowrap border flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
            Marketing y Enlaces
        </button>
    </div>

    <!-- Formulario de Configuración Principal -->
    <form action="/{{ $shop->slug }}/admin/settings" method="POST" enctype="multipart/form-data" 
          class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2rem] p-6 md:p-8 shadow-sm space-y-6 transition-colors duration-300" 
          x-show="activeTab !== 'enlaces'" x-cloak>
        @csrf
        @method('PUT')

        <!-- TAB 1: IDENTIDAD COMERCIAL -->
        <div x-show="activeTab === 'comercio'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6 pt-2">
            <div>
                <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                    Identidad Comercial
                </span>
                <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                    Datos del Comercio
                </h3>
                <p class="text-xs text-slate-400 dark:text-slate-500">
                    Personaliza la información pública que se mostrará en tu catálogo digital.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Nombre de la Empresa -->
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-bold text-slate-700 dark:text-slate-300">Nombre de la Empresa</label>
                    <input type="text" id="name" name="name" 
                           class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" 
                           value="{{ old('name', $shop->name) }}" required>
                </div>

                <!-- WhatsApp de Pedidos -->
                <div class="space-y-1.5">
                    <label for="whatsapp_number" class="text-xs font-bold text-slate-700 dark:text-slate-300">WhatsApp (Formato Internacional)</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" 
                           class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" 
                           value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" required placeholder="e.g. 584120000000">
                </div>

                <!-- Descripción/Eslogan -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="description" class="text-xs font-bold text-slate-700 dark:text-slate-300">Descripción o Eslogan</label>
                    <textarea id="description" name="description" 
                              class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-medium" 
                              rows="2">{{ old('description', $shop->description) }}</textarea>
                </div>

                <!-- Ubicación -->
                <div class="space-y-1.5 md:col-span-2">
                    <label for="address" class="text-xs font-bold text-slate-700 dark:text-slate-300">Dirección Física</label>
                    <input type="text" id="address" name="address" 
                           class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-medium" 
                           value="{{ old('address', $shop->address) }}">
                </div>

                <!-- Google Maps -->
                <div class="space-y-1.5 md:col-span-1">
                    <label for="google_maps_link" class="text-xs font-bold text-slate-700 dark:text-slate-300">Enlace de Google Maps</label>
                    <input type="url" id="google_maps_link" name="google_maps_link" 
                           class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-medium" 
                           placeholder="https://maps.google.com/..." value="{{ old('google_maps_link', $shop->google_maps_link) }}">
                </div>

                <!-- Tasa Monetaria -->
                <div class="space-y-1.5 md:col-span-1" x-data="{
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
                    <label for="base_currency" class="text-xs font-bold text-slate-700 dark:text-slate-300">Tasa monetaria</label>
                    <div class="flex gap-2">
                        <select id="base_currency" name="base_currency" x-model="baseCurrency" @change="fetchRate()" 
                                class="w-[45%] bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-3 py-3 text-xs text-slate-800 dark:text-slate-250 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold">
                            <option value="" disabled>Selecciona moneda</option>
                            <option value="USD">Dólares (USD)</option>
                            <option value="EUR">Euros (EUR)</option>
                            <option value="VES">Bolívares (Personalizado)</option>
                            <option value="COP">Pesos (COP)</option>
                        </select>
                        <div class="relative w-[55%]">
                            <input type="text" name="exchange_rate" x-model="exchangeRate" 
                                   :readonly="baseCurrency === 'USD' || baseCurrency === 'EUR'" 
                                   :class="(baseCurrency === 'USD' || baseCurrency === 'EUR') ? 'bg-slate-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-500 cursor-not-allowed' : 'bg-slate-50 dark:bg-slate-850 text-slate-800 dark:text-slate-200 focus:border-primary focus:ring-primary focus:ring-1 focus:outline-none'" 
                                   class="w-full border border-slate-200 dark:border-slate-750 rounded-2xl px-3 py-3 text-xs transition-all shadow-inner font-bold" 
                                   placeholder="Ej: Bs. 39.50">
                            <div x-show="isLoading" class="absolute right-3 top-3" style="display: none;">
                                <svg class="animate-spin h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
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
                
                <div class="space-y-1.5 md:col-span-2" 
                     x-data="{ 
                         type: '{{ $isCustom ? 'custom' : 'simple' }}',
                         text: '{{ addslashes($simpleText ?? '') }}',
                         schedule: {{ json_encode($scheduleData) }},
                         days: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']
                     }">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Horario de Trabajo</label>
                        <button type="button" 
                                @click="type = type === 'simple' ? 'custom' : 'simple'"
                                class="text-[10px] font-bold px-3 py-1.5 rounded-full transition-all border"
                                :class="type === 'custom' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700'">
                            <span x-show="type === 'simple'">Opciones Avanzadas</span>
                            <span x-show="type === 'custom'" x-cloak>Usar Texto Simple</span>
                        </button>
                    </div>
                    
                    <!-- Input Simple -->
                    <div x-show="type === 'simple'" x-collapse>
                        <input type="text" x-model="text" 
                               class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-750 rounded-2xl px-4 py-3 text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-medium" 
                               placeholder="Ej: Lun - Sab, 8am a 6pm">
                    </div>

                    <!-- Constructor Custom -->
                    <div x-show="type === 'custom'" x-collapse x-cloak 
                         class="bg-slate-50 dark:bg-slate-950 rounded-2xl p-4 md:p-5 shadow-inner border border-slate-200 dark:border-slate-850 mt-1 transition-colors">
                        <div class="mb-5">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">Horario de atención</h4>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Configura las horas de apertura o marca días cerrados.</p>
                        </div>
                        
                        <div class="space-y-4">
                            <template x-for="day in days" :key="day">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 pb-3 border-b border-slate-200 dark:border-slate-800/80 last:border-0 last:pb-0">
                                    
                                    <!-- Día y Checkbox Cerrado -->
                                    <div class="w-28 shrink-0 flex flex-col justify-center">
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-1.5" x-text="day"></span>
                                        <label class="flex items-center gap-2 cursor-pointer group w-max">
                                            <input type="checkbox" x-model="schedule[day].closed" class="w-3.5 h-3.5 rounded border-slate-300 dark:border-slate-600 text-primary focus:ring-primary bg-white dark:bg-slate-800 cursor-pointer">
                                            <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors">Cerrada</span>
                                        </label>
                                    </div>

                                    <!-- Controles de Tiempo -->
                                    <div class="flex items-center gap-3 flex-grow transition-opacity duration-300" :class="schedule[day].closed ? 'opacity-30 pointer-events-none' : ''">
                                        <div class="flex-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-2.5 focus-within:border-primary transition-colors">
                                            <span class="block text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Abre a la(s)</span>
                                            <input type="time" x-model="schedule[day].open" class="w-full bg-transparent text-slate-800 dark:text-slate-200 text-xs font-semibold focus:outline-none">
                                        </div>
                                        <span class="text-slate-400 dark:text-slate-600 text-sm font-bold">-</span>
                                        <div class="flex-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-2.5 focus-within:border-primary transition-colors">
                                            <span class="block text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Cierra a la(s)</span>
                                            <input type="time" x-model="schedule[day].close" class="w-full bg-transparent text-slate-800 dark:text-slate-200 text-xs font-semibold focus:outline-none">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Hidden input para enviar el JSON stringificado -->
                    <input type="hidden" name="work_hours" :value="JSON.stringify({ type: type, text: text, schedule: schedule })">
                </div>

                <!-- Métodos de Pago -->
                <div class="space-y-2 md:col-span-2" 
                     x-data="{ 
                         methods: '{{ old('payment_methods', $shop->payment_methods ?? '') }}'.split(',').map(i => i.trim()).filter(i => i),
                         availableMethods: [
                             {name: 'Transferencia', color: 'bg-slate-600 text-white border-slate-600 shadow-[0_3px_10px_rgba(71,85,105,0.3)]'},
                             {name: 'Pago Móvil', color: 'bg-teal-500 text-white border-teal-500 shadow-[0_3px_10px_rgba(20,184,166,0.3)]'},
                             {name: 'Efectivo', color: 'bg-emerald-600 text-white border-emerald-600 shadow-[0_3px_10px_rgba(5,150,105,0.3)]'},
                             {name: 'Zelle', color: 'bg-purple-600 text-white border-purple-600 shadow-[0_3px_10px_rgba(147,51,234,0.3)]'},
                             {name: 'Binance', color: 'bg-yellow-500 text-white border-yellow-500 shadow-[0_3px_10px_rgba(234,179,8,0.3)]'},
                             {name: 'PayPal', color: 'bg-blue-600 text-white border-blue-600 shadow-[0_3px_10px_rgba(37,99,235,0.3)]'},
                             {name: 'Punto de Venta', color: 'bg-indigo-500 text-white border-indigo-500 shadow-[0_3px_10px_rgba(99,102,241,0.3)]'}
                         ],
                         toggle(methodName) {
                             if (this.methods.includes(methodName)) {
                                 this.methods = this.methods.filter(m => m !== methodName);
                             } else {
                                 this.methods.push(methodName);
                             }
                         }
                     }">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-1">Métodos de Pago Aceptados</label>
                    
                    <!-- Tags Interactivas -->
                    <div class="flex flex-wrap gap-2">
                        <template x-for="item in availableMethods" :key="item.name">
                            <button type="button" 
                                    @click="toggle(item.name)"
                                    :class="methods.includes(item.name) ? item.color : 'bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-750 hover:bg-slate-100 dark:hover:bg-slate-700 hover:border-slate-300 shadow-inner'"
                                    class="px-3.5 py-2 rounded-xl border text-[11px] font-bold transition-all duration-300 select-none flex items-center gap-1.5 focus:outline-none">
                                <svg x-show="methods.includes(item.name)" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span x-text="item.name"></span>
                            </button>
                        </template>
                    </div>
                    
                    <!-- Hidden input para enviar el string separado por comas -->
                    <input type="hidden" name="payment_methods" :value="methods.join(', ')">
                </div>
            </div>
        </div>

        <!-- TAB 2: PALETA DE COLORES -->
        <div x-show="activeTab === 'colores'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="pt-2">
            <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                Aesthetics & Styling
            </span>
            <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                Paleta de Colores de Marca
            </h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 mb-5">
                Define el tono visual con el que tus clientes percibirán tu marca.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Color Primario -->
                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 p-3.5 rounded-2xl shadow-inner">
                    <input type="color" id="color_primary" name="color_primary" class="w-12 h-12 rounded-full border-2 border-white dark:border-slate-800 shadow cursor-pointer shrink-0 bg-transparent" value="{{ old('color_primary', $shop->color_primary) }}">
                    <div>
                        <label for="color_primary" class="text-xs font-bold text-slate-800 dark:text-slate-100 block">Principal</label>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 block font-semibold">Botones y acciones</span>
                    </div>
                </div>

                <!-- Color Secundario -->
                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 p-3.5 rounded-2xl shadow-inner">
                    <input type="color" id="color_secondary" name="color_secondary" class="w-12 h-12 rounded-full border-2 border-white dark:border-slate-800 shadow cursor-pointer shrink-0 bg-transparent" value="{{ old('color_secondary', $shop->color_secondary) }}">
                    <div>
                        <label for="color_secondary" class="text-xs font-bold text-slate-800 dark:text-slate-100 block">Secundario</label>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 block font-semibold">Títulos y Badges</span>
                    </div>
                </div>

                <!-- Color de Fondo -->
                <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 p-3.5 rounded-2xl shadow-inner">
                    <input type="color" id="color_background" name="color_background" class="w-12 h-12 rounded-full border-2 border-white dark:border-slate-800 shadow cursor-pointer shrink-0 bg-transparent" value="{{ old('color_background', $shop->color_background) }}">
                    <div>
                        <label for="color_background" class="text-xs font-bold text-slate-800 dark:text-slate-100 block">Fondo del Menú</label>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 block font-semibold">Fondo general</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: ACTIVOS VISUALES -->
        <div x-show="activeTab === 'imagenes'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="pt-2">
            <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                Activos de Marca
            </span>
            <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-3 mb-1">
                Imágenes de Portada e Identidad
            </h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 mb-5">
                Sube los logotipos y las fotos destacadas de tu establecimiento comercial.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Cargar Logo -->
                <div class="border-2 dashed border-slate-200 dark:border-slate-700 p-6 rounded-2xl text-center hover:border-primary/50 transition bg-slate-50/50 dark:bg-slate-850/30 flex flex-col items-center justify-between min-h-[220px]">
                    <div>
                        <label class="text-xs font-bold text-slate-800 dark:text-slate-100 block mb-1">Logo Comercial</label>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 block mb-4">Recomendado: Cuadrado (500x500px)</span>
                    </div>
                    <input type="file" name="logo" accept="image/*" class="hidden" id="logo-input">
                    <button type="button" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-700 dark:text-slate-300 text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition active:scale-95" onclick="document.getElementById('logo-input').click()">
                        Seleccionar Logo
                    </button>
                    @if($shop->logo_path)
                        <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path) }}" alt="Preview Logo" class="w-16 h-16 rounded-full object-cover border-2 border-white dark:border-slate-800 shadow-md mt-4">
                    @endif
                </div>

                <!-- Cargar Portada -->
                <div class="border-2 dashed border-slate-200 dark:border-slate-700 p-6 rounded-2xl text-center hover:border-primary/50 transition bg-slate-50/50 dark:bg-slate-850/30 flex flex-col items-center justify-between min-h-[220px]">
                    <div>
                        <label class="text-xs font-bold text-slate-800 dark:text-slate-100 block mb-1">Portada / Banner</label>
                        <span class="text-[9px] text-slate-400 dark:text-slate-500 block mb-4">Recomendado: Horizontal (1200x480px)</span>
                    </div>
                    <input type="file" name="cover" accept="image/*" class="hidden" id="cover-input">
                    <button type="button" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-700 dark:text-slate-300 text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition active:scale-95" onclick="document.getElementById('cover-input').click()">
                        Seleccionar Portada
                    </button>
                    @if($shop->cover_path)
                        <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="Preview Portada" class="w-full h-12 object-cover rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mt-4">
                    @endif
                </div>
            </div>
        </div>

        <!-- Botón de Guardado Global -->
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="w-full bg-primary hover:brightness-105 text-white font-extrabold py-3.5 rounded-2xl transition shadow-lg shadow-primary/20 text-xs">
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
@endsection
