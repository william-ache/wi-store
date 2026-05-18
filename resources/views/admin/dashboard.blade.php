<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Panel de Administración - {{ config('current_shop')->name ?? 'Mi Tienda' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ config('current_shop')->color_primary ?? '#E60067' }}',
                        secondary: '{{ config('current_shop')->color_secondary ?? '#C6A100' }}',
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
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800 text-white font-bold transition">
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
                    <a href="/{{ config('current_shop')->slug }}/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition font-medium">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
                        Ajustes Visuales
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-slate-800/60 space-y-2">
                <a href="/{{ config('current_shop')->slug }}" target="_blank" class="w-full bg-slate-800 hover:bg-primary hover:text-white text-slate-300 font-bold py-2.5 rounded-xl border border-slate-700/80 hover:border-primary transition text-xs flex items-center justify-center gap-2">
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
            
            <!-- TOP HEADER (iOS Mobile Title Bar vs Desktop Spacious Header) -->
            <header class="bg-white border-b border-slate-100 px-4 md:px-8 py-4 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div>
                        <span class="text-[10px] uppercase font-extrabold tracking-widest text-slate-400">Panel de Control</span>
                        <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight">
                            {{ config('current_shop')->name ?? 'Mi Tienda' }}
                        </h1>
                    </div>
                    
                    <!-- Botón Ir a la Tienda (Móvil e indirecto) + Volver al SaaS -->
                    <div class="flex items-center gap-2">
                        <a href="/" class="px-3 py-2 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center gap-1.5 active:scale-95 transition text-xs font-black text-rose-600">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>Salir</span>
                        </a>
                        <a href="/{{ config('current_shop')->slug }}" target="_blank" class="w-10 h-10 md:px-4 md:w-auto bg-slate-50 border border-slate-100 rounded-full md:rounded-xl flex items-center justify-center gap-2 shadow-inner active:scale-95 transition text-xs font-bold text-slate-600">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-600"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            <span class="hidden md:inline">Ver Menú Digital</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- CORE DASHBOARD BODY -->
            <main class="max-w-7xl mx-auto w-full px-4 md:px-8 py-6 space-y-8 flex-grow">

                <!-- 1. RESUMEN DE MÉTRICAS (Fondo oscuro degradado) -->
                <div class="bg-gradient-to-tr from-slate-900 to-slate-800 text-white rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 w-40 h-40 bg-white/5 rounded-full blur-xl"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-center md:text-left border-b md:border-b-0 md:border-r border-white/10 pb-4 md:pb-0 md:pr-6">
                            <span class="text-xs uppercase font-extrabold tracking-wider text-slate-400">Total Recibido</span>
                            <div class="text-3xl md:text-4xl font-black mt-1">$1,245.80</div>
                            <p class="text-[10px] text-slate-400 mt-2">Calculado automáticamente a tasa BCV</p>
                        </div>
                        
                        <div class="grid grid-cols-2 col-span-2 gap-4 text-center">
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Pedidos</span>
                                <span class="text-xl md:text-2xl font-black text-white">42</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Visitas del Menú</span>
                                <span class="text-xl md:text-2xl font-black text-white">890</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. CONTROL TASA BCV E INFORMACIÓN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-extrabold text-slate-400 block">Tasa BCV Activa</span>
                            <span class="text-base font-black text-slate-800">{{ config('current_shop')->exchange_rate }}</span>
                        </div>
                        <button class="bg-slate-50 border border-slate-100 text-slate-700 text-xs font-bold px-4 py-2 rounded-2xl active:bg-slate-100 transition shadow-inner">
                            Actualizar Tasa
                        </button>
                    </div>
                    
                    <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-extrabold text-slate-400 block">WhatsApp de Pedidos</span>
                            <span class="text-base font-black text-slate-800">{{ config('current_shop')->whatsapp_number }}</span>
                        </div>
                        <a href="/{{ config('current_shop')->slug }}/admin/settings" class="bg-slate-50 border border-slate-100 text-slate-700 text-xs font-bold px-4 py-2 rounded-2xl active:bg-slate-100 transition shadow-inner">
                            Modificar
                        </a>
                    </div>
                </div>

                <!-- 3. LISTADO HÍBRIDO DE PRODUCTOS (Tabla en PC, Lista de Tarjetas en Móvil) -->
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-base md:text-lg font-black text-slate-800">Catálogo de Productos</h3>
                        <button class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-2xl active:scale-95 transition shadow-sm shadow-brand-500/10">
                            + Agregar Producto
                        </button>
                    </div>

                    <!-- A. VISTA ESCRITORIO: TABLA DETALLADA (hidden md:block) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs md:text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase font-extrabold text-[10px]">
                                    <th class="py-3 px-4">Producto</th>
                                    <th class="py-3 px-4">Categoría</th>
                                    <th class="py-3 px-4 text-right">Precio</th>
                                    <th class="py-3 px-4 text-center">Estado</th>
                                    <th class="py-3 px-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                                    <td class="py-3.5 px-4 font-bold text-slate-800">Arreglo Globos Premium</td>
                                    <td class="py-3.5 px-4 text-slate-500">Globos y Arreglos</td>
                                    <td class="py-3.5 px-4 text-right font-black">$25.00</td>
                                    <td class="py-3.5 px-4 text-center"><span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-100">Disponible</span></td>
                                    <td class="py-3.5 px-4 text-center space-x-2">
                                        <button class="text-slate-600 hover:text-slate-900 font-bold">Editar</button>
                                        <button class="text-rose-500 hover:text-rose-700 font-bold">Eliminar</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                                    <td class="py-3.5 px-4 font-bold text-slate-800">Bouquet Rosas y Chocolates</td>
                                    <td class="py-3.5 px-4 text-slate-500">Globos y Arreglos</td>
                                    <td class="py-3.5 px-4 text-right font-black">$35.00</td>
                                    <td class="py-3.5 px-4 text-center"><span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-100">Disponible</span></td>
                                    <td class="py-3.5 px-4 text-center space-x-2">
                                        <button class="text-slate-600 hover:text-slate-900 font-bold">Editar</button>
                                        <button class="text-rose-500 hover:text-rose-700 font-bold">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- B. VISTA MÓVIL: LISTADO DE TARJETAS VERTICAL (md:hidden) -->
                    <div class="md:hidden space-y-3.5">
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex justify-between items-center">
                            <div>
                                <span class="text-sm font-bold text-slate-800 block">Arreglo Globos Premium</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Globos y Arreglos · <strong class="text-slate-900">$25.00</strong></span>
                            </div>
                            <div class="flex gap-2.5">
                                <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600 active:bg-slate-100">✏️</button>
                                <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold text-rose-500 active:bg-slate-100">🗑️</button>
                            </div>
                        </div>
                        
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex justify-between items-center">
                            <div>
                                <span class="text-sm font-bold text-slate-800 block">Bouquet Rosas y Chocolates</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Globos y Arreglos · <strong class="text-slate-900">$35.00</strong></span>
                            </div>
                            <div class="flex gap-2.5">
                                <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600 active:bg-slate-100">✏️</button>
                                <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold text-rose-500 active:bg-slate-100">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- 2. MÓVIL: BARRA DE NAVEGACIÓN INFERIOR DE TIENDA (md:hidden) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-100 flex justify-around items-center z-40 max-w-md mx-auto shadow-lg">
        <a href="#" class="flex flex-col items-center justify-center flex-1 h-full text-primary font-bold active:scale-95 transition">
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
        <a href="/{{ config('current_shop')->slug }}/admin/settings" class="flex flex-col items-center justify-center flex-1 h-full text-slate-400 active:scale-95 transition hover:text-slate-600">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
            <span class="text-[9px] mt-1 tracking-wider">Ajustes</span>
        </a>
    </nav>

</body>
</html>
