<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Configuración Visual - {{ $shop->name }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $shop->color_primary ?? '#E60067' }}',
                        secondary: '{{ $shop->color_secondary ?? '#C6A100' }}',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }
    </style>
</head>
<body class="text-slate-800 pb-20 md:pb-0 select-none">

    <!-- 1. LAYOUT DE ESCRITORIO CON SIDEBAR (md:flex) -->
    <div class="min-h-screen md:flex">
        
        <!-- SIDEBAR DE ESCRITORIO (Fijo a la izquierda, oculto en móvil) -->
        <aside class="hidden md:flex md:w-64 bg-slate-900 text-slate-300 flex-col justify-between border-r border-slate-800 shrink-0 sticky top-0 h-screen">
            <div>
                <!-- Brand Logo Header -->
                <div class="h-16 px-6 border-b border-slate-800/80 flex items-center justify-between">
                    <span class="text-xl font-black text-white">WI<span class="text-primary">Store</span></span>
                    <span class="bg-primary/10 text-primary text-[9px] uppercase font-bold px-2 py-0.5 rounded-full border border-primary/20">Admin</span>
                </div>

                <!-- Navlinks -->
                <nav class="p-4 space-y-1.5">
                    <a href="/{{ $shop->slug }}/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition font-medium">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Inicio
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition font-medium">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                        Categorías
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition font-medium">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        Productos
                    </a>
                    <a href="/{{ $shop->slug }}/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800 text-white font-bold transition">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
                        Ajustes Visuales
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-slate-800/60 space-y-2">
                <a href="/{{ $shop->slug }}" target="_blank" class="w-full bg-slate-800 hover:bg-primary hover:text-white text-slate-300 font-bold py-2.5 rounded-xl border border-slate-700/80 hover:border-primary transition text-xs flex items-center justify-center gap-2">
                    Ver Menú Digital →
                </a>
                <a href="/" class="w-full bg-rose-600/10 hover:bg-rose-600 hover:text-white text-rose-400 font-bold py-2 rounded-xl border border-rose-500/20 hover:border-rose-600 transition text-[11px] flex items-center justify-center gap-1.5">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Volver a WIStore
                </a>
            </div>
        </aside>

        <!-- ÁREA CENTRAL DE CONTENIDO (Móvil full, Escritorio flex-1) -->
        <div class="flex-grow flex flex-col min-h-screen">
            
            <!-- TOP HEADER -->
            <header class="bg-white border-b border-slate-100 px-4 md:px-8 py-4 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div>
                        <span class="text-[10px] uppercase font-extrabold tracking-widest text-slate-400">Configuración</span>
                        <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">
                            Ajustes Visuales
                        </h1>
                    </div>
                    
                    <!-- Botón Salir / Ver Menú -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('logout') }}" class="px-3 py-2 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center gap-1.5 active:scale-95 transition text-xs font-black text-rose-600">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>Salir</span>
                        </a>
                        <a href="/{{ $shop->slug }}" target="_blank" class="w-10 h-10 md:px-4 md:w-auto bg-slate-50 border border-slate-100 rounded-full md:rounded-xl flex items-center justify-center gap-2 shadow-inner active:scale-95 transition text-xs font-bold text-slate-600">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-600"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            <span class="hidden md:inline">Ver Menú Digital</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- CORE SETTINGS BODY -->
            <main class="max-w-4xl w-full px-4 md:px-8 py-6 space-y-8 flex-grow">
                
                @if(session('success'))
                    <div class="bg-emerald-50 text-emerald-700 text-xs font-semibold p-4 rounded-2xl border border-emerald-100">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulario de Configuración Principal -->
                <form action="/{{ $shop->slug }}/admin/settings" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-100 rounded-[2rem] p-6 md:p-8 shadow-sm space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                            Identidad Comercial
                        </span>
                        <h3 class="text-base md:text-lg font-black text-slate-800 mt-3 mb-1">
                            Datos del Comercio
                        </h3>
                        <p class="text-xs text-slate-400">
                            Personaliza la información pública que se mostrará en tu catálogo digital.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nombre de la Empresa -->
                        <div class="space-y-1.5">
                            <label for="name" class="text-xs font-bold text-slate-700">Nombre de la Empresa</label>
                            <input type="text" id="name" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" value="{{ old('name', $shop->name) }}" required>
                        </div>

                        <!-- WhatsApp de Pedidos -->
                        <div class="space-y-1.5">
                            <label for="whatsapp_number" class="text-xs font-bold text-slate-700">WhatsApp (Formato Internacional)</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" required placeholder="e.g. 584120000000">
                        </div>

                        <!-- Descripción/Eslogan -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="description" class="text-xs font-bold text-slate-700">Descripción o Eslogan</label>
                            <textarea id="description" name="description" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-medium" rows="2">{{ old('description', $shop->description) }}</textarea>
                        </div>

                        <!-- Ubicación -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="address" class="text-xs font-bold text-slate-700">Dirección Física</label>
                            <input type="text" id="address" name="address" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-medium" value="{{ old('address', $shop->address) }}">
                        </div>

                        <!-- Métodos de Pago -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="payment_methods" class="text-xs font-bold text-slate-700">Métodos de Pago (Separados por coma)</label>
                            <input type="text" id="payment_methods" name="payment_methods" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-inner font-semibold" value="{{ old('payment_methods', $shop->payment_methods) }}" placeholder="e.g. Pago Móvil, Zelle, Efectivo">
                        </div>
                    </div>

                    <!-- Paleta de Colores Dinámicos -->
                    <div class="pt-4 border-t border-slate-100">
                        <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                            Aesthetics & Styling
                        </span>
                        <h3 class="text-base md:text-lg font-black text-slate-800 mt-3 mb-1">
                            Paleta de Colores de Marca
                        </h3>
                        <p class="text-xs text-slate-400 mb-5">
                            Define el tono visual con el que tus clientes percibirán tu marca.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Color Primario -->
                            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 p-3.5 rounded-2xl shadow-inner">
                                <input type="color" id="color_primary" name="color_primary" class="w-12 h-12 rounded-full border-2 border-white shadow cursor-pointer shrink-0 bg-transparent" value="{{ old('color_primary', $shop->color_primary) }}">
                                <div>
                                    <label for="color_primary" class="text-xs font-bold text-slate-800 block">Principal</label>
                                    <span class="text-[9px] text-slate-400 block font-semibold">Botones y acciones</span>
                                </div>
                            </div>

                            <!-- Color Secundario -->
                            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 p-3.5 rounded-2xl shadow-inner">
                                <input type="color" id="color_secondary" name="color_secondary" class="w-12 h-12 rounded-full border-2 border-white shadow cursor-pointer shrink-0 bg-transparent" value="{{ old('color_secondary', $shop->color_secondary) }}">
                                <div>
                                    <label for="color_secondary" class="text-xs font-bold text-slate-800 block">Secundario</label>
                                    <span class="text-[9px] text-slate-400 block font-semibold">Títulos y Badges</span>
                                </div>
                            </div>

                            <!-- Color de Fondo -->
                            <div class="flex items-center gap-3 bg-slate-50 border border-slate-200/80 p-3.5 rounded-2xl shadow-inner">
                                <input type="color" id="color_background" name="color_background" class="w-12 h-12 rounded-full border-2 border-white shadow cursor-pointer shrink-0 bg-transparent" value="{{ old('color_background', $shop->color_background) }}">
                                <div>
                                    <label for="color_background" class="text-xs font-bold text-slate-800 block">Fondo del Menú</label>
                                    <span class="text-[9px] text-slate-400 block font-semibold">Fondo general</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activos Visuales (Imágenes) -->
                    <div class="pt-4 border-t border-slate-100">
                        <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                            Activos de Marca
                        </span>
                        <h3 class="text-base md:text-lg font-black text-slate-800 mt-3 mb-1">
                            Imágenes de Portada e Identidad
                        </h3>
                        <p class="text-xs text-slate-400 mb-5">
                            Sube los logotipos y las fotos destacadas de tu establecimiento comercial.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Cargar Logo -->
                            <div class="border-2 dashed border-slate-200 p-6 rounded-2xl text-center hover:border-primary/50 transition bg-slate-50/50 flex flex-col items-center justify-between min-h-[220px]">
                                <div>
                                    <label class="text-xs font-bold text-slate-800 block mb-1">Logo Comercial</label>
                                    <span class="text-[9px] text-slate-400 block mb-4">Recomendado: Cuadrado (500x500px)</span>
                                </div>
                                <input type="file" name="logo" accept="image/*" class="hidden" id="logo-input">
                                <button type="button" class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition active:scale-95" onclick="document.getElementById('logo-input').click()">
                                    Seleccionar Logo
                                </button>
                                @if($shop->logo_path)
                                    <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path) }}" alt="Preview Logo" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md mt-4">
                                @endif
                            </div>

                            <!-- Cargar Portada -->
                            <div class="border-2 dashed border-slate-200 p-6 rounded-2xl text-center hover:border-primary/50 transition bg-slate-50/50 flex flex-col items-center justify-between min-h-[220px]">
                                <div>
                                    <label class="text-xs font-bold text-slate-800 block mb-1">Portada / Banner</label>
                                    <span class="text-[9px] text-slate-400 block mb-4">Recomendado: Horizontal (1200x480px)</span>
                                </div>
                                <input type="file" name="cover" accept="image/*" class="hidden" id="cover-input">
                                <button type="button" class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition active:scale-95" onclick="document.getElementById('cover-input').click()">
                                    Seleccionar Portada
                                </button>
                                @if($shop->cover_path)
                                    <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="Preview Portada" class="w-full h-12 object-cover rounded-xl border border-slate-200 shadow-sm mt-4">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-primary hover:brightness-105 text-white font-extrabold py-3.5 rounded-2xl transition shadow-lg shadow-primary/20 text-xs">
                            Guardar Cambios Visuales
                        </button>
                    </div>
                </form>

                <!-- COMPONENTE: GESTIÓN DE ENLACE CORTO -->
                <div class="bg-white border border-slate-100 rounded-[2rem] p-6 md:p-8 shadow-sm relative" x-data="{ showToast: false }">
                    <div class="absolute -right-12 -top-12 w-28 h-28 bg-primary/5 rounded-full blur-xl"></div>

                    <!-- Encabezado del Módulo -->
                    <div class="mb-6">
                        <span class="bg-primary/10 text-primary text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-primary/20">
                            Marketing y Redes
                        </span>
                        <h3 class="text-base md:text-lg font-black text-slate-800 mt-3 mb-1">
                            Enlace Corto Personalizado
                        </h3>
                        <p class="text-xs text-slate-400">
                            Configura una palabra clave corta y fácil de recordar para compartir tu menú digital en Instagram, TikTok o tarjetas de presentación.
                        </p>
                    </div>

                    @if(session('success_short_link'))
                        <div class="bg-emerald-50 text-emerald-700 text-xs font-semibold p-4 rounded-xl border border-emerald-100 mb-6">
                            {{ session('success_short_link') }}
                        </div>
                    @endif

                    <!-- A. COMPONENTE "COPIAR LINK" (Si ya está configurado) -->
                    @if($shortLink = $shop->shortLinks()->first())
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 md:p-6 mb-6 shadow-inner">
                            <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider block mb-2">Enlace Corto Activo</span>
                            
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                <div class="flex-grow bg-white border border-slate-200 rounded-xl px-4 py-3 flex items-center justify-between text-xs md:text-sm text-slate-800 font-bold select-all overflow-x-auto shadow-sm">
                                    <span>{{ str_replace(['http://', 'https://'], '', url('/l/' . $shortLink->code)) }}</span>
                                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-normal shrink-0 ml-2">Activo</span>
                                </div>
                                
                                <button type="button" 
                                        @click="navigator.clipboard.writeText('{{ url('/l/' . $shortLink->code) }}'); showToast = true; setTimeout(() => { showToast = false }, 2500);"
                                        class="bg-primary hover:brightness-105 text-white font-extrabold px-6 py-3 rounded-xl flex items-center justify-center gap-2 active:scale-95 transition text-xs shrink-0 shadow-md shadow-primary/10">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    Copiar Enlace
                                </button>
                            </div>

                            <!-- Métricas del Enlace -->
                            <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 font-medium">
                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded bg-white border border-slate-200 text-slate-600 font-bold shadow-sm">
                                    📊 {{ $shortLink->clicks_count }} {{ $shortLink->clicks_count == 1 ? 'visita' : 'visitas' }}
                                </span>
                                <span>Registrado desde el acortador interno.</span>
                            </div>
                        </div>
                    @endif

                    <!-- B. FORMULARIO DE ASIGNACIÓN (Siempre editable) -->
                    <form action="/{{ $shop->slug }}/admin/settings/short-link" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-group space-y-1.5">
                            <label for="code" class="text-xs font-bold text-slate-700">Palabra clave o prefijo corto</label>
                            
                            <div class="flex items-stretch rounded-xl border border-slate-200 overflow-hidden focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15 transition shadow-sm bg-slate-50 shadow-inner">
                                <span class="bg-slate-100 border-r border-slate-200 text-slate-500 px-4 py-3 flex items-center text-xs md:text-sm font-bold select-none shrink-0">
                                    wistore.com/l/
                                </span>
                                <input type="text" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code', $shop->shortLinks()->first()?->code) }}" 
                                       placeholder="ej: {{ $shop->slug }}" 
                                       required 
                                       class="w-full px-4 py-3 text-xs md:text-sm text-slate-800 font-bold placeholder-slate-400 focus:outline-none bg-transparent">
                            </div>

                            @error('code')
                                <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                            @enderror
                            <p class="text-[10px] text-slate-400 font-medium">
                                Usa palabras simples, sin espacios ni caracteres especiales. Ej: 'ys', 'detallitos', 'regalos'.
                            </p>
                        </div>

                        <button type="submit" 
                                class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold py-3.5 px-6 rounded-xl transition text-xs active:scale-[0.98] w-full sm:w-auto shadow shadow-slate-900/10">
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
            </main>
        </div>
    </div>

    <!-- 2. MÓVIL: BARRA DE NAVEGACIÓN INFERIOR DE TIENDA (md:hidden) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-100 flex justify-around items-center z-40 max-w-md mx-auto shadow-lg">
        <a href="/{{ $shop->slug }}/admin/dashboard" class="flex flex-col items-center justify-center flex-1 h-full text-slate-400 active:scale-95 transition hover:text-slate-600">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span class="text-[9px] mt-1 tracking-wider">Inicio</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center flex-1 h-full text-slate-400 active:scale-95 transition hover:text-slate-600">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
            <span class="text-[9px] mt-1 tracking-wider">Categorías</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center flex-1 h-full text-slate-400 active:scale-95 transition hover:text-slate-600">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            <span class="text-[9px] mt-1 tracking-wider">Productos</span>
        </a>
        <a href="/{{ $shop->slug }}/admin/settings" class="flex flex-col items-center justify-center flex-1 h-full text-primary font-bold active:scale-95 transition hover:text-slate-600">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
            <span class="text-[9px] mt-1 tracking-wider">Ajustes</span>
        </a>
    </nav>

</body>
</html>
