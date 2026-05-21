<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $company['name'] }} - Menú Digital</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Leaflet para el Mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        :root {
            --color-primary: {{ $company['colors']['primary'] }};
            --color-secondary: {{ $company['colors']['secondary'] }};
            --color-bg: {{ $company['colors']['bg_light'] }};
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Outfit', 'sans-serif';
            background: linear-gradient(135deg, var(--color-bg) 0%, rgba(255, 255, 255, 0.4) 100%);
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.02); }
        ::-webkit-scrollbar-thumb { background: var(--color-primary); border-radius: 9999px; transition: background 0.3s ease; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-secondary); }
        * { scrollbar-width: thin; scrollbar-color: var(--color-primary) transparent; }

        @keyframes shine {
            0% { transform: translateX(-100%) skewX(-15deg); }
            50% { transform: translateX(100%) skewX(-15deg); }
            100% { transform: translateX(100%) skewX(-15deg); }
        }
        .animate-shine {
            animation: shine 0.8s ease-in-out;
        }

        /* Daltonism Filter Classes */
        .daltonism-protanopia { filter: url(#protanopia); }
        .daltonism-deuteranopia { filter: url(#deuteranopia); }
        .daltonism-tritanopia { filter: url(#tritanopia); }
        .daltonism-monochromacy { filter: grayscale(100%); }

        /* Custom styled Range Slider */
        input[type="range"]::-webkit-slider-runnable-track {
            background: #E2E8F0;
            height: 6px;
            border-radius: 9999px;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--color-primary);
            cursor: pointer;
            margin-top: -6px;
            border: 2px solid #FFFFFF;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
            transition: transform 0.1s ease;
        }
        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }
        input[type="range"]:focus {
            outline: none;
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 pb-12 select-none flex flex-col" x-data="storeApp()">

@php
    $currencySymbol = '$';
    $bc = strtolower($company['base_currency'] ?? 'usd');
    if ($bc === 'eur') $currencySymbol = '€';
    elseif ($bc === 'bs' || $bc === 'ves') $currencySymbol = 'Bs.';
    elseif ($bc === 'cop') $currencySymbol = 'COP ';

    // Parse payment methods safely
    $paymentMethodsRaw = $company['payment_methods'] ?? '';
    $paymentMethods = [];
    try {
        if (!empty($paymentMethodsRaw) && str_starts_with(trim($paymentMethodsRaw), '{')) {
            $paymentMethods = json_decode($paymentMethodsRaw, true) ?: [];
        }
    } catch (\Exception $e) {
        $paymentMethods = [];
    }

    if (empty($paymentMethods) && !empty($paymentMethodsRaw)) {
        foreach (explode(',', $paymentMethodsRaw) as $m) {
            $name = trim($m);
            if ($name) {
                $paymentMethods[$name] = ['active' => true, 'details' => ''];
            }
        }
    }

    if (empty($paymentMethods)) {
        $paymentMethods = [
            'Efectivo' => ['active' => true, 'details' => ''],
            'Pago Móvil' => ['active' => true, 'details' => '']
        ];
    }

    // Filter only active ones for display
    $activePaymentMethods = [];
    foreach ($paymentMethods as $name => $data) {
        if (!empty($data['active'])) {
            $activePaymentMethods[$name] = $data;
        }
    }

    // Helpers to get icon and color for categories (with automatic name-based fallbacks)
    $getCategoryIcon = function($category) {
        if (!empty($category->icon)) {
            return $category->icon;
        }
        $name = mb_strtolower($category->name, 'UTF-8');
        if (str_contains($name, 'empanada')) {
            if (str_contains($name, 'clásica') || str_contains($name, 'clasica')) return 'fa-fire';
            return 'fa-star';
        }
        if (str_contains($name, 'bebida') || str_contains($name, 'refresco') || str_contains($name, 'jugo')) return 'fa-glass-water';
        if (str_contains($name, 'dulce') || str_contains($name, 'chuchería') || str_contains($name, 'chucheria') || str_contains($name, 'postre')) return 'fa-candy-cane';
        if (str_contains($name, 'conveniencia') || str_contains($name, 'cesta') || str_contains($name, 'carrito') || str_contains($name, 'artículo') || str_contains($name, 'articulo')) return 'fa-basket-shopping';
        if (str_contains($name, 'hamburguesa')) return 'fa-hamburger';
        if (str_contains($name, 'pizza')) return 'fa-pizza-slice';
        if (str_contains($name, 'pollo') || str_contains($name, 'carne')) return 'fa-drumstick-bite';
        if (str_contains($name, 'hot dog') || str_contains($name, 'perro')) return 'fa-hotdog';
        if (str_contains($name, 'combo') || str_contains($name, 'promoción') || str_contains($name, 'promo')) return 'fa-tags';
        
        return 'fa-folder'; // default fallback icon
    };

    $getCategoryColor = function($category) {
        if (!empty($category->color)) {
            return $category->color;
        }
        $name = mb_strtolower($category->name, 'UTF-8');
        if (str_contains($name, 'empanada')) {
            if (str_contains($name, 'clásica') || str_contains($name, 'clasica')) return '#10B981'; // green/emerald
            return '#EF4444'; // red
        }
        if (str_contains($name, 'bebida') || str_contains($name, 'refresco') || str_contains($name, 'jugo')) return '#06B6D4'; // cyan
        if (str_contains($name, 'dulce') || str_contains($name, 'chuchería') || str_contains($name, 'chucheria') || str_contains($name, 'postre')) return '#EC4899'; // pink
        if (str_contains($name, 'conveniencia') || str_contains($name, 'cesta') || str_contains($name, 'carrito') || str_contains($name, 'artículo') || str_contains($name, 'articulo')) return '#6366F1'; // indigo
        if (str_contains($name, 'hamburguesa')) return '#F59E0B'; // amber
        if (str_contains($name, 'pizza')) return '#EF4444'; // red
        if (str_contains($name, 'combo') || str_contains($name, 'promoción') || str_contains($name, 'promo')) return '#8B5CF6'; // purple
        
        return 'var(--color-primary)'; // default primary color fallback
    };

    // Clean and parse exchange rate safely
    $rawExchangeRate = $company['exchange_rate'] ?? '0';
    $cleanExchangeRate = preg_replace('/^[a-zA-Z.\s]+/', '', $rawExchangeRate);
    $cleanExchangeRate = str_replace(',', '.', $cleanExchangeRate);
    $exchangeRateFloat = (float) preg_replace("/[^0-9.]/", "", $cleanExchangeRate);

    /**
     * Extrae y valida la configuración de badge desde el campo features del producto.
     * Estructura: features.badge = { text, bgColor, icon, position }
     * 
     * @param mixed $product
     * @return array|null  Devuelve el badgeConfig o null si no está configurado
     */
    $getBadgeConfig = function($product): ?array {
        $features = is_array($product->features) ? $product->features : [];
        $badge = $features['badge'] ?? null;
        if (!$badge || empty($badge['text'])) return null;
        return [
            'text'     => (string) ($badge['text'] ?? ''),
            'bgColor'  => (string) ($badge['bgColor'] ?? '#1e293b'),
            'icon'     => (string) ($badge['icon'] ?? ''),
            'position' => in_array($badge['position'] ?? 'left', ['left', 'right']) ? $badge['position'] : 'left',
        ];
    };
@endphp

    <!-- LOADER -->
    <div id="app-loader" class="fixed inset-0 bg-white flex flex-col justify-center items-center z-[9999] transition-opacity duration-500">
        <div class="relative w-24 h-24 flex justify-center items-center mb-2">
            <div class="absolute inset-0 border-4 border-slate-100 rounded-full animate-spin" style="border-top-color: var(--color-primary);"></div>
            <img src="{{ !empty($company['logo']) ? $company['logo'] : asset('img/default-logo.png') }}" alt="Logo" class="w-20 h-20 rounded-full object-cover shadow-sm animate-pulse">
        </div>
        <span class="mt-4 text-xs font-semibold tracking-wider text-slate-400 uppercase">Cargando Menú...</span>
    </div>

    <!-- PORTADA / BANNER DE LA TIENDA (MÓVIL Y PC) -->
    <main class="flex-grow">
    <div class="relative h-56 md:h-80 w-full bg-slate-900 overflow-hidden">
        <img src="{{ $company['cover'] }}" alt="Portada" class="w-full h-full object-cover opacity-70">
        <!-- Oscurecimiento sutil general -->
        <div class="absolute inset-0 bg-black/10"></div>
        <!-- Desvanecimiento (Fade) elegante hacia el color de fondo de la aplicación -->
        <div class="absolute inset-x-0 bottom-0 h-32 md:h-48" style="background: linear-gradient(to top, var(--color-bg) 0%, transparent 100%);"></div>
    </div>

    <!-- MAIN CONTAINER - ESTRUCTURA 2 COLUMNAS (FLEXBOX) -->
    <div class="max-w-7xl mx-auto px-4 md:px-8 -mt-16 md:-mt-32 relative z-30 pb-8">
        <div class="flex flex-col md:flex-row gap-8 items-start">
            
            <!-- A. COLUMNA IZQUIERDA (Info Tienda - Sidebar integrado) -->
            <div class="w-full md:w-80 md:shrink-0 md:sticky md:top-6 space-y-6">
                <!-- Se redujo el border-radius, se quitó el shadow gigante y backdrop-blur para hacerlo más sutil -->
                <div class="relative bg-white/95 backdrop-blur-xl border border-white/40 rounded-2xl p-6 shadow-lg text-center mt-0">
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full border-4 border-white bg-white shadow-sm overflow-hidden">
                        <img src="{{ !empty($company['logo']) ? $company['logo'] : asset('img/default-logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>

                    <div class="pt-10">
                        <h1 class="text-xl md:text-2xl font-black tracking-tight" style="color: var(--color-secondary);">
                            {{ $company['name'] }}
                        </h1>
                        <p class="text-xs text-slate-500 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-map-marker-alt"></i>
                            @if(!empty($company['google_maps_link']))
                                <a href="{{ $company['google_maps_link'] }}" target="_blank" class="hover:underline hover:text-slate-700 transition">{{ $company['address'] }}</a>
                            @else
                                {{ $company['address'] }}
                            @endif
                        </p>

                        <div class="flex flex-wrap items-center justify-center gap-2 mt-4 text-[10px] md:text-xs font-semibold">
                            <!-- DYNAMIC STATUS BADGE -->
                            <span :class="storeStatus.colorClass" class="px-3 py-1 rounded-full border flex items-center gap-1 shadow-sm transition-all duration-300 cursor-pointer hover:scale-105 active:scale-95" @click="showSchedulesModal = true">
                                <span :class="storeStatus.dotClass" class="w-2 h-2 rounded-full animate-ping"></span>
                                <span x-text="storeStatus.label"></span>
                            </span>

                            <!-- PREPARATION TIME BADGE -->
                            <span class="bg-slate-50 text-slate-600 px-3 py-1 rounded-full border border-slate-100 flex items-center gap-1 shadow-sm hover:bg-slate-100 transition cursor-pointer" style="color: var(--color-secondary);">
                                <span class="text-[10px]">⏱️</span> 20-30 min
                            </span>

                            <!-- RATING BADGE -->
                            <span class="bg-amber-50 text-amber-600 px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1 shadow-sm hover:bg-amber-100 transition cursor-pointer" @click="showReviewsModal = true">
                                <i class="fas fa-star text-amber-400 text-[10px]"></i> <span x-text="averageRating.toFixed(1)">{{ number_format($averageRating, 1) }}</span>
                            </span>

                            <!-- CURRENT BRANCH BADGE -->
                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full border border-blue-100 flex items-center gap-1 hover:bg-blue-100 transition cursor-pointer shadow-sm" @click="showBranchesModal = true">
                                <i class="fas fa-store text-blue-500 text-[10px]"></i> Sede: {{ $company['name'] }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-600 mt-4 leading-relaxed">
                            {{ $company['description'] ?: '¡Haz tu pedido en línea de forma rápida y sencilla!' }}
                        </p>

                        <!-- PARSEO DE WHATSAPP MULTI-CONTACTO -->
                        @php
                            $whatsappRaw = $company['whatsapp'] ?? '';
                            $whatsapps = [];
                            
                            if (!empty($whatsappRaw)) {
                                if (str_contains($whatsappRaw, ',')) {
                                    $parts = explode(',', $whatsappRaw);
                                    $index = 1;
                                    foreach ($parts as $part) {
                                        $part = trim($part);
                                        if (empty($part)) continue;
                                        
                                        if (str_contains($part, ':')) {
                                            $subparts = explode(':', $part, 2);
                                            $label = trim($subparts[0]);
                                            $num = preg_replace('/[^0-9]/', '', $subparts[1]);
                                            if (!empty($num)) {
                                                $whatsapps[] = ['label' => $label, 'number' => $num];
                                            }
                                        } else {
                                            $num = preg_replace('/[^0-9]/', '', $part);
                                            if (!empty($num)) {
                                                $whatsapps[] = ['label' => 'WhatsApp ' . $index++, 'number' => $num];
                                            }
                                        }
                                    }
                                } else {
                                    if (str_contains($whatsappRaw, ':')) {
                                        $subparts = explode(':', $whatsappRaw, 2);
                                        $label = trim($subparts[0]);
                                        $num = preg_replace('/[^0-9]/', '', $subparts[1]);
                                        if (!empty($num)) {
                                            $whatsapps[] = ['label' => $label, 'number' => $num];
                                        }
                                    } else {
                                        $num = preg_replace('/[^0-9]/', '', $whatsappRaw);
                                        if (!empty($num)) {
                                            $whatsapps[] = ['label' => 'WhatsApp', 'number' => $num];
                                        }
                                    }
                                }
                            }
                            
                            if (empty($whatsapps) && !empty($whatsappRaw)) {
                                $whatsapps[] = ['label' => 'WhatsApp', 'number' => preg_replace('/[^0-9]/', '', $whatsappRaw)];
                            }
                        @endphp

                        <!-- REDES SOCIALES -->
                        @php
                            $hasFacebook = !empty($company['facebook']);
                            $hasTiktok = !empty($company['tiktok']);
                            $hasInstagram = !empty($company['instagram']);
                            $hasX = !empty($company['x_twitter']);
                            $hasAnySocial = $hasFacebook || $hasTiktok || $hasInstagram || $hasX;
                        @endphp

                        @if($hasAnySocial)
                            <div class="mt-4 flex items-center justify-center gap-2.5 select-none">
                                <!-- Facebook -->
                                @if($hasFacebook)
                                    <a href="{{ $company['facebook'] }}" target="_blank"
                                       class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-[#1877F2]/10 border-[#1877F2]/20 text-[#1877F2] hover:bg-[#1877F2] hover:text-white hover:scale-110 active:scale-95"
                                       title="Visítanos en Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif

                                <!-- TikTok -->
                                @if($hasTiktok)
                                    <a href="{{ $company['tiktok'] }}" target="_blank"
                                       class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-black/10 border-black/20 text-black hover:bg-black hover:text-white hover:scale-110 active:scale-95 group"
                                       title="Síguenos en TikTok">
                                        <i class="fab fa-tiktok text-black group-hover:text-white transition-colors"></i>
                                    </a>
                                @endif

                                <!-- Instagram -->
                                @if($hasInstagram)
                                    <a href="{{ $company['instagram'] }}" target="_blank"
                                       class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-gradient-to-tr from-[#FFB703]/10 to-[#E60067]/10 border-[#E60067]/20 text-[#E60067] hover:from-[#FFB703] hover:to-[#E60067] hover:text-white hover:scale-110 active:scale-95"
                                       title="Síguenos en Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif

                                <!-- X (Twitter) -->
                                @if($hasX)
                                    <a href="{{ $company['x_twitter'] }}" target="_blank"
                                       class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-black/10 border-black/20 text-black hover:bg-black hover:text-white hover:scale-110 active:scale-95 group"
                                       title="Síguenos en X (Twitter)">
                                        <svg class="w-3 h-3 text-black group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- CANALES DE CONTACTO -->
                        @php
                            $hasTelegram = !empty($company['telegram']);
                            $hasTelegramUrl = $hasTelegram ? (str_contains($company['telegram'], 't.me') ? $company['telegram'] : 'https://t.me/' . ltrim($company['telegram'], '@')) : '';
                            $hasAnyContact = !empty($company['whatsapp']) || $hasTelegram;
                        @endphp

                        @if($hasAnyContact)
                            <div class="mt-3.5 flex flex-wrap justify-center gap-1.5 text-[9px] md:text-[10px] font-bold select-none">
                                <!-- WhatsApp -->
                                @if(!empty($company['whatsapp']))
                                    @if(count($whatsapps) > 1)
                                        <button @click="showWhatsappModal = true"
                                                class="flex items-center gap-1 bg-emerald-50 hover:bg-emerald-500 hover:text-white border border-emerald-100 text-emerald-600 px-2.5 py-1 rounded-xl transition duration-300 active:scale-95 shadow-sm cursor-pointer">
                                            <i class="fab fa-whatsapp text-xs"></i> WhatsApp
                                        </button>
                                    @else
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapps[0]['number'] ?? $company['whatsapp']) }}" target="_blank"
                                           class="flex items-center gap-1 bg-emerald-50 hover:bg-emerald-500 hover:text-white border border-emerald-100 text-emerald-600 px-2.5 py-1 rounded-xl transition duration-300 active:scale-95 shadow-sm">
                                            <i class="fab fa-whatsapp text-xs"></i> WhatsApp
                                        </a>
                                    @endif
                                @endif

                                <!-- Telegram Contacto -->
                                @if($hasTelegram)
                                    <a href="{{ $hasTelegramUrl }}" target="_blank"
                                       class="flex items-center gap-1 bg-sky-50 hover:bg-[#0088cc] hover:text-white border border-[#0088cc]/20 text-[#0088cc] px-2.5 py-1 rounded-xl transition duration-300 active:scale-95 shadow-sm">
                                        <i class="fab fa-telegram-plane text-xs"></i> Telegram
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- MÉTODOS DE PAGO -->
                        @php
                            $methodColors = [
                                'Transferencia' => 'bg-slate-600 hover:bg-slate-700 text-white border-slate-600',
                                'Pago Móvil' => 'bg-teal-500 hover:bg-teal-600 text-white border-teal-500',
                                'Efectivo' => 'bg-emerald-600 hover:bg-emerald-700 text-white border-emerald-600',
                                'Zelle' => 'bg-purple-600 hover:bg-purple-700 text-white border-purple-600',
                                'Binance' => 'bg-amber-500 hover:bg-amber-600 text-white border-amber-500',
                                'PayPal' => 'bg-blue-600 hover:bg-blue-700 text-white border-blue-600',
                                'Punto de Venta' => 'bg-indigo-500 hover:bg-indigo-600 text-white border-indigo-500',
                            ];
                        @endphp
                        <!-- TASA MONETARIA -->
                        @if(!empty($company['exchange_rate']))
                        <div class="mt-6 w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 flex flex-col items-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-0.5">Tasa Monetaria</span>
                            <span class="text-lg font-black text-slate-800">{{ $company['exchange_rate'] }}</span>
                            @if(!empty($company['exchange_updated_at']))
                            <span class="text-[9px] text-slate-400 font-semibold mt-0.5">Actualizado: {{ $company['exchange_updated_at'] }}</span>
                            @endif
                        </div>
                        @endif

                        <!-- MÉTODOS DE PAGO -->
                        <div class="mt-5 text-center border-t border-slate-100 pt-4 flex flex-col items-center w-full">
                            <button @click="showAllPaymentMethodsModal = true"
                                    class="w-full bg-gradient-to-r from-slate-800 to-slate-900 hover:from-slate-900 hover:to-black text-white font-extrabold py-3 px-4 rounded-2xl text-[11px] flex items-center justify-center gap-2 transition shadow-md hover:scale-[1.01] active:scale-95 select-none cursor-pointer border border-slate-700/30">
                                <i class="fas fa-wallet text-xs"></i> 
                                <span>Ver Métodos de Pago</span>
                                <span class="bg-white/20 text-white text-[9px] px-2 py-0.5 rounded-full font-black ml-1 shadow-sm">{{ count($activePaymentMethods) }}</span>
                            </button>
                        </div>

                        <!-- BOTONES DE ACCIÓN (HORARIOS, SUCURSALES Y OPINIONES) -->
                        <div class="mt-5 grid grid-cols-2 gap-2">
                            <button @click="showSchedulesModal = true" class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                                <i class="far fa-clock"></i> <span>Horarios</span>
                            </button>
                            <button @click="showBranchesModal = true" class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                                <i class="fas fa-store"></i> <span>Sucursales</span>
                            </button>
                        </div>
                        <button @click="showReviewsModal = true" class="mt-2 w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition active:scale-95 shadow-sm">
                            <i class="fas fa-comment-dots"></i> 
                            <span>Ver Opiniones</span>
                            <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-extrabold ml-1 shadow-sm" x-text="totalReviewsCount">{{ $reviews->count() }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- B. COLUMNA CENTRAL (Buscador, Categorías y Productos) -->
            <div class="flex-1 w-full space-y-6">
                
                <!-- Buscador Dinámico -->
                <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-100 flex items-center gap-2">
                    <i class="fas fa-search text-slate-400 ml-3"></i>
                    <input type="text" x-model="searchQuery" placeholder="Buscar productos..." class="w-full bg-transparent border-none focus:ring-0 text-sm py-2 px-2 text-slate-800 placeholder-slate-400">
                    <button x-show="searchQuery !== ''" @click="searchQuery = ''" class="mr-3 text-slate-400 hover:text-rose-500"><i class="fas fa-times"></i></button>
                </div>

                <!-- Categorías (Navegación Horizontal - Cards Premium) -->
                <div class="sticky top-4 z-40 bg-white/95 backdrop-blur-md py-2 px-4 rounded-2xl shadow-md border border-slate-100/80 transition-all duration-300">
                    <div id="category-nav-bar" class="flex items-start md:justify-center gap-3.5 md:gap-5 overflow-x-auto whitespace-nowrap scrollbar-none py-0.5">
                        
                        <!-- Todas -->
                        <a href="#" id="nav-chip-0" class="flex flex-col items-center gap-0.5 group cursor-pointer focus:outline-none select-none transition-all duration-300 shrink-0"
                           @click.prevent="scrollToCategory(0)">
                            <div class="relative w-9 h-9 rounded-lg bg-white border flex items-center justify-center transition-all duration-300 shadow-sm"
                                 :class="activeCategory === 0 ? 'scale-105 shadow-md ring-2 ring-[var(--color-primary)]/10' : 'border-slate-100 hover:border-slate-300 hover:scale-102'"
                                 :style="activeCategory === 0 ? 'border-color: var(--color-primary);' : ''">
                                <i class="fas fa-border-all text-xs transition-colors duration-300"
                                   :class="activeCategory === 0 ? 'text-[var(--color-primary)]' : 'text-slate-400 group-hover:text-slate-600'"></i>
                                
                                <span class="absolute -top-1 -right-1 text-[6.5px] font-black text-white px-0.5 py-0.25 min-w-[13px] h-[13px] rounded-full border border-white shadow-sm flex items-center justify-center transition-all duration-300"
                                      style="background-color: var(--color-primary);">
                                    {{ $categories->sum(fn($c) => $c->products->count()) }}
                                </span>
                            </div>
                            <span class="text-[7.5px] font-black tracking-wider uppercase transition-colors duration-300 text-center max-w-[60px] whitespace-normal break-words leading-tight pt-0.5"
                                  :class="activeCategory === 0 ? 'text-slate-900 font-extrabold' : 'text-slate-400 group-hover:text-slate-600'">
                                Todas
                            </span>
                        </a>

                        @foreach($categories as $category)
                            @php
                                $icon = $getCategoryIcon($category);
                                $color = $getCategoryColor($category);
                                $prodCount = $category->products->count();
                            @endphp
                            <a href="#cat-{{ $category->id }}" id="nav-chip-{{ $category->id }}"
                               class="flex flex-col items-center gap-0.5 group cursor-pointer focus:outline-none select-none transition-all duration-300 shrink-0"
                               @click.prevent="scrollToCategory({{ $category->id }})">
                                <div class="relative w-9 h-9 rounded-lg bg-white border flex items-center justify-center transition-all duration-300 shadow-sm"
                                     :class="activeCategory === {{ $category->id }} ? 'scale-105 shadow-md ring-2' : 'border-slate-100 hover:border-slate-300 hover:scale-102'"
                                     :style="activeCategory === {{ $category->id }} ? 'border-color: ' + '{{ $color }}' + '; ring-color: ' + '{{ $color }}1A' + ';' : ''">
                                    <i class="fas {{ $icon }} text-xs transition-all duration-300"
                                       :style="activeCategory === {{ $category->id }} ? 'color: ' + '{{ $color }}' : ''"
                                       :class="activeCategory === {{ $category->id }} ? '' : 'text-slate-400 group-hover:text-slate-600'"></i>
                                    
                                    <span class="absolute -top-1 -right-1 text-[6.5px] font-black text-white px-0.5 py-0.25 min-w-[13px] h-[13px] rounded-full border border-white shadow-sm flex items-center justify-center transition-all duration-300"
                                          style="background-color: {{ $color }};">
                                        {{ $prodCount }}
                                    </span>
                                </div>
                                <span class="text-[7.5px] font-black tracking-wider uppercase transition-all duration-300 text-center max-w-[60px] whitespace-normal break-words leading-tight pt-0.5"
                                      :class="activeCategory === {{ $category->id }} ? 'text-slate-900 font-extrabold' : 'text-slate-400 group-hover:text-slate-600'">
                                    {{ $category->name }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- PRODUCTOS -->
                <div id="products-container">
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                        <section id="cat-{{ $category->id }}" class="mb-10 scroll-mt-28" 
                                 x-intersect:enter="onSectionIntersect({{ $category->id }}, true)"
                                 x-show="(selectedCategory === 0 || selectedCategory === {{ $category->id }}) && (searchQuery === '' || [
                                     @foreach($category->products as $product)
                                         '{{ strtolower(str_replace("'", "\'", $product->name)) }}',
                                     @endforeach
                                 ].some(name => name.includes(searchQuery.toLowerCase())))"
                                 x-transition:enter="transition ease-out duration-400"
                                 x-transition:enter-start="opacity-0 translate-y-4"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-4">
                            @php
                                $color = $getCategoryColor($category);
                                $icon = $getCategoryIcon($category);
                            @endphp
                            <div class="flex items-center gap-2 mb-4 select-none">
                                <span class="w-1 h-6 rounded-full shrink-0" style="background-color: {{ $color }};"></span>
                                <div class="w-7 h-7 rounded-xl flex items-center justify-center border shrink-0 transition-all duration-300"
                                     style="background-color: {{ $color }}15; border-color: {{ $color }}25; color: {{ $color }};">
                                    <i class="fas {{ $icon }} text-xs"></i>
                                </div>
                                <h2 class="text-base md:text-lg font-black tracking-tight" style="color: var(--color-secondary);">{{ $category->name }}</h2>
                                <span class="text-[9px] font-black text-white px-1.5 py-0.5 rounded-lg flex items-center justify-center shadow-sm shrink-0"
                                      style="background-color: {{ $color }};"
                                      x-text="[
                                          @foreach($category->products as $p)
                                              '{{ strtolower(str_replace("'", "\'", $p->name)) }}',
                                          @endforeach
                                      ].filter(name => name.includes(searchQuery.toLowerCase())).length + ' disp.'">
                                    {{ $category->products->count() }} disp.
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($category->products as $product)
                                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm flex flex-col justify-between relative overflow-hidden group"
                                     x-data="{ qty: 1, clicked: false }"
                                     x-show="searchQuery === '' || '{{ strtolower(str_replace("'", "\'", $product->name)) }}'.includes(searchQuery.toLowerCase())"
                                     x-transition:enter="transition-all ease-out duration-300 transform"
                                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition-all ease-in duration-200 transform"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 translate-y-2">
                                    @if($product->image_path)
                                    @php $badgeConfig = $getBadgeConfig($product); @endphp
                                    <div class="h-40 w-full bg-slate-50 shrink-0 relative overflow-hidden">
                                        <img @click="openProductDetails({{ $product->toJson() }})" src="{{ filter_var($product->image_path, FILTER_VALIDATE_URL) ? $product->image_path : asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300 select-none">
                                        
                                        {{-- ── BADGE CHIP (badgeConfig from features.badge) ── --}}
                                        @if($badgeConfig)
                                        <div class="absolute top-2 z-10 pointer-events-none {{ $badgeConfig['position'] === 'right' ? 'right-2' : 'left-2' }}">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black text-white tracking-wide shadow-[0_2px_8px_rgba(0,0,0,0.28)] ring-1 ring-white/20 backdrop-blur-[2px] select-none"
                                                  style="background-color: {{ $badgeConfig['bgColor'] }};">
                                                @if($badgeConfig['icon'])
                                                <i class="fa-solid {{ $badgeConfig['icon'] }} text-[9px] leading-none"></i>
                                                @endif
                                                {{ $badgeConfig['text'] }}
                                            </span>
                                        </div>
                                        @endif
                                        
                                        <!-- Shein-like variant color swatches overlay -->
                                        <div class="absolute bottom-2 right-2 flex gap-1 bg-white/80 backdrop-blur-[2px] px-1.5 py-1 rounded-full shadow-sm max-w-[90%] overflow-x-auto scrollbar-none"
                                             x-show="getProductFeatures({{ $product->toJson() }}).colors && getProductFeatures({{ $product->toJson() }}).colors.length > 0"
                                             @click.stop>
                                            <template x-for="color in getProductFeatures({{ $product->toJson() }}).colors.slice(0, 4)" :key="color.name">
                                                <button type="button" 
                                                        @click="openProductDetails({{ $product->toJson() }}, { selectedColor: color.name })"
                                                        class="w-3.5 h-3.5 rounded-full border border-white shadow-sm hover:scale-110 active:scale-95 transition-transform cursor-pointer"
                                                        :style="{ backgroundColor: color.hex }"
                                                        :title="color.name">
                                                </button>
                                            </template>
                                            <template x-if="getProductFeatures({{ $product->toJson() }}).colors && getProductFeatures({{ $product->toJson() }}).colors.length > 4">
                                                <span class="text-[8px] font-black text-slate-600 flex items-center justify-center px-0.5" x-text="'+' + (getProductFeatures({{ $product->toJson() }}).colors.length - 4)"></span>
                                            </template>
                                        </div>
                                    </div>
                                    @else
                                    @php $badgeConfig = $getBadgeConfig($product); @endphp
                                    @endif

                                    <div class="flex-grow flex flex-col justify-between p-4 relative">
                                        {{-- Badge para productos sin imagen --}}
                                        @if(!$product->image_path && isset($badgeConfig) && $badgeConfig)
                                        <div class="absolute top-2 z-10 {{ $badgeConfig['position'] === 'right' ? 'right-2' : 'left-2' }}">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black text-white tracking-wide shadow-[0_2px_8px_rgba(0,0,0,0.18)] ring-1 ring-black/5 select-none"
                                                  style="background-color: {{ $badgeConfig['bgColor'] }};">
                                                @if($badgeConfig['icon'])
                                                <i class="fa-solid {{ $badgeConfig['icon'] }} text-[9px] leading-none"></i>
                                                @endif
                                                {{ $badgeConfig['text'] }}
                                            </span>
                                        </div>
                                        @endif
                                        <div>
                                            <h3 class="text-base md:text-lg font-bold text-slate-900 mb-1.5 leading-tight">{{ $product->name }}</h3>
                                            <p class="text-xs md:text-sm text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                                        </div>
                                        
                                        <div class="flex flex-col gap-3 mt-auto">
                                            <!-- Price and Quantity Control Row -->
                                            <div class="flex justify-between items-center">
                                                <div class="flex flex-col">
                                                    <span class="text-sm md:text-base font-black text-slate-900">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</span>
                                                    @if($exchangeRateFloat > 0)
                                                         @php
                                                             $bsPrice = $product->price * $exchangeRateFloat;
                                                         @endphp
                                                         <span class="text-[10px] text-slate-400 font-extrabold mt-0.5">Bs. {{ number_format($bsPrice, 2, ',', '.') }}</span>
                                                     @endif
                                                 </div>
                                                
                                                <!-- Qty Pill Selector -->
                                                <div class="flex items-center gap-1.5 bg-slate-50 p-1 rounded-full border border-slate-200/80 shadow-inner">
                                                    <button type="button" @click="if (qty > 1) qty--" class="w-6 h-6 rounded-full bg-white text-slate-600 flex items-center justify-center font-black text-xs hover:bg-rose-50 hover:text-rose-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">-</button>
                                                    <span class="text-[11px] font-black text-slate-700 w-4 text-center select-none" x-text="qty"></span>
                                                    <button type="button" @click="qty++" class="w-6 h-6 rounded-full bg-white text-slate-600 flex items-center justify-center font-black text-xs hover:bg-emerald-50 hover:text-emerald-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">+</button>
                                                </div>
                                            </div>
                                            
                                            <!-- Action Button -->
                                            <div class="mt-auto w-full">
                                                <button type="button" 
                                                        class="w-full py-2.5 rounded-xl text-white font-extrabold text-xs flex items-center justify-center gap-1.5 shadow-sm transition-all duration-300 relative overflow-hidden select-none cursor-pointer hover:scale-[1.02] active:scale-95"
                                                        style="background-color: var(--color-primary);"
                                                        @click="
                                                            const _f = getProductFeatures({{ $product->toJson() }});
                                                            const _hasVariants = (_f.colors && _f.colors.length > 0) || (_f.sizes && _f.sizes.length > 0) || (_f.units && _f.units.length > 0);
                                                            if (_hasVariants) {
                                                                openProductDetails({{ $product->toJson() }}, { qty: qty });
                                                            } else {
                                                                clicked = true;
                                                                addToCartWithQty({{ $product->toJson() }}, qty);
                                                                setTimeout(() => { clicked = false; qty = 1; }, 1200);
                                                            }
                                                        ">
                                                    <template x-if="!clicked">
                                                        <span class="flex items-center gap-1.5">
                                                            <i class="fas fa-shopping-basket text-[10px]"></i>
                                                            <span>Agregar al Pedido</span>
                                                            <span class="opacity-80 font-bold" x-show="qty > 1" x-text="'(' + qty + ')'"></span>
                                                        </span>
                                                    </template>
                                                    <template x-if="clicked">
                                                        <span class="flex items-center gap-1.5">
                                                            <i class="fas fa-check text-[10px]"></i>
                                                            <span>¡Agregado!</span>
                                                        </span>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </section>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </main>

    <!-- SYSTEM FOOTER -->
    @if(env('SYSTEM_BRAND_NAME'))
    <div class="w-full text-center py-4 mt-2 select-none">
        <a href="{{ env('SYSTEM_BRAND_URL', '#') }}" target="_blank" class="text-xs font-black tracking-widest uppercase transition-all duration-300 hover:scale-105 inline-block" style="color: var(--color-primary);">
            {{ env('SYSTEM_BRAND_NAME') }} <span class="opacity-75 font-semibold">v{{ env('SYSTEM_BRAND_VERSION', '1.0.0') }}</span>
        </a>
    </div>
    @endif

    <!-- FLOATING CART BUTTON -->
    <div class="fixed bottom-6 right-6 z-40" x-show="totalItems > 0" x-transition style="display: none;">
        <button @click="isCartOpen = true" class="relative w-16 h-16 rounded-full flex items-center justify-center text-white shadow-[0_8px_30px_rgba(0,0,0,0.3)] hover:scale-105 active:scale-95 transition-transform" style="background-color: var(--color-primary);">
            <i class="fas fa-shopping-bag text-2xl"></i>
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[11px] font-black w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow-sm" x-text="totalItems"></span>
        </button>
    </div>

    <!-- FLOATING ACCESSIBILITY BUTTON -->
    <div class="fixed bottom-6 left-6 z-40">
        <button @click="showAccessibilityModal = true" class="w-10 h-10 rounded-full flex items-center justify-center bg-white border border-slate-200 text-slate-700 shadow-[0_4px_12px_rgba(0,0,0,0.08)] hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer" title="Configuración y Accesibilidad">
            <i class="fas fa-universal-access text-base" style="color: var(--color-primary);"></i>
        </button>
    </div>

    <!-- ACCESSIBILITY MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showAccessibilityModal" @click="showAccessibilityModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[88%] max-w-[290px] bg-white rounded-[24px] shadow-2xl z-[1001] max-h-[80vh] flex flex-col overflow-hidden origin-center"
         x-show="showAccessibilityModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        
        <!-- Header -->
        <div class="py-3 px-4 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-1.5">
                <i class="fas fa-universal-access text-sm"></i>
                <h2 class="text-xs font-black tracking-tight">Accesibilidad</h2>
            </div>
            <button @click="showAccessibilityModal = false" class="text-white/80 hover:text-white hover:bg-white/10 w-6 h-6 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-3 overflow-y-auto bg-slate-50 space-y-3 scrollbar-none">
            <!-- Font Size Card -->
            <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                <div class="flex items-center gap-1.5 text-slate-700">
                    <i class="fas fa-font text-[10px]"></i>
                    <h3 class="text-[9px] font-black uppercase tracking-wider">Tamaño de Letra</h3>
                </div>
                <p class="text-[9px] text-slate-500 leading-normal font-medium">
                    Desliza para aumentar el tamaño del texto.
                </p>

                <!-- Premium Range Slider -->
                <div class="relative pt-5 pb-1 px-0.5">
                    <!-- Bubble Indicator -->
                    <div class="absolute -top-1.5 bg-slate-800 text-white text-[8px] font-black px-1.5 py-0.5 rounded shadow-sm flex items-center justify-center whitespace-nowrap z-10 pointer-events-none transition-all duration-75 select-none"
                         :style="{ left: 'calc(' + ((accessibility.fontSize - 14) / 10) * 100 + '% - 0px)', transform: 'translateX(-50%)' }">
                        <span x-text="accessibility.fontSize + ' px'"></span>
                        <div class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-slate-800 rotate-45"></div>
                    </div>

                    <!-- Track and input -->
                    <div class="relative flex items-center">
                        <span class="text-[9px] font-black text-slate-400 shrink-0 mr-1.5 select-none">A</span>
                        <input type="range" min="14" max="24" step="1" x-model="accessibility.fontSize" @input="updateFontSize()"
                               class="w-full h-1 rounded-lg appearance-none cursor-pointer accent-[var(--color-primary)]">
                        <span class="text-xs font-black text-slate-400 shrink-0 ml-1.5 select-none">A</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-center text-[8px] text-slate-400 font-bold uppercase tracking-wider border-t border-slate-55 pt-2 px-0.5 shrink-0">
                    <span>Estándar (16px)</span>
                    <button type="button" @click="accessibility.fontSize = 16; updateFontSize()" class="text-[var(--color-primary)] hover:underline active:scale-95 font-extrabold cursor-pointer">Restablecer</button>
                </div>
            </div>

            <!-- Daltonism / Color Filters Card -->
            <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm space-y-2 shrink-0">
                <div class="flex items-center gap-1.5 text-slate-700">
                    <i class="fas fa-eye-dropper text-[10px]"></i>
                    <h3 class="text-[9px] font-black uppercase tracking-wider">Daltonismo</h3>
                </div>
                <p class="text-[9px] text-slate-500 leading-normal font-medium">
                    Optimiza los colores del menú.
                </p>

                <!-- Grid of Daltonism Options -->
                <div class="grid grid-cols-1 gap-1.5">
                    <!-- Normal -->
                    <button type="button" @click="setDaltonism('normal')"
                            class="w-full px-2.5 py-1.5 rounded-xl border text-left transition duration-200 flex justify-between items-center active:scale-[0.99] cursor-pointer"
                            :class="accessibility.daltonism === 'normal' ? 'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' : 'border-slate-200 hover:bg-slate-50 text-slate-600'">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold">Visión Normal</span>
                            <span class="text-[8px] opacity-75 mt-0.5">Colores estándar del menú</span>
                        </div>
                        <div class="flex gap-0.5 shrink-0">
                            <span class="w-2 h-2 rounded-full bg-rose-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-sky-500 border border-white shadow-sm"></span>
                        </div>
                    </button>

                    <!-- Protanopia -->
                    <button type="button" @click="setDaltonism('protanopia')"
                            class="w-full px-2.5 py-1.5 rounded-xl border text-left transition duration-200 flex justify-between items-center active:scale-[0.99] cursor-pointer"
                            :class="accessibility.daltonism === 'protanopia' ? 'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' : 'border-slate-200 hover:bg-slate-50 text-slate-600'">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold">Protanopía</span>
                            <span class="text-[8px] opacity-75 mt-0.5">Insensibilidad al color rojo</span>
                        </div>
                        <div class="flex gap-0.5 style='filter: url(#protanopia);' shrink-0">
                            <span class="w-2 h-2 rounded-full bg-rose-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-sky-500 border border-white shadow-sm"></span>
                        </div>
                    </button>

                    <!-- Deuteranopia -->
                    <button type="button" @click="setDaltonism('deuteranopia')"
                            class="w-full px-2.5 py-1.5 rounded-xl border text-left transition duration-200 flex justify-between items-center active:scale-[0.99] cursor-pointer"
                            :class="accessibility.daltonism === 'deuteranopia' ? 'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' : 'border-slate-200 hover:bg-slate-50 text-slate-600'">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold">Deuteranopía</span>
                            <span class="text-[8px] opacity-75 mt-0.5">Insensibilidad al color verde</span>
                        </div>
                        <div class="flex gap-0.5 style='filter: url(#deuteranopia);' shrink-0">
                            <span class="w-2 h-2 rounded-full bg-rose-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-sky-500 border border-white shadow-sm"></span>
                        </div>
                    </button>

                    <!-- Tritanopia -->
                    <button type="button" @click="setDaltonism('tritanopia')"
                            class="w-full px-2.5 py-1.5 rounded-xl border text-left transition duration-200 flex justify-between items-center active:scale-[0.99] cursor-pointer"
                            :class="accessibility.daltonism === 'tritanopia' ? 'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' : 'border-slate-200 hover:bg-slate-50 text-slate-600'">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold">Tritanopía</span>
                            <span class="text-[8px] opacity-75 mt-0.5">Insensibilidad al azul / amarillo</span>
                        </div>
                        <div class="flex gap-0.5 style='filter: url(#tritanopia);' shrink-0">
                            <span class="w-2 h-2 rounded-full bg-rose-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-sky-500 border border-white shadow-sm"></span>
                        </div>
                    </button>

                    <!-- Monochromacy -->
                    <button type="button" @click="setDaltonism('monochromacy')"
                            class="w-full px-2.5 py-1.5 rounded-xl border text-left transition duration-200 flex justify-between items-center active:scale-[0.99] cursor-pointer"
                            :class="accessibility.daltonism === 'monochromacy' ? 'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' : 'border-slate-200 hover:bg-slate-50 text-slate-600'">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold">Monocromía</span>
                            <span class="text-[8px] opacity-75 mt-0.5">Escala completa de grises</span>
                        </div>
                        <div class="flex gap-0.5 style='filter: grayscale(100%);' shrink-0">
                            <span class="w-2 h-2 rounded-full bg-rose-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 border border-white shadow-sm"></span>
                            <span class="w-2 h-2 rounded-full bg-sky-500 border border-white shadow-sm"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer button -->
        <div class="p-3 bg-white border-t border-slate-100 text-center select-none shrink-0">
            <button @click="showAccessibilityModal = false" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-2 rounded-xl transition active:scale-95 text-[9px] uppercase tracking-wider cursor-pointer">
                Listo / Guardar
            </button>
        </div>
    </div>

    <!-- WHATSAPP MULTI-CONTACT MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showWhatsappModal" @click="showWhatsappModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-xs bg-white rounded-3xl shadow-2xl z-[1001] overflow-hidden origin-center flex flex-col max-h-[85vh]"
         x-show="showWhatsappModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <!-- Header -->
        <div class="p-4 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fab fa-whatsapp text-base"></i>
                <h2 class="text-base font-black tracking-tight">Contactar por WhatsApp</h2>
            </div>
            <button @click="showWhatsappModal = false" class="text-white/80 hover:text-white hover:bg-white/10 w-8 h-8 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-4 bg-slate-50 overflow-y-auto space-y-2 scrollbar-none">
            <p class="text-[10px] text-slate-500 font-medium text-center mb-3">
                Selecciona a qué contacto o departamento deseas escribir:
            </p>
            @foreach($whatsapps as $wa)
                <a href="https://wa.me/{{ $wa['number'] }}" target="_blank" @click="showWhatsappModal = false"
                   class="flex items-center justify-between bg-white border border-slate-100 hover:border-emerald-300 hover:bg-emerald-50/20 px-3.5 py-3 rounded-2xl transition duration-200 shadow-sm active:scale-[0.98] group">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="text-xs font-black text-slate-800 group-hover:text-emerald-700 transition-colors">{{ $wa['label'] }}</span>
                            <span class="text-[9px] text-slate-400 font-semibold mt-0.5">{{ $wa['number'] }}</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-[8px] text-slate-355 group-hover:translate-x-0.5 group-hover:text-emerald-500 transition-all"></i>
                </a>
            @endforeach
        </div>
        <!-- Footer -->
        <div class="p-3 bg-white border-t border-slate-100 text-center shrink-0">
            <button @click="showWhatsappModal = false" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold py-2.5 rounded-xl transition active:scale-95 text-[10px] uppercase tracking-wider cursor-pointer">
                Cancelar
            </button>
        </div>
    </div>

    <!-- WHATSAPP ORDER DIRECTION MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showOrderWhatsappModal" @click="showOrderWhatsappModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-xs bg-white rounded-3xl shadow-2xl z-[1001] overflow-hidden origin-center flex flex-col max-h-[85vh]"
         x-show="showOrderWhatsappModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <!-- Header -->
        <div class="p-4 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fab fa-whatsapp text-base"></i>
                <h2 class="text-base font-black tracking-tight">Enviar Pedido</h2>
            </div>
            <button @click="showOrderWhatsappModal = false" class="text-white/80 hover:text-white hover:bg-white/10 w-8 h-8 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-4 bg-slate-50 overflow-y-auto space-y-2 scrollbar-none">
            <p class="text-[10px] text-slate-500 font-medium text-center mb-3">
                Selecciona a qué sucursal o departamento enviar tu pedido:
            </p>
            @foreach($whatsapps as $wa)
                <button @click="redirectToOrderWhatsApp('{{ $wa['number'] }}')"
                   class="w-full flex items-center justify-between bg-white border border-slate-100 hover:border-emerald-300 hover:bg-emerald-50/20 px-3.5 py-3 rounded-2xl transition duration-200 shadow-sm active:scale-[0.98] group cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="text-xs font-black text-slate-800 group-hover:text-emerald-700 transition-colors">{{ $wa['label'] }}</span>
                            <span class="text-[9px] text-slate-400 font-semibold mt-0.5">{{ $wa['number'] }}</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-[8px] text-slate-355 group-hover:translate-x-0.5 group-hover:text-emerald-500 transition-all"></i>
                </button>
            @endforeach
        </div>
        <!-- Footer -->
        <div class="p-3 bg-white border-t border-slate-100 text-center shrink-0">
            <button @click="showOrderWhatsappModal = false" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold py-2.5 rounded-xl transition active:scale-95 text-[10px] uppercase tracking-wider cursor-pointer">
                Cancelar
            </button>
        </div>
    </div>

    <!-- CART MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="isCartOpen" @click="isCartOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-bottom-right"
         x-show="isCartOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <div class="p-6 flex justify-between items-center select-none text-white shadow-sm" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-shopping-bag text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Mi Pedido</h2>
            </div>
            <button @click="isCartOpen = false" class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 flex-grow overflow-y-auto scrollbar-none bg-slate-50 space-y-6">
            <!-- CART ITEMS -->
            <div class="space-y-3">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex justify-between items-center bg-white border border-slate-100 p-4 rounded-2xl shadow-sm hover:shadow-md transition duration-200">
                        <div>
                            <span class="text-sm font-bold text-slate-800 block" x-text="item.name"></span>
                            <div class="flex flex-col">
                                <span class="text-xs font-extrabold text-[var(--color-primary)]" x-text="currencySymbol + (item.price * item.quantity).toFixed(2)"></span>
                                <span x-show="exchangeRate > 0" class="text-[10px] text-slate-400 font-bold mt-0.5" x-text="'Bs. ' + ((item.price * item.quantity) * exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-7 h-7 rounded-full bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center font-extrabold text-sm hover:bg-rose-100 transition active:scale-90" @click="updateQty(item.id, -1)">-</button>
                            <span class="text-sm font-extrabold text-slate-800" x-text="item.quantity"></span>
                            <button class="w-7 h-7 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center font-extrabold text-sm hover:bg-emerald-100 transition active:scale-90" @click="updateQty(item.id, 1)">+</button>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="text-center py-8 text-sm text-slate-400 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">El carrito está vacío.</div>
            </div>
            
            <!-- DELIVERY INFO WRAPPED IN AN ELEGANT CARD PANEL -->
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-4" x-show="cart.length > 0">
                <h3 class="text-sm font-black text-slate-800 flex items-center gap-1.5">
                    <span class="w-1.5 h-3.5 rounded-full bg-[var(--color-primary)]"></span>
                    Datos de Entrega
                </h3>
                
                <div class="flex bg-slate-100 rounded-2xl p-1 border border-slate-200/40">
                    <button @click="deliveryType = 'pickup'; deliveryCost = 0"
                            :class="deliveryType === 'pickup' ? 'bg-white shadow-md text-slate-900 font-extrabold scale-[1.01]' : 'text-slate-500 hover:text-slate-800 font-bold'"
                            class="flex-1 py-2.5 text-xs rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-store"></i> Retiro en local
                    </button>
                    <button @click="deliveryType = 'delivery'; if(!mapInitialized) { initMap(); } else { setTimeout(() => { if(map) map.invalidateSize(); }, 50); }"
                            :class="deliveryType === 'delivery' ? 'bg-white shadow-md text-slate-900 font-extrabold scale-[1.01]' : 'text-slate-500 hover:text-slate-800 font-bold'"
                            class="flex-1 py-2.5 text-xs rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-motorcycle"></i> Delivery
                    </button>
                </div>

                <!-- DELIVERY METODO TABS (MAPA O GPS) -->
                <div x-show="deliveryType === 'delivery'" x-transition class="space-y-3 pt-1">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Método de ubicación:</p>
                    <div class="grid grid-cols-2 gap-2 bg-slate-100 rounded-xl p-1 border border-slate-200/40">
                        <button @click="deliveryMode = 'map'; if(!mapInitialized) { initMap(); } else { setTimeout(() => { if(map) map.invalidateSize(); }, 50); }"
                                :class="deliveryMode === 'map' ? 'bg-white shadow-sm text-slate-800 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-bold'"
                                class="py-2 text-[11px] rounded-lg transition flex items-center justify-center gap-1.5">
                            <i class="fas fa-map-marked-alt text-[var(--color-primary)]"></i> Ubicar en Mapa
                        </button>
                        <button @click="deliveryMode = 'gps'; useGPS()"
                                :class="deliveryMode === 'gps' ? 'bg-white shadow-sm text-slate-800 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-bold'"
                                class="py-2 text-[11px] rounded-lg transition flex items-center justify-center gap-1.5">
                            <i class="fas fa-location-arrow text-emerald-500" :class="isGpsLoading ? 'animate-spin' : ''"></i>
                            <span x-text="isGpsLoading ? 'Obteniendo GPS...' : 'Usar mi GPS'">Usar mi GPS</span>
                        </button>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[10px] text-slate-500 font-bold flex items-center gap-1">
                            <i class="fas fa-info-circle text-[var(--color-primary)]"></i>
                            <span x-show="deliveryMode === 'map'">Mueve el marcador o haz clic en el mapa para fijar tu entrega:</span>
                            <span x-show="deliveryMode === 'gps'">Mapa centrado en tu señal de GPS. Puedes reajustar si es necesario:</span>
                        </p>
                        
                        <div class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-inner">
                            <div id="delivery-map" class="w-full h-44 z-10" wire:ignore></div>
                            <div x-show="gpsSuccess" class="absolute top-2 right-2 bg-emerald-500 text-white text-[9px] font-black px-2.5 py-1 rounded-lg z-20 shadow flex items-center gap-1 animate-pulse">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span> GPS ACTIVO
                            </div>
                        </div>
                        
                        <p x-show="deliveryCost > 0" class="text-xs text-emerald-800 font-bold bg-emerald-50/80 p-3 rounded-2xl text-center border border-emerald-100 mt-2 shadow-sm flex flex-col justify-center items-center gap-0.5">
                            <span>Distancia calculada: <span class="text-slate-900" x-text="deliveryDistance.toFixed(2)"></span> km</span>
                            <span class="text-emerald-600 text-sm">Costo de Envío: <span class="font-extrabold" x-text="currencySymbol + deliveryCost.toFixed(2)"></span></span>
                        </p>
                    </div>
                </div>

                <!-- CLIENT FIELDS WITH NICE FLOATING LOOK & LEFT ICONS -->
                <div class="space-y-3 pt-2">
                    <div>
                        <div class="relative">
                            <i class="far fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" x-model="customerName" 
                                   class="w-full rounded-xl pl-11 pr-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:ring-2 shadow-sm transition placeholder-slate-400"
                                   :class="showErrors && !customerName.trim() ? 'border border-rose-300 focus:border-rose-500 focus:ring-rose-500/10 bg-rose-50/20' : 'border border-slate-200 focus:border-[var(--color-primary)] focus:bg-white focus:ring-[var(--color-primary)]/10 bg-slate-50'"
                                   placeholder="Tu nombre completo">
                        </div>
                        <span x-show="showErrors && !customerName.trim()" x-transition class="text-[11px] text-rose-600 font-bold mt-1.5 ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Por favor ingresa tu nombre.
                        </span>
                    </div>
                    <div>
                        <div class="relative">
                            <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="tel" x-model="customerPhone" 
                                   class="w-full rounded-xl pl-11 pr-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:ring-2 shadow-sm transition placeholder-slate-400"
                                   :class="showErrors && !customerPhone.trim() ? 'border border-rose-300 focus:border-rose-500 focus:ring-rose-500/10 bg-rose-50/20' : 'border border-slate-200 focus:border-[var(--color-primary)] focus:bg-white focus:ring-[var(--color-primary)]/10 bg-slate-50'"
                                   placeholder="Tu número de celular / WhatsApp">
                        </div>
                        <span x-show="showErrors && !customerPhone.trim()" x-transition class="text-[11px] text-rose-600 font-bold mt-1.5 ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Por favor ingresa tu número de celular.
                        </span>
                    </div>
                </div>
            </div>

            <!-- PAYMENT METHOD SELECTION CARD PANEL -->
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-4" x-show="cart.length > 0">
                <h3 class="text-sm font-black text-slate-800 flex items-center gap-1.5 select-none">
                    <span class="w-1.5 h-3.5 rounded-full bg-[var(--color-primary)]"></span>
                    Método de Pago
                </h3>
                
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="(methodData, methodName) in paymentMethodsList" :key="methodName">
                        <button type="button" 
                                @click="selectPayment(methodName)"
                                :class="selectedPaymentMethod === methodName ? 'ring-2 ring-[var(--color-primary)] bg-slate-50/80 text-slate-900 border-transparent shadow-sm' : 'border border-slate-200 text-slate-500 hover:text-slate-800 bg-white'"
                                class="py-3 px-3 text-xs rounded-2xl font-bold transition flex flex-col items-center justify-center gap-2 cursor-pointer relative overflow-hidden group">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" :class="selectedPaymentMethod === methodName ? 'text-[var(--color-primary)]' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="font-extrabold text-[11px]" x-text="methodName"></span>
                            </span>
                            <div x-show="selectedPaymentMethod === methodName" class="absolute top-1 right-1 text-[var(--color-primary)]">
                                <i class="fas fa-check-circle text-[10px]"></i>
                            </div>
                        </button>
                    </template>
                </div>

                <!-- DYNAMIC PAYMENT METHOD DETAILS IN CART -->
                <div x-show="selectedPaymentDetails.trim() !== ''" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="bg-slate-50 border border-slate-150/50 p-4 rounded-2xl space-y-2.5">
                    <div class="flex justify-between items-center select-none">
                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest flex items-center gap-1">
                            <i class="fas fa-info-circle text-[var(--color-primary)]"></i> Datos para transferir / pagar
                        </span>
                        <div x-data="{ copied: false }">
                            <button type="button" @click="navigator.clipboard.writeText(selectedPaymentDetails); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="text-[9px] font-bold text-[var(--color-primary)] hover:underline flex items-center gap-0.5 cursor-pointer">
                                <i class="far" :class="copied ? 'fa-check-circle text-emerald-500' : 'fa-copy'"></i>
                                <span x-text="copied ? '¡Copiado!' : 'Copiar'">Copiar</span>
                            </button>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-700 leading-relaxed font-semibold whitespace-pre-line bg-white/70 p-3 rounded-xl border border-slate-100 shadow-inner" x-text="selectedPaymentDetails"></p>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border-t border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <span class="text-base font-black text-slate-800">Total:</span>
                <div class="text-right">
                    <span class="text-lg font-black text-slate-900 block" x-text="currencySymbol + (total + deliveryCost).toFixed(2)"></span>
                    <span x-show="exchangeRate > 0" class="text-xs font-bold text-slate-400 block mt-0.5" 
                          x-text="'Bs. ' + ((total + deliveryCost) * exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </div>
            </div>
            <button @click="sendWhatsApp()" class="w-full bg-[#25D366] text-white font-extrabold py-3.5 rounded-2xl flex items-center justify-center gap-2 active:scale-95 transition shadow-lg shadow-emerald-500/20 text-sm">
                <i class="fab fa-whatsapp text-lg"></i> Confirmar y Enviar Pedido
            </button>
        </div>
    </div>

    <!-- SCHEDULES MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showSchedulesModal" @click="showSchedulesModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
         x-show="showSchedulesModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <h2 class="text-xl font-black text-slate-800">Horarios de Atención</h2>
            <button @click="showSchedulesModal = false" class="text-slate-400 hover:text-rose-500 w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 transition"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-2.5 scrollbar-none">
            <!-- Si es tipo simple, mostrar una tarjeta elegante con el texto simple -->
            <template x-if="workHours && workHours.type === 'simple'">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <i class="far fa-clock text-[var(--color-primary)] text-3xl mb-3 block"></i>
                    <p class="text-sm font-bold text-slate-700 leading-relaxed" x-text="workHours.text || 'Sin horario configurado'"></p>
                </div>
            </template>
            
            <!-- Si es tipo custom, mostrar la lista detallada por día de la semana -->
            <template x-if="!workHours || workHours.type === 'custom'">
                <div class="space-y-2.5">
                    <template x-for="day in ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']" :key="day">
                        <div class="flex justify-between items-center bg-white px-4 py-3 rounded-xl border border-slate-100 shadow-sm">
                            <span class="text-sm font-bold" :class="day === 'Domingo' ? 'text-rose-500' : 'text-slate-700'" x-text="day"></span>
                            
                            <!-- Cerrado -->
                            <template x-if="getScheduleDay(day).closed">
                                <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-2.5 py-1 rounded-md uppercase tracking-wider border border-rose-100">Cerrado</span>
                            </template>
                            
                            <!-- Abierto con horario -->
                            <template x-if="!getScheduleDay(day).closed">
                                <span class="text-xs font-bold text-slate-500" x-text="formatTimeRange(getScheduleDay(day).open, getScheduleDay(day).close)"></span>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <!-- BRANCHES MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showBranchesModal" @click="showBranchesModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
         x-show="showBranchesModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <h2 class="text-xl font-black text-slate-800">Nuestras Sucursales</h2>
            <button @click="showBranchesModal = false" class="text-slate-400 hover:text-rose-500 w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 transition"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-4 scrollbar-none">
            @foreach($branches as $branch)
                @php
                    $isCurrent = $branch->slug === $company['slug'];
                @endphp
                <div class="bg-white p-5 rounded-2xl border-2 shadow-sm relative overflow-hidden transition duration-300 {{ $isCurrent ? 'border-[var(--color-primary)] ring-1 ring-[var(--color-primary)]/20' : 'border-slate-100 hover:shadow-md hover:border-slate-200' }}">
                    @if($isCurrent)
                        <div class="absolute top-0 right-0 bg-[var(--color-primary)] text-white text-[9px] font-black uppercase px-2.5 py-1 rounded-bl-xl shadow-sm">Actual</div>
                    @endif
                    <h3 class="text-sm font-black text-slate-800 mb-1.5">{{ $branch->name }}</h3>
                    <p class="text-xs text-slate-500 flex items-start gap-1.5 leading-relaxed">
                        <i class="fas fa-map-marker-alt mt-0.5 text-slate-400"></i> {{ $branch->address ?: 'Dirección no especificada' }}
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @if(!empty($branch->google_maps_link))
                            <a href="{{ $branch->google_maps_link }}" target="_blank" class="text-[10px] font-bold text-[var(--color-primary)] bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-xl hover:bg-blue-100 transition flex items-center gap-1 active:scale-95">
                                <i class="fas fa-directions"></i> Cómo llegar
                            </a>
                        @endif
                        @if(!$isCurrent)
                            <a href="/{{ $branch->slug }}" class="text-[10px] font-bold text-slate-600 bg-slate-100 border border-slate-200 px-3 py-1.5 rounded-xl hover:bg-slate-250 transition flex items-center gap-1 active:scale-95">
                                <i class="fas fa-exchange-alt text-slate-400"></i> Ir a esta Sede
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- REVIEWS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showReviewsModal" @click="showReviewsModal = false; showForm = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
         x-show="showReviewsModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;" x-data="{ showForm: false }">
        <div class="p-6 flex justify-between items-center text-white shadow-sm select-none" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-comment-dots text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Opiniones</h2>
            </div>
            <button @click="showReviewsModal = false; showForm = false" class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i class="fas fa-times text-lg"></i></button>
        </div>
        
        @php
            $totalReviews = $reviews->count();
            $count5 = $reviews->where('rating', 5)->count();
            $count4 = $reviews->where('rating', 4)->count();
            $count3 = $reviews->where('rating', 3)->count();
            $count2 = $reviews->where('rating', 2)->count();
            $count1 = $reviews->where('rating', 1)->count();

            $pct5 = $totalReviews > 0 ? ($count5 / $totalReviews) * 100 : 0;
            $pct4 = $totalReviews > 0 ? ($count4 / $totalReviews) * 100 : 0;
            $pct3 = $totalReviews > 0 ? ($count3 / $totalReviews) * 100 : 0;
            $pct2 = $totalReviews > 0 ? ($count2 / $totalReviews) * 100 : 0;
            $pct1 = $totalReviews > 0 ? ($count1 / $totalReviews) * 100 : 0;
        @endphp

        <!-- Resumen de Valoración y Distribución Visual (Histograma) -->
        <div class="px-6 py-5 bg-slate-50 border-b border-slate-100 grid grid-cols-12 gap-4 items-center select-none">
            <!-- Puntuación Promedio (Hacer click aquí resetea a 'Todas') -->
            <div @click="starFilter = 0" 
                 class="col-span-4 text-center border-r border-slate-200/80 pr-3 flex flex-col justify-center items-center cursor-pointer p-2.5 rounded-2xl transition hover:bg-slate-200/40"
                 :class="starFilter === 0 ? 'bg-slate-250 ring-1 ring-slate-200/60' : ''"
                 title="Ver todas las opiniones">
                <span class="text-4xl font-black text-slate-800 leading-none" x-text="averageRating.toFixed(1)">{{ number_format($averageRating, 1) }}</span>
                <div class="flex justify-center text-amber-400 text-xs my-1.5 gap-0.5">
                    <template x-for="i in 5" :key="i">
                        <i :class="i <= Math.round(averageRating) ? 'fas fa-star' : 'far fa-star'"></i>
                    </template>
                </div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">
                    <span x-text="totalReviewsCount">{{ $totalReviews }}</span> <span x-text="totalReviewsCount === 1 ? 'opinión' : 'opiniones'">{{ $totalReviews == 1 ? 'opinión' : 'opiniones' }}</span>
                </span>
            </div>

            <!-- Distribución / Histograma de Barras (Filtrables al hacer click) -->
            <div class="col-span-8 space-y-1 pl-3">
                @foreach([5, 4, 3, 2, 1] as $star)
                    @php
                        $cStar = ${"count".$star};
                        $pctStar = ${"pct".$star};
                    @endphp
                    <div @click="starFilter = starFilter === {{ $star }} ? 0 : {{ $star }}"
                         class="flex items-center gap-2 text-[10px] font-bold text-slate-500 cursor-pointer p-1 rounded-xl transition hover:bg-slate-200/50"
                         :class="starFilter === {{ $star }} ? 'bg-amber-100/50 text-amber-900 ring-1 ring-amber-200/70' : ''"
                         title="Filtrar por {{ $star }} estrellas">
                        <span class="w-3 text-right">{{ $star }}</span>
                        <i class="fas fa-star text-amber-400 text-[8px]"></i>
                        <div class="flex-grow bg-slate-200 rounded-full h-2 overflow-hidden shadow-inner">
                            <div class="bg-amber-400 h-full rounded-full transition-all duration-500" 
                                 :style="'width: ' + starPercentages[{{ $star }}] + '%'"
                                 style="width: {{ $pctStar }}%"></div>
                        </div>
                        <span class="w-6 text-right text-slate-400 font-semibold" x-text="starCounts[{{ $star }}]">{{ $cStar }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Banner de Filtro Activo -->
        <div x-show="starFilter !== 0" x-cloak x-transition
             class="px-6 py-2.5 bg-amber-50/50 border-b border-slate-100 flex justify-between items-center text-xs select-none">
            <span class="text-amber-800/90 font-bold flex items-center gap-1.5">
                <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Mostrando opiniones de <span x-text="starFilter" class="underline decoration-amber-400 font-black"></span> estrellas
            </span>
            <button @click="starFilter = 0" class="text-[var(--color-primary)] hover:underline font-extrabold text-[10px] uppercase tracking-wider transition active:scale-95">
                Ver Todas
            </button>
        </div>

        <div class="p-6 flex-grow overflow-y-auto scrollbar-none bg-slate-50">
            <div class="space-y-4">
                <!-- Alpine Dynamic List -->
                <template x-for="(rev, index) in reviewsList" :key="index">
                    <div x-show="starFilter === 0 || starFilter === rev.rating" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white border border-slate-100 p-4 rounded-2xl shadow-sm">
                        <div class="flex justify-between items-start mb-1">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-bold text-slate-800" x-text="rev.customer_name"></span>
                                <template x-if="rev.created_at">
                                    <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-1">
                                        <i class="fas fa-calendar-alt text-[9px]"></i>
                                        <span x-text="new Date(rev.created_at).toLocaleDateString('es-VE', { year: 'numeric', month: 'short', day: 'numeric' })"></span>
                                    </span>
                                </template>
                            </div>
                            <span class="text-xs text-amber-500 shrink-0 ml-2 mt-0.5">
                                <template x-for="star in 5" :key="star">
                                    <i :class="star <= rev.rating ? 'fas fa-star' : 'far fa-star'" class="mr-0.5"></i>
                                </template>
                            </span>
                        </div>
                        <template x-if="rev.comment">
                            <p class="text-xs text-slate-500 mt-2 italic" x-text="'“' + rev.comment + '”'"></p>
                        </template>
                    </div>
                </template>

                <!-- No reviews empty state -->
                <div x-show="reviewsList.length === 0" class="text-sm text-slate-400 text-center py-4">
                    No hay opiniones disponibles.
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-100 flex flex-col gap-3 select-none">
            <!-- Botón para desplegar el formulario -->
            <button x-show="!showForm" @click="showForm = true"
                    class="w-full bg-[var(--color-primary)] hover:brightness-110 text-white font-extrabold py-3 rounded-2xl text-xs transition shadow-lg shadow-[var(--color-primary)]/15 flex items-center justify-center gap-2 active:scale-[0.98]">
                <i class="fas fa-pen-fancy"></i> Agregar Opinión
            </button>

            <!-- Bloque del Formulario Desplegado -->
            <div x-show="showForm" x-cloak x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-sm font-black text-slate-800">Deja tu opinión</h3>
                    <button @click="showForm = false" class="text-slate-400 hover:text-slate-600 text-xs font-bold transition">Cancelar</button>
                </div>
                
                <div x-show="reviewSubmitted" class="bg-emerald-50 text-emerald-700 text-sm font-bold p-3 rounded-xl border border-emerald-100 text-center mb-0">¡Gracias por tu valoración!</div>
                <form @submit.prevent="submitReview" x-show="!reviewSubmitted" class="flex flex-col gap-3">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="checkbox" id="anon" x-model="review.anonymous" class="rounded border-slate-300 text-[var(--color-primary)]">
                        <label for="anon" class="text-xs font-bold text-slate-600 cursor-pointer">Comentar como Anónimo</label>
                    </div>
                    <input type="text" x-show="!review.anonymous" x-model="review.name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none" placeholder="Tu nombre">
                    
                    <div class="flex flex-col gap-2.5 bg-slate-50 border border-slate-200 rounded-2xl p-4 text-center select-none" x-data="{ hoverRating: 0 }">
                        <span class="text-xs font-black text-slate-500 block uppercase tracking-wider">Valoración de tu experiencia</span>
                        <div class="flex justify-center gap-4 py-1" @mouseleave="hoverRating = 0">
                            <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                <button type="button" 
                                        @click="review.rating = star"
                                        @mouseenter="hoverRating = star"
                                        class="text-3xl transition-all duration-150 transform hover:scale-125 focus:outline-none cursor-pointer"
                                        :class="(hoverRating ? hoverRating >= star : parseInt(review.rating) >= star) ? 'text-amber-400' : 'text-slate-300'">
                                    <i class="fas fa-star"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                    <textarea x-model="review.comment" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none" rows="2" placeholder="Opcional: Escribe un comentario..."></textarea>
                    <button type="submit" class="w-full text-white font-bold py-3 rounded-xl text-xs active:scale-95 transition mt-1" style="background-color: var(--color-primary);">Enviar Calificación</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- ALL PAYMENT METHODS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showAllPaymentMethodsModal" @click="showAllPaymentMethodsModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[92%] max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[85vh] flex flex-col overflow-hidden origin-center"
         x-show="showAllPaymentMethodsModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <!-- Header -->
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fas fa-wallet text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Métodos de Pago</h2>
            </div>
            <button @click="showAllPaymentMethodsModal = false" class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 bg-slate-50 overflow-y-auto space-y-4 scrollbar-none flex-grow">
            <!-- Tabs de métodos de pago -->
            <div class="flex flex-wrap gap-2 justify-center">
                <template x-for="(methodData, methodName) in paymentMethodsList" :key="methodName">
                    <button type="button"
                            @click="activeMethodTab = methodName"
                            :class="activeMethodTab === methodName ? (colors[methodName] || 'bg-[var(--color-primary)] text-white shadow-sm border-transparent') : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100'"
                            class="px-3.5 py-2 text-[10.5px] font-black rounded-xl border transition active:scale-95 cursor-pointer flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span x-text="methodName"></span>
                    </button>
                </template>
            </div>

            <!-- Detalles del método seleccionado -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3.5 mt-2">
                <div class="flex items-center gap-1.5 text-slate-800 border-b border-slate-100 pb-2.5">
                    <span class="w-1.5 h-3.5 rounded-full transition-all duration-300" :class="colors[activeMethodTab] ? colors[activeMethodTab].split(' ')[0] : 'bg-[var(--color-primary)]'"></span>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-700" x-text="activeMethodTab"></h3>
                </div>
                
                <div class="text-xs text-slate-600 leading-relaxed font-semibold bg-slate-50 p-4.5 rounded-xl border border-slate-150/50 whitespace-pre-line shadow-inner max-h-[250px] overflow-y-auto scrollbar-none" 
                     x-text="paymentMethodsList[activeMethodTab]?.details || 'Este método de pago no requiere datos adicionales.'"></div>
                
                <div x-data="{ copied: false }" class="pt-1.5">
                    <button @click="navigator.clipboard.writeText(paymentMethodsList[activeMethodTab]?.details || ''); copied = true; setTimeout(() => copied = false, 2000)"
                            class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl text-[11px] flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                        <i class="far" :class="copied ? 'fa-check-circle text-emerald-500' : 'fa-copy'"></i>
                        <span x-text="copied ? '¡Datos copiados!' : 'Copiar datos al portapapeles'">Copiar datos al portapapeles</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="p-5 bg-white border-t border-slate-100 text-center shrink-0">
            <button @click="showAllPaymentMethodsModal = false" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-3.5 rounded-xl transition active:scale-95 text-[11px] uppercase tracking-wider cursor-pointer">
                Cerrar
            </button>
        </div>
    </div>

    <!-- PAYMENT DETAILS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showPaymentDetailsModal" @click="showPaymentDetailsModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-center"
         x-show="showPaymentDetailsModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fas fa-wallet text-lg"></i>
                <h2 class="text-xl font-black tracking-tight" x-text="selectedPaymentMethodName">Datos de Pago</h2>
            </div>
            <button @click="showPaymentDetailsModal = false" class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-4 scrollbar-none">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <p class="text-xs text-slate-400 font-extrabold uppercase tracking-wider">Instrucciones para transferir / pagar:</p>
                <div class="text-sm text-slate-700 leading-relaxed font-semibold bg-slate-50 p-4 rounded-xl border border-slate-150/50 whitespace-pre-line" x-text="selectedPaymentMethodDetails"></div>
                
                <div x-data="{ copied: false }" class="pt-2">
                    <button @click="navigator.clipboard.writeText(selectedPaymentMethodDetails); copied = true; setTimeout(() => copied = false, 2000)"
                            class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                        <i class="far" :class="copied ? 'fa-check-circle text-emerald-500' : 'fa-copy'"></i>
                        <span x-text="copied ? '¡Datos copiados!' : 'Copiar datos al portapapeles'">Copiar datos al portapapeles</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="p-5 bg-white border-t border-slate-100 text-center select-none">
            <button @click="showPaymentDetailsModal = false" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-3.5 rounded-2xl transition active:scale-95 text-xs">
                Entendido / Cerrar
            </button>
        </div>
    </div>

    <!-- PRODUCT DETAILS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showProductModal" @click="showProductModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-center"
         x-show="showProductModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-50"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-50"
         style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm" style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fas fa-shopping-bag text-lg"></i>
                <h2 class="text-xl font-black tracking-tight" x-text="modalProduct ? modalProduct.name : 'Detalles de Producto'">Detalles del Producto</h2>
            </div>
            <button @click="showProductModal = false" class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-6 scrollbar-none flex-grow" x-data="{ modalClicked: false }">
            <!-- Image Slider / Carousel -->
            <div class="relative rounded-2xl overflow-hidden bg-slate-100 shadow-inner border border-slate-200" x-show="modalProduct">
                <!-- Slides Container -->
                <div class="h-64 w-full relative overflow-hidden">
                    <template x-for="(img, idx) in modalProductFeatures.images" :key="idx">
                        <div x-show="modalActiveSlide === idx"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-x-full"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 translate-x-0"
                             x-transition:leave-end="opacity-0 -translate-x-full"
                             class="absolute inset-0 flex items-center justify-center">
                            <img :src="img" class="w-full h-full object-cover" alt="Product Image slide">
                        </div>
                    </template>
                    <div x-show="!modalProductFeatures.images || modalProductFeatures.images.length === 0" class="absolute inset-0 flex items-center justify-center">
                        <img :src="modalProduct ? (modalProduct.image_path ? (modalProduct.image_path.startsWith('http') ? modalProduct.image_path : '/storage/' + modalProduct.image_path) : '') : ''" class="w-full h-full object-cover" alt="Default Product Image">
                    </div>
                </div>
                <!-- Left/Right Controls -->
                <template x-if="modalProductFeatures.images && modalProductFeatures.images.length > 1">
                    <div>
                        <button type="button" @click="modalActiveSlide = (modalActiveSlide === 0) ? modalProductFeatures.images.length - 1 : modalActiveSlide - 1"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-700 shadow flex items-center justify-center active:scale-90 transition">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </button>
                        <button type="button" @click="modalActiveSlide = (modalActiveSlide === modalProductFeatures.images.length - 1) ? 0 : modalActiveSlide + 1"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-700 shadow flex items-center justify-center active:scale-90 transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </template>
                <!-- Dots indicators -->
                <template x-if="modalProductFeatures.images && modalProductFeatures.images.length > 1">
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 bg-black/30 backdrop-blur-[2px] px-2.5 py-1 rounded-full">
                        <template x-for="(img, idx) in modalProductFeatures.images" :key="idx">
                            <button type="button" @click="modalActiveSlide = idx"
                                    class="w-1.5 h-1.5 rounded-full transition-all duration-200"
                                    :class="modalActiveSlide === idx ? 'bg-white w-3' : 'bg-white/50'"></button>
                        </template>
                    </div>
                </template>
            </div>
            
            <!-- Description -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block">Descripción</span>
                <p class="text-xs text-slate-600 leading-relaxed font-medium" x-text="modalProduct ? modalProduct.description : ''"></p>
            </div>
            
            <!-- Variants Selection Panels -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4" x-show="modalProduct">
                <!-- COLORS SELECTOR -->
                <div x-show="modalProductFeatures.colors && modalProductFeatures.colors.length > 0" class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Color seleccionado: <span class="text-slate-700 font-bold" x-text="modalSelectedColor"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <template x-for="color in modalProductFeatures.colors" :key="color.name">
                            <button type="button" @click="modalSelectedColor = color.name"
                                    class="w-8 h-8 rounded-full border-2 transition-all duration-200 cursor-pointer flex items-center justify-center shadow-sm relative hover:scale-105 active:scale-95"
                                    :class="modalSelectedColor === color.name ? 'border-[var(--color-primary)] ring-2 ring-[var(--color-primary)]/20' : 'border-white'"
                                    :style="{ backgroundColor: color.hex }"
                                    :title="color.name">
                                <i x-show="modalSelectedColor === color.name" 
                                   class="fas fa-check text-xs shadow-sm"
                                   :class="color.hex === '#FFFFFF' || color.hex === '#F8FAFC' ? 'text-slate-800' : 'text-white'"></i>
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- SIZES SELECTOR -->
                <div x-show="modalProductFeatures.sizes && modalProductFeatures.sizes.length > 0" class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Talla seleccionada: <span class="text-slate-700 font-bold" x-text="modalSelectedSize"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="size in modalProductFeatures.sizes" :key="size">
                            <button type="button" @click="modalSelectedSize = size"
                                    class="w-10 h-10 rounded-xl font-black text-xs transition-all duration-200 flex items-center justify-center border cursor-pointer active:scale-95"
                                    :class="modalSelectedSize === size ? 'border-[var(--color-primary)] bg-[var(--color-primary)] text-white shadow-sm shadow-[var(--color-primary)]/10 scale-105' : 'border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300'">
                                <span x-text="size"></span>
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- UNITS / WEIGHTS SELECTOR -->
                <div x-show="modalProductFeatures.units && modalProductFeatures.units.length > 0" class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Presentación seleccionada: <span class="text-slate-700 font-bold" x-text="modalSelectedUnit"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="unit in modalProductFeatures.units" :key="unit">
                            <button type="button" @click="modalSelectedUnit = unit"
                                    class="px-4 py-2.5 rounded-xl font-extrabold text-xs transition-all duration-200 flex items-center justify-center border cursor-pointer active:scale-95"
                                    :class="modalSelectedUnit === unit ? 'border-[var(--color-primary)] bg-[var(--color-primary)] text-white shadow-sm shadow-[var(--color-primary)]/10 scale-105' : 'border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300'">
                                <span x-text="unit"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Pricing row -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex justify-between items-center" x-show="modalProduct">
                <span class="text-xs font-black text-slate-800">Precio unitario:</span>
                <div class="text-right">
                    <span class="text-lg font-black text-slate-900 block" x-text="currencySymbol + (modalProduct ? parseFloat(modalProduct.price) : 0).toFixed(2)"></span>
                    <span x-show="exchangeRate > 0" class="text-xs font-bold text-slate-400 block mt-0.5" 
                          x-text="'Bs. ' + ((modalProduct ? parseFloat(modalProduct.price) : 0) * exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-white border-t border-slate-100 flex justify-between items-center gap-4" x-show="modalProduct">
            <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200/50 shadow-inner shrink-0">
                <button type="button" @click="if (modalQty > 1) modalQty--" class="w-8 h-8 rounded-xl bg-white text-slate-600 flex items-center justify-center font-black text-sm hover:bg-rose-50 hover:text-rose-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">-</button>
                <span class="text-xs font-black text-slate-700 w-6 text-center select-none" x-text="modalQty"></span>
                <button type="button" @click="modalQty++" class="w-8 h-8 rounded-xl bg-white text-slate-600 flex items-center justify-center font-black text-sm hover:bg-emerald-50 hover:text-emerald-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">+</button>
            </div>
            
            <button type="button" 
                    class="flex-grow py-3.5 px-4 rounded-2xl text-white font-extrabold text-sm flex items-center justify-center gap-2 shadow-lg transition-all duration-300 relative overflow-hidden select-none cursor-pointer"
                    style="background-color: var(--color-primary);"
                    :class="modalClicked ? 'scale-95 brightness-95' : 'hover:scale-[1.01] active:scale-95 hover:shadow-lg'"
                    @click="
                        if (!modalClicked) {
                            modalClicked = true;
                            addToCartWithVariants();
                            setTimeout(() => { modalClicked = false; }, 850);
                        }
                    ">
                <span x-show="!modalClicked" class="flex items-center gap-1.5">
                    <i class="fas fa-shopping-basket text-xs"></i> Agregar al Pedido <span class="opacity-80 font-bold" x-text="'(' + modalQty + ')'"></span>
                </span>
                <span x-show="modalClicked" class="flex items-center gap-1.5 text-emerald-100 animate-bounce">
                    <i class="fas fa-check text-xs"></i> ¡Agregado!
                </span>
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full"
                     :class="modalClicked ? 'animate-shine' : ''"></div>
            </button>
        </div>
    </div>

    <!-- Script de inicialización -->
    @php
        $workHoursJson          = $company['work_hours'] ?? null;
        $storeLatJs             = (float)($company['latitude'] ?? 0);
        $storeLngJs             = (float)($company['longitude'] ?? 0);
        $deliveryRateJs         = (float)($company['delivery_rate_per_km'] ?? 0);
        $reviewsListJson        = $reviews->map(fn($r) => [
            'customer_name' => $r->customer_name,
            'rating'        => (int)$r->rating,
            'comment'       => $r->comment,
            'created_at'    => $r->created_at ? $r->created_at->toIso8601String() : null,
        ])->values()->all();
    @endphp
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                const loader = document.getElementById('app-loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => loader.remove(), 500);
                }
            }, 1000);
        });

        function storeApp() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                customerName: localStorage.getItem('customerName') || '',
                customerPhone: localStorage.getItem('customerPhone') || '',
                isCartOpen: false,
                showReviewsModal: false,
                showSchedulesModal: false,
                showBranchesModal: false,
                showErrors: false,
                activeCategory: 0,
                selectedCategory: 0,
                searchQuery: '',
                starFilter: 0,
                review: { name: '', rating: '5', comment: '', anonymous: false },
                isSubmitting: false,
                reviewSubmitted: false,
                currencySymbol: '{{ $currencySymbol }}',

                showWhatsappModal: false,
                showOrderWhatsappModal: false,
                pendingOrderMessage: '',
                // Accessibility properties
                showAccessibilityModal: false,
                accessibility: {
                    fontSize: parseInt(localStorage.getItem('store_font_size') || '16'),
                    daltonism: localStorage.getItem('store_daltonism') || 'normal'
                },
                
                deliveryType: 'pickup',
                deliveryMode: 'map',
                isGpsLoading: false,
                gpsSuccess: false,
                deliveryDistance: 0,
                deliveryCost: 0,
                mapInitialized: false,
                map: null,
                marker: null,
                storeLat: {{ $storeLatJs }},
                storeLng: {{ $storeLngJs }},
                deliveryRate: {{ $deliveryRateJs }},
                exchangeRate: {{ $exchangeRateFloat }},

                // Dynamic payment methods variables
                showPaymentDetailsModal: false,
                showAllPaymentMethodsModal: false,
                selectedPaymentMethodName: '',
                selectedPaymentMethodDetails: '',
                selectedPaymentMethod: '',
                selectedPaymentDetails: '',
                paymentMethodsList: @json($activePaymentMethods),
                activeMethodTab: '',
                colors: { 
                    'Transferencia': 'bg-slate-600 border-slate-600 text-white', 
                    'Pago Móvil': 'bg-teal-500 border-teal-500 text-white', 
                    'Efectivo': 'bg-emerald-600 border-emerald-600 text-white', 
                    'Zelle': 'bg-purple-600 border-purple-600 text-white', 
                    'Binance': 'bg-amber-500 border-amber-500 text-white', 
                    'PayPal': 'bg-blue-600 border-blue-600 text-white', 
                    'Punto de Venta': 'bg-indigo-500 border-indigo-500 text-white' 
                },

                // Specs modal states
                showProductModal: false,
                modalProduct: null,
                modalProductFeatures: { images: [], colors: [], sizes: [], units: [] },
                modalSelectedColor: '',
                modalSelectedSize: '',
                modalSelectedUnit: '',
                modalQty: 1,
                modalActiveSlide: 0,
                modalClicked: false,

                // Dynamic reactive reviews list loaded from database initially
                reviewsList: @json($reviewsListJson),

                // Dynamic store hours state
                workHours: (() => {
                    let wh = @json($workHoursJson);
                    if (!wh) return null;
                    if (typeof wh === 'string') {
                        try {
                            wh = JSON.parse(wh);
                        } catch(e) {
                            return { type: 'simple', text: wh };
                        }
                    }
                    return wh;
                })(),
                storeStatus: {
                    state: 'open',
                    label: 'Abierto',
                    colorClass: 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition',
                    dotClass: 'bg-emerald-500'
                },
                lastNotifiedStatus: localStorage.getItem('lastNotifiedStatus') || '',

                init() {
                    this.$watch('cart', val => localStorage.setItem('cart', JSON.stringify(val)));
                    this.$watch('customerName', val => localStorage.setItem('customerName', val));
                    this.$watch('customerPhone', val => localStorage.setItem('customerPhone', val));

                    // Set default selected payment method to the first active method
                    const activeKeys = Object.keys(this.paymentMethodsList);
                    if (activeKeys.length > 0) {
                        this.selectedPaymentMethod = activeKeys[0];
                        this.selectedPaymentDetails = this.paymentMethodsList[activeKeys[0]].details || '';
                        this.activeMethodTab = activeKeys[0];
                    }

                    // Schedule dynamic updates
                    this.updateStoreStatus();
                    setInterval(() => this.updateStoreStatus(), 30000);

                    // Apply accessibility settings on load
                    this.applyAccessibilitySettings();
                },

                getScheduleDay(day) {
                    const defaultSchedule = {
                        'Lunes': { closed: false, open: '08:00', close: '18:00' },
                        'Martes': { closed: false, open: '08:00', close: '18:00' },
                        'Miércoles': { closed: false, open: '08:00', close: '18:00' },
                        'Jueves': { closed: false, open: '08:00', close: '18:00' },
                        'Viernes': { closed: false, open: '08:00', close: '18:00' },
                        'Sábado': { closed: false, open: '08:00', close: '18:00' },
                        'Domingo': { closed: true, open: '08:00', close: '18:00' }
                    };
                    if (this.workHours && this.workHours.type === 'custom' && this.workHours.schedule && this.workHours.schedule[day]) {
                        return this.workHours.schedule[day];
                    }
                    return defaultSchedule[day];
                },

                formatTime(timeStr) {
                    if (!timeStr) return '';
                    const parts = timeStr.split(':');
                    let hours = parseInt(parts[0], 10);
                    const minutes = parts[1] || '00';
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12;
                    return `${hours.toString().padStart(2, '0')}:${minutes} ${ampm}`;
                },

                formatTimeRange(open, close) {
                    return `${this.formatTime(open)} - ${this.formatTime(close)}`;
                },

                updateStoreStatus() {
                    const daysMap = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    const currentDate = new Date();
                    const currentDayName = daysMap[currentDate.getDay()];
                    
                    const currentHours = currentDate.getHours();
                    const currentMinutes = currentDate.getMinutes();
                    const currentTotalMinutes = currentHours * 60 + currentMinutes;
                    
                    let state = 'open';
                    let label = 'Abierto';
                    let colorClass = 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition';
                    let dotClass = 'bg-emerald-500';
                    
                    const parseTimeToMinutes = (timeStr) => {
                        if (!timeStr) return 0;
                        const parts = timeStr.split(':');
                        return parseInt(parts[0], 10) * 60 + parseInt(parts[1] || '0', 10);
                    };

                    const defaultSchedule = {
                        'Lunes': { closed: false, open: '08:00', close: '18:00' },
                        'Martes': { closed: false, open: '08:00', close: '18:00' },
                        'Miércoles': { closed: false, open: '08:00', close: '18:00' },
                        'Jueves': { closed: false, open: '08:00', close: '18:00' },
                        'Viernes': { closed: false, open: '08:00', close: '18:00' },
                        'Sábado': { closed: false, open: '08:00', close: '18:00' },
                        'Domingo': { closed: true, open: '08:00', close: '18:00' }
                    };

                    let wh = this.workHours;
                    
                    if (!wh || wh.type === 'simple') {
                        state = 'open';
                        label = 'Abierto';
                        colorClass = 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition';
                        dotClass = 'bg-emerald-500';
                    } else if (wh.type === 'custom') {
                        const dayConfig = wh.schedule && wh.schedule[currentDayName] ? wh.schedule[currentDayName] : defaultSchedule[currentDayName];
                        
                        if (dayConfig.closed) {
                            state = 'closed';
                            label = 'Cerrado';
                            colorClass = 'bg-rose-50 text-rose-600 border-rose-100 hover:bg-rose-100 transition';
                            dotClass = 'bg-rose-500';
                        } else {
                            const openMin = parseTimeToMinutes(dayConfig.open);
                            const closeMin = parseTimeToMinutes(dayConfig.close);
                            
                            if (currentTotalMinutes < openMin) {
                                const diff = openMin - currentTotalMinutes;
                                if (diff <= 60) {
                                    state = 'opening_soon';
                                    label = `Pronto a Abrir (${diff} min)`;
                                    colorClass = 'bg-blue-50 text-blue-600 border-blue-100 hover:bg-blue-100 transition animate-pulse duration-1000';
                                    dotClass = 'bg-blue-500';
                                    
                                    if (this.lastNotifiedStatus !== 'opening_soon') {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'info',
                                            title: '¡Abriremos pronto!',
                                            text: `La tienda abrirá en ${diff} minutos. ¡Prepara tu carrito!`,
                                            showConfirmButton: false,
                                            timer: 8000,
                                            timerProgressBar: true
                                        });
                                        this.lastNotifiedStatus = 'opening_soon';
                                        localStorage.setItem('lastNotifiedStatus', 'opening_soon');
                                    }
                                } else {
                                    state = 'closed';
                                    label = `Cerrado (Abre ${this.formatTime(dayConfig.open)})`;
                                    colorClass = 'bg-rose-50 text-rose-600 border-rose-100 hover:bg-rose-100 transition';
                                    dotClass = 'bg-rose-500';
                                }
                            } else if (currentTotalMinutes >= openMin && currentTotalMinutes < closeMin) {
                                const diff = closeMin - currentTotalMinutes;
                                if (diff <= 60) {
                                    state = 'closing_soon';
                                    label = `Pronto a Cerrar (${diff} min)`;
                                    colorClass = 'bg-amber-50 text-amber-600 border-amber-100 hover:bg-amber-100 transition animate-pulse duration-1000';
                                    dotClass = 'bg-amber-500';
                                    
                                    if (this.lastNotifiedStatus !== 'closing_soon') {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'warning',
                                            title: '¡Cerramos pronto!',
                                            text: `La tienda cerrará en ${diff} minutos. ¡Envía tu pedido a tiempo!`,
                                            showConfirmButton: false,
                                            timer: 8000,
                                            timerProgressBar: true
                                        });
                                        this.lastNotifiedStatus = 'closing_soon';
                                        localStorage.setItem('lastNotifiedStatus', 'closing_soon');
                                    }
                                } else {
                                    state = 'open';
                                    label = 'Abierto';
                                    colorClass = 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition';
                                    dotClass = 'bg-emerald-500';
                                    
                                    if (this.lastNotifiedStatus === 'closing_soon' || this.lastNotifiedStatus === 'opening_soon') {
                                        this.lastNotifiedStatus = '';
                                        localStorage.removeItem('lastNotifiedStatus');
                                    }
                                }
                            } else {
                                state = 'closed';
                                label = 'Cerrado';
                                colorClass = 'bg-rose-50 text-rose-600 border-rose-100 hover:bg-rose-100 transition';
                                dotClass = 'bg-rose-500';
                                
                                if (this.lastNotifiedStatus === 'closing_soon' || this.lastNotifiedStatus === 'opening_soon') {
                                    this.lastNotifiedStatus = '';
                                    localStorage.removeItem('lastNotifiedStatus');
                                }
                            }
                        }
                    }
                    
                    this.storeStatus = { state, label, colorClass, dotClass };
                },

                selectPayment(name) {
                    this.selectedPaymentMethod = name;
                    this.selectedPaymentDetails = this.paymentMethodsList[name]?.details || '';
                },

                openPaymentDetails(name, details) {
                    this.selectedPaymentMethodName = name;
                    this.selectedPaymentMethodDetails = details || 'Este método de pago no requiere datos adicionales.';
                    this.showPaymentDetailsModal = true;
                },

                get total() { return this.cart.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0); },
                get totalItems() { return this.cart.reduce((sum, item) => sum + item.quantity, 0); },

                // Reactive getters for real-time calculation in modal/storefront
                get averageRating() {
                    if (this.reviewsList.length === 0) return 5.0;
                    let sum = this.reviewsList.reduce((acc, r) => acc + r.rating, 0);
                    return (sum / this.reviewsList.length);
                },
                get totalReviewsCount() {
                    return this.reviewsList.length;
                },
                get starCounts() {
                    let counts = {5: 0, 4: 0, 3: 0, 2: 0, 1: 0};
                    this.reviewsList.forEach(r => {
                        if (counts[r.rating] !== undefined) counts[r.rating]++;
                    });
                    return counts;
                },
                get starPercentages() {
                    let total = this.reviewsList.length;
                    let pcts = {5: 0, 4: 0, 3: 0, 2: 0, 1: 0};
                    if (total > 0) {
                        for (let i = 1; i <= 5; i++) {
                            pcts[i] = (this.starCounts[i] / total) * 100;
                        }
                    }
                    return pcts;
                },

                addToCart(product) {
                    this.addToCartWithQty(product, 1);
                },

                playAddSound() {
                    try {
                        const AudioCtx = window.AudioContext || window.webkitAudioContext;
                        if (!AudioCtx) return;
                        const audioCtx = new AudioCtx();
                        
                        // First chime note (higher frequency)
                        const osc1 = audioCtx.createOscillator();
                        const gain1 = audioCtx.createGain();
                        
                        osc1.type = 'sine'; // Pure smooth tone
                        osc1.frequency.setValueAtTime(523.25, audioCtx.currentTime); // C5 note
                        osc1.frequency.exponentialRampToValueAtTime(880, audioCtx.currentTime + 0.15); // Ramp up to A5 for a bright chime
                        
                        gain1.gain.setValueAtTime(0.15, audioCtx.currentTime);
                        gain1.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.3); // Decay smoothly
                        
                        osc1.connect(gain1);
                        gain1.connect(audioCtx.destination);
                        
                        osc1.start();
                        osc1.stop(audioCtx.currentTime + 0.3);
                        
                        // Second subtle harmonic note for depth
                        setTimeout(() => {
                            try {
                                const osc2 = audioCtx.createOscillator();
                                const gain2 = audioCtx.createGain();
                                
                                osc2.type = 'triangle'; // Softer tone
                                osc2.frequency.setValueAtTime(659.25, audioCtx.currentTime); // E5
                                osc2.frequency.exponentialRampToValueAtTime(1046.50, audioCtx.currentTime + 0.1); // C6
                                
                                gain2.gain.setValueAtTime(0.08, audioCtx.currentTime);
                                gain2.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.25);
                                
                                osc2.connect(gain2);
                                gain2.connect(audioCtx.destination);
                                
                                osc2.start();
                                osc2.stop(audioCtx.currentTime + 0.25);
                            } catch (err) {}
                        }, 50);
                    } catch (e) {
                        console.warn("Web Audio API not allowed or supported yet:", e);
                    }
                },

                getProductFeatures(product) {
                    if (!product) return { images: [], colors: [], sizes: [], units: [] };
                    if (product.features && typeof product.features === 'object') {
                        return {
                            images: product.features.images || [product.image_path],
                            colors: product.features.colors || [],
                            sizes: product.features.sizes || [],
                            units: product.features.units || []
                        };
                    }
                    
                    const name = (product.name || '').toLowerCase();
                    const image = product.image_path ? (product.image_path.startsWith('http') ? product.image_path : '/storage/' + product.image_path) : '';
                    
                    let images = [image];
                    let colors = [];
                    let sizes = [];
                    let units = [];
                    
                    // Fallback variants for clothing items
                    if (name.includes('camisa') || name.includes('franela') || name.includes('pantalon') || 
                        name.includes('jean') || name.includes('vestido') || name.includes('sueter') || 
                        name.includes('zapato') || name.includes('zapatilla') || name.includes('ropa') || 
                        name.includes('t-shirt') || name.includes('asd')) {
                        
                        colors = [
                            { name: 'Negro', hex: '#1E293B' },
                            { name: 'Blanco', hex: '#F8FAFC' },
                            { name: 'Azul', hex: '#3B82F6' },
                            { name: 'Verde', hex: '#10B981' }
                        ];
                        sizes = ['S', 'M', 'L', 'XL'];
                        images = [image, image, image]; // Repeat the image to populate slider
                    } 
                    // Fallback variants for grocery items
                    else if (name.includes('cafe') || name.includes('harina') || name.includes('arroz') || 
                             name.includes('azucar') || name.includes('queso') || name.includes('jamon') || 
                             name.includes('carne') || name.includes('pollo') || name.includes('fruta') || 
                             name.includes('pan') || name.includes('torta') || name.includes('hamburguesa') || 
                             name.includes('pizza') || name.includes('helado')) {
                        
                        units = ['250g', '500g', '1kg'];
                    }
                    
                    return { images, colors, sizes, units };
                },

                 openProductDetails(product, options = {}) {
                    this.modalProduct = product;
                    this.modalProductFeatures = this.getProductFeatures(product);
                    
                    // Set default selected options
                    this.modalSelectedColor = options.selectedColor || (this.modalProductFeatures.colors.length > 0 ? this.modalProductFeatures.colors[0].name : '');
                    this.modalSelectedSize = this.modalProductFeatures.sizes.length > 0 ? this.modalProductFeatures.sizes[0] : '';
                    this.modalSelectedUnit = this.modalProductFeatures.units.length > 0 ? this.modalProductFeatures.units[0] : '';
                    this.modalQty = options.qty || 1;
                    this.modalActiveSlide = 0;
                    
                    this.showProductModal = true;
                },

                addToCartWithQty(product, quantity) {
                    let qty = parseInt(quantity) || 1;
                    const features = this.getProductFeatures(product);
                    
                    const size = features.sizes.length > 0 ? features.sizes[0] : '';
                    const color = features.colors.length > 0 ? features.colors[0].name : '';
                    const unit = features.units.length > 0 ? features.units[0] : '';
                    
                    const variantKey = [size, color, unit].filter(Boolean).join('-');
                    const cartItemId = variantKey ? `${product.id}-${variantKey}` : product.id;
                    
                    const variantLabel = [size, color, unit].filter(Boolean).join(', ');
                    const displayName = variantLabel ? `${product.name} (${variantLabel})` : product.name;
                    
                    let existing = this.cart.find(i => i.id === cartItemId);
                    if (existing) {
                        existing.quantity += qty;
                    } else {
                        this.cart.push({
                            id: cartItemId,
                            product_id: product.id,
                            name: displayName,
                            price: parseFloat(product.price),
                            quantity: qty,
                            selectedColor: color,
                            selectedSize: size,
                            selectedUnit: unit,
                            image_path: product.image_path
                        });
                    }
                    this.playAddSound();
                },

                addToCartWithVariants() {
                    if (!this.modalProduct) return;
                    
                    const product = this.modalProduct;
                    const size = this.modalSelectedSize;
                    const color = this.modalSelectedColor;
                    const unit = this.modalSelectedUnit;
                    const qty = this.modalQty;
                    
                    const variantKey = [size, color, unit].filter(Boolean).join('-');
                    const cartItemId = variantKey ? `${product.id}-${variantKey}` : product.id;
                    
                    const variantLabel = [size, color, unit].filter(Boolean).join(', ');
                    const displayName = variantLabel ? `${product.name} (${variantLabel})` : product.name;
                    
                    let existing = this.cart.find(i => i.id === cartItemId);
                    if (existing) {
                        existing.quantity += qty;
                    } else {
                        this.cart.push({
                            id: cartItemId,
                            product_id: product.id,
                            name: displayName,
                            price: parseFloat(product.price),
                            quantity: qty,
                            selectedColor: color,
                            selectedSize: size,
                            selectedUnit: unit,
                            image_path: product.image_path
                        });
                    }
                    
                    this.playAddSound();
                    
                    setTimeout(() => {
                        this.showProductModal = false;
                    }, 800);
                },

                updateQty(id, amount) {
                    let item = this.cart.find(i => i.id === id);
                    if (item) {
                        item.quantity += amount;
                        if (item.quantity <= 0) this.cart = this.cart.filter(i => i.id !== id);
                    }
                },

                scrollToCategory(catId) {
                    this.selectedCategory = catId;
                    this.activeCategory = catId;
                    
                    const targetElement = catId === 0 ? document.getElementById('products-container') : document.getElementById('cat-' + catId);
                    if (targetElement) {
                        this.isProgrammaticScroll = true;
                        if (this.scrollTimeout) clearTimeout(this.scrollTimeout);

                        const offset = 120; // Ajuste para que la barra de categorías sticky quede visible y no tape los títulos
                        const bodyRect = document.body.getBoundingClientRect().top;
                        const elementRect = targetElement.getBoundingClientRect().top;
                        const elementPosition = elementRect - bodyRect;
                        const offsetPosition = elementPosition - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        this.scrollTimeout = setTimeout(() => {
                            this.isProgrammaticScroll = false;
                        }, 500);
                    }
                    this.centerCategoryNavChip(catId);
                },

                centerCategoryNavChip(catId) {
                    const navBar = document.getElementById('category-nav-bar');
                    const activeChip = document.getElementById('nav-chip-' + catId);
                    if (navBar && activeChip) {
                        const navBarWidth = navBar.offsetWidth;
                        const chipLeft = activeChip.offsetLeft;
                        const chipWidth = activeChip.offsetWidth;
                        
                        navBar.scrollTo({
                            left: chipLeft - (navBarWidth / 2) + (chipWidth / 2),
                            behavior: 'smooth'
                        });
                    }
                },

                onSectionIntersect(catId, isIntersecting) {
                    if (this.isProgrammaticScroll) return;
                    // Solo actualiza la categoría activa al hacer scroll si estamos en el modo "Todas" (selectedCategory === 0)
                    if (isIntersecting && this.searchQuery === '' && this.selectedCategory === 0) {
                        this.activeCategory = catId;
                        this.centerCategoryNavChip(catId);
                    }
                },

                async submitReview() {
                    let finalName = this.review.anonymous ? 'Anónimo' : this.review.name.trim();
                    if(!finalName) return alert('Por favor ingresa tu nombre o marca la casilla de anónimo.');
                    if(!this.review.rating) return alert('Por favor selecciona una valoración en estrellas.');

                    this.isSubmitting = true;
                    try {
                        let response = await fetch('/{{ $company['slug'] }}/reviews', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                customer_name: finalName,
                                rating: parseInt(this.review.rating),
                                comment: this.review.comment
                            })
                        });
                        if(response.ok) {
                            // Inject into the list dynamically in real-time
                            this.reviewsList.unshift({
                                customer_name: finalName,
                                rating: parseInt(this.review.rating),
                                comment: this.review.comment
                            });
                            this.reviewSubmitted = true;
                            setTimeout(() => {
                                this.review = { name: '', rating: '5', comment: '', anonymous: false };
                                this.reviewSubmitted = false;
                                this.showForm = false;
                            }, 2000);
                        }
                    } catch (error) {
                         alert('Error al enviar calificación');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                initMap() {
                    if (this.mapInitialized || !this.storeLat || !this.storeLng) return;
                    setTimeout(() => {
                        let center = [this.storeLat, this.storeLng];
                        this.map = L.map('delivery-map').setView(center, 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);
                        
                        this.marker = L.marker(center, {draggable: true}).addTo(this.map);
                        
                        this.marker.on('dragend', (e) => {
                            let pos = e.target.getLatLng();
                            this.calculateDistance(pos.lat, pos.lng);
                        });
                        
                        this.map.on('click', (e) => {
                            this.marker.setLatLng(e.latlng);
                            this.calculateDistance(e.latlng.lat, e.latlng.lng);
                        });
                        
                        this.mapInitialized = true;
                        
                        // Force invalidateSize after loading to ensure it's rendered correctly
                        setTimeout(() => {
                            if (this.map) this.map.invalidateSize();
                        }, 200);
                    }, 350);
                },

                calculateDistance(lat2, lon2) {
                    if (!this.storeLat || !this.storeLng) return;
                    let lat1 = this.storeLat;
                    let lon1 = this.storeLng;
                    
                    const R = 6371;
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a = 
                        Math.sin(dLat/2) * Math.sin(dLat/2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                        Math.sin(dLon/2) * Math.sin(dLon/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                    const d = R * c; 
                    
                    this.deliveryDistance = d;
                    this.deliveryCost = d * this.deliveryRate;
                },

                useGPS() {
                    if (!navigator.geolocation) {
                        Swal.fire({
                            icon: 'error',
                            title: 'GPS no soportado',
                            text: 'Tu navegador o dispositivo no soporta geolocalización.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }
                    
                    this.isGpsLoading = true;
                    this.gpsSuccess = false;
                    
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            // Initialize map if it isn't yet
                            if (!this.mapInitialized) {
                                this.initMap();
                            }
                            
                            // We need to wait a small timeout to make sure map element is rendered if it was hidden
                            setTimeout(() => {
                                if (this.map && this.marker) {
                                    this.marker.setLatLng([lat, lng]);
                                    this.map.setView([lat, lng], 16);
                                    this.calculateDistance(lat, lng);
                                    
                                    // Make sure map updates sizes
                                    this.map.invalidateSize();
                                }
                            }, 400);
                            
                            this.isGpsLoading = false;
                            this.gpsSuccess = true;
                            
                            Swal.fire({
                                icon: 'success',
                                title: '¡Ubicación encontrada!',
                                text: 'Hemos centrado el mapa en tu posición GPS actual. Puedes mover el pin si necesitas ajustar.',
                                timer: 2500,
                                timerProgressBar: true,
                                confirmButtonColor: 'var(--color-primary)'
                            });
                        },
                        (error) => {
                            this.isGpsLoading = false;
                            let errMsg = 'No pudimos obtener tu ubicación. Por favor, asegúrate de activar el GPS y dar permisos.';
                            if (error.code === error.PERMISSION_DENIED) {
                                errMsg = 'Has denegado el acceso al GPS. Por favor actívalo en los ajustes de tu navegador o selecciona en el mapa manualmente.';
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de GPS',
                                text: errMsg,
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            // Revert to manual map mode if GPS fails
                            this.deliveryMode = 'map';
                            if (!this.mapInitialized) this.initMap();
                        },
                        { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
                    );
                },

                async sendWhatsApp() {
                    if(this.cart.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Carrito vacío',
                            text: 'Por favor agrega productos antes de enviar tu pedido.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }
                    
                    this.showErrors = false;
                    if(!this.customerName.trim() || !this.customerPhone.trim()) {
                        this.showErrors = true;
                        // Focus on the first invalid field
                        setTimeout(() => {
                            const firstInvalid = document.querySelector('.border-rose-300');
                            if(firstInvalid) firstInvalid.focus();
                        }, 50);
                        return;
                    }
                    if(this.deliveryType === 'delivery' && (!this.storeLat || !this.storeLng)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Servicio no disponible',
                            text: 'El servicio de delivery no está disponible. Coordenadas de tienda no configuradas.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }

                    // Mostrar SweetAlert2 Cargando
                    Swal.fire({
                        title: 'Procesando pedido...',
                        text: 'Estamos registrando tu orden, por favor espera.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        await fetch('/{{ $company['slug'] }}/clients/quick-register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                name: this.customerName,
                                phone: this.customerPhone
                            })
                        });
                    } catch (e) { console.error('Error en quick-register:', e); }

                    // Notificar orden al backend para generar alerta y registrar en el sistema
                    const orderTotal = this.total + this.deliveryCost;
                    try {
                        await fetch('/{{ $company['slug'] }}/orders/notify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                customer_name: this.customerName,
                                customer_phone: this.customerPhone,
                                total: orderTotal,
                                delivery_type: this.deliveryType,
                                payment_method: this.selectedPaymentMethod
                            })
                        });
                    } catch (e) { console.error('Error registrando notificación de orden:', e); }

                    let text = `*Pedido de ${this.customerName}*%0A`;
                    text += `*Teléfono:* ${this.customerPhone}%0A`;
                    text += `*Tipo:* ${this.deliveryType === 'delivery' ? 'Delivery' : 'Retiro en local'}%0A`;
                    if (this.selectedPaymentMethod) {
                        text += `*Método de Pago:* ${this.selectedPaymentMethod}%0A`;
                    }
                    text += `%0A`;
                    
                    this.cart.forEach(i => {
                        text += `▫️ ${i.quantity}x ${i.name} - ${this.currencySymbol}${(i.price * i.quantity).toFixed(2)}%0A`;
                    });

                    if (this.deliveryType === 'delivery' && this.marker) {
                        text += `%0A*Costo de Envío:* ${this.currencySymbol}${this.deliveryCost.toFixed(2)}`;
                        text += `%0A*Ubicación:* https://www.google.com/maps?q=${this.marker.getLatLng().lat},${this.marker.getLatLng().lng}`;
                    }

                    text += `%0A%0A*TOTAL:* ${this.currencySymbol}${orderTotal.toFixed(2)}`;
                    
                    const numWhatsapps = {{ count($whatsapps) }};
                    if (numWhatsapps > 1) {
                        this.pendingOrderMessage = text;
                        Swal.fire({
                            icon: 'success',
                            title: '¡Pedido Registrado!',
                            text: 'Selecciona a qué sucursal o departamento enviar tu pedido.',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            willClose: () => {
                                this.showOrderWhatsappModal = true;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Pedido Registrado!',
                            text: 'Te estamos redirigiendo a WhatsApp para completar el envío.',
                            timer: 2500,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            willClose: () => {
                                window.open(`https://wa.me/{{ $whatsapps[0]['number'] ?? preg_replace('/[^0-9]/', '', $company['whatsapp']) }}?text=${text}`, '_blank');
                            }
                        });
                    }
                },

                redirectToOrderWhatsApp(waNumber) {
                    this.showOrderWhatsappModal = false;
                    window.open(`https://wa.me/${waNumber}?text=${this.pendingOrderMessage}`, '_blank');
                },

                applyAccessibilitySettings() {
                    document.documentElement.style.fontSize = this.accessibility.fontSize + 'px';
                    const body = document.body;
                    body.classList.remove('daltonism-protanopia', 'daltonism-deuteranopia', 'daltonism-tritanopia', 'daltonism-monochromacy');
                    if (this.accessibility.daltonism !== 'normal') {
                        body.classList.add('daltonism-' + this.accessibility.daltonism);
                    }
                },

                updateFontSize() {
                    localStorage.setItem('store_font_size', this.accessibility.fontSize);
                    document.documentElement.style.fontSize = this.accessibility.fontSize + 'px';
                },

                setDaltonism(mode) {
                    this.accessibility.daltonism = mode;
                    localStorage.setItem('store_daltonism', mode);
                    this.applyAccessibilitySettings();
                }
            }
        }
    </script>

    <!-- SVG Filters for Daltonism (Invisible definitions) -->
    <svg class="hidden" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <filter id="protanopia">
                <feColorMatrix type="matrix" values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
            <filter id="deuteranopia">
                <feColorMatrix type="matrix" values="0.625, 0.375, 0, 0, 0, 0.7, 0.3, 0, 0, 0, 0, 0.3, 0.7, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
            <filter id="tritanopia">
                <feColorMatrix type="matrix" values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
        </defs>
    </svg>
</body>
</html>
