<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Panel de Administración') - {{ config('current_shop')->name ?? 'Mi Tienda' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: {{ config('current_shop')->color_primary ?? '#E60067' }};
            --color-secondary: {{ config('current_shop')->color_secondary ?? '#C6A100' }};
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }
        [x-cloak] { display: none !important; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .overflow-x-auto {
            padding: 0.25rem 0.25rem 1.25rem 0.25rem;
        }

        /* DataTables custom premium styling */
        .dataTables_wrapper {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 0 !important;
        }
        .dataTables_wrapper .dataTables_length select {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.45rem 1.75rem 0.45rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            outline: none;
            color: #475569;
        }
        .dark .dataTables_wrapper .dataTables_length select {
            background-color: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0 !important;
        }
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            margin-bottom: 0 !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            padding: 0.45rem 1rem 0.45rem 2.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            outline: none;
            transition: all 0.2s;
            color: #334155;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.03);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 0.875rem center;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(230, 0, 103, 0.15);
        }
        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #1e293b;
            border-color: #334155;
            color: #f1f5f9;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E");
        }
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            border-radius: 1.25rem !important;
            overflow: hidden;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 8px 15px -6px rgba(0, 0, 0, 0.04), 0 0 1px 0 rgba(0, 0, 0, 0.1) !important;
        }
        .dark table.dataTable {
            border: 1px solid #1e293b !important;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.02) !important;
        }
        table.dataTable thead th {
            background-color: var(--color-primary, #E60067) !important;
            color: white !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.05em !important;
            padding: 1rem 1.25rem !important;
            border-bottom: none !important;
        }
        table.dataTable tbody td {
            padding: 1rem 1.25rem !important;
            font-size: 0.8125rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background-color: white !important;
        }
        .dark table.dataTable tbody td {
            border-bottom-color: #1e293b !important;
            color: #e2e8f0 !important;
            background-color: #0f172a !important;
        }
        table.dataTable tbody tr:hover td {
            background-color: #f8fafc !important;
        }
        .dark table.dataTable tbody tr:hover td {
            background-color: #1e293b !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem !important;
            display: flex;
            gap: 0.25rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            padding: 0.375rem 0.75rem !important;
            transition: all 0.2s !important;
            background: white !important;
            color: #475569 !important;
        }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-color: #334155 !important;
            background: #1e293b !important;
            color: #cbd5e1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            color: #1e293b !important;
            border-color: #cbd5e1 !important;
        }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #334155 !important;
            color: white !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--color-primary, #E60067) !important;
            color: white !important;
            border-color: var(--color-primary, #E60067) !important;
            box-shadow: 0 4px 12px rgba(230, 0, 103, 0.25) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f8fafc !important;
            color: #94a3b8 !important;
            border-color: #e2e8f0 !important;
        }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #0f172a !important;
            color: #475569 !important;
            border-color: #1e293b !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 0.75rem !important;
            color: #64748b !important;
            font-weight: 700 !important;
            padding-top: 1.25rem !important;
        }
        .dark .dataTables_wrapper .dataTables_info {
            color: #94a3b8 !important;
        }

        /* SweetAlert2 Premium Customizations */
        .swal2-popup {
            border-radius: 1.5rem !important;
            font-family: 'Outfit', sans-serif !important;
            padding: 2rem !important;
        }
        .dark .swal2-popup {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
            border: 1px solid #1e293b !important;
        }
        .swal2-title {
            font-weight: 800 !important;
            font-size: 1.25rem !important;
            color: #1e293b !important;
        }
        .dark .swal2-title {
            color: #f1f5f9 !important;
        }
        .swal2-html-container {
            font-size: 0.875rem !important;
            color: #64748b !important;
        }
        .dark .swal2-html-container {
            color: #94a3b8 !important;
        }
        .swal2-confirm {
            background-color: var(--color-primary) !important;
            border-radius: 0.75rem !important;
            font-weight: 700 !important;
            font-size: 0.8125rem !important;
            padding: 0.625rem 1.5rem !important;
            box-shadow: 0 4px 12px rgba(230, 0, 103, 0.2) !important;
        }
        .swal2-cancel {
            border-radius: 0.75rem !important;
            font-weight: 700 !important;
            font-size: 0.8125rem !important;
            padding: 0.625rem 1.5rem !important;
        }

        /* Premium DataTables Export Buttons */
        .dt-buttons {
            display: inline-flex !important;
            gap: 0.5rem !important;
            margin-bottom: 0 !important;
        }
        .dt-button {
            border-radius: 0.75rem !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            padding: 0.5rem 1rem !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02) !important;
        }
        
        /* Excel default styles */
        .btn-export-excel {
            border: 1px solid #bbf7d0 !important; /* emerald-200 */
            color: #15803d !important; /* emerald-700 */
            background-color: #f0fdf4 !important; /* emerald-50 */
        }
        .dark .btn-export-excel {
            border: 1px solid rgba(34, 197, 94, 0.3) !important;
            color: #4ade80 !important; /* emerald-400 */
            background-color: rgba(20, 83, 45, 0.25) !important;
        }
        .btn-export-excel:hover {
            border-color: #22c55e !important; /* emerald-500 */
            color: white !important;
            background-color: #22c55e !important;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2) !important;
        }
        .dark .btn-export-excel:hover {
            border-color: #22c55e !important;
            color: white !important;
            background-color: #15803d !important;
        }

        /* PDF default styles */
        .btn-export-pdf {
            border: 1px solid #fecaca !important; /* red-200 */
            color: #b91c1c !important; /* red-700 */
            background-color: #fef2f2 !important; /* red-50 */
        }
        .dark .btn-export-pdf {
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #f87171 !important; /* red-400 */
            background-color: rgba(127, 29, 29, 0.25) !important;
        }
        .btn-export-pdf:hover {
            border-color: #ef4444 !important; /* red-500 */
            color: white !important;
            background-color: #ef4444 !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2) !important;
        }
        .dark .btn-export-pdf:hover {
            border-color: #ef4444 !important;
            color: white !important;
            background-color: #b91c1c !important;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            body > *:not(#print-preview-modal) {
                display: none !important;
            }
            #print-preview-modal {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                height: auto !important;
                overflow: visible !important;
                background: white !important;
                display: flex !important;
            }
            #print-preview-modal > div:first-child {
                display: none !important; /* Ocultar barra superior en impresión */
            }
            #print-preview-modal > div:last-child {
                background: white !important;
                padding: 0 !important;
            }
            #print-preview-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <!-- DataTables Buttons and Export Extensions -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>window.JSZip = JSZip;</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="text-slate-800 pb-20 md:pb-0 select-none bg-slate-50 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-200 min-h-full flex flex-col" 
      x-data="{ 
          showAllNotifs: false, 
          darkMode: localStorage.getItem('admin-dark-mode') === 'true', 
          unreadCount: 120,
          init() {
              // Apply theme instantly on boot
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
              this.$watch('darkMode', val => {
                  localStorage.setItem('admin-dark-mode', val);
                  if (val) {
                      document.documentElement.classList.add('dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                  }
              });
          }
      }" 
      :class="{ 'dark': darkMode }">

    <!-- 1. LAYOUT DE ESCRITORIO CON SIDEBAR (md:flex) -->
    <div class="min-h-screen md:flex flex-grow">
        
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
                    <a href="/{{ config('current_shop')->slug }}/admin/dashboard" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/dashboard') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Inicio
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/categories" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/categories*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                        Categorías
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/products" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/products*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        Productos
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/orders" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/orders*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Órdenes
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/clients" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/clients*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Clientes
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/settings" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/settings') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
                        Configuración
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
            
            <!-- TOP HEADER -->
            <header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 px-4 md:px-8 py-4 sticky top-0 z-30 transition-colors duration-300">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div>
                            <span class="text-[10px] uppercase font-extrabold tracking-widest text-slate-400">Panel Administrativo</span>
                            <h1 class="text-lg md:text-2xl font-black text-primary tracking-tight leading-none mt-0.5">
                                {{ config('current_shop')->name ?? 'Mi Tienda' }}
                            </h1>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 md:gap-5">
                        <!-- Buscador -->
                        <div class="hidden md:flex relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-400 group-focus-within:text-primary transition-colors"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </div>
                            <input type="text" class="w-80 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-full pl-9 pr-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary shadow-inner transition-all placeholder-slate-400 dark:placeholder-slate-500" placeholder="Buscar órdenes, productos...">
                        </div>

                        <!-- Botón Dark/Light Mode -->
                        <button @click="darkMode = !darkMode" class="relative p-2 text-slate-400 hover:text-primary transition-colors cursor-pointer hidden md:block" title="Alternar tema">
                            <!-- Icono Luna (Visible en Light Mode) -->
                            <svg x-show="!darkMode" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                            <!-- Icono Sol (Visible en Dark Mode) -->
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                        </button>

                        <!-- Campana de Notificaciones -->
                        <div x-data="{ notifOpen: false }" class="relative z-50">
                            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="relative p-2 text-slate-400 hover:text-primary transition-colors cursor-pointer hidden md:block">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <span x-cloak x-show="unreadCount > 0" class="absolute top-0 right-0 w-[18px] h-[18px] bg-rose-500 rounded-full border-2 border-white dark:border-slate-900 flex items-center justify-center text-[8px] font-black text-white shadow-sm" x-text="unreadCount > 99 ? '+99' : unreadCount"></span>
                            </button>

                            <!-- Mini Modal de Notificaciones -->
                            <div x-show="notifOpen" x-cloak x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden origin-top-right">
                                <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                    <span class="text-sm font-black text-slate-800 dark:text-slate-200">Notificaciones</span>
                                    <span class="text-[10px] bg-rose-100 text-rose-600 font-bold px-2 py-0.5 rounded-full" x-text="unreadCount > 99 ? '+99 Nuevas' : unreadCount + ' Nuevas'">Nuevas</span>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <!-- Item 1 -->
                                    <div class="p-4 border-b border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-emerald-600 dark:text-emerald-400"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-800 dark:text-slate-200">Nueva orden recibida</p>
                                            <p class="text-[10px] text-slate-500 mt-0.5">Orden #1042 por $25.00</p>
                                            <span class="text-[9px] font-bold text-primary mt-1 block">Hace 5 min</span>
                                        </div>
                                    </div>
                                    <!-- Item 2 -->
                                    <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-950 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-amber-600 dark:text-amber-400"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-800 dark:text-slate-200">Actualiza tu tasa BCV</p>
                                            <p class="text-[10px] text-slate-500 mt-0.5">La tasa oficial ha cambiado recientemente.</p>
                                            <span class="text-[9px] font-bold text-primary mt-1 block">Hace 1 hora</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" @click="showAllNotifs = true; notifOpen = false" class="block w-full text-center p-3 text-xs font-bold text-primary bg-slate-50 dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors border-t border-slate-100 dark:border-slate-800">
                                    Ver todas las notificaciones
                                </button>
                            </div>
                        </div>
                        
                        <div class="hidden md:block w-px h-6 bg-slate-200 dark:bg-slate-700"></div>

                        <!-- Perfil Dropdown -->
                        <div x-data="{ open: false }" class="relative z-50">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 hover:bg-slate-50 dark:hover:bg-slate-800 p-1 md:pr-3 rounded-full border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all cursor-pointer">
                                @if(config('current_shop') && config('current_shop')->logo_path)
                                    <img src="{{ filter_var(config('current_shop')->logo_path, FILTER_VALIDATE_URL) ? config('current_shop')->logo_path : asset('storage/' . config('current_shop')->logo_path) }}" alt="Logo" class="w-8 h-8 md:w-9 md:h-9 rounded-full object-cover shadow-sm border border-slate-100 dark:border-slate-800">
                                @else
                                    <div class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-[#00529b] flex items-center justify-center text-white font-black text-sm shadow-sm">
                                        A
                                    </div>
                                @endif
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300 hidden md:inline">
                                     {{ config('current_shop')->name ?? 'Admin' }}
                                 </span>
                                 <svg class="w-4 h-4 text-slate-400 hidden md:inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>

                            <!-- Menú Desplegable -->
                            <div x-show="open" x-cloak x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden origin-top-right">
                                <div class="p-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                                    <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Mi Cuenta</span>
                                    <span class="block text-sm font-black text-slate-800 dark:text-slate-200 mt-0.5">Administrador</span>
                                </div>
                                <a href="/{{ config('current_shop')->slug }}" target="_blank" class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-colors flex items-center gap-2.5">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    Ver Menú Digital
                                </a>
                                <a href="{{ route('logout') }}" class="px-4 py-3.5 text-xs font-bold text-[#d83434] hover:bg-rose-50 dark:hover:bg-slate-800 border-t border-slate-100 dark:border-slate-800 transition-colors flex items-center gap-2.5">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- CORE DASHBOARD BODY -->
            <main class="max-w-7xl mx-auto w-full px-4 md:px-8 py-6 space-y-6 flex-grow">
                @yield('content')
            </main>
        </div>
    </div>

    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 flex justify-around items-center z-40 max-w-md mx-auto shadow-lg transition-colors duration-300">
        <a href="/{{ config('current_shop')->slug }}/admin/dashboard" 
           class="flex flex-col items-center justify-center flex-1 h-full transition {{ request()->is('*/admin/dashboard') ? 'text-primary font-bold active:scale-95' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span class="text-[9px] mt-1 tracking-wider">Inicio</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/categories" 
           class="flex flex-col items-center justify-center flex-1 h-full transition {{ request()->is('*/admin/categories*') ? 'text-primary font-bold active:scale-95' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
            <span class="text-[9px] mt-1 tracking-wider">Categorías</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/products" 
           class="flex flex-col items-center justify-center flex-1 h-full transition {{ request()->is('*/admin/products*') ? 'text-primary font-bold active:scale-95' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            <span class="text-[9px] mt-1 tracking-wider">Productos</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/orders" 
           class="flex flex-col items-center justify-center flex-1 h-full transition {{ request()->is('*/admin/orders*') ? 'text-primary font-bold active:scale-95' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span class="text-[9px] mt-1 tracking-wider">Órdenes</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/settings" 
           class="flex flex-col items-center justify-center flex-1 h-full transition {{ request()->is('*/admin/settings') ? 'text-primary font-bold active:scale-95' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
            <span class="text-[9px] mt-1 tracking-wider">Config.</span>
        </a>
    </nav>

    <!-- MODAL TODAS LAS NOTIFICACIONES -->
    <div x-show="showAllNotifs" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="showAllNotifs" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showAllNotifs = false"></div>
        <div x-show="showAllNotifs" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[85vh] transition-colors duration-300">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 sticky top-0 z-10 transition-colors duration-300">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-black text-slate-800 dark:text-slate-200">Todas las Notificaciones</h3>
                    <span class="bg-rose-100 text-rose-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full" x-text="unreadCount > 99 ? '+99 Nuevas' : unreadCount + ' Nuevas'">2 Nuevas</span>
                </div>
                <button @click="showAllNotifs = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <!-- Modal Body (Scrollable list) -->
            <div class="overflow-y-auto flex-grow p-2">
                <!-- Item 1 -->
                <div class="p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition cursor-pointer flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-950 flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-emerald-600 dark:text-emerald-400"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Nueva orden recibida</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Has recibido una nueva orden (#1042) por el monto de $25.00. Revisa el panel de órdenes para más detalles y confirmar su preparación.</p>
                        <span class="text-[10px] font-bold text-primary mt-2 block">Hace 5 min</span>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div class="p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition cursor-pointer flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-950 flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-amber-600 dark:text-amber-400"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Actualiza tu tasa BCV</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">La tasa oficial ha cambiado recientemente. Te sugerimos revisar y ajustar tus precios o sincronizar con DolarAPI para mantener todo actualizado.</p>
                        <span class="text-[10px] font-bold text-primary mt-2 block">Hace 1 hora</span>
                    </div>
                </div>
                
                <!-- Item 3 (Leída) -->
                <div class="p-4 rounded-2xl flex gap-4 opacity-70">
                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-500 dark:text-slate-400"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Bienvenido a WIStore</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Tu cuenta ha sido creada exitosamente. Empieza a configurar tu menú digital y personaliza tus ajustes visuales para empezar a vender.</p>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 mt-2 block">Ayer</span>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex justify-end transition-colors duration-300">
                <button @click="showAllNotifs = false" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-700 dark:text-slate-300 font-bold text-xs px-5 py-2.5 rounded-xl transition-colors shadow-sm active:scale-95">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- PRINT PREVIEW OVERLAY -->
    <div id="print-preview-modal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm hidden flex-col select-text">
        <!-- Top Bar -->
        <div class="text-white px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md" style="background-color: var(--color-primary, #E60067) !important;">
            <div class="flex items-center gap-2.5 font-bold">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <span class="text-sm tracking-wide">Vista Previa de Impresión</span>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="triggerPrint()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Guardar como PDF / Imprimir
                </button>
                <button onclick="closePrintPreview()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-bold text-xs px-4 py-2 rounded-lg transition">
                    ✕ Cerrar Vista Previa
                </button>
            </div>
        </div>
        
        <!-- Document Container -->
        <div class="flex-grow overflow-y-auto px-4 md:px-8 py-8 flex justify-center bg-slate-100 dark:bg-slate-900/40">
            <!-- The Paper (A4 / Letter Styled) -->
            <div id="print-preview-paper" class="bg-white text-slate-800 w-full max-w-4xl p-12 my-4 shadow-2xl rounded-sm border border-slate-200 flex flex-col justify-between" style="min-height: 297mm; font-family: 'Outfit', sans-serif;">
                <div>
                    <!-- Header Section -->
                    <div class="border-b-2 border-slate-800 pb-6 mb-8 flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase leading-none">{{ config('current_shop')->name ?? 'Mi Tienda' }}</h2>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1.5">Sistema Integrado de Control Administrativo (SICA)</p>
                        </div>
                        <div class="text-right text-xs text-slate-600">
                            <p class="font-bold text-slate-800" id="preview-report-title">Reporte de Inventario</p>
                            <p class="mt-1">Fecha Emisión: <span class="font-bold text-slate-800">{{ date('d/m/Y') }}</span></p>
                            <p class="mt-0.5">Registros: <span class="font-bold text-slate-800" id="preview-record-count">0</span></p>
                        </div>
                    </div>
                    
                    <!-- Table Section -->
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse text-xs border border-slate-300" id="preview-table">
                            <!-- Dynamic columns & rows will be injected here -->
                        </table>
                    </div>
                </div>
                
                <!-- Footer Section -->
                <div class="border-t border-slate-200 pt-6 mt-12 flex justify-between items-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                    <span>© {{ date('Y') }} {{ config('current_shop')->name }}. Todos los derechos reservados.</span>
                    <span>Reporte Autogenerado por WIStore SICA</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Preview & Excel Controller Logic -->
    <script>
        window.applyCustomExcelStyle = function(xlsx, brandColor) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            var styles = xlsx.xl['styles.xml'];

            var hexColor = brandColor.replace('#', '').toUpperCase();
            if(hexColor.length === 6) hexColor = 'FF' + hexColor;

            var fills = $('fills', styles);
            var cellXfs = $('cellXfs', styles);
            var fonts = $('fonts', styles);

            // Fuente Título (Blanco, Bold, 14)
            fonts.append('<font><b/><sz val="14"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>');
            var fontTitleId = fonts.find('font').length - 1;
            
            // Fuente Thead (Blanco, Bold, 11)
            fonts.append('<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>');
            var fontTheadId = fonts.find('font').length - 1;
            
            // Fuente Subtítulo (Gris oscuro, Italic, 10)
            fonts.append('<font><i/><sz val="10"/><color rgb="FF475569"/><name val="Calibri"/></font>');
            var fontSubId = fonts.find('font').length - 1;

            // Relleno Marca
            fills.append('<fill><patternFill patternType="solid"><fgColor rgb="' + hexColor + '"/><bgColor indexed="64"/></patternFill></fill>');
            var fillBrandId = fills.find('fill').length - 1;
            
            // Relleno Gris Claro (Subtítulo)
            fills.append('<fill><patternFill patternType="solid"><fgColor rgb="FFF1F5F9"/><bgColor indexed="64"/></patternFill></fill>');
            var fillGrayId = fills.find('fill').length - 1;

            fonts.attr('count', fonts.find('font').length);
            fills.attr('count', fills.find('fill').length);

            // Estilos XF
            var styleTitleXml = '<xf numFmtId="0" fontId="'+fontTitleId+'" fillId="'+fillBrandId+'" borderId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>';
            cellXfs.append(styleTitleXml);
            var styleTitleId = cellXfs.find('xf').length - 1;

            var styleSubXml = '<xf numFmtId="0" fontId="'+fontSubId+'" fillId="'+fillGrayId+'" borderId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>';
            cellXfs.append(styleSubXml);
            var styleSubId = cellXfs.find('xf').length - 1;

            var styleTheadXml = '<xf numFmtId="0" fontId="'+fontTheadId+'" fillId="'+fillBrandId+'" borderId="1" applyFont="1" applyFill="1" applyAlignment="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>';
            cellXfs.append(styleTheadXml);
            var styleTheadId = cellXfs.find('xf').length - 1;

            cellXfs.attr('count', cellXfs.find('xf').length);

            // Aplicar a celdas
            $('row[r="1"] c', sheet).attr('s', styleTitleId); // Título
            $('row[r="2"] c', sheet).attr('s', styleSubId);   // Subtítulo (messageTop)
            $('row[r="3"] c', sheet).attr('s', styleTheadId); // Thead
        };

        function openPrintPreview(dt) {
            // Deduzco el título según el texto del elemento de menú activo del sidebar
            let activeLinkText = $('aside a.bg-primary\\/10 span').text().trim() || 'General';
            if (!activeLinkText || activeLinkText === "") {
                activeLinkText = "Inventario de Tienda";
            }
            let reportTitle = "Reporte de " + activeLinkText;
            $('#preview-report-title').text(reportTitle);
            
            // Obtengo las cabeceras de columnas (ignorando la última que es Acciones)
            let headers = [];
            dt.columns().every(function(index) {
                if (index < dt.columns().count() - 1) {
                    headers.push($(dt.column(index).header()).text().trim());
                }
            });
            
            // Obtengo los datos de las filas
            let rows = [];
            dt.rows({ search: 'applied', order: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
                let rowData = [];
                let cells = this.node().cells;
                for (let i = 0; i < cells.length - 1; i++) {
                    let $cell = $(cells[i]);
                    // Identifico si la celda tiene imágenes (ej: foto del producto)
                    if ($cell.find('img').length > 0) {
                        rowData.push({ type: 'image', value: $cell.find('img').attr('src') });
                    } else if ($cell.find('span.whitespace-nowrap').length > 0) {
                        // Es un badge con estilos
                        rowData.push({ type: 'badge', value: $cell.find('span').text().trim(), class: $cell.find('span').attr('class') });
                    } else {
                        rowData.push({ type: 'text', value: $cell.text().trim() });
                    }
                }
                rows.push(rowData);
            });
            
            $('#preview-record-count').text(rows.length);
            
            // Genero la tabla HTML limpia
            let tableHtml = '<thead><tr class="text-white border-b border-slate-400 font-extrabold uppercase tracking-wider text-[10px]" style="background-color: var(--color-primary, #E60067) !important;">';
            headers.forEach(h => {
                tableHtml += `<th class="px-4 py-3 border border-slate-300">${h}</th>`;
            });
            tableHtml += '</tr></thead><tbody>';
            
            if (rows.length === 0) {
                tableHtml += `<tr><td colspan="${headers.length}" class="px-4 py-8 text-center text-slate-400">No se encontraron registros.</td></tr>`;
            } else {
                rows.forEach(row => {
                    tableHtml += '<tr class="border-b border-slate-200 text-slate-700 hover:bg-slate-50">';
                    row.forEach(cell => {
                        tableHtml += '<td class="px-4 py-3 border border-slate-300 align-middle">';
                        if (cell.type === 'image') {
                            tableHtml += `<img src="${cell.value}" class="w-8 h-8 object-cover rounded-lg border border-slate-200">`;
                        } else if (cell.type === 'badge') {
                            tableHtml += `<span class="inline-block px-2.5 py-1 text-[10px] font-bold rounded-lg ${cell.class}">${cell.value}</span>`;
                        } else {
                            tableHtml += cell.value;
                        }
                        tableHtml += '</td>';
                    });
                    tableHtml += '</tr>';
                });
            }
            tableHtml += '</tbody>';
            
            $('#preview-table').html(tableHtml);
            
            // Muestro la modal
            $('#print-preview-modal').removeClass('hidden').addClass('flex');
        }
        
        function closePrintPreview() {
            $('#print-preview-modal').removeClass('flex').addClass('hidden');
        }
        
        function triggerPrint() {
            window.print();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
