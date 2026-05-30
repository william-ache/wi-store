<!DOCTYPE html>
<html lang="es" class="h-full wi-store-ui wi-store-admin" x-data="adminLayout" :class="{ 'dark': darkMode, 'admin-sidebar-open': sidebarOpen, 'admin-sidebar-mini': sidebarMini }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo.head', ['seo' => \App\Support\SeoMeta::admin()])
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '{{ \App\Support\PlanFeatures::brandColor(config('current_shop'), 'primary') }}',
                        secondary: '{{ \App\Support\PlanFeatures::brandColor(config('current_shop'), 'secondary') }}',
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom layout styling -->
    @include('partials.admin.styles')
    @include('partials.global.wi-store-scrollbar')
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
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

    @stack('page-styles')
</head>
<body class="wi-store-admin-body select-none transition-colors duration-300">

    <div class="admin-viewport">
        <div
            class="admin-sidebar-backdrop md:hidden"
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeSidebar()"
            aria-hidden="true"
        ></div>

        @include('components.admin.sidebar')

        <div class="admin-main-column">
            @include('components.admin.header')

            <div class="admin-topbar-spacer" aria-hidden="true"></div>

            @if(isset($shopIsInactive) && $shopIsInactive)
            <div class="max-w-7xl mx-auto w-full px-4 md:px-8 pt-4">
                <div class="bg-gradient-to-r from-red-600/90 to-rose-600/90 dark:from-red-950/80 dark:to-rose-950/80 backdrop-blur-md text-white px-6 py-4 rounded-2xl border border-red-500/30 dark:border-red-500/20 shadow-lg flex flex-col md:flex-row items-center justify-between gap-4 animate-pulse">
                    <div class="flex items-center gap-3.5 text-center md:text-left">
                        <div class="w-10 h-10 rounded-full bg-white/10 dark:bg-red-500/20 flex items-center justify-center text-xl animate-bounce shrink-0">
                            ⚠️
                        </div>
                        <div>
                            <h4 class="font-extrabold text-sm tracking-wide uppercase">Tienda Temporalmente Desactivada</h4>
                            <p class="text-xs text-red-100 dark:text-red-300 font-medium mt-0.5">
                                Para activarla nuevamente debe comprar un plan. El menú digital público se encuentra fuera de servicio y todos los accesos de escritura han sido suspendidos.
                            </p>
                        </div>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <span class="bg-white/10 dark:bg-white/5 border border-white/20 text-white text-[10px] uppercase font-black px-3.5 py-1.5 rounded-full tracking-wider shadow-inner hidden sm:inline-block">
                            Modo de Lectura
                        </span>
                        @php
                            $plan = config('current_shop')->plan ?? 'free_trial';
                            if ($plan === 'premium') {
                                $btnGradient = 'from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white shadow-[0_0_20px_rgba(168,85,247,0.3)]';
                                $planBadge = 'Activar Negocio 👑';
                            } elseif ($plan === 'standard') {
                                $btnGradient = 'from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-white shadow-[0_0_20px_rgba(14,165,233,0.3)]';
                                $planBadge = 'Activar Emprendedor ⚡';
                            } elseif ($plan === 'free_trial') {
                                $btnGradient = 'from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 shadow-[0_0_20px_rgba(16,185,129,0.3)]';
                                $planBadge = 'Comprar Plan 🎁';
                            } else {
                                $btnGradient = 'from-amber-500 to-yellow-500 hover:from-amber-400 hover:to-yellow-400 text-slate-950 shadow-[0_0_20px_rgba(245,158,11,0.3)]';
                                $planBadge = 'Comprar Plan 💎';
                            }
                        @endphp
                        <a href="/{{ config('current_shop')->slug }}/admin/billing/expired" class="bg-gradient-to-r {{ $btnGradient }} text-xs font-black px-4 py-2.5 rounded-xl tracking-wider shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center gap-1.5 shrink-0 border border-white/10">
                            {{ $planBadge }}
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- CORE DASHBOARD BODY -->
            <main class="admin-main-content max-w-7xl mx-auto w-full px-4 md:px-8 py-6 space-y-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Modal Notifications List -->
    @include('modals.admin.all-notifications')

    <!-- Print Preview Overlay Modal -->
    @include('modals.admin.print-preview')

    <!-- Modal Compartir Catálogo (QR) -->
    @include('modals.admin.share-qr')

    <!-- Modal de Feedback Global -->
    @include('modals.admin.feedback')
    @include('modals.admin.rate-wi-store')

    @include('partials.admin.request-loader')

    <!-- Common Layout AlpineJS and Excel export scripts -->
    @include('partials.admin.scripts')
    @include('partials.admin.request-loader-script')
    
    @stack('scripts')
</body>
</html>
