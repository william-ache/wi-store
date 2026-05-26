<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $company['name'] }} - Menú Digital</title>

    {{-- PIXELS Y TRACKING --}}
    @if (!empty($company['facebook_pixel_id']))
        <!-- Meta Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $company['facebook_pixel_id'] }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $company['facebook_pixel_id'] }}&ev=PageView&noscript=1" /></noscript>
    @endif

    @if (!empty($company['tiktok_pixel_id']))
        <!-- TikTok Pixel Code -->
        <script>
            ! function(w, d, t) {
                w.TiktokAnalyticsObject = t;
                var ttq = w[t] = w[t] || [];
                ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias",
                    "group", "enableCookie", "disableCookie"
                ];
                ttq.setAndDefer = function(t, e) {
                    t[e] = function() {
                        t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                };
                for (var i = 0; i < ttq.methods.length; i++) {
                    ttq.setAndDefer(ttq, ttq.methods[i])
                }
                ttq.instance = function(t) {
                    for (var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++) {
                        ttq.setAndDefer(e, ttq.methods[n])
                    }
                    return e
                };
                ttq.load = function(e, n) {
                    var i = "https://analytics.tiktok.com/i18n/pixel/events.js";
                    ttq._i = ttq._i || {};
                    ttq._i[e] = [];
                    ttq._i[e]._u = i;
                    ttq._t = ttq._t || {};
                    ttq._t[e] = +new Date;
                    ttq._o = ttq._o || {};
                    ttq._o[e] = n || {};
                    var o = document.createElement("script");
                    o.type = "text/javascript";
                    o.async = !0;
                    o.src = i + "?sdkid=" + e + "&lib=" + t;
                    var a = document.getElementsByTagName("script")[0];
                    a.parentNode.insertBefore(o, a)
                };
                ttq.load("{{ $company['tiktok_pixel_id'] }}");
                ttq.page();
            }(window, document, 'ttq');
        </script>
    @endif

    @if (!empty($company['google_analytics_id']))
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $company['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $company['google_analytics_id'] }}');
        </script>
    @endif

    @if (!empty($company['stripe_enabled']))
        <script src="https://js.stripe.com/v3/"></script>
    @endif

    <!-- PWA Dynamic Manifest and Apple/Android Meta Tags -->
    <link rel="manifest" href="/{{ $company['slug'] }}/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $company['name'] }}">
    <link rel="apple-touch-icon" href="{{ $company['logo'] ?: 'https://ui-avatars.com/api/?name='.urlencode($company['name']).'&background=1A1A1A&color=fff' }}">

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/{{ $company['slug'] }}/service-worker.js')
                    .then(reg => console.log('Service Worker registrado con éxito:', reg.scope))
                    .catch(err => console.error('Error al registrar Service Worker:', err));
            });
        }
    </script>

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
        @php
            $storePrimary = \App\Support\BrandColor::normalizeHex($company['colors']['primary'] ?? '#E60067');
            $storeOnPrimary = \App\Support\BrandColor::onPrimary($storePrimary);
            $storePrimaryRgb = \App\Support\BrandColor::rgb($storePrimary);
            $storeOnPrimaryRgb = \App\Support\BrandColor::onPrimaryRgb($storePrimary);
        @endphp
        :root {
            --color-primary: {{ $storePrimary }};
            --color-primary-rgb: {{ $storePrimaryRgb['r'] }}, {{ $storePrimaryRgb['g'] }}, {{ $storePrimaryRgb['b'] }};
            --color-on-primary: {{ $storeOnPrimary }};
            --color-on-primary-rgb: {{ $storeOnPrimaryRgb['r'] }}, {{ $storeOnPrimaryRgb['g'] }}, {{ $storeOnPrimaryRgb['b'] }};
            --color-secondary: {{ $company['colors']['secondary'] }};
            --color-bg: {{ $company['colors']['bg_light'] }};
        }

        .store-accent-fill {
            background-color: var(--color-primary);
            color: var(--color-on-primary);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', 'sans-serif';
            background: linear-gradient(135deg, var(--color-bg) 0%, rgba(255, 255, 255, 0.4) 100%);
            -webkit-tap-highlight-color: transparent;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 9999px;
            transition: background 0.3s ease;
        }

        .cashea-logo-badge { border-radius: 6px; }
        .krece-logo-badge { border-radius: 6px; }
        .krece-brand-bg { background-color: #22D3EE; }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-secondary);
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: var(--color-primary) transparent;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) skewX(-15deg);
            }

            50% {
                transform: translateX(100%) skewX(-15deg);
            }

            100% {
                transform: translateX(100%) skewX(-15deg);
            }
        }

        .animate-shine {
            animation: shine 0.8s ease-in-out;
        }

        @keyframes bcv-shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-bcv-shimmer {
            animation: bcv-shimmer 3.5s infinite;
        }

        /* Daltonism Filter Classes */
        .daltonism-protanopia {
            filter: url(#protanopia);
        }

        .daltonism-deuteranopia {
            filter: url(#deuteranopia);
        }

        .daltonism-tritanopia {
            filter: url(#tritanopia);
        }

        .daltonism-monochromacy {
            filter: grayscale(100%);
        }

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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            transition: transform 0.1s ease;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }

        input[type="range"]:focus {
            outline: none;
        }

        /* Premium Gold Effects */
        @keyframes premium-glow {

            0%,
            100% {
                box-shadow: 0 0 12px rgba(251, 191, 36, 0.5), 0 0 25px rgba(251, 191, 36, 0.25), inset 0 0 10px rgba(251, 191, 36, 0.3);
                border-color: #FBBF24;
            }

            50% {
                box-shadow: 0 0 25px rgba(251, 191, 36, 0.9), 0 0 50px rgba(251, 191, 36, 0.5), inset 0 0 20px rgba(251, 191, 36, 0.6);
                border-color: #F59E0B;
            }
        }

        @keyframes float-crown {

            0%,
            100% {
                transform: translate(-50%, 0) rotate(0deg);
                filter: drop-shadow(0 4px 6px rgba(251, 191, 36, 0.7));
            }

            50% {
                transform: translate(-50%, -6px) rotate(2deg);
                filter: drop-shadow(0 10px 15px rgba(251, 191, 36, 0.95));
            }
        }

        .premium-border-glow {
            animation: premium-glow 3s infinite ease-in-out !important;
            border-color: #FBBF24 !important;
        }

        .float-crown-animation {
            animation: float-crown 3s infinite ease-in-out;
        }

        .text-gold-gradient {
            background: linear-gradient(135deg, #FFE885 0%, #F5B041 40%, #F39C12 70%, #D4AC0D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
    </style>
</head>

<body class="min-h-screen text-slate-800 pb-12 select-none flex flex-col" x-data="storeApp()">

    @php
        $currencySymbol = '$';
        $bc = strtolower($company['base_currency'] ?? 'usd');
        if ($bc === 'eur') {
            $currencySymbol = '€';
        } elseif ($bc === 'bs' || $bc === 'ves') {
            $currencySymbol = 'Bs.';
        } elseif ($bc === 'cop') {
            $currencySymbol = 'COP ';
        }

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
                'Pago Móvil' => ['active' => true, 'details' => ''],
            ];
        }

        // Filter only active ones for display
        $activePaymentMethods = [];
        foreach ($paymentMethods as $name => $data) {
            if (!empty($data['active'])) {
                $activePaymentMethods[$name] = $data;
            }
        }

        if (!empty($company['stripe_enabled'])) {
            $activePaymentMethods['Tarjeta'] = ['active' => true, 'details' => 'Pago directo en línea con tarjeta de crédito/débito a través de Stripe.'];
        }
        if (!empty($company['binance_enabled'])) {
            $activePaymentMethods['Binance'] = ['active' => true, 'details' => 'Paga con criptomonedas (USDT) al instante usando Binance Pay.'];
        }
        if (!empty($company['pagomovil_enabled'])) {
            $activePaymentMethods['Pago Móvil'] = ['active' => true, 'details' => 'Pago Móvil Directo al Banco ' . ($company['pagomovil_bank'] ?? '') . ' - Tel: ' . ($company['pagomovil_phone'] ?? '') . ' - CI: ' . ($company['pagomovil_id'] ?? '')];
        }
        if (!empty($company['cashea_enabled']) && !empty($company['cashea_qr_url'])) {
            $activePaymentMethods['Cashea'] = [
                'active' => true,
                'details' => 'Financia tu compra en cuotas con Cashea. Escanea el código QR de la tienda al pagar.',
                'type' => 'cashea_qr',
                'qr_url' => $company['cashea_qr_url'],
            ];
        }
        if (!empty($company['cashea_link_enabled']) && !empty($company['cashea_link_url'])) {
            $activePaymentMethods['Cashea Link'] = [
                'active' => true,
                'details' => 'Paga en cuotas con Cashea usando el enlace de pago de la tienda.',
                'type' => 'cashea_link',
                'link_url' => $company['cashea_link_url'],
            ];
        }
        if (!empty($company['krece_enabled']) && !empty($company['krece_qr_url'])) {
            $activePaymentMethods['Krece'] = [
                'active' => true,
                'details' => 'Financia tu compra en cuotas con Krece. Escanea el código QR de la tienda al pagar.',
                'type' => 'krece_qr',
                'qr_url' => $company['krece_qr_url'],
            ];
        }
        if (!empty($company['krece_link_enabled']) && !empty($company['krece_link_url'])) {
            $activePaymentMethods['Krece Link'] = [
                'active' => true,
                'details' => 'Paga en cuotas con Krece usando el enlace de pago de la tienda.',
                'type' => 'krece_link',
                'link_url' => $company['krece_link_url'],
            ];
        }

        $hasPaymentMethodsConfigured = (!empty($paymentMethodsRaw)
            || !empty($company['stripe_enabled'])
            || !empty($company['binance_enabled'])
            || !empty($company['pagomovil_enabled'])
            || !empty($company['cashea_enabled'])
            || !empty($company['cashea_link_enabled'])
            || !empty($company['krece_enabled'])
            || !empty($company['krece_link_enabled'])) && count($activePaymentMethods) > 0;

        // Helpers to get icon and color for categories (with automatic name-based fallbacks)
        $getCategoryIcon = function ($category) {
            if (!empty($category->icon)) {
                return $category->icon;
            }
            $name = mb_strtolower($category->name, 'UTF-8');
            if (str_contains($name, 'empanada')) {
                if (str_contains($name, 'clásica') || str_contains($name, 'clasica')) {
                    return 'fa-fire';
                }
                return 'fa-star';
            }
            if (str_contains($name, 'bebida') || str_contains($name, 'refresco') || str_contains($name, 'jugo')) {
                return 'fa-glass-water';
            }
            if (
                str_contains($name, 'dulce') ||
                str_contains($name, 'chuchería') ||
                str_contains($name, 'chucheria') ||
                str_contains($name, 'postre')
            ) {
                return 'fa-candy-cane';
            }
            if (
                str_contains($name, 'conveniencia') ||
                str_contains($name, 'cesta') ||
                str_contains($name, 'carrito') ||
                str_contains($name, 'artículo') ||
                str_contains($name, 'articulo')
            ) {
                return 'fa-basket-shopping';
            }
            if (str_contains($name, 'hamburguesa')) {
                return 'fa-hamburger';
            }
            if (str_contains($name, 'pizza')) {
                return 'fa-pizza-slice';
            }
            if (str_contains($name, 'pollo') || str_contains($name, 'carne')) {
                return 'fa-drumstick-bite';
            }
            if (str_contains($name, 'hot dog') || str_contains($name, 'perro')) {
                return 'fa-hotdog';
            }
            if (str_contains($name, 'combo') || str_contains($name, 'promoción') || str_contains($name, 'promo')) {
                return 'fa-tags';
            }

            return 'fa-folder'; // default fallback icon
        };

        $getCategoryColor = function ($category) {
            if (!empty($category->color)) {
                return $category->color;
            }
            $name = mb_strtolower($category->name, 'UTF-8');
            if (str_contains($name, 'empanada')) {
                if (str_contains($name, 'clásica') || str_contains($name, 'clasica')) {
                    return '#10B981';
                } // green/emerald
                return '#EF4444'; // red
            }
            if (str_contains($name, 'bebida') || str_contains($name, 'refresco') || str_contains($name, 'jugo')) {
                return '#06B6D4';
            } // cyan
            if (
                str_contains($name, 'dulce') ||
                str_contains($name, 'chuchería') ||
                str_contains($name, 'chucheria') ||
                str_contains($name, 'postre')
            ) {
                return '#EC4899';
            } // pink
            if (
                str_contains($name, 'conveniencia') ||
                str_contains($name, 'cesta') ||
                str_contains($name, 'carrito') ||
                str_contains($name, 'artículo') ||
                str_contains($name, 'articulo')
            ) {
                return '#6366F1';
            } // indigo
            if (str_contains($name, 'hamburguesa')) {
                return '#F59E0B';
            } // amber
            if (str_contains($name, 'pizza')) {
                return '#EF4444';
            } // red
            if (str_contains($name, 'combo') || str_contains($name, 'promoción') || str_contains($name, 'promo')) {
                return '#8B5CF6';
            } // purple

            return 'var(--color-primary)'; // default primary color fallback
        };

        // Clean and parse exchange rate safely
        $rawExchangeRate = $company['exchange_rate'] ?? '0';
        $cleanExchangeRate = preg_replace('/^[a-zA-Z.\s]+/', '', $rawExchangeRate);
        $cleanExchangeRate = str_replace(',', '.', $cleanExchangeRate);
        $exchangeRateFloat = (float) preg_replace('/[^0-9.]/', '', $cleanExchangeRate);

        // Pre-calculate company initials for avatar fallbacks
        $words = explode(' ', trim($company['name'] ?? ''));
        $initials = '';
        if (count($words) >= 2) {
            $initials = mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1);
        } elseif (count($words) == 1 && !empty($words[0])) {
            $initials = mb_substr($words[0], 0, 2);
        }
        $initials = mb_strtoupper($initials ?: 'WD');

        // Pre-calculate subscription plan details
        $companyPlanKey = strtolower(trim($company['plan'] ?? ($company['subscription_plan'] ?? '')));
        if (in_array($companyPlanKey, ['standar', 'standard'])) {
            $companyPlanKey = 'standard';
        } elseif (in_array($companyPlanKey, ['premium', 'premiun', 'gold'])) {
            $companyPlanKey = 'premium';
        } elseif (in_array($companyPlanKey, ['free_trial', 'prueba gratuita']) || empty($companyPlanKey)) {
            $companyPlanKey = 'free_trial';
        }
        $isPremiumPlan = $companyPlanKey === 'premium';

        /**
         * Extrae y valida la configuración de badge desde el campo features del producto.
         * Estructura: features.badge = { text, bgColor, icon, position }
         *
         * @param mixed $product
         * @return array|null  Devuelve el badgeConfig o null si no está configurado
         */
        $getBadgeConfig = function ($product): ?array {
            $features = is_array($product->features) ? $product->features : [];
            $badge = $features['badge'] ?? null;
            if (!$badge || empty($badge['text'])) {
                return null;
            }
            return [
                'text' => (string) ($badge['text'] ?? ''),
                'bgColor' => (string) ($badge['bgColor'] ?? '#1e293b'),
                'icon' => (string) ($badge['icon'] ?? ''),
                'position' => in_array($badge['position'] ?? 'left', ['left', 'right']) ? $badge['position'] : 'left',
            ];
        };
    @endphp

    <!-- LOADER -->
    <div id="app-loader"
        class="fixed inset-0 bg-white flex flex-col justify-center items-center z-[9999] transition-opacity duration-500">
        <div class="relative w-24 h-24 flex justify-center items-center mb-2">
            @if ($isPremiumPlan)
                <div
                    class="absolute -top-7 left-1/2 z-40 pointer-events-none float-crown-animation flex items-center justify-center">
                    <i
                        class="fas fa-crown text-[22px] text-gold-gradient filter drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)]"></i>
                    <span class="absolute w-1.5 h-1.5 rounded-full bg-white animate-ping opacity-75"
                        style="top: 1px;"></span>
                </div>
            @endif
            <div class="absolute inset-0 border-4 {{ $isPremiumPlan ? 'border-yellow-100/50' : 'border-slate-100' }} rounded-full animate-spin"
                style="border-top-color: {{ $isPremiumPlan ? '#F59E0B' : 'var(--color-primary)' }};"></div>
            <div
                class="w-20 h-20 rounded-full {{ $isPremiumPlan ? 'premium-border-glow border-2 border-yellow-400 shadow-[0_0_15px_rgba(251,191,36,0.5)] bg-white' : 'bg-slate-200 text-slate-400 shadow-sm' }} overflow-hidden flex items-center justify-center text-xs font-bold relative z-10">
                @if (!empty($company['logo']))
                    <img src="{{ $company['logo'] }}" alt="Logo" class="w-full h-full object-cover"
                        id="loader-logo-img"
                        onerror="this.style.display='none'; document.getElementById('loader-logo-fallback').classList.remove('hidden');">
                    <div id="loader-logo-fallback"
                        class="hidden w-full h-full text-white flex items-center justify-center text-lg font-black tracking-wider"
                        style="background-color: var(--color-primary);">
                        {{ $initials }}
                    </div>
                @else
                    <div class="w-full h-full text-white flex items-center justify-center text-lg font-black tracking-wider"
                        style="background-color: var(--color-primary);">
                        {{ $initials }}
                    </div>
                @endif
            </div>
        </div>
        <span class="mt-4 text-xs font-semibold tracking-wider text-slate-400 uppercase">Cargando Menú...</span>
    </div>

    <!-- PORTADA / BANNER DE LA TIENDA (MÓVIL Y PC) -->
    <main class="flex-grow">
        <div class="relative h-56 md:h-80 w-full bg-slate-900 overflow-hidden">
            <img src="{{ !empty($company['cover']) ? $company['cover'] : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200' }}"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200';"
                alt="Portada" class="w-full h-full object-cover opacity-70">
            <!-- Oscurecimiento sutil general -->
            <div class="absolute inset-0 bg-black/10"></div>
            <!-- Desvanecimiento (Fade) elegante hacia el color de fondo de la aplicación -->
            <div class="absolute inset-x-0 bottom-0 h-32 md:h-48"
                style="background: linear-gradient(to top, var(--color-bg) 0%, transparent 100%);"></div>
        </div>

        <!-- MAIN CONTAINER - ESTRUCTURA 2 COLUMNAS (FLEXBOX) -->
        <div class="max-w-7xl mx-auto px-4 md:px-8 -mt-16 md:-mt-32 relative z-30 pb-8">
            <div class="flex flex-col md:flex-row gap-8 items-start">

                <!-- A. COLUMNA IZQUIERDA (Info Tienda - Sidebar integrado) -->
                <div class="w-full md:w-80 md:shrink-0 md:sticky md:top-6 space-y-6">
                    <!-- Se redujo el border-radius, se quitó el shadow gigante y backdrop-blur para hacerlo más sutil -->
                    <div
                        class="relative bg-white/95 backdrop-blur-xl border border-white/40 rounded-2xl p-6 shadow-lg text-center mt-0">


                        @if ($isPremiumPlan)
                            <div
                                class="absolute -top-20 left-1/2 z-40 pointer-events-none float-crown-animation flex items-center justify-center">
                                <i
                                    class="fas fa-crown text-[30px] text-gold-gradient filter drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)]"></i>
                                <span class="absolute w-2 h-2 rounded-full bg-white animate-ping opacity-75"
                                    style="top: 2px;"></span>
                            </div>
                        @endif

                        <div
                            class="absolute -top-12 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full border-4 {{ $isPremiumPlan ? 'premium-border-glow border-yellow-400 shadow-[0_0_20px_rgba(251,191,36,0.6)] bg-white' : 'border-white bg-white shadow-sm' }} overflow-hidden flex items-center justify-center">
                            @if (!empty($company['logo']))
                                <img src="{{ $company['logo'] }}" alt="Logo" class="w-full h-full object-cover"
                                    id="company-logo-img"
                                    onerror="this.style.display='none'; document.getElementById('company-logo-fallback').classList.remove('hidden');">
                                <div id="company-logo-fallback"
                                    class="hidden w-full h-full text-white flex items-center justify-center text-xl font-black tracking-wider"
                                    style="background-color: var(--color-primary);">
                                    {{ $initials }}
                                </div>
                            @else
                                <div class="w-full h-full text-white flex items-center justify-center text-xl font-black tracking-wider"
                                    style="background-color: var(--color-primary);">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>

                        @php
                            $companyMapUrl = !empty($company['google_maps_link'])
                                ? $company['google_maps_link']
                                : 'https://www.google.com/maps/search/?api=1&query=' .
                                    urlencode($company['address'] ?? '');
                        @endphp
                        <div class="pt-10">
                            <button type="button" @click="shareMenu()"
                                class="absolute top-5 right-5 inline-flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-700 shadow-sm w-10 h-10 hover:bg-slate-50 transition-all duration-200"
                                title="Compartir menú">
                                <i class="fas fa-share-alt"></i>
                            </button>

                            <h1 class="text-xl md:text-2xl font-black tracking-tight"
                                style="color: var(--color-secondary);">
                                {{ $company['name'] }}
                            </h1>
                            <p class="text-xs text-slate-500 mt-2 flex items-center justify-center gap-2">
                                <a href="{{ $companyMapUrl }}" target="_blank"
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-700 border border-slate-200 hover:bg-slate-200 transition">
                                    <i class="fas fa-map-marker-alt text-[10px] text-slate-500"></i>
                                    <span>{{ $company['address'] ?: 'Dirección no disponible' }}</span>
                                </a>
                            </p>

                            <div
                                class="flex flex-wrap items-center justify-center gap-2 mt-4 text-[10px] md:text-xs font-semibold">
                                <!-- DYNAMIC STATUS BADGE -->
                                <button type="button"
                                    class="px-3 py-1 rounded-full border flex items-center gap-1 shadow-sm transition-all duration-300 cursor-pointer hover:scale-105 active:scale-95 bg-white text-slate-700 border-slate-200"
                                    :class="hasScheduleInfo ? storeStatus.colorClass :
                                        'bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed opacity-60'"
                                    @click="hasScheduleInfo && (showSchedulesModal = true)"
                                    :disabled="!hasScheduleInfo">
                                    <span :class="storeStatus.dotClass"
                                        class="w-2 h-2 rounded-full animate-ping"></span>
                                    <span x-text="storeStatus.label"></span>
                                </button>

                                <!-- RATING BADGE -->
                                <button type="button"
                                    class="bg-amber-50 text-amber-600 px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1 shadow-sm hover:bg-amber-100 transition cursor-pointer"
                                    @click="showReviewsModal = true">
                                    <i class="fas fa-star text-amber-400 text-[10px]"></i> <span
                                        x-text="averageRating.toFixed(1)">{{ number_format($averageRating, 1) }}</span>
                                </button>

                                @include('partials.store.financing-badges')

                                <!-- CURRENT BRANCH BADGE -->
                                <button @click="showBranchesModal = true"
                                    class="cursor-pointer bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1 rounded-full border border-blue-100 flex items-center gap-1 hover:scale-105 active:scale-95 transition-all duration-200 shadow-sm select-none">
                                    <i class="fas fa-store text-blue-500 text-[10px]"></i> Sede:
                                    {{ $company['name'] }}
                                </button>
                            </div>

                            <!-- DYNAMIC AMENITIES BADGES -->
                            @if (!empty($company['amenities']))
                                @php
                                    $activeAmenities = [];
                                    $allPossibleAmenities = [
                                        'wifi' => [
                                            'label' => 'Wi-Fi',
                                            'icon' => 'fas fa-wifi',
                                            'bg' =>
                                                'bg-blue-50/90 text-blue-700 border-blue-100/60 shadow-[0_1px_2px_rgba(59,130,246,0.05)] dark:bg-blue-950/20 dark:text-blue-400 dark:border-blue-900/30',
                                            'iconColor' => 'text-blue-500 dark:text-blue-400',
                                        ],
                                        'parking' => [
                                            'label' => 'Estacionamiento',
                                            'icon' => 'fas fa-parking',
                                            'bg' =>
                                                'bg-emerald-50/90 text-emerald-700 border-emerald-100/60 shadow-[0_1px_2px_rgba(16,185,129,0.05)] dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/30',
                                            'iconColor' => 'text-emerald-500 dark:text-emerald-400',
                                        ],
                                        'restrooms' => [
                                            'label' => 'Baños públicos',
                                            'icon' => 'fas fa-restroom',
                                            'bg' =>
                                                'bg-teal-50/90 text-teal-700 border-teal-100/60 shadow-[0_1px_2px_rgba(20,184,166,0.05)] dark:bg-teal-950/20 dark:text-teal-400 dark:border-teal-900/30',
                                            'iconColor' => 'text-teal-500 dark:text-teal-400',
                                        ],
                                        'pet_friendly' => [
                                            'label' => 'Pet Friendly',
                                            'icon' => 'fas fa-paw',
                                            'bg' =>
                                                'bg-indigo-50/90 text-indigo-700 border-indigo-100/60 shadow-[0_1px_2px_rgba(99,102,241,0.05)] dark:bg-indigo-950/20 dark:text-indigo-400 dark:border-indigo-900/30',
                                            'iconColor' => 'text-indigo-500 dark:text-indigo-400',
                                        ],
                                        'kids_menu' => [
                                            'label' => 'Menú Niños',
                                            'icon' => 'fas fa-child',
                                            'bg' =>
                                                'bg-rose-50/90 text-rose-700 border-rose-100/60 shadow-[0_1px_2px_rgba(244,63,94,0.05)] dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-900/30',
                                            'iconColor' => 'text-rose-500 dark:text-rose-400',
                                        ],
                                        'reservations' => [
                                            'label' => 'Reservas',
                                            'icon' => 'fas fa-calendar-alt',
                                            'bg' =>
                                                'bg-amber-50/90 text-amber-700 border-amber-100/60 shadow-[0_1px_2px_rgba(245,158,11,0.05)] dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900/30',
                                            'iconColor' => 'text-amber-500 dark:text-amber-400',
                                        ],
                                    ];

                                    foreach ($company['amenities'] as $key => $amenityData) {
                                        if (
                                            isset($amenityData['enabled']) &&
                                            ($amenityData['enabled'] === '1' ||
                                                $amenityData['enabled'] === 1 ||
                                                $amenityData['enabled'] === true ||
                                                $amenityData['enabled'] === 'true')
                                        ) {
                                            if (isset($allPossibleAmenities[$key])) {
                                                $activeAmenities[$key] = array_merge($allPossibleAmenities[$key], [
                                                    'val' => $amenityData['value'] ?? '',
                                                ]);
                                            }
                                        }
                                    }
                                @endphp
                            @endif

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
                                            if (empty($part)) {
                                                continue;
                                            }

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
                                                    $whatsapps[] = [
                                                        'label' => 'WhatsApp ' . $index++,
                                                        'number' => $num,
                                                    ];
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
                                    $whatsapps[] = [
                                        'label' => 'WhatsApp',
                                        'number' => preg_replace('/[^0-9]/', '', $whatsappRaw),
                                    ];
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

                            @if ($hasAnySocial)
                                <div class="mt-4 flex items-center justify-center gap-3 select-none">
                                    <!-- Facebook -->
                                    @if ($hasFacebook)
                                        <a href="{{ $company['facebook'] }}" target="_blank"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-[#1877F2]/10 border-[#1877F2]/20 text-[#1877F2] hover:bg-[#1877F2] hover:text-white hover:scale-110 active:scale-95"
                                            title="Visítanos en Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif

                                    <!-- TikTok -->
                                    @if ($hasTiktok)
                                        <a href="{{ $company['tiktok'] }}" target="_blank"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-black/10 border-black/20 text-black hover:bg-black hover:text-white hover:scale-110 active:scale-95 group"
                                            title="Síguenos en TikTok">
                                            <i
                                                class="fab fa-tiktok text-black group-hover:text-white transition-colors"></i>
                                        </a>
                                    @endif

                                    <!-- Instagram -->
                                    @if ($hasInstagram)
                                        <a href="{{ $company['instagram'] }}" target="_blank"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-gradient-to-tr from-[#FFB703]/10 to-[#E60067]/10 border-[#E60067]/20 text-[#E60067] hover:from-[#FFB703] hover:to-[#E60067] hover:text-white hover:scale-110 active:scale-95"
                                            title="Síguenos en Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif

                                    <!-- X (Twitter) -->
                                    @if ($hasX)
                                        <a href="{{ $company['x_twitter'] }}" target="_blank"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs transition-all duration-300 shadow-sm border bg-black/10 border-black/20 text-black hover:bg-black hover:text-white hover:scale-110 active:scale-95 group"
                                            title="Síguenos en X (Twitter)">
                                            <svg class="w-3 h-3 text-black group-hover:text-white transition-colors"
                                                fill="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- CANALES DE CONTACTO -->
                            @php
                                $hasTelegram = !empty($company['telegram']);
                                $hasTelegramUrl = $hasTelegram
                                    ? (str_contains($company['telegram'], 't.me')
                                        ? $company['telegram']
                                        : 'https://t.me/' . ltrim($company['telegram'], '@'))
                                    : '';
                                $hasWhatsApp = !empty($company['whatsapp']);
                            @endphp

                            @if ($hasWhatsApp || $hasTelegram)
                                <div
                                    class="mt-3.5 flex flex-wrap justify-center gap-2 text-[10px] md:text-[11px] font-bold select-none">
                                    <!-- WhatsApp -->
                                    @if ($hasWhatsApp)
                                        @if (count($whatsapps) > 1)
                                            <button @click="showWhatsappModal = true"
                                                class="flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-500 hover:text-white border border-emerald-100 text-emerald-600 px-3 py-1.5 rounded-xl transition duration-300 active:scale-95 shadow-sm cursor-pointer">
                                                <i class="fab fa-whatsapp text-[13px]"></i> WhatsApp
                                            </button>
                                        @else
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapps[0]['number'] ?? $company['whatsapp']) }}"
                                                target="_blank"
                                                class="flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-500 hover:text-white border border-emerald-100 text-emerald-600 px-3 py-1.5 rounded-xl transition duration-300 active:scale-95 shadow-sm">
                                                <i class="fab fa-whatsapp text-[13px]"></i> WhatsApp
                                            </a>
                                        @endif
                                    @endif

                                    <!-- Telegram Contacto -->
                                    @if ($hasTelegram)
                                        <a href="{{ $hasTelegramUrl }}" target="_blank"
                                            class="flex items-center gap-1.5 bg-sky-50 hover:bg-[#0088cc] hover:text-white border border-[#0088cc]/20 text-[#0088cc] px-3 py-1.5 rounded-xl transition duration-300 active:scale-95 shadow-sm">
                                            <i class="fab fa-telegram-plane text-[13px]"></i> Telegram
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
                                    'Punto de Venta' =>
                                        'bg-indigo-500 hover:bg-indigo-600 text-white border-indigo-500',
                                ];
                            @endphp

                            <!-- TASA MONETARIA -->
                            @if (!empty($company['exchange_rate']))
                                @php
                                    $currencyLabel =
                                        isset($company['base_currency']) &&
                                        strtoupper($company['base_currency']) === 'EUR'
                                            ? 'EUR'
                                            : 'USD';
                                @endphp
                                <div class="mt-4 w-full max-w-[280px] mx-auto bg-gradient-to-br from-[#5A6370] to-[#3B424D] text-white border border-[#374151]/55 rounded-2xl px-4 py-3 flex flex-col items-center relative overflow-hidden transition-all duration-300 hover:shadow-lg select-none"
                                    style="box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.15), 0 8px 20px -6px rgba(0, 0, 0, 0.2);">
                                    <!-- Decorative light reflection shimmer effect -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full animate-bcv-shimmer pointer-events-none">
                                    </div>

                                    <!-- Large subtle background watermark -->
                                    <div
                                        class="absolute -left-4 -bottom-4 w-24 h-24 opacity-[0.05] text-white pointer-events-none select-none transform rotate-12">
                                        <svg viewBox="0 0 100 100" class="w-full h-full" fill="currentColor">
                                            <!-- Concentric outer circles -->
                                            <circle cx="50" cy="50" r="48" fill="none"
                                                stroke="currentColor" stroke-width="1.8" />
                                            <circle cx="50" cy="50" r="45" fill="none"
                                                stroke="currentColor" stroke-width="0.8" />

                                            <!-- 32 detailed segments rotated -->
                                            @for ($i = 0; $i < 32; $i++)
                                                <use href="#bcv-seal-segment"
                                                    transform="rotate({{ $i * 11.25 }} 50 50)" />
                                            @endfor

                                            <!-- Solid central circle -->
                                            <circle cx="50" cy="50" r="25.5" fill="currentColor"
                                                stroke="white" stroke-width="0.8" />

                                            <!-- Inner banner box for BCV letters -->
                                            <rect x="23" y="38" width="54" height="24" fill="currentColor"
                                                stroke="white" stroke-width="1.5" rx="1.5" />
                                            <text x="50" y="55.5" font-family="'Georgia', 'Times New Roman', serif"
                                                font-weight="900" font-size="16" fill="white" text-anchor="middle"
                                                letter-spacing="1">BCV</text>
                                        </svg>
                                    </div>

                                    <!-- Official Seal Stamp (Esquina Superior Derecha) -->
                                    <div class="absolute top-2 right-2 w-[38px] h-[38px] bg-white/90 backdrop-blur-md rounded-full shadow-[0_2px_8px_rgba(0,0,0,0.15)] border border-slate-200/40 flex items-center justify-center transform -rotate-12 hover:rotate-0 hover:scale-105 active:scale-95 transition-all duration-300 pointer-events-auto cursor-pointer"
                                        title="Tasa Oficial del Banco Central de Venezuela">
                                        <svg viewBox="0 0 100 100" class="w-[30px] h-[30px] text-slate-800"
                                            fill="currentColor">
                                            <defs>
                                                <g id="bcv-seal-segment">
                                                    <path d="M 50,5.5 L 47.8,10.2 L 52.2,10.2 Z" fill="currentColor" />
                                                    <path
                                                        d="M 50,11.5 L 44,17.2 L 46.2,19.2 L 50,15.6 L 53.8,19.2 L 56,17.2 Z"
                                                        fill="currentColor" />
                                                    <path d="M 49.3,10 L 50.7,10 L 50.7,24.5 L 49.3,24.5 Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M 50,16.5 L 45.2,21.3 L 47,23.1 L 50,20.1 L 53,23.1 L 54.8,21.3 Z"
                                                        fill="currentColor" />
                                                    <path d="M 50,21.5 L 48.2,24.2 L 51.8,24.2 Z"
                                                        fill="currentColor" />
                                                </g>
                                            </defs>
                                            <!-- Concentric outer circles -->
                                            <circle cx="50" cy="50" r="48" fill="none"
                                                stroke="currentColor" stroke-width="1.8" />
                                            <circle cx="50" cy="50" r="45" fill="none"
                                                stroke="currentColor" stroke-width="0.8" />

                                            <!-- 32 detailed segments rotated -->
                                            @for ($i = 0; $i < 32; $i++)
                                                <use href="#bcv-seal-segment"
                                                    transform="rotate({{ $i * 11.25 }} 50 50)" />
                                            @endfor

                                            <!-- Solid central circle -->
                                            <circle cx="50" cy="50" r="25.5" fill="currentColor"
                                                stroke="white" stroke-width="0.8" />

                                            <!-- Inner banner box for BCV letters -->
                                            <rect x="23" y="38" width="54" height="24" fill="currentColor"
                                                stroke="white" stroke-width="1.5" rx="1.5" />
                                            <text x="50" y="55.5" font-family="'Georgia', 'Times New Roman', serif"
                                                font-weight="900" font-size="16" fill="white" text-anchor="middle"
                                                letter-spacing="1">BCV</text>
                                        </svg>
                                    </div>

                                    <span
                                        class="text-[#A2ACBC] text-[9.5px] font-black uppercase tracking-[0.15em] mb-1 select-none pr-8">
                                        Tasa Oficial BCV ({{ $currencyLabel }})
                                    </span>

                                    <span
                                        class="text-xl md:text-2xl font-black text-white tracking-tight mb-1 select-none pr-8">
                                        {{ $company['exchange_rate'] }}
                                    </span>

                                    @if (!empty($company['exchange_updated_at']))
                                        <div
                                            class="text-[#96A4B6] text-[9.5px] font-semibold flex items-center justify-center gap-1 mt-0.5 select-none w-full border-t border-white/5 pt-1.5">
                                            <i class="far fa-clock text-[9px] text-[#8A95A5]"></i>
                                            <span>Actualizado: {{ $company['exchange_updated_at'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- MÉTODOS DE PAGO -->
                            <div
                                class="mt-5 text-center border-t border-slate-100 pt-4 flex flex-col items-center w-full">
                                <button @click="hasPaymentMethodsConfigured && (showAllPaymentMethodsModal = true)"
                                    :class="hasPaymentMethodsConfigured ?
                                        'w-full bg-gradient-to-r from-slate-800 to-slate-900 hover:from-slate-900 hover:to-black text-white' :
                                        'w-full bg-slate-200 text-slate-500 cursor-not-allowed border border-slate-200'"
                                    :disabled="!hasPaymentMethodsConfigured"
                                    class="font-extrabold py-3 px-4 rounded-2xl text-[11px] flex items-center justify-center gap-2 transition shadow-md active:scale-95 select-none border border-slate-700/30">
                                    <i class="fas fa-wallet text-xs"></i>
                                    <span>Métodos de Pago</span>
                                    <span
                                        class="bg-white/20 text-white text-[9px] px-2 py-0.5 rounded-full font-black ml-1 shadow-sm">{{ count($activePaymentMethods) }}</span>
                                </button>
                            </div>

                            <!-- BOTONES DE ACCIÓN (HORARIOS, SUCURSALES Y OPINIONES) -->
                            <div class="mt-5 grid grid-cols-2 gap-2">
                                <button @click="showSchedulesModal = true"
                                    class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                                    <i class="far fa-clock"></i> <span>Horarios</span>
                                    <span x-show="hasScheduleInfo"
                                        class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-extrabold ml-1 shadow-sm">
                                        <span x-text="getOpenDaysCount()"></span>
                                    </span>
                                </button>
                                <button @click="showBranchesModal = true"
                                    class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                                    <i class="fas fa-store"></i> <span>Sucursales</span>
                                    <span
                                        class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-extrabold ml-1 shadow-sm">
                                        {{ count($branches) }}
                                    </span>
                                </button>
                            </div>
                            <div
                                class="mt-2 grid {{ ($company['has_dine_in'] ?? true) || ($company['has_pickup'] ?? true) || ($company['has_delivery'] ?? true) ? 'grid-cols-2' : 'grid-cols-1' }} gap-2">
                                @if (($company['has_dine_in'] ?? true) || ($company['has_pickup'] ?? true) || ($company['has_delivery'] ?? true))
                                    <button @click="showServiceTypesModal = true"
                                        class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition active:scale-95 shadow-sm">
                                        <i class="fas fa-concierge-bell"></i>
                                        <span>Servicios</span>
                                        <span
                                            class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-extrabold ml-1 shadow-sm">
                                            {{ ($company['has_dine_in'] ?? true ? 1 : 0) + ($company['has_pickup'] ?? true ? 1 : 0) + ($company['has_delivery'] ?? true ? 1 : 0) }}
                                        </span>
                                    </button>
                                @endif
                                <button @click="showReviewsModal = true"
                                    class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition active:scale-95 shadow-sm">
                                    <i class="fas fa-comment-dots"></i>
                                    <span>Opiniones</span>
                                    <span
                                        class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-extrabold ml-1 shadow-sm"
                                        x-text="totalReviewsCount">{{ $reviews->count() }}</span>
                                </button>
                            </div>

                            <!-- BOTÓN DE ACCIÓN RESERVAS -->
                            <div class="mt-2">
                                <button @click="showBookingModal = true; bookingName = customerName; bookingPhone = customerPhone"
                                    class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition active:scale-95 shadow-sm">
                                    <i class="far fa-calendar-alt text-[var(--color-primary)]"></i>
                                    <span>Agendar Reserva / Cita</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- B. COLUMNA CENTRAL (Buscador, Categorías y Productos) -->
                <div class="flex-1 w-full space-y-6">

                    <!-- Buscador Dinámico -->
                    <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-100 flex items-center gap-2">
                        <i class="fas fa-search text-slate-400 ml-3"></i>
                        <input type="text" x-model="searchQuery" placeholder="Buscar productos..."
                            class="w-full bg-transparent border-none focus:ring-0 text-sm py-2 px-2 text-slate-800 placeholder-slate-400">
                        <button x-show="searchQuery !== ''" @click="searchQuery = ''"
                            class="mr-3 text-slate-400 hover:text-rose-500"><i class="fas fa-times"></i></button>
                    </div>

                    <!-- Categorías (Navegación Horizontal - Cards Premium) -->
                    <div
                        class="sticky top-4 z-40 bg-white/95 backdrop-blur-md py-2 px-4 rounded-2xl shadow-md border border-slate-100/80 transition-all duration-300">
                        <div id="category-nav-bar"
                            class="flex flex-wrap md:flex-nowrap items-start md:justify-center gap-3.5 md:gap-5 overflow-visible md:overflow-x-auto py-0.5">

                            <!-- Todas -->
                            <a href="#" id="nav-chip-0"
                                class="flex flex-col items-center gap-0.5 group cursor-pointer focus:outline-none select-none transition-all duration-300 shrink-0"
                                @click.prevent="scrollToCategory(0)">
                                <div class="relative w-9 h-9 rounded-lg bg-white border flex items-center justify-center transition-all duration-300 shadow-sm"
                                    :class="activeCategory === 0 ? 'scale-105 shadow-md ring-2 ring-[var(--color-primary)]/10' :
                                        'border-slate-100 hover:border-slate-300 hover:scale-102'"
                                    :style="activeCategory === 0 ? 'border-color: var(--color-primary);' : ''">
                                    <i class="fas fa-border-all text-xs transition-colors duration-300"
                                        :class="activeCategory === 0 ? 'text-[var(--color-primary)]' :
                                            'text-slate-400 group-hover:text-slate-600'"></i>

                                    <span
                                        class="absolute -top-1 -right-1 text-[8px] md:text-[9px] font-black text-white px-1.5 py-0.5 min-w-[18px] h-[18px] rounded-full border border-white shadow-sm flex items-center justify-center transition-all duration-300"
                                        style="background-color: var(--color-primary);">
                                        {{ $categories->sum(fn($c) => $c->products->count()) }}
                                    </span>
                                </div>
                                <span
                                    class="text-[7.5px] font-black tracking-wider uppercase transition-colors duration-300 text-center max-w-[60px] whitespace-normal break-words leading-tight pt-0.5"
                                    :class="activeCategory === 0 ? 'text-slate-900 font-extrabold' :
                                        'text-slate-400 group-hover:text-slate-600'">
                                    Todas
                                </span>
                            </a>

                            @foreach ($categories as $category)
                                @php
                                    $icon = $getCategoryIcon($category);
                                    $color = $getCategoryColor($category);
                                    $prodCount = $category->products->count();
                                @endphp
                                @if ($prodCount > 0)
                                    <a href="#cat-{{ $category->id }}" id="nav-chip-{{ $category->id }}"
                                        class="flex flex-col items-center gap-0.5 group cursor-pointer focus:outline-none select-none transition-all duration-300 shrink-0"
                                        @click.prevent="scrollToCategory({{ $category->id }})">
                                        <div class="relative w-9 h-9 rounded-lg bg-white border flex items-center justify-center transition-all duration-300 shadow-sm"
                                            :class="activeCategory === {{ $category->id }} ? 'scale-105 shadow-md ring-2' :
                                                'border-slate-100 hover:border-slate-300 hover:scale-102'"
                                            :style="activeCategory === {{ $category->id }} ?
                                                'border-color: {{ $color }}; ring-color: {{ $color }}1A; box-shadow: 0 15px 35px -24px {{ $color }}55;' :
                                                ''">
                                            <i class="fas {{ $icon }} text-xs transition-all duration-300"
                                                :style="activeCategory === {{ $category->id }} ? 'color: ' +
                                                    '{{ $color }}' : ''"
                                                :class="activeCategory === {{ $category->id }} ? '' :
                                                    'text-slate-400 group-hover:text-slate-600'"></i>

                                            <span
                                                class="absolute -top-1 -right-1 text-[8px] md:text-[9px] font-black text-white px-1.5 py-0.5 min-w-[18px] h-[18px] rounded-full border border-white shadow-sm flex items-center justify-center transition-all duration-300"
                                                style="background-color: {{ $color }};">
                                                {{ $prodCount }}
                                            </span>
                                        </div>
                                        <span
                                            class="text-[7.5px] font-black tracking-wider uppercase transition-all duration-300 text-center max-w-[60px] whitespace-normal break-words leading-tight pt-0.5"
                                            :class="activeCategory === {{ $category->id }} ? 'text-slate-900 font-extrabold' :
                                                'text-slate-400 group-hover:text-slate-600'">
                                            {{ $category->name }}
                                        </span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- PRODUCTOS -->
                    <div id="products-container">
                        @foreach ($categories as $category)
                            @if ($category->products->count() > 0)
                                <section id="cat-{{ $category->id }}" class="mb-10 scroll-mt-28"
                                    x-intersect:enter="onSectionIntersect({{ $category->id }}, true)"
                                    x-show="(selectedCategory === 0 || selectedCategory === {{ $category->id }}) && (searchQuery === '' || [
                                     @foreach ($category->products as $product)
                                         '{{ strtolower(str_replace("'", "\'", $product->name)) }}', @endforeach
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
                                        <span class="w-1 h-6 rounded-full shrink-0"
                                            style="background-color: {{ $color }};"></span>
                                        <div class="w-7 h-7 rounded-xl flex items-center justify-center border shrink-0 transition-all duration-300"
                                            style="background-color: {{ $color }}15; border-color: {{ $color }}25; color: {{ $color }};">
                                            <i class="fas {{ $icon }} text-xs"></i>
                                        </div>
                                        <h2 class="text-base md:text-lg font-black tracking-tight"
                                            style="color: var(--color-secondary);">{{ $category->name }}</h2>
                                        <span
                                            class="text-xs md:text-sm font-black text-white px-2 py-1 rounded-lg flex items-center justify-center shadow-sm shrink-0"
                                            style="background-color: {{ $color }};"
                                            x-text="[
                                          @foreach ($category->products as $p)
                                              '{{ strtolower(str_replace("'", "\'", $p->name)) }}', @endforeach
                                      ].filter(name => name.includes(searchQuery.toLowerCase())).length">
                                            {{ $category->products->count() }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach ($category->products as $product)
                                            <div class="bg-white rounded-2xl flex flex-col justify-between relative overflow-hidden group"
                                                style="border: 1px solid {{ $color }}22; box-shadow: 0 18px 45px -28px {{ $color }}40;"
                                                x-data="{ qty: 1, clicked: false, productData: {{ $product->toJson() }} }"
                                                x-show="searchQuery === '' || '{{ strtolower(str_replace("'", "\'", $product->name)) }}'.includes(searchQuery.toLowerCase())"
                                                x-transition:enter="transition-all ease-out duration-300 transform"
                                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                x-transition:leave="transition-all ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 scale-95 translate-y-2">
                                                @php $badgeConfig = $getBadgeConfig($product); @endphp
                                                <div class="h-40 w-full bg-slate-50 shrink-0 relative overflow-hidden">
                                                    <img @click="openProductDetails(productData)"
                                                        :src="getProductFeatures(productData).images[0] ||
                                                            '{{ asset('img1.jpg') }}'"
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300 select-none">

                                                    {{-- ── BADGE CHIP (badgeConfig from features.badge) ── --}}
                                                    @if ($badgeConfig)
                                                        <div
                                                            class="absolute top-2 z-10 pointer-events-none {{ $badgeConfig['position'] === 'right' ? 'right-2' : 'left-2' }}">
                                                            <span
                                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black text-white tracking-wide shadow-[0_2px_8px_rgba(0,0,0,0.28)] ring-1 ring-white/20 backdrop-blur-[2px] select-none"
                                                                style="background-color: {{ $badgeConfig['bgColor'] }};">
                                                                @if ($badgeConfig['icon'])
                                                                    <i
                                                                        class="fa-solid {{ $badgeConfig['icon'] }} text-[9px] leading-none"></i>
                                                                @endif
                                                                {{ $badgeConfig['text'] }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                </div>

                                                <div class="flex-grow flex flex-col justify-between p-4 relative">
                                                    {{-- Badge para productos sin imagen --}}
                                                    @if (!$product->image_path && isset($badgeConfig) && $badgeConfig)
                                                        <div
                                                            class="absolute top-2 z-10 {{ $badgeConfig['position'] === 'right' ? 'right-2' : 'left-2' }}">
                                                            <span
                                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black text-white tracking-wide shadow-[0_2px_8px_rgba(0,0,0,0.18)] ring-1 ring-black/5 select-none"
                                                                style="background-color: {{ $badgeConfig['bgColor'] }};">
                                                                @if ($badgeConfig['icon'])
                                                                    <i
                                                                        class="fa-solid {{ $badgeConfig['icon'] }} text-[9px] leading-none"></i>
                                                                @endif
                                                                {{ $badgeConfig['text'] }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h3
                                                            class="text-base md:text-lg font-bold text-slate-900 mb-1.5 leading-tight">
                                                            {{ $product->name }}</h3>
                                                        <div class="flex flex-wrap gap-2 mb-3">
                                                            <template
                                                                x-if="getProductFeatures(productData).colors && getProductFeatures(productData).colors.length > 0">
                                                                <span
                                                                    class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-700">
                                                                    Color
                                                                </span>
                                                            </template>
                                                            <template
                                                                x-if="getProductFeatures(productData).sizes && getProductFeatures(productData).sizes.length > 0">
                                                                <span
                                                                    class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-700">
                                                                    Talla
                                                                </span>
                                                            </template>
                                                            <template
                                                                x-if="getProductFeatures(productData).flavors && getProductFeatures(productData).flavors.length > 0">
                                                                <span
                                                                    class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-700">
                                                                    Sabor
                                                                </span>
                                                            </template>
                                                            <template
                                                                x-if="getProductFeatures(productData).units && getProductFeatures(productData).units.length > 0">
                                                                <span
                                                                    class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-[10px] font-semibold text-slate-700">
                                                                    Presentación
                                                                </span>
                                                            </template>
                                                        </div>
                                                        @if ($product->preparation_time)
                                                            <div class="flex items-center gap-1 mb-3">
                                                                <span class="text-[10px]">⏱️</span>
                                                                <span class="text-[10px] font-semibold"
                                                                    style="color: var(--color-secondary);">{{ $product->preparation_time }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="flex flex-col gap-3 mt-auto">
                                                        <!-- Price and Quantity Control Row -->
                                                        <div class="flex justify-between items-center">
                                                            <div class="flex flex-col">
                                                                <span
                                                                    class="text-sm md:text-base font-black text-slate-900">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</span>
                                                                @if ($exchangeRateFloat > 0)
                                                                    @php
                                                                        $bsPrice = $product->price * $exchangeRateFloat;
                                                                    @endphp
                                                                    <span
                                                                        class="text-[10px] text-slate-400 font-extrabold mt-0.5">Bs.
                                                                        {{ number_format($bsPrice, 2, ',', '.') }}</span>
                                                                @endif
                                                            </div>

                                                            <!-- Qty Pill Selector -->
                                                            <div
                                                                class="flex items-center gap-1.5 bg-slate-50 p-1 rounded-full border border-slate-200/80 shadow-inner">
                                                                <button type="button" @click="if (qty > 1) qty--"
                                                                    class="w-6 h-6 rounded-full bg-white text-slate-600 flex items-center justify-center font-black text-xs hover:bg-rose-50 hover:text-rose-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">-</button>
                                                                <span
                                                                    class="text-[11px] font-black text-slate-700 w-4 text-center select-none"
                                                                    x-text="qty"></span>
                                                                <button type="button" @click="qty++"
                                                                    class="w-6 h-6 rounded-full bg-white text-slate-600 flex items-center justify-center font-black text-xs hover:bg-emerald-50 hover:text-emerald-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">+</button>
                                                            </div>
                                                        </div>

                                                        <!-- Action Button -->
                                                        <div class="mt-auto w-full">
                                                            <button type="button"
                                                                class="w-full py-2.5 rounded-xl text-white font-extrabold text-xs flex items-center justify-center gap-1.5 shadow-sm transition-all duration-300 relative overflow-hidden select-none cursor-pointer hover:scale-[1.02] active:scale-95"
                                                                style="background-color: var(--color-primary);"
                                                                @click="
                                                            const _f = getProductFeatures(productData);
                                                            const _hasVariants = (_f.colors && _f.colors.length > 0) || (_f.sizes && _f.sizes.length > 0) || (_f.units && _f.units.length > 0) || (_f.flavors && _f.flavors.length > 0);
                                                            if (_hasVariants) {
                                                                openProductDetails(productData, { qty: qty });
                                                            } else {
                                                                clicked = true;
                                                                addToCartWithQty(productData, qty);
                                                                setTimeout(() => { clicked = false; qty = 1; }, 1200);
                                                            }
                                                        ">
                                                                <template x-if="!clicked">
                                                                    <span class="flex items-center gap-1.5">
                                                                        <i
                                                                            class="fas fa-shopping-basket text-[10px]"></i>
                                                                        <span>Agregar al Pedido</span>
                                                                        <span class="opacity-80 font-bold"
                                                                            x-show="qty > 1"
                                                                            x-text="'(' + qty + ')'"></span>
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
    @if (env('SYSTEM_BRAND_NAME'))
        <div class="w-full text-center py-4 mt-2 select-none">
            <a href="{{ env('SYSTEM_BRAND_URL', '#') }}" target="_blank"
                class="text-xs font-black tracking-widest uppercase transition-all duration-300 hover:scale-105 inline-block"
                style="color: var(--color-primary);">
                {{ env('SYSTEM_BRAND_NAME') }} <span
                    class="opacity-75 font-semibold">v{{ env('SYSTEM_BRAND_VERSION', '1.0.0') }}</span>
            </a>
        </div>
    @endif

    <!-- Persistent Table Badge for Dine-in -->
    <div x-show="tableNumber" x-cloak
        class="fixed bottom-24 right-6 z-40 bg-slate-900/95 dark:bg-slate-900/98 backdrop-blur-md border border-white/10 text-white px-4 py-2.5 rounded-full shadow-[0_12px_40px_rgba(0,0,0,0.2)] flex items-center gap-2 hover:scale-105 active:scale-95 transition-all duration-300">
        <span class="flex h-2.5 w-2.5 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
        </span>
        <span class="text-xs font-black tracking-wide flex items-center gap-1 select-none">
            <i class="fas fa-utensils text-[var(--color-primary)]"></i> Mesa #<span x-text="tableNumber"></span>
        </span>
    </div>

    <!-- FLOATING CART BUTTON -->
    <div class="fixed bottom-6 right-6 z-40" x-transition>
        <button @click="isCartOpen = true"
            class="relative w-16 h-16 rounded-full flex items-center justify-center text-white {{ $isPremiumPlan ? 'premium-border-glow border-4 border-yellow-400 shadow-[0_0_20px_rgba(251,191,36,0.6)]' : 'shadow-[0_8px_30px_rgba(0,0,0,0.3)]' }} hover:scale-105 active:scale-95 transition-all duration-300"
            style="background-color: var(--color-primary);">
            <i class="fas fa-shopping-bag text-2xl"></i>
            <span
                class="absolute -top-1 -right-1 bg-rose-500 text-white text-[11px] font-black w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow-sm"
                x-text="totalItems"></span>
        </button>
    </div>

    <!-- FLOATING ACCESSIBILITY BUTTON -->
    <div class="fixed bottom-6 left-6 z-40" x-show="false">
        <button @click="showAccessibilityModal = true"
            class="w-10 h-10 rounded-full flex items-center justify-center bg-white border border-slate-200 text-slate-700 shadow-[0_4px_12px_rgba(0,0,0,0.08)] hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer"
            title="Configuración y Accesibilidad">
            <i class="fas fa-universal-access text-base" style="color: var(--color-primary);"></i>
        </button>
    </div>

    <!-- ACCESSIBILITY MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showAccessibilityModal"
        @click="showAccessibilityModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[88%] max-w-[290px] bg-white rounded-[24px] shadow-2xl z-[1001] max-h-[80vh] flex flex-col overflow-hidden origin-center"
        x-show="showAccessibilityModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">

        <!-- Header -->
        <div class="py-3 px-4 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-1.5">
                <i class="fas fa-universal-access text-sm"></i>
                <h2 class="text-xs font-black tracking-tight">Accesibilidad</h2>
            </div>
            <button @click="showAccessibilityModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-6 h-6 flex items-center justify-center rounded-full transition active:scale-95">
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
                        :style="{
                            left: 'calc(' + ((accessibility.fontSize - 14) / 10) * 100 + '% - 0px)',
                            transform: 'translateX(-50%)'
                        }">
                        <span x-text="accessibility.fontSize + ' px'"></span>
                        <div class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-slate-800 rotate-45">
                        </div>
                    </div>

                    <!-- Track and input -->
                    <div class="relative flex items-center">
                        <span class="text-[9px] font-black text-slate-400 shrink-0 mr-1.5 select-none">A</span>
                        <input type="range" min="14" max="24" step="1"
                            x-model="accessibility.fontSize" @input="updateFontSize()"
                            class="w-full h-1 rounded-lg appearance-none cursor-pointer accent-[var(--color-primary)]">
                        <span class="text-xs font-black text-slate-400 shrink-0 ml-1.5 select-none">A</span>
                    </div>
                </div>

                <div
                    class="flex justify-between items-center text-[8px] text-slate-400 font-bold uppercase tracking-wider border-t border-slate-55 pt-2 px-0.5 shrink-0">
                    <span>Estándar (16px)</span>
                    <button type="button" @click="accessibility.fontSize = 16; updateFontSize()"
                        class="text-[var(--color-primary)] hover:underline active:scale-95 font-extrabold cursor-pointer">Restablecer</button>
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
                        :class="accessibility.daltonism === 'normal' ?
                            'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' :
                            'border-slate-200 hover:bg-slate-50 text-slate-600'">
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
                        :class="accessibility.daltonism === 'protanopia' ?
                            'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' :
                            'border-slate-200 hover:bg-slate-50 text-slate-600'">
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
                        :class="accessibility.daltonism === 'deuteranopia' ?
                            'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' :
                            'border-slate-200 hover:bg-slate-50 text-slate-600'">
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
                        :class="accessibility.daltonism === 'tritanopia' ?
                            'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' :
                            'border-slate-200 hover:bg-slate-50 text-slate-600'">
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
                        :class="accessibility.daltonism === 'monochromacy' ?
                            'border-[var(--color-primary)] bg-[var(--color-primary)]/5 font-black text-slate-800' :
                            'border-slate-200 hover:bg-slate-50 text-slate-600'">
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
            <button @click="showAccessibilityModal = false"
                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-2 rounded-xl transition active:scale-95 text-[9px] uppercase tracking-wider cursor-pointer">
                Listo / Guardar
            </button>
        </div>
    </div>

    <!-- WHATSAPP MULTI-CONTACT MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showWhatsappModal"
        @click="showWhatsappModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-xs bg-white rounded-3xl shadow-2xl z-[1001] overflow-hidden origin-center flex flex-col max-h-[85vh]"
        x-show="showWhatsappModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <!-- Header -->
        <div class="p-4 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fab fa-whatsapp text-base"></i>
                <h2 class="text-base font-black tracking-tight">Contactar por WhatsApp</h2>
            </div>
            <button @click="showWhatsappModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-8 h-8 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-4 bg-slate-50 overflow-y-auto space-y-2 scrollbar-none">
            <p class="text-[10px] text-slate-500 font-medium text-center mb-3">
                Selecciona a qué contacto o departamento deseas escribir:
            </p>
            @foreach ($whatsapps as $wa)
                <a href="https://wa.me/{{ $wa['number'] }}" target="_blank" @click="showWhatsappModal = false"
                    class="flex items-center justify-between bg-white border border-slate-100 hover:border-emerald-300 hover:bg-emerald-50/20 px-3.5 py-3 rounded-2xl transition duration-200 shadow-sm active:scale-[0.98] group">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </div>
                        <div class="flex flex-col text-left">
                            <span
                                class="text-xs font-black text-slate-800 group-hover:text-emerald-700 transition-colors">{{ $wa['label'] }}</span>
                            <span class="text-[9px] text-slate-400 font-semibold mt-0.5">{{ $wa['number'] }}</span>
                        </div>
                    </div>
                    <i
                        class="fas fa-chevron-right text-[8px] text-slate-355 group-hover:translate-x-0.5 group-hover:text-emerald-500 transition-all"></i>
                </a>
            @endforeach
        </div>
        <!-- Footer -->
        <div class="p-3 bg-white border-t border-slate-100 text-center shrink-0">
            <button @click="showWhatsappModal = false"
                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold py-2.5 rounded-xl transition active:scale-95 text-[10px] uppercase tracking-wider cursor-pointer">
                Cancelar
            </button>
        </div>
    </div>

    <!-- WHATSAPP ORDER DIRECTION MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showOrderWhatsappModal"
        @click="showOrderWhatsappModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-xs bg-white rounded-3xl shadow-2xl z-[1001] overflow-hidden origin-center flex flex-col max-h-[85vh]"
        x-show="showOrderWhatsappModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <!-- Header -->
        <div class="p-4 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fab fa-whatsapp text-base"></i>
                <h2 class="text-base font-black tracking-tight">Enviar Pedido</h2>
            </div>
            <button @click="showOrderWhatsappModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-8 h-8 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-4 bg-slate-50 overflow-y-auto space-y-2 scrollbar-none">
            <p class="text-[10px] text-slate-500 font-medium text-center mb-3">
                Selecciona a qué sucursal o departamento enviar tu pedido:
            </p>
            @foreach ($whatsapps as $wa)
                <button @click="redirectToOrderWhatsApp('{{ $wa['number'] }}')"
                    class="w-full flex items-center justify-between bg-white border border-slate-100 hover:border-emerald-300 hover:bg-emerald-50/20 px-3.5 py-3 rounded-2xl transition duration-200 shadow-sm active:scale-[0.98] group cursor-pointer">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-200 shrink-0">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </div>
                        <div class="flex flex-col text-left">
                            <span
                                class="text-xs font-black text-slate-800 group-hover:text-emerald-700 transition-colors">{{ $wa['label'] }}</span>
                            <span class="text-[9px] text-slate-400 font-semibold mt-0.5">{{ $wa['number'] }}</span>
                        </div>
                    </div>
                    <i
                        class="fas fa-chevron-right text-[8px] text-slate-355 group-hover:translate-x-0.5 group-hover:text-emerald-500 transition-all"></i>
                </button>
            @endforeach
        </div>
        <!-- Footer -->
        <div class="p-3 bg-white border-t border-slate-100 text-center shrink-0">
            <button @click="showOrderWhatsappModal = false"
                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-extrabold py-2.5 rounded-xl transition active:scale-95 text-[10px] uppercase tracking-wider cursor-pointer">
                Cancelar
            </button>
        </div>
    </div>

    <!-- CART MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="isCartOpen"
        @click="isCartOpen = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-bottom-right"
        x-show="isCartOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-5 flex justify-between items-center gap-4 select-none text-white shadow-sm"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-shopping-bag text-lg"></i>
                <div>
                    <h2 class="text-lg font-black tracking-tight">Mi Pedido</h2>
                    <p class="text-[11px] text-white/80" x-text="totalItems + ' artículos'"></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button @click="confirmClearCart()"
                    class="text-white/80 hover:text-white hover:bg-white/10 px-3 py-2 rounded-2xl text-[11px] font-bold transition active:scale-95">
                    Vaciar carrito
                </button>
                <button @click="isCartOpen = false"
                    class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                        class="fas fa-times text-lg"></i></button>
            </div>
        </div>
        <div class="p-5 flex-grow overflow-y-auto scrollbar-none bg-slate-50 space-y-4">
            <!-- AVISO DINÁMICO DE ENVÍO GRATIS -->
            <template x-if="enableFreeShipping && cart.length > 0">
                <div class="rounded-2xl p-3.5 border transition-all duration-300 flex items-center gap-3 shadow-sm select-none"
                    :class="total < freeShippingMinAmount ?
                        'bg-amber-50 border-amber-200 text-amber-800' :
                        'bg-emerald-50 border-emerald-200 text-emerald-800'">

                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-sm"
                        :class="total < freeShippingMinAmount ? 'bg-amber-100 text-amber-600' :
                            'bg-emerald-100 text-emerald-600'">
                        <template x-if="total < freeShippingMinAmount">
                            <i class="fas fa-info-circle text-base animate-pulse"></i>
                        </template>
                        <template x-if="total >= freeShippingMinAmount">
                            <i class="fas fa-gift text-base"></i>
                        </template>
                    </div>

                    <div class="flex-grow min-w-0">
                        <template x-if="total < freeShippingMinAmount">
                            <div class="text-[11px] font-semibold">
                                Faltan <span class="font-extrabold text-xs"
                                    x-text="currencySymbol + (freeShippingMinAmount - total).toFixed(2)"></span> para
                                <span class="font-bold">envío gratis</span>
                            </div>
                        </template>
                        <template x-if="total >= freeShippingMinAmount">
                            <div class="text-[11px] font-black tracking-wide flex items-center gap-1 uppercase">
                                ¡Tienes envío gratis! <i
                                    class="fas fa-check-circle text-emerald-500 animate-bounce"></i>
                            </div>
                        </template>

                        <div class="w-full bg-slate-200 rounded-full h-1.5 mt-1.5 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 ease-out"
                                :class="total < freeShippingMinAmount ? 'bg-amber-500' : 'bg-emerald-500'"
                                :style="{ width: Math.min((total / freeShippingMinAmount) * 100, 100) + '%' }">
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- CART ITEMS -->
            <div class="space-y-3">
                <template x-for="item in cart" :key="item.id">
                    <div
                        class="grid grid-cols-[auto_1fr] gap-3 items-start bg-white border border-slate-100 p-3 rounded-2xl shadow-sm hover:shadow-md transition duration-200">
                        <div
                            class="w-14 h-14 rounded-3xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                            <img :src="item.image_path ? (item.image_path.startsWith('http') ? item.image_path : '/storage/' +
                                item.image_path) : '{{ asset('img1.jpg') }}'"
                                alt="Imagen del producto" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0 space-y-2">
                            <div class="flex items-start justify-between gap-3">
                                <span class="text-sm font-bold text-slate-800 truncate" x-text="item.name"></span>
                                <button type="button"
                                    class="text-rose-500 hover:text-rose-700 text-xs font-bold px-2 py-1 rounded-full border border-rose-100 bg-rose-50 transition"
                                    @click="confirmRemoveItem(item.id)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-1 text-[10px] text-slate-500">
                                <template x-if="item.selectedSize">
                                    <span class="px-2 py-1 rounded-full bg-slate-100 border border-slate-200">Talla:
                                        <span class="font-black" x-text="item.selectedSize"></span></span>
                                </template>
                                <template x-if="item.selectedColor">
                                    <span
                                        class="px-2 py-1 rounded-full bg-slate-100 border border-slate-200 flex items-center gap-1">
                                        <span class="w-2.5 h-2.5 rounded-full border border-slate-300"
                                            :style="{
                                                backgroundColor: item.selectedColor.toLowerCase() === 'blanco' ?
                                                    '#f8fafc' : item.selectedColor.toLowerCase() === 'negro' ?
                                                    '#0f172a' : item.selectedColor.toLowerCase()
                                            }"></span>
                                        <span class="font-black" x-text="item.selectedColor"></span>
                                    </span>
                                </template>
                                <template x-if="item.selectedUnit">
                                    <span class="px-2 py-1 rounded-full bg-slate-100 border border-slate-200">Unidad:
                                        <span class="font-black" x-text="item.selectedUnit"></span></span>
                                </template>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <div
                                    class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-2 py-1">
                                    <button
                                        class="w-7 h-7 rounded-full bg-white border border-slate-200 text-rose-600 flex items-center justify-center font-extrabold text-sm hover:bg-rose-50 transition active:scale-90"
                                        @click="updateQty(item.id, -1)">-</button>
                                    <span class="text-sm font-extrabold text-slate-800" x-text="item.quantity"></span>
                                    <button
                                        class="w-7 h-7 rounded-full bg-white border border-slate-200 text-emerald-600 flex items-center justify-center font-extrabold text-sm hover:bg-emerald-50 transition active:scale-90"
                                        @click="updateQty(item.id, 1)">+</button>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-extrabold text-[var(--color-primary)] block"
                                        x-text="currencySymbol + (item.price * item.quantity).toFixed(2)"></span>
                                    <span x-show="exchangeRate > 0" class="text-[10px] text-slate-400 font-bold"
                                        x-text="'Bs. ' + ((item.price * item.quantity) * exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0"
                    class="text-center py-8 text-sm text-slate-400 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    El carrito está vacío.</div>
            </div>

            <!-- DELIVERY INFO WRAPPED IN AN ELEGANT CARD PANEL -->
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-4"
                x-show="cart.length > 0">
                <h3 class="text-sm font-black text-slate-800 flex items-center gap-1.5">
                    <span class="w-1.5 h-3.5 rounded-full bg-[var(--color-primary)]"></span>
                    Datos de Entrega
                </h3>

                <div class="flex bg-slate-100 rounded-2xl p-1 border border-slate-200/40">
                    <button @click="deliveryType = 'pickup'; deliveryCost = 0"
                        :class="deliveryType === 'pickup' ? 'bg-white shadow-md text-slate-900 font-extrabold scale-[1.01]' :
                            'text-slate-500 hover:text-slate-800 font-bold'"
                        class="flex-1 py-2.5 text-xs rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-store"></i> Retiro en local
                    </button>
                    <button
                        @click="deliveryType = 'delivery'; if(!mapInitialized) { initMap(); } else { setTimeout(() => { if(map) map.invalidateSize(); }, 50); }"
                        :class="deliveryType === 'delivery' ? 'bg-white shadow-md text-slate-900 font-extrabold scale-[1.01]' :
                            'text-slate-500 hover:text-slate-800 font-bold'"
                        class="flex-1 py-2.5 text-xs rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-motorcycle"></i> Delivery
                    </button>
                    @if ($company['has_dine_in'] ?? true)
                    <button @click="deliveryType = 'dine_in'; deliveryCost = 0"
                        :class="deliveryType === 'dine_in' ? 'bg-white shadow-md text-slate-900 font-extrabold scale-[1.01]' :
                            'text-slate-500 hover:text-slate-800 font-bold'"
                        class="flex-1 py-2.5 text-xs rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                        <i class="fas fa-utensils"></i> En mesa
                    </button>
                    @endif
                </div>

                <!-- DELIVERY METODO TABS (MAPA O GPS) -->
                <div x-show="deliveryType === 'delivery'" x-transition class="space-y-3 pt-1">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Método de ubicación:</p>
                    <div class="grid grid-cols-2 gap-2 bg-slate-100 rounded-xl p-1 border border-slate-200/40">
                        <button
                            @click="deliveryMode = 'map'; if(!mapInitialized) { initMap(); } else { setTimeout(() => { if(map) map.invalidateSize(); }, 50); }"
                            :class="deliveryMode === 'map' ? 'bg-white shadow-sm text-slate-800 font-extrabold' :
                                'text-slate-500 hover:text-slate-800 font-bold'"
                            class="py-2 text-[11px] rounded-lg transition flex items-center justify-center gap-1.5">
                            <i class="fas fa-map-marked-alt text-[var(--color-primary)]"></i> Ubicar en Mapa
                        </button>
                        <button @click="deliveryMode = 'gps'; useGPS()"
                            :class="deliveryMode === 'gps' ? 'bg-white shadow-sm text-slate-800 font-extrabold' :
                                'text-slate-500 hover:text-slate-800 font-bold'"
                            class="py-2 text-[11px] rounded-lg transition flex items-center justify-center gap-1.5">
                            <i class="fas fa-location-arrow text-emerald-500"
                                :class="isGpsLoading ? 'animate-spin' : ''"></i>
                            <span x-text="isGpsLoading ? 'Obteniendo GPS...' : 'Usar mi GPS'">Usar mi GPS</span>
                        </button>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[10px] text-slate-500 font-bold flex items-center gap-1">
                            <i class="fas fa-info-circle text-[var(--color-primary)]"></i>
                            <span x-show="deliveryMode === 'map'">Mueve el marcador o haz clic en el mapa para fijar tu
                                entrega:</span>
                            <span x-show="deliveryMode === 'gps'">Mapa centrado en tu señal de GPS. Puedes reajustar si
                                es necesario:</span>
                        </p>

                        <div class="relative rounded-2xl overflow-hidden border border-slate-200 shadow-inner">
                            <div id="delivery-map" class="w-full h-44 z-10" wire:ignore></div>
                            <div x-show="gpsSuccess"
                                class="absolute top-2 right-2 bg-emerald-500 text-white text-[9px] font-black px-2.5 py-1 rounded-lg z-20 shadow flex items-center gap-1 animate-pulse">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span> GPS ACTIVO
                            </div>
                        </div>

                        <p x-show="deliveryCost > 0"
                            class="text-xs text-emerald-800 font-bold bg-emerald-50/80 p-3 rounded-2xl text-center border border-emerald-100 mt-2 shadow-sm flex flex-col justify-center items-center gap-0.5">
                            <span>Distancia calculada: <span class="text-slate-900"
                                    x-text="deliveryDistance.toFixed(2)"></span> km</span>
                            <span class="text-emerald-600 text-sm">Costo de Envío: <span class="font-extrabold"
                                    x-text="actualDeliveryCost === 0 ? 'Gratis' : (currencySymbol + actualDeliveryCost.toFixed(2))"></span></span>
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
                                :class="showErrors && !customerName.trim() ?
                                    'border border-rose-300 focus:border-rose-500 focus:ring-rose-500/10 bg-rose-50/20' :
                                    'border border-slate-200 focus:border-[var(--color-primary)] focus:bg-white focus:ring-[var(--color-primary)]/10 bg-slate-50'"
                                placeholder="Tu nombre completo">
                        </div>
                        <span x-show="showErrors && !customerName.trim()" x-transition
                            class="text-[11px] text-rose-600 font-bold mt-1.5 ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Por favor ingresa tu nombre.
                        </span>
                    </div>
                    <div>
                        <div class="relative">
                            <i
                                class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="tel" x-model="customerPhone"
                                class="w-full rounded-xl pl-11 pr-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:ring-2 shadow-sm transition placeholder-slate-400"
                                :class="showErrors && !customerPhone.trim() ?
                                    'border border-rose-300 focus:border-rose-500 focus:ring-rose-500/10 bg-rose-50/20' :
                                    'border border-slate-200 focus:border-[var(--color-primary)] focus:bg-white focus:ring-[var(--color-primary)]/10 bg-slate-50'"
                                placeholder="Tu número de celular / WhatsApp">
                        </div>
                        <span x-show="showErrors && !customerPhone.trim()" x-transition
                            class="text-[11px] text-rose-600 font-bold mt-1.5 ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Por favor ingresa tu número de celular.
                        </span>
                    </div>

                    <div x-show="deliveryType === 'dine_in'" x-transition>
                        <div class="relative">
                            <i class="fas fa-utensils absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="number" x-model="tableNumber"
                                class="w-full rounded-xl pl-11 pr-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:ring-2 shadow-sm transition placeholder-slate-400 border border-slate-200 focus:border-[var(--color-primary)] focus:bg-white focus:ring-[var(--color-primary)]/10 bg-slate-50"
                                placeholder="Ingresa tu número de mesa">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PAYMENT METHOD SELECTION CARD PANEL -->
            <div class="bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-4"
                x-show="cart.length > 0">
                <h3 class="text-sm font-black text-slate-800 flex items-center gap-1.5 select-none">
                    <span class="w-1.5 h-3.5 rounded-full bg-[var(--color-primary)]"></span>
                    Método de Pago
                </h3>

                <div :class="showErrors && !selectedPaymentMethod ? 'border border-rose-300 rounded-3xl p-1' : ''"
                    class="grid grid-cols-2 gap-2">
                    <template x-for="(methodData, methodName) in paymentMethodsList" :key="methodName">
                        <button type="button" @click="selectPayment(methodName)"
                            :class="selectedPaymentMethod === methodName ?
                                'ring-2 ring-[var(--color-primary)] bg-slate-50/80 text-slate-900 border-transparent shadow-sm' :
                                'border border-slate-200 text-slate-500 hover:text-slate-800 bg-white'"
                            class="py-3 px-3 text-xs rounded-2xl font-bold transition flex flex-col items-center justify-center gap-2 cursor-pointer relative overflow-hidden group">
                            <span class="flex items-center gap-1.5">
                                <template x-if="methodName === 'Cashea' || methodName === 'Cashea Link'">
                                    <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-5 w-5 rounded-md object-contain cashea-logo-badge">
                                </template>
                                <template x-if="methodName === 'Krece' || methodName === 'Krece Link'">
                                    <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-5 w-5 rounded-md object-contain krece-logo-badge">
                                </template>
                                <template x-if="!['Cashea','Cashea Link','Krece','Krece Link'].includes(methodName)">
                                    <svg class="w-3.5 h-3.5"
                                        :class="selectedPaymentMethod === methodName ? 'text-[var(--color-primary)]' :
                                            'text-slate-400'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                </template>
                                <span class="font-extrabold text-[11px]" x-text="methodName"></span>
                            </span>
                            <div x-show="selectedPaymentMethod === methodName"
                                class="absolute top-1 right-1 text-[var(--color-primary)]">
                                <i class="fas fa-check-circle text-[10px]"></i>
                            </div>
                        </button>
                    </template>
                </div>
                <div x-show="showErrors && !selectedPaymentMethod"
                    class="text-[11px] text-rose-600 font-bold mt-2 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i>
                    Selecciona un método de pago.
                </div>

                <!-- DYNAMIC PAYMENT METHOD DETAILS IN CART -->
                <div x-show="selectedPaymentDetails.trim() !== ''"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-slate-50 border border-slate-150/50 p-4 rounded-2xl space-y-2.5">
                    <div class="flex justify-between items-center select-none">
                        <span
                            class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest flex items-center gap-1">
                            <i class="fas fa-info-circle text-[var(--color-primary)]"></i> Datos para transferir /
                            pagar
                        </span>
                        <div x-data="{ copied: false }">
                            <button type="button"
                                @click="navigator.clipboard.writeText(selectedPaymentDetails); copied = true; setTimeout(() => copied = false, 2000)"
                                class="text-[9px] font-bold text-[var(--color-primary)] hover:underline flex items-center gap-0.5 cursor-pointer">
                                <i class="far"
                                    :class="copied ? 'fa-check-circle text-emerald-500' : 'fa-copy'"></i>
                                <span x-text="copied ? '¡Copiado!' : 'Copiar'">Copiar</span>
                            </button>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-700 leading-relaxed font-semibold whitespace-pre-line bg-white/70 p-3 rounded-xl border border-slate-100 shadow-inner"
                        x-text="selectedPaymentDetails"></p>

                    <!-- DIRECT PAYMENT GATEWAY FORMS -->
                    <!-- 1. Stripe Form -->
                    <div x-show="selectedPaymentMethod === 'Tarjeta' && {{ $company['stripe_enabled'] ? 'true' : 'false' }}"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-indigo-50/40 to-slate-50 border border-indigo-150/40 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-indigo-650 font-extrabold uppercase tracking-widest flex items-center gap-1.5 select-none">
                            <i class="fab fa-stripe text-indigo-500 text-sm"></i> Pago Directo Seguro con Tarjeta
                        </span>
                        <p class="text-[9px] text-slate-400 leading-relaxed font-semibold">
                            Ingresa los datos de tu tarjeta de crédito o débito para procesar el pago de forma segura a través de Stripe.
                        </p>
                        
                        <!-- Simulated Premium Card Inputs -->
                        <div class="space-y-2">
                            <div class="space-y-1">
                                <label class="text-[8px] font-extrabold text-slate-500 uppercase block pl-0.5">Número de Tarjeta</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-450 text-[10px]"><i class="far fa-credit-card"></i></span>
                                    <input type="text" x-model="stripeCardNumber" placeholder="4242 4242 4242 4242" class="w-full bg-white border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-[10px] focus:outline-none focus:border-indigo-500 transition-all font-semibold font-mono">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label class="text-[8px] font-extrabold text-slate-500 uppercase block pl-0.5">Vencimiento</label>
                                    <input type="text" x-model="stripeExpiry" placeholder="MM/AA" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[10px] focus:outline-none focus:border-indigo-500 transition-all font-semibold font-mono text-center">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[8px] font-extrabold text-slate-500 uppercase block pl-0.5">CVC / CVV</label>
                                    <input type="password" x-model="stripeCvc" placeholder="•••" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[10px] focus:outline-none focus:border-indigo-500 transition-all font-semibold font-mono text-center">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Binance Pay QR Form -->
                    <div x-show="selectedPaymentMethod === 'Binance' && {{ $company['binance_enabled'] ? 'true' : 'false' }}"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-amber-50/40 to-slate-50 border border-amber-150/40 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-amber-605 font-extrabold uppercase tracking-widest flex items-center gap-1.5 select-none">
                            <i class="fas fa-coins text-amber-500"></i> Binance Pay (USDT)
                        </span>
                        <p class="text-[9px] text-slate-400 leading-relaxed font-semibold">
                            Escanea el código QR de Binance Pay con tu aplicación de Binance o envía directamente a nuestro ID de pago.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center gap-3 bg-white p-3 rounded-xl border border-slate-100 shadow-inner">
                            <!-- Simulated QR Code -->
                            <div class="w-20 h-20 bg-slate-50 rounded-lg flex items-center justify-center shrink-0 border border-slate-100 shadow-inner relative overflow-hidden group">
                                <i class="fas fa-qrcode text-slate-800 text-5xl"></i>
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-[8px] text-white font-black uppercase text-center p-1">Escaneame</div>
                            </div>
                            <div class="space-y-1 text-[9px] text-slate-500 font-semibold leading-normal w-full">
                                <div><strong>Binance Pay ID:</strong> <span class="font-mono text-slate-700 select-all">987654321</span></div>
                                <div><strong>Monto:</strong> <span class="font-mono text-slate-700" x-text="currencySymbol + parseFloat(total).toFixed(2)"></span></div>
                                <div class="text-[8px] text-amber-600">Por favor ingresa tu Pay ID de Binance abajo después de pagar.</div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[8px] font-extrabold text-slate-500 uppercase block pl-0.5">Binance Pay ID del Cliente (8-9 dígitos)</label>
                            <input type="text" x-model="binancePayId" placeholder="e.g. 12345678" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[10px] focus:outline-none focus:border-amber-500 transition-all font-semibold font-mono">
                        </div>
                    </div>

                    <!-- 3. Pago Móvil Direct Input -->
                    <div x-show="selectedPaymentMethod === 'Pago Móvil' && {{ $company['pagomovil_enabled'] ? 'true' : 'false' }}"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-teal-50/40 to-slate-50 border border-teal-150/40 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-teal-650 font-extrabold uppercase tracking-widest flex items-center gap-1.5 select-none">
                            <i class="fas fa-mobile-alt text-teal-500"></i> Pago Móvil Conciliación Rápida
                        </span>
                        <p class="text-[9px] text-slate-400 leading-relaxed font-semibold">
                            Realiza el pago móvil desde tu banco a los siguientes datos de nuestra cuenta comercial:
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 bg-white/70 p-3 rounded-xl border border-slate-100 shadow-inner select-all leading-normal text-[9px] text-slate-500 font-semibold">
                            <div><strong class="text-slate-400 block text-[7px] uppercase tracking-wider">Banco</strong> <span class="text-slate-700 font-bold">{{ $company['pagomovil_bank'] }}</span></div>
                            <div><strong class="text-slate-400 block text-[7px] uppercase tracking-wider">Teléfono</strong> <span class="text-slate-700 font-bold">{{ $company['pagomovil_phone'] }}</span></div>
                            <div><strong class="text-slate-400 block text-[7px] uppercase tracking-wider">Cédula / RIF</strong> <span class="text-slate-700 font-bold">{{ $company['pagomovil_id'] }}</span></div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[8px] font-extrabold text-slate-500 uppercase block pl-0.5">Referencia de la Transacción (Últimos 4-6 dígitos)</label>
                            <input type="text" x-model="pagomovilReference" placeholder="e.g. 1234" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[10px] focus:outline-none focus:border-teal-500 transition-all font-semibold font-mono">
                        </div>
                    </div>

                    <!-- 4. Cashea QR (punto de venta) -->
                    <div x-show="selectedPaymentMethod === 'Cashea'"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-[#FFE500]/15 to-slate-50 border border-[#FFE500]/40 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-slate-800 font-extrabold uppercase tracking-widest flex items-center gap-2 select-none">
                            <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-6 w-6 rounded-md object-contain cashea-logo-badge">
                            Pago con Cashea (cuotas)
                        </span>
                        <p class="text-[9px] text-slate-500 leading-relaxed font-semibold">
                            Escanea el QR de la tienda con la app Cashea para financiar tu compra en cuotas.
                        </p>
                        @if (!empty($company['cashea_qr_url']))
                            <div class="flex justify-center p-3 bg-white rounded-2xl border border-slate-100 shadow-inner">
                                <img src="{{ $company['cashea_qr_url'] }}" alt="QR Cashea" class="max-w-[200px] w-full h-auto object-contain">
                            </div>
                        @endif
                        <label class="flex items-start gap-2 cursor-pointer select-none">
                            <input type="checkbox" x-model="casheaConfirmed" class="mt-0.5 rounded border-[#FFE500] text-[#FFE500] focus:ring-[#FFE500]">
                            <span class="text-[10px] font-bold text-slate-700">Confirmo que pagaré con Cashea escaneando este QR</span>
                        </label>
                    </div>

                    <!-- 5. Cashea Link -->
                    <div x-show="selectedPaymentMethod === 'Cashea Link'"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-[#FFE500]/15 to-slate-50 border border-[#FFE500]/40 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-slate-800 font-extrabold uppercase tracking-widest flex items-center gap-2 select-none">
                            <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-6 w-6 rounded-md object-contain cashea-logo-badge">
                            Cashea Link
                        </span>
                        <p class="text-[9px] text-slate-500 leading-relaxed font-semibold">
                            Abre el enlace de pago Cashea de la tienda para completar tu financiamiento en cuotas.
                        </p>
                        @if (!empty($company['cashea_link_url']))
                            <a href="{{ $company['cashea_link_url'] }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-[#FFE500] text-black text-[11px] font-black uppercase tracking-wide hover:brightness-95 transition-all shadow-md">
                                <i class="fas fa-external-link-alt text-[10px]"></i>
                                Abrir enlace Cashea
                            </a>
                        @endif
                        <label class="flex items-start gap-2 cursor-pointer select-none">
                            <input type="checkbox" x-model="casheaLinkConfirmed" class="mt-0.5 rounded border-[#FFE500] text-[#FFE500] focus:ring-[#FFE500]">
                            <span class="text-[10px] font-bold text-slate-700">Confirmo que pagaré usando el enlace Cashea Link</span>
                        </label>
                    </div>

                    <!-- 6. Krece QR -->
                    <div x-show="selectedPaymentMethod === 'Krece'"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-sky-100/50 to-slate-50 border border-sky-200/60 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-slate-800 font-extrabold uppercase tracking-widest flex items-center gap-2 select-none">
                            <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-6 w-6 rounded-md object-contain krece-logo-badge">
                            Pago con Krece (cuotas)
                        </span>
                        <p class="text-[9px] text-slate-500 leading-relaxed font-semibold">
                            Escanea el QR de la tienda con la app Krece para financiar tu compra en cuotas.
                        </p>
                        @if (!empty($company['krece_qr_url']))
                            <div class="flex justify-center p-3 bg-white rounded-2xl border border-slate-100 shadow-inner">
                                <img src="{{ $company['krece_qr_url'] }}" alt="QR Krece" class="max-w-[200px] w-full h-auto object-contain">
                            </div>
                        @endif
                        <label class="flex items-start gap-2 cursor-pointer select-none">
                            <input type="checkbox" x-model="kreceConfirmed" class="mt-0.5 rounded border-sky-300 text-sky-500 focus:ring-sky-400">
                            <span class="text-[10px] font-bold text-slate-700">Confirmo que pagaré con Krece escaneando este QR</span>
                        </label>
                    </div>

                    <!-- 7. Krece Link -->
                    <div x-show="selectedPaymentMethod === 'Krece Link'"
                        x-transition:enter="transition ease-out duration-250"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="bg-gradient-to-br from-sky-100/50 to-slate-50 border border-sky-200/60 p-4 rounded-2xl space-y-3 mt-3">
                        <span class="text-[10px] text-slate-800 font-extrabold uppercase tracking-widest flex items-center gap-2 select-none">
                            <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-6 w-6 rounded-md object-contain krece-logo-badge">
                            Krece Link
                        </span>
                        <p class="text-[9px] text-slate-500 leading-relaxed font-semibold">
                            Abre el enlace de pago Krece de la tienda para completar tu financiamiento en cuotas.
                        </p>
                        @if (!empty($company['krece_link_url']))
                            <a href="{{ $company['krece_link_url'] }}" target="_blank" rel="noopener noreferrer"
                               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl krece-brand-bg text-black text-[11px] font-black uppercase tracking-wide hover:brightness-95 transition-all shadow-md">
                                <i class="fas fa-external-link-alt text-[10px]"></i>
                                Abrir enlace Krece
                            </a>
                        @endif
                        <label class="flex items-start gap-2 cursor-pointer select-none">
                            <input type="checkbox" x-model="kreceLinkConfirmed" class="mt-0.5 rounded border-sky-300 text-sky-500 focus:ring-sky-400">
                            <span class="text-[10px] font-bold text-slate-700">Confirmo que pagaré usando el enlace Krece Link</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- COUPON CODE PANEL -->
        <div class="px-5 pt-4" x-show="cart.length > 0" x-transition>
            <div class="bg-gradient-to-br from-slate-50 to-white border border-slate-200/80 rounded-2xl p-4 shadow-sm">
                <h3 class="text-xs font-black text-slate-700 flex items-center gap-1.5 mb-3">
                    <span
                        class="inline-flex items-center justify-center w-5 h-5 rounded-lg bg-[var(--color-primary)]/10">
                        <i class="fas fa-tag text-[var(--color-primary)] text-[10px]"></i>
                    </span>
                    Cupón de Descuento
                </h3>

                <!-- Input Row -->
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" x-model="couponCode" @input="couponCode = couponCode.toUpperCase()"
                            @keydown.enter.prevent="applyCouponCode()" :disabled="appliedCoupon !== null"
                            placeholder="Ej: VERANO20"
                            class="w-full rounded-xl pl-4 pr-4 py-3 text-xs font-bold tracking-wider text-slate-800 border transition placeholder-slate-300 focus:outline-none focus:ring-2"
                            :class="appliedCoupon !== null ?
                                'bg-emerald-50 border-emerald-200 text-emerald-700 focus:ring-emerald-300/30' :
                                'bg-white border-slate-200 focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)]/10'">
                    </div>
                    <button type="button" @click="applyCouponCode()"
                        :disabled="!couponCode.trim() && appliedCoupon === null"
                        class="px-4 py-3 rounded-xl text-xs font-extrabold transition active:scale-95 shadow-sm"
                        :class="appliedCoupon !== null ?
                            'bg-rose-100 text-rose-600 hover:bg-rose-200 border border-rose-200' :
                            'bg-[var(--color-primary)] text-white hover:opacity-90 disabled:opacity-40 disabled:cursor-not-allowed'">
                        <span x-show="appliedCoupon === null"><i class="fas fa-check mr-1"></i>Aplicar</span>
                        <span x-show="appliedCoupon !== null"><i class="fas fa-times mr-1"></i>Quitar</span>
                    </button>
                </div>

                <!-- Success feedback -->
                <div x-show="appliedCoupon !== null" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-2.5 bg-emerald-50 border border-emerald-200 rounded-xl px-3 py-2.5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-white text-[9px]"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold text-emerald-800"
                                x-text="'¡Cupón ' + (appliedCoupon?.code ?? '') + ' aplicado!'"></p>
                            <p class="text-[10px] text-emerald-600 font-semibold"
                                x-text="appliedCoupon?.type === 'percentage'
                                    ? appliedCoupon.value + '% de descuento'
                                    : currencySymbol + parseFloat(appliedCoupon?.value ?? 0).toFixed(2) + ' de descuento'">
                            </p>
                        </div>
                    </div>
                    <span class="text-sm font-extrabold text-emerald-700"
                        x-text="'-' + currencySymbol + discountAmount.toFixed(2)"></span>
                </div>

                <!-- Error feedback -->
                <div x-show="couponError !== ''" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-2.5 bg-rose-50 border border-rose-200 rounded-xl px-3 py-2.5 flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-rose-400 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation text-white text-[9px]"></i>
                    </div>
                    <p class="text-[11px] font-bold text-rose-700" x-text="couponError"></p>
                </div>
            </div>
        </div>

        <div class="p-5 bg-white border-t border-slate-100 mt-4">
            <!-- Subtotal row (shown only when coupon is applied) -->
            <div class="flex justify-between items-center mb-1.5" x-show="appliedCoupon !== null" x-transition>
                <span class="text-xs font-bold text-slate-400">Subtotal:</span>
                <span class="text-xs font-bold text-slate-500"
                    x-text="currencySymbol + (total + actualDeliveryCost).toFixed(2)"></span>
            </div>
            <!-- Discount row -->
            <div class="flex justify-between items-center mb-1.5" x-show="appliedCoupon !== null" x-transition>
                <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    <i class="fas fa-tag text-[10px]"></i>
                    <span x-text="'Cupón ' + (appliedCoupon?.code ?? '')"></span>:
                </span>
                <span class="text-xs font-extrabold text-emerald-600"
                    x-text="'-' + currencySymbol + discountAmount.toFixed(2)"></span>
            </div>
            <div class="flex justify-between items-start mb-4"
                :class="appliedCoupon !== null ? 'pt-1.5 border-t border-slate-100' : ''">
                <span class="text-base font-black text-slate-800">Total:</span>
                <div class="text-right">
                    <span class="text-lg font-black text-slate-900 block"
                        x-text="currencySymbol + Math.max(total - discountAmount + actualDeliveryCost, 0).toFixed(2)"></span>
                    <span x-show="exchangeRate > 0" class="text-xs font-bold text-slate-400 block mt-0.5"
                        x-text="'Bs. ' + (Math.max(total - discountAmount + actualDeliveryCost, 0) * exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </div>
            </div>
            <button x-show="cart.length > 0" @click="sendWhatsApp()"
                class="w-full bg-[#25D366] text-white font-extrabold py-3.5 rounded-2xl flex items-center justify-center gap-2 active:scale-95 transition shadow-lg shadow-emerald-500/20 text-sm"
                style="display: none;">
                <i class="fab fa-whatsapp text-lg"></i> Confirmar y Enviar Pedido
            </button>
        </div>
    </div>

    <!-- SCHEDULES MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showSchedulesModal"
        @click="showSchedulesModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
        x-show="showSchedulesModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="far fa-clock text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Horarios de Atención</h2>
            </div>
            <button @click="showSchedulesModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-2.5 scrollbar-none">
            <!-- Si no tiene un horario configurado -->
            <template x-if="!hasScheduleInfo">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <i class="far fa-clock text-rose-500 text-3xl mb-3 block"></i>
                    <p class="text-sm font-bold text-slate-700 leading-relaxed">
                        Horario no configurado
                    </p>
                </div>
            </template>

            <!-- Si es tipo simple y tiene un texto personalizado (que no sea genérico de "horario configurado"), mostrarlo -->
            <template
                x-if="workHours && workHours.type === 'simple' && workHours.text && workHours.text !== 'Horario configurado' && workHours.text !== 'Horario personalizado configurado'">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <i class="far fa-clock text-[var(--color-primary)] text-3xl mb-3 block"></i>
                    <p class="text-sm font-bold text-slate-700 leading-relaxed" x-text="workHours.text"></p>
                </div>
            </template>

            <!-- Mostrar la lista semanal de horarios solo si tiene un horario configurado -->
            <div class="space-y-2.5" x-show="hasScheduleInfo">
                <template x-for="day in ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']"
                    :key="day">
                    <div class="flex justify-between items-center px-4 py-3 rounded-xl border shadow-sm"
                        :class="day === currentDayName ?
                            'bg-[var(--color-primary)]/10 border-[var(--color-primary)] shadow-[0_8px_30px_rgba(59,130,246,0.1)]' :
                            'bg-white border border-slate-100'">
                        <span class="text-sm font-bold"
                            :class="day === currentDayName ? 'text-[var(--color-primary)]' : day === 'Domingo' ?
                                'text-rose-500' : 'text-slate-700'"
                            x-text="day"></span>

                        <template x-if="getScheduleDay(day).closed">
                            <span
                                class="text-[10px] font-black text-rose-500 bg-rose-50 px-2.5 py-1 rounded-md uppercase tracking-wider border border-rose-100">Cerrado</span>
                        </template>

                        <template x-if="!getScheduleDay(day).closed">
                            <span class="text-xs font-bold"
                                :class="day === currentDayName ? 'text-[var(--color-primary)]' : 'text-slate-500'"
                                x-text="formatTimeRange(getScheduleDay(day).open, getScheduleDay(day).close)"></span>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- SERVICES MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showServicesModal"
        @click="showServicesModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
        x-show="showServicesModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-concierge-bell text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Servicios & Comodidades</h2>
            </div>
            <button @click="showServicesModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-2.5 scrollbar-none">
            <template x-if="services && services.length > 0">
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="service in services" :key="service.label">
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center gap-2 text-center transition-transform duration-300 hover:scale-[1.02]"
                            :class="service.bg">
                            <i :class="service.icon + ' ' + service.iconColor" class="text-2xl"></i>
                            <span class="text-xs font-bold" x-text="service.label"></span>
                            <template x-if="service.val">
                                <span class="text-[10px] font-bold opacity-90" x-text="service.val"></span>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="!services || services.length === 0">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <i class="fas fa-concierge-bell text-slate-300 text-3xl mb-3 block"></i>
                    <p class="text-sm font-bold text-slate-500">No hay servicios disponibles</p>
                </div>
            </template>
        </div>
    </div>

    <!-- SERVICE TYPES MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showServiceTypesModal"
        @click="showServiceTypesModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
        x-show="showServiceTypesModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-concierge-bell text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Tipos de Servicio</h2>
            </div>
            <button @click="showServiceTypesModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-2.5 scrollbar-none">
            <template x-if="serviceTypes && serviceTypes.length > 0">
                <div class="grid grid-cols-1 gap-3">
                    <template x-for="serviceType in serviceTypes" :key="serviceType.key">
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3 transition-transform duration-300 hover:scale-[1.02]"
                            :class="serviceType.bg">
                            <i :class="serviceType.icon + ' ' + serviceType.iconColor" class="text-2xl"></i>
                            <span class="text-sm font-bold" x-text="serviceType.label"></span>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="!serviceTypes || serviceTypes.length === 0">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <i class="fas fa-concierge-bell text-slate-300 text-3xl mb-3 block"></i>
                    <p class="text-sm font-bold text-slate-500">No hay servicios disponibles</p>
                </div>
            </template>
        </div>
    </div>

    <!-- BRANCHES MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showBranchesModal"
        @click="showBranchesModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
        x-show="showBranchesModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-store text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Nuestras Sucursales</h2>
            </div>
            <button @click="showBranchesModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-4 scrollbar-none">
            @foreach ($branches as $branch)
                @php
                    $isCurrent = $branch->slug === $company['slug'];
                @endphp
                <div
                    class="bg-white p-5 rounded-2xl border-2 shadow-sm relative overflow-hidden transition duration-300 {{ $isCurrent ? 'border-[var(--color-primary)] ring-1 ring-[var(--color-primary)]/20' : 'border-slate-100 hover:shadow-md hover:border-slate-200' }}">
                    @if ($isCurrent)
                        <div
                            class="absolute top-0 right-0 bg-[var(--color-primary)] text-white text-[9px] font-black uppercase px-2.5 py-1 rounded-bl-xl shadow-sm">
                            Actual</div>
                    @endif
                    <h3 class="text-sm font-black text-slate-800 mb-1.5">{{ $branch->name }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        @if (!empty($branch->google_maps_link))
                            <a href="{{ $branch->google_maps_link }}" target="_blank"
                                class="inline-flex items-center gap-2 text-[10px] font-bold text-[var(--color-primary)] bg-blue-50 border border-blue-100 px-3 py-2 rounded-xl hover:bg-blue-100 transition active:scale-95">
                                <i class="fas fa-map-marker-alt text-[11px]"></i>
                                <span>{{ $branch->address ?: 'Dirección no especificada' }}</span>
                            </a>
                        @else
                            <span
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-100 text-[10px] font-bold text-slate-600">
                                <i class="fas fa-map-marker-alt text-[11px]"></i>
                                {{ $branch->address ?: 'Dirección no especificada' }}
                            </span>
                        @endif
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @if (!empty($branch->google_maps_link))
                            <a href="{{ $branch->google_maps_link }}" target="_blank"
                                class="text-[10px] font-bold text-[var(--color-primary)] bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-xl hover:bg-blue-100 transition flex items-center gap-1 active:scale-95">
                                <i class="fas fa-directions"></i> Cómo llegar
                            </a>
                        @endif
                        @if (!$isCurrent)
                            <a href="/{{ $branch->slug }}"
                                class="text-[10px] font-bold text-slate-600 bg-slate-100 border border-slate-200 px-3 py-1.5 rounded-xl hover:bg-slate-250 transition flex items-center gap-1 active:scale-95">
                                <i class="fas fa-exchange-alt text-slate-400"></i> Ir a esta Sede
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- BOOKING MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showBookingModal"
        @click="showBookingModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;" x-cloak></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
        x-show="showBookingModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;" x-cloak>
        
        <div class="p-6 flex justify-between items-center text-white shadow-sm select-none"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="far fa-calendar-alt text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Reservas</h2>
            </div>
            <button @click="showBookingModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>

        <form @submit.prevent="submitBooking()" class="p-6 space-y-4 overflow-y-auto flex-grow bg-slate-50">
            <p class="text-xs text-slate-500 font-bold text-center leading-relaxed">
                Agenda tu cita o reserva de mesa de manera rápida. Te confirmaremos la disponibilidad vía WhatsApp.
            </p>

            <!-- Nombre -->
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tu Nombre</label>
                <div class="relative">
                    <i class="far fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" x-model="bookingName" required
                        class="w-full rounded-xl pl-11 pr-4 py-3 text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10 focus:border-[var(--color-primary)] bg-white text-slate-800 font-semibold"
                        placeholder="Ej: Valentina Ramos">
                </div>
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Número de Celular / WhatsApp</label>
                <div class="relative">
                    <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="tel" x-model="bookingPhone" required
                        class="w-full rounded-xl pl-11 pr-4 py-3 text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10 focus:border-[var(--color-primary)] bg-white text-slate-800 font-semibold"
                        placeholder="Ej: +58 412-1234567">
                </div>
            </div>

            <!-- Fecha -->
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Fecha</label>
                <div class="relative">
                    <i class="far fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="date" x-model="bookingDate" required
                        class="w-full rounded-xl pl-11 pr-4 py-3 text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10 focus:border-[var(--color-primary)] bg-white text-slate-800 font-semibold">
                </div>
            </div>

            <!-- Bloque de Horario -->
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Horario Disponible</label>
                <div class="relative">
                    <i class="far fa-clock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <select x-model="bookingTimeSlot" required
                        class="w-full rounded-xl pl-11 pr-4 py-3 text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary)]/10 focus:border-[var(--color-primary)] bg-white text-slate-800 font-semibold">
                        <option value="08:00 - 09:00">08:00 AM - 09:00 AM</option>
                        <option value="09:00 - 10:00">09:00 AM - 10:00 AM</option>
                        <option value="10:00 - 11:00">10:00 AM - 11:00 AM</option>
                        <option value="11:00 - 12:00">11:00 AM - 12:00 PM</option>
                        <option value="12:00 - 13:00">12:00 PM - 01:00 PM</option>
                        <option value="13:00 - 14:00">01:00 PM - 02:00 PM</option>
                        <option value="14:00 - 15:00">02:00 PM - 03:00 PM</option>
                        <option value="15:00 - 16:00">03:00 PM - 04:00 PM</option>
                        <option value="16:00 - 17:00">04:00 PM - 05:00 PM</option>
                        <option value="17:00 - 18:00">05:00 PM - 06:00 PM</option>
                        <option value="18:00 - 19:00">06:00 PM - 07:00 PM</option>
                        <option value="19:00 - 20:00">07:00 PM - 08:00 PM</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-[var(--color-primary)] hover:opacity-90 text-white font-extrabold py-3.5 rounded-xl text-sm transition active:scale-[0.99] shadow-md flex items-center justify-center gap-2 cursor-pointer mt-2">
                <i class="far fa-calendar-check"></i>
                <span>Solicitar Reservación</span>
            </button>
        </form>
    </div>

    <!-- REVIEWS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showReviewsModal"
        @click="showReviewsModal = false; showForm = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-top md:origin-left"
        x-show="showReviewsModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;" x-data="{ showForm: false }">
        <div class="p-6 flex justify-between items-center text-white shadow-sm select-none"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-comment-dots text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Opiniones</h2>
            </div>
            <button @click="showReviewsModal = false; showForm = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
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
                <span class="text-4xl font-black text-slate-800 leading-none"
                    x-text="averageRating.toFixed(1)">{{ number_format($averageRating, 1) }}</span>
                <div class="flex justify-center text-amber-400 text-xs my-1.5 gap-0.5">
                    <template x-for="i in 5" :key="i">
                        <i :class="i <= Math.round(averageRating) ? 'fas fa-star' : 'far fa-star'"></i>
                    </template>
                </div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">
                    <span x-text="totalReviewsCount">{{ $totalReviews }}</span> <span
                        x-text="totalReviewsCount === 1 ? 'opinión' : 'opiniones'">{{ $totalReviews == 1 ? 'opinión' : 'opiniones' }}</span>
                </span>
            </div>

            <!-- Distribución / Histograma de Barras (Filtrables al hacer click) -->
            <div class="col-span-8 space-y-1 pl-3">
                @foreach ([5, 4, 3, 2, 1] as $star)
                    @php
                        $cStar = ${'count' . $star};
                        $pctStar = ${'pct' . $star};
                    @endphp
                    <div @click="starFilter = starFilter === {{ $star }} ? 0 : {{ $star }}"
                        class="flex items-center gap-2 text-[10px] font-bold text-slate-500 cursor-pointer p-1 rounded-xl transition hover:bg-slate-200/50"
                        :class="starFilter === {{ $star }} ?
                            'bg-amber-100/50 text-amber-900 ring-1 ring-amber-200/70' : ''"
                        title="Filtrar por {{ $star }} estrellas">
                        <span class="w-3 text-right">{{ $star }}</span>
                        <i class="fas fa-star text-amber-400 text-[8px]"></i>
                        <div class="flex-grow bg-slate-200 rounded-full h-2 overflow-hidden shadow-inner">
                            <div class="bg-amber-400 h-full rounded-full transition-all duration-500"
                                :style="'width: ' + starPercentages[{{ $star }}] + '%'"
                                style="width: {{ $pctStar }}%"></div>
                        </div>
                        <span class="w-6 text-right text-slate-400 font-semibold"
                            x-text="starCounts[{{ $star }}]">{{ $cStar }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Banner de Filtro Activo -->
        <div x-show="starFilter !== 0" x-cloak x-transition
            class="px-6 py-2.5 bg-amber-50/50 border-b border-slate-100 flex justify-between items-center text-xs select-none">
            <span class="text-amber-800/90 font-bold flex items-center gap-1.5">
                <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Mostrando opiniones de <span x-text="starFilter"
                    class="underline decoration-amber-400 font-black"></span> estrellas
            </span>
            <button @click="starFilter = 0"
                class="text-[var(--color-primary)] hover:underline font-extrabold text-[10px] uppercase tracking-wider transition active:scale-95">
                Ver Todas
            </button>
        </div>

        <div class="p-6 flex-grow overflow-y-auto scrollbar-none bg-slate-50">
            <div class="space-y-4">
                <!-- Alpine Dynamic List -->
                <template x-for="(rev, index) in reviewsList" :key="index">
                    <div x-show="starFilter === 0 || starFilter === rev.rating"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="bg-white border border-slate-100 p-4 rounded-2xl shadow-sm">
                        <div class="flex justify-between items-start mb-1">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-bold text-slate-800" x-text="rev.customer_name"></span>
                                <template x-if="rev.created_at">
                                    <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-1">
                                        <i class="fas fa-calendar-alt text-[9px]"></i>
                                        <span
                                            x-text="new Date(rev.created_at).toLocaleDateString('es-VE', { year: 'numeric', month: 'short', day: 'numeric' })"></span>
                                    </span>
                                </template>
                            </div>
                            <span class="text-xs text-amber-500 shrink-0 ml-2 mt-0.5">
                                <template x-for="star in 5" :key="star">
                                    <i :class="star <= rev.rating ? 'fas fa-star' : 'far fa-star'"
                                        class="mr-0.5"></i>
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
            <div x-show="showForm" x-cloak x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0 translate-y-3"
                x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-sm font-black text-slate-800">Deja tu opinión</h3>
                    <button @click="showForm = false"
                        class="text-slate-400 hover:text-slate-600 text-xs font-bold transition">Cancelar</button>
                </div>

                <div x-show="reviewSubmitted"
                    class="bg-emerald-50 text-emerald-700 text-sm font-bold p-3 rounded-xl border border-emerald-100 text-center mb-0">
                    ¡Gracias por tu valoración!</div>
                <form @submit.prevent="submitReview" x-show="!reviewSubmitted" class="flex flex-col gap-3">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="checkbox" id="anon" x-model="review.anonymous"
                            class="rounded border-slate-300 text-[var(--color-primary)]">
                        <label for="anon" class="text-xs font-bold text-slate-600 cursor-pointer">Comentar como
                            Anónimo</label>
                    </div>
                    <input type="text" x-show="!review.anonymous" x-model="review.name"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none"
                        placeholder="Tu nombre">

                    <div class="flex flex-col gap-2.5 bg-slate-50 border border-slate-200 rounded-2xl p-4 text-center select-none"
                        x-data="{ hoverRating: 0 }">
                        <span class="text-xs font-black text-slate-500 block uppercase tracking-wider">Valoración de
                            tu
                            experiencia</span>
                        <div class="flex justify-center gap-4 py-1" @mouseleave="hoverRating = 0">
                            <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                <button type="button" @click="review.rating = star"
                                    @mouseenter="hoverRating = star"
                                    class="text-3xl transition-all duration-150 transform hover:scale-125 focus:outline-none cursor-pointer"
                                    :class="(hoverRating ? hoverRating >= star : parseInt(review.rating) >= star) ?
                                    'text-amber-400' : 'text-slate-300'">
                                    <i class="fas fa-star"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                    <textarea x-model="review.comment"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none"
                        rows="2" placeholder="Opcional: Escribe un comentario..."></textarea>
                    <button type="submit"
                        class="w-full text-white font-bold py-3 rounded-xl text-xs active:scale-95 transition mt-1"
                        style="background-color: var(--color-primary);">Enviar Calificación</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ALL PAYMENT METHODS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showAllPaymentMethodsModal"
        @click="showAllPaymentMethodsModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[92%] max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[85vh] flex flex-col overflow-hidden origin-center"
        x-show="showAllPaymentMethodsModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <!-- Header -->
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm shrink-0"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fas fa-wallet text-lg"></i>
                <h2 class="text-xl font-black tracking-tight">Métodos de Pago</h2>
            </div>
            <button @click="showAllPaymentMethodsModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 bg-slate-50 overflow-y-auto space-y-4 scrollbar-none flex-grow">
            <!-- Tabs de métodos de pago -->
            <div class="flex flex-wrap gap-2 justify-center">
                <template x-for="(methodData, methodName) in paymentMethodsList" :key="methodName">
                    <button type="button" @click="activeMethodTab = methodName"
                        :class="activeMethodTab === methodName ? (colors[methodName] ||
                                'bg-[var(--color-primary)] text-white shadow-sm border-transparent') :
                            'bg-white text-slate-600 border-slate-200 hover:bg-slate-100'"
                        class="px-3.5 py-2 text-[10.5px] font-black rounded-xl border transition active:scale-95 cursor-pointer flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        <span x-text="methodName"></span>
                    </button>
                </template>
            </div>

            <!-- Detalles del método seleccionado -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3.5 mt-2">
                <div class="flex items-center gap-1.5 text-slate-800 border-b border-slate-100 pb-2.5">
                    <span class="w-1.5 h-3.5 rounded-full transition-all duration-300"
                        :class="colors[activeMethodTab] ? colors[activeMethodTab].split(' ')[0] : 'bg-[var(--color-primary)]'"></span>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-700" x-text="activeMethodTab">
                    </h3>
                </div>

                <div class="text-xs text-slate-600 leading-relaxed font-semibold bg-slate-50 p-4.5 rounded-xl border border-slate-150/50 whitespace-pre-line shadow-inner max-h-[250px] overflow-y-auto scrollbar-none"
                    x-text="paymentMethodsList[activeMethodTab]?.details || 'Este método de pago no requiere datos adicionales.'">
                </div>

                <div x-data="{ copied: false }" class="pt-1.5">
                    <button
                        @click="navigator.clipboard.writeText(paymentMethodsList[activeMethodTab]?.details || ''); copied = true; setTimeout(() => copied = false, 2000)"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl text-[11px] flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                        <i class="far" :class="copied ? 'fa-check-circle text-emerald-500' : 'fa-copy'"></i>
                        <span x-text="copied ? '¡Datos copiados!' : 'Copiar datos al portapapeles'">Copiar datos al
                            portapapeles</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="p-5 bg-white border-t border-slate-100 text-center shrink-0">
            <button @click="showAllPaymentMethodsModal = false"
                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-3.5 rounded-xl transition active:scale-95 text-[11px] uppercase tracking-wider cursor-pointer">
                Cerrar
            </button>
        </div>
    </div>

    <!-- PAYMENT DETAILS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showPaymentDetailsModal"
        @click="showPaymentDetailsModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-center"
        x-show="showPaymentDetailsModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fas fa-wallet text-lg"></i>
                <h2 class="text-xl font-black tracking-tight" x-text="selectedPaymentMethodName">Datos de Pago</h2>
            </div>
            <button @click="showPaymentDetailsModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-4 scrollbar-none">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <p class="text-xs text-slate-400 font-extrabold uppercase tracking-wider">Instrucciones para
                    transferir
                    / pagar:</p>
                <div class="text-sm text-slate-700 leading-relaxed font-semibold bg-slate-50 p-4 rounded-xl border border-slate-150/50 whitespace-pre-line"
                    x-text="selectedPaymentMethodDetails"></div>

                <div x-data="{ copied: false }" class="pt-2">
                    <button
                        @click="navigator.clipboard.writeText(selectedPaymentMethodDetails); copied = true; setTimeout(() => copied = false, 2000)"
                        class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm">
                        <i class="far" :class="copied ? 'fa-check-circle text-emerald-500' : 'fa-copy'"></i>
                        <span x-text="copied ? '¡Datos copiados!' : 'Copiar datos al portapapeles'">Copiar datos al
                            portapapeles</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="p-5 bg-white border-t border-slate-100 text-center select-none">
            <button @click="showPaymentDetailsModal = false"
                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-3.5 rounded-2xl transition active:scale-95 text-xs">
                Entendido / Cerrar
            </button>
        </div>
    </div>

    <!-- PRODUCT DETAILS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showProductModal"
        @click="showProductModal = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden origin-center"
        x-show="showProductModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-50" style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center text-white shadow-sm"
            style="background-color: var(--color-primary);">
            <div class="flex items-center gap-2">
                <i class="fas fa-shopping-bag text-lg"></i>
                <h2 class="text-xl font-black tracking-tight"
                    x-text="modalProduct ? modalProduct.name : 'Detalles de Producto'">Detalles del Producto</h2>
            </div>
            <button @click="showProductModal = false"
                class="text-white/80 hover:text-white hover:bg-white/10 w-9 h-9 flex items-center justify-center rounded-full transition active:scale-95"><i
                    class="fas fa-times text-lg"></i></button>
        </div>
        <div class="p-6 overflow-y-auto bg-slate-50 space-y-6 scrollbar-none flex-grow" x-data="{ modalClicked: false }">
            <!-- Image Slider / Carousel -->
            <div class="relative rounded-2xl overflow-hidden bg-slate-100 shadow-inner border border-slate-200"
                x-show="modalProduct">
                <!-- Slides Container -->
                <div class="h-64 w-full relative overflow-hidden">
                    <template x-for="(img, idx) in modalProductFeatures.images" :key="idx">
                        <div x-show="modalActiveSlide === idx" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-full"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-full"
                            class="absolute inset-0 flex items-center justify-center">
                            <img :src="img" class="w-full h-full object-cover"
                                alt="Product Image slide">
                        </div>
                    </template>
                    <div x-show="!modalProductFeatures.images || modalProductFeatures.images.length === 0"
                        class="absolute inset-0 flex items-center justify-center">
                        <img :src="modalProduct ? (modalProduct.image_path ? (modalProduct.image_path.startsWith('http') ?
                            modalProduct.image_path : '/storage/' + modalProduct.image_path) : '') : ''"
                            class="w-full h-full object-cover" alt="Default Product Image">
                    </div>
                </div>
                <!-- Left/Right Controls -->
                <template x-if="modalProductFeatures.images && modalProductFeatures.images.length > 1">
                    <div>
                        <button type="button"
                            @click="modalActiveSlide = (modalActiveSlide === 0) ? modalProductFeatures.images.length - 1 : modalActiveSlide - 1"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-700 shadow flex items-center justify-center active:scale-90 transition">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </button>
                        <button type="button"
                            @click="modalActiveSlide = (modalActiveSlide === modalProductFeatures.images.length - 1) ? 0 : modalActiveSlide + 1"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-700 shadow flex items-center justify-center active:scale-90 transition">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </template>
                <!-- Dots indicators -->
                <template x-if="modalProductFeatures.images && modalProductFeatures.images.length > 1">
                    <div
                        class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 bg-black/30 backdrop-blur-[2px] px-2.5 py-1 rounded-full">
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
                <span
                    class="text-[9px] text-slate-400 font-extrabold uppercase tracking-wider block">Descripción</span>
                <p class="text-xs text-slate-600 leading-relaxed font-medium"
                    x-text="modalProduct ? modalProduct.description : ''"></p>
            </div>

            <!-- Preparation Time -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-2"
                x-show="modalProduct">
                <span class="text-base leading-none">⏱️</span>
                <span class="text-xs font-black text-slate-800">Tiempo estimado de preparación:</span>
                <span class="text-xs font-black text-slate-500 ml-auto"
                    x-text="modalProduct && modalProduct.preparation_time ? modalProduct.preparation_time : '20-30 min'">20-30
                    min</span>
            </div>

            <!-- Variants Selection Panels -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4" x-show="modalProduct">
                <!-- COLORS SELECTOR -->
                <div x-show="modalProductFeatures.colors && modalProductFeatures.colors.length > 0"
                    class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Color
                            seleccionado: <span class="text-slate-700 font-bold"
                                x-text="modalSelectedColor"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <template x-for="color in modalProductFeatures.colors" :key="color.name">
                            <button type="button" @click="modalSelectedColor = color.name"
                                class="w-8 h-8 rounded-full border-2 transition-all duration-200 cursor-pointer flex items-center justify-center shadow-sm relative hover:scale-105 active:scale-95"
                                :class="modalSelectedColor === color.name ?
                                    'border-[var(--color-primary)] ring-2 ring-[var(--color-primary)]/20' :
                                    'border-white'"
                                :style="{ backgroundColor: color.hex }" :title="color.name">
                                <i x-show="modalSelectedColor === color.name" class="fas fa-check text-xs shadow-sm"
                                    :class="color.hex === '#FFFFFF' || color.hex === '#F8FAFC' ? 'text-slate-800' :
                                        'text-white'"></i>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- SIZES SELECTOR -->
                <div x-show="modalProductFeatures.sizes && modalProductFeatures.sizes.length > 0" class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Talla
                            seleccionada: <span class="text-slate-700 font-bold"
                                x-text="modalSelectedSize"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="size in modalProductFeatures.sizes" :key="size">
                            <button type="button" @click="modalSelectedSize = size"
                                class="w-10 h-10 rounded-xl font-black text-xs transition-all duration-200 flex items-center justify-center border cursor-pointer active:scale-95"
                                :class="modalSelectedSize === size ?
                                    'border-[var(--color-primary)] bg-[var(--color-primary)] text-white shadow-sm shadow-[var(--color-primary)]/10 scale-105' :
                                    'border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300'">
                                <span x-text="size"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div x-show="modalProductFeatures.flavors && modalProductFeatures.flavors.length > 0"
                    class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Sabor
                            seleccionado: <span class="text-slate-700 font-bold"
                                x-text="modalSelectedFlavor"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="flavor in modalProductFeatures.flavors" :key="flavor">
                            <button type="button" @click="modalSelectedFlavor = flavor"
                                class="px-3 py-2 rounded-xl font-black text-xs transition-all duration-200 flex items-center justify-center border cursor-pointer active:scale-95"
                                :class="modalSelectedFlavor === flavor ?
                                    'border-[var(--color-primary)] bg-[var(--color-primary)] text-white shadow-sm shadow-[var(--color-primary)]/10 scale-105' :
                                    'border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300'">
                                <span x-text="flavor"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- UNITS / WEIGHTS SELECTOR -->
                <div x-show="modalProductFeatures.units && modalProductFeatures.units.length > 0" class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Presentación
                            seleccionada: <span class="text-slate-700 font-bold"
                                x-text="modalSelectedUnit"></span></span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="unit in modalProductFeatures.units" :key="unit">
                            <button type="button" @click="modalSelectedUnit = unit"
                                class="px-4 py-2.5 rounded-xl font-extrabold text-xs transition-all duration-200 flex items-center justify-center border cursor-pointer active:scale-95"
                                :class="modalSelectedUnit === unit ?
                                    'border-[var(--color-primary)] bg-[var(--color-primary)] text-white shadow-sm shadow-[var(--color-primary)]/10 scale-105' :
                                    'border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300'">
                                <span x-text="unit"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Pricing row -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex justify-between items-center"
                x-show="modalProduct">
                <span class="text-xs font-black text-slate-800">Precio unitario:</span>
                <div class="text-right">
                    <span class="text-lg font-black text-slate-900 block"
                        x-text="currencySymbol + (modalProduct ? parseFloat(modalProduct.price) : 0).toFixed(2)"></span>
                    <span x-show="exchangeRate > 0" class="text-xs font-bold text-slate-400 block mt-0.5"
                        x-text="'Bs. ' + ((modalProduct ? parseFloat(modalProduct.price) : 0) * exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-100 flex justify-between items-center gap-4"
            x-show="modalProduct">
            <div
                class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200/50 shadow-inner shrink-0">
                <button type="button" @click="if (modalQty > 1) modalQty--"
                    class="w-8 h-8 rounded-xl bg-white text-slate-600 flex items-center justify-center font-black text-sm hover:bg-rose-50 hover:text-rose-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">-</button>
                <span class="text-xs font-black text-slate-700 w-6 text-center select-none"
                    x-text="modalQty"></span>
                <button type="button" @click="modalQty++"
                    class="w-8 h-8 rounded-xl bg-white text-slate-600 flex items-center justify-center font-black text-sm hover:bg-emerald-50 hover:text-emerald-600 transition active:scale-75 shadow-sm border border-slate-200/30 select-none">+</button>
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
                    <i class="fas fa-shopping-basket text-xs"></i> Agregar al Pedido <span
                        class="opacity-80 font-bold" x-text="'(' + modalQty + ')'"></span>
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
        $workHoursJson = $company['work_hours'] ?? null;
        $storeLatJs = (float) ($company['latitude'] ?? 0);
        $storeLngJs = (float) ($company['longitude'] ?? 0);
        $deliveryRateJs = (float) ($company['delivery_rate_per_km'] ?? 0);
        $reviewsListJson = $reviews
            ->map(
                fn($r) => [
                    'customer_name' => $r->customer_name,
                    'rating' => (int) $r->rating,
                    'comment' => $r->comment,
                    'created_at' => $r->created_at ? $r->created_at->toIso8601String() : null,
                ],
            )
            ->values()
            ->all();
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
                showBookingModal: false,
                bookingName: '',
                bookingPhone: '',
                bookingDate: new Date().toISOString().split('T')[0],
                bookingTimeSlot: '12:00 - 13:00',
                showSchedulesModal: false,
                showServicesModal: false,
                showServiceTypesModal: false,
                showBranchesModal: false,
                showErrors: false,
                activeCategory: 0,
                selectedCategory: 0,
                searchQuery: '',
                starFilter: 0,
                review: {
                    name: '',
                    rating: '5',
                    comment: '',
                    anonymous: false
                },
                isSubmitting: false,
                reviewSubmitted: false,
                currencySymbol: '{{ $currencySymbol }}',

                showWhatsappModal: false,
                showOrderWhatsappModal: false,
                pendingOrderMessage: '',
                showPaymentError: false,

                // Coupons properties
                couponCode: '',
                appliedCoupon: null,
                couponError: '',
                stripeCardNumber: '',
                stripeExpiry: '',
                stripeCvc: '',
                binancePayId: '',
                pagomovilReference: '',
                casheaConfirmed: false,
                casheaLinkConfirmed: false,
                kreceConfirmed: false,
                kreceLinkConfirmed: false,
                get discountAmount() {
                    if (!this.appliedCoupon) return 0;
                    if (this.appliedCoupon.type === 'percentage') {
                        return this.total * (parseFloat(this.appliedCoupon.value) / 100);
                    } else {
                        return parseFloat(this.appliedCoupon.value);
                    }
                },

                // Propiedades de Anuncios
                announcements: @json($announcements ?? []),
                showAnnouncementModal: false,
                activeAnnouncementSlide: 0,

                // Accessibility properties
                showAccessibilityModal: false,
                accessibility: {
                    fontSize: parseInt(localStorage.getItem('store_font_size') || '16'),
                    daltonism: localStorage.getItem('store_daltonism') || 'normal'
                },

                deliveryType: 'pickup',
                tableNumber: '',
                deliveryMode: 'map',
                isGpsLoading: false,
                gpsSuccess: false,
                deliveryCost: 0,
                enableFreeShipping: {{ $company['enable_free_shipping'] ? 'true' : 'false' }},
                freeShippingMinAmount: {{ (float) ($company['free_shipping_min_amount'] ?? 0) }},
                mapInitialized: false,
                map: null,
                marker: null,
                storeLat: {{ $storeLatJs }},
                storeLng: {{ $storeLngJs }},
                deliveryRate: {{ $deliveryRateJs }},
                exchangeRate: {{ $exchangeRateFloat }},
                hasScheduleInfo: {{ !empty($workHoursJson) ? 'true' : 'false' }},
                hasPaymentMethodsConfigured: {{ $hasPaymentMethodsConfigured ? 'true' : 'false' }},

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
                modalProductFeatures: {
                    images: [],
                    colors: [],
                    sizes: [],
                    units: [],
                    flavors: []
                },
                modalSelectedColor: '',
                modalSelectedSize: '',
                modalSelectedUnit: '',
                modalSelectedFlavor: '',
                modalQty: 1,
                modalActiveSlide: 0,
                modalClicked: false,
                originalTitle: '',

                // Dynamic reactive reviews list loaded from database initially
                reviewsList: @json($reviewsListJson),

                // Dynamic store hours state
                workHours: (() => {
                    let wh = @json($workHoursJson);
                    if (!wh) return null;
                    if (typeof wh === 'string') {
                        try {
                            wh = JSON.parse(wh);
                        } catch (e) {
                            return {
                                type: 'simple',
                                text: wh
                            };
                        }
                    }
                    return wh;
                })(),

                // Services data
                services: (() => {
                    return window.servicesData || [];
                })(),

                // Service types data
                serviceTypes: (() => {
                    return [{
                            key: 'has_dine_in',
                            label: 'Comer aquí',
                            icon: 'fas fa-utensils',
                            bg: 'bg-emerald-50/90 text-emerald-700 border-emerald-100/60',
                            iconColor: 'text-emerald-500',
                            enabled: @json($company['has_dine_in'] ?? true)
                        },
                        {
                            key: 'has_pickup',
                            label: 'Recoger',
                            icon: 'fas fa-shopping-bag',
                            bg: 'bg-amber-50/90 text-amber-700 border-amber-100/60',
                            iconColor: 'text-amber-500',
                            enabled: @json($company['has_pickup'] ?? true)
                        },
                        {
                            key: 'has_delivery',
                            label: 'Entrega a domicilio',
                            icon: 'fas fa-motorcycle',
                            bg: 'bg-blue-50/90 text-blue-700 border-blue-100/60',
                            iconColor: 'text-blue-500',
                            enabled: @json($company['has_delivery'] ?? true)
                        }
                    ].filter(s => s.enabled);
                })(),
                storeStatus: {
                    state: 'open',
                    label: 'Abierto',
                    colorClass: 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition',
                    dotClass: 'bg-emerald-500'
                },
                lastNotifiedStatus: localStorage.getItem('lastNotifiedStatus') || '',

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const mesa = urlParams.get('mesa');
                    if (mesa) {
                        this.tableNumber = mesa;
                        this.deliveryType = 'dine_in';
                    }

                    // Debounce cart telemetry sync
                    let telemetryTimeout;
                    const triggerTelemetry = () => {
                        clearTimeout(telemetryTimeout);
                        telemetryTimeout = setTimeout(() => this.syncCartTelemetry(), 2500);
                    };

                    this.$watch('cart', val => {
                        localStorage.setItem('cart', JSON.stringify(val));
                        triggerTelemetry();
                    });
                    this.$watch('customerName', val => {
                        localStorage.setItem('customerName', val);
                        triggerTelemetry();
                    });
                    this.$watch('customerPhone', val => {
                        localStorage.setItem('customerPhone', val);
                        triggerTelemetry();
                    });

                    this.$watch('showProductModal', val => {
                        if (val && this.modalProduct) {
                            if (!this.originalTitle) {
                                this.originalTitle = document.title;
                            }
                            document.title = this.modalProduct.seo_title || (this.modalProduct.name + ' - {{ addslashes($company['name']) }}');
                        } else {
                            if (this.originalTitle) {
                                document.title = this.originalTitle;
                            }
                        }
                    });

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

                    // Mostrar el anuncio apenas entra al menú — forzar cierre del carrito y modales primero
                    if (this.announcements && this.announcements.length > 0 && !sessionStorage.getItem(
                            'announcements_closed')) {
                        // Forzar cierre del carrito y cualquier modal para que el anuncio sea lo primero que ve el usuario
                        this.isCartOpen = false;
                        this.showWhatsappModal = false;
                        this.showReviewsModal = false;
                        this.showSchedulesModal = false;
                        this.showServicesModal = false;
                        this.showServiceTypesModal = false;
                        this.showBranchesModal = false;
                        // Mostrar el anuncio inmediatamente al entrar
                        this.showAnnouncementModal = true;
                    }
                },

                getScheduleDay(day) {
                    const defaultSchedule = {
                        'Lunes': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Martes': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Miércoles': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Jueves': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Viernes': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Sábado': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Domingo': {
                            closed: true,
                            open: '08:00',
                            close: '18:00'
                        }
                    };
                    if (this.workHours && this.workHours.type === 'custom' && this.workHours.schedule && this.workHours
                        .schedule[day]) {
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

                getOpenDaysCount() {
                    if (!this.hasScheduleInfo) return 0;
                    if (this.workHours && this.workHours.type === 'simple') {
                        return 6;
                    }
                    const days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                    let count = 0;
                    for (let day of days) {
                        if (!this.getScheduleDay(day).closed) {
                            count++;
                        }
                    }
                    return count;
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
                        'Lunes': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Martes': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Miércoles': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Jueves': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Viernes': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Sábado': {
                            closed: false,
                            open: '08:00',
                            close: '18:00'
                        },
                        'Domingo': {
                            closed: true,
                            open: '08:00',
                            close: '18:00'
                        }
                    };

                    let wh = this.workHours;

                    if (!wh || wh.type === 'simple') {
                        state = 'open';
                        label = 'Abierto';
                        colorClass = 'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition';
                        dotClass = 'bg-emerald-500';
                    } else if (wh.type === 'custom') {
                        const dayConfig = wh.schedule && wh.schedule[currentDayName] ? wh.schedule[currentDayName] :
                            defaultSchedule[currentDayName];

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
                                    colorClass =
                                        'bg-blue-50 text-blue-600 border-blue-100 hover:bg-blue-100 transition animate-pulse duration-1000';
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
                                    colorClass =
                                        'bg-amber-50 text-amber-600 border-amber-100 hover:bg-amber-100 transition animate-pulse duration-1000';
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
                                    colorClass =
                                        'bg-emerald-50 text-emerald-600 border-emerald-100 hover:bg-emerald-100 transition';
                                    dotClass = 'bg-emerald-500';

                                    if (this.lastNotifiedStatus === 'closing_soon' || this.lastNotifiedStatus ===
                                        'opening_soon') {
                                        this.lastNotifiedStatus = '';
                                        localStorage.removeItem('lastNotifiedStatus');
                                    }
                                }
                            } else {
                                state = 'closed';
                                label = 'Cerrado';
                                colorClass = 'bg-rose-50 text-rose-600 border-rose-100 hover:bg-rose-100 transition';
                                dotClass = 'bg-rose-500';

                                if (this.lastNotifiedStatus === 'closing_soon' || this.lastNotifiedStatus ===
                                    'opening_soon') {
                                    this.lastNotifiedStatus = '';
                                    localStorage.removeItem('lastNotifiedStatus');
                                }
                            }
                        }
                    }

                    this.storeStatus = {
                        state,
                        label,
                        colorClass,
                        dotClass
                    };
                },

                selectPayment(name) {
                    this.selectedPaymentMethod = name;
                    this.selectedPaymentDetails = this.paymentMethodsList[name]?.details || '';
                    this.casheaConfirmed = false;
                    this.casheaLinkConfirmed = false;
                    this.kreceConfirmed = false;
                    this.kreceLinkConfirmed = false;
                    this.showPaymentError = false;
                },

                openPaymentDetails(name, details) {
                    this.selectedPaymentMethodName = name;
                    this.selectedPaymentMethodDetails = details || 'Este método de pago no requiere datos adicionales.';
                    this.showPaymentDetailsModal = true;
                },

                get currentDayName() {
                    const daysMap = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    return daysMap[new Date().getDay()];
                },

                get total() {
                    return this.cart.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
                },
                get totalItems() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },
                get actualDeliveryCost() {
                    if (this.deliveryType !== 'delivery') return 0;
                    if (this.enableFreeShipping && this.total >= this.freeShippingMinAmount && this.total > 0) {
                        return 0;
                    }
                    return this.deliveryCost;
                },

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
                    let counts = {
                        5: 0,
                        4: 0,
                        3: 0,
                        2: 0,
                        1: 0
                    };
                    this.reviewsList.forEach(r => {
                        if (counts[r.rating] !== undefined) counts[r.rating]++;
                    });
                    return counts;
                },
                get starPercentages() {
                    let total = this.reviewsList.length;
                    let pcts = {
                        5: 0,
                        4: 0,
                        3: 0,
                        2: 0,
                        1: 0
                    };
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
                        osc1.frequency.exponentialRampToValueAtTime(880, audioCtx.currentTime +
                            0.15); // Ramp up to A5 for a bright chime

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
                                osc2.frequency.exponentialRampToValueAtTime(1046.50, audioCtx.currentTime +
                                    0.1); // C6

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
                    if (!product) return {
                        images: [],
                        colors: [],
                        sizes: [],
                        units: [],
                        flavors: []
                    };
                    const defaultImage = '{{ asset('img1.jpg') }}';
                    if (product.features && typeof product.features === 'object') {
                        const rawImages = product.features.images || product.features.imagenes || [];
                        const rawColors = product.features.colors || product.features.colores || [];
                        const rawSizes = product.features.sizes || product.features.tamanos || [];
                        const rawUnits = product.features.units || product.features.medidas || [];
                        const rawFlavors = product.features.flavors || product.features.sabores || [];

                        let images = Array.isArray(rawImages) && rawImages.length ? rawImages : [product.image_path];
                        images = images.map(img => {
                            if (!img) return defaultImage;
                            return img.startsWith('http') ? img : '/storage/' + img;
                        });

                        const colors = Array.isArray(rawColors) ? rawColors.map(color => ({
                            name: color.name || color.nombre || (typeof color === 'string' ? color : ''),
                            hex: color.hex || color.color || '#000000'
                        })).filter(c => c.name && c.hex) : [];
                        const sizes = Array.isArray(rawSizes) ? rawSizes.map(item => typeof item === 'string' ? item : (item
                            ?.name || item?.value || '')).filter(Boolean) : [];
                        const units = Array.isArray(rawUnits) ? rawUnits.map(item => typeof item === 'string' ? item : (item
                            ?.name || item?.value || '')).filter(Boolean) : [];
                        const flavors = Array.isArray(rawFlavors) ? rawFlavors.map(item => typeof item === 'string' ? item :
                            (item?.name || item?.value || '')).filter(Boolean) : [];

                        return {
                            images,
                            colors,
                            sizes,
                            units,
                            flavors
                        };
                    }

                    const name = (product.name || '').toLowerCase();
                    const image = product.image_path ? (product.image_path.startsWith('http') ? product.image_path :
                        '/storage/' + product.image_path) : defaultImage;

                    let images = [image];
                    let colors = [];
                    let sizes = [];
                    let units = [];

                    // Fallback variants for clothing items
                    if (name.includes('camisa') || name.includes('franela') || name.includes('pantalon') ||
                        name.includes('jean') || name.includes('vestido') || name.includes('sueter') ||
                        name.includes('zapato') || name.includes('zapatilla') || name.includes('ropa') ||
                        name.includes('t-shirt') || name.includes('asd')) {

                        colors = [{
                                name: 'Negro',
                                hex: '#1E293B'
                            },
                            {
                                name: 'Blanco',
                                hex: '#F8FAFC'
                            },
                            {
                                name: 'Azul',
                                hex: '#3B82F6'
                            },
                            {
                                name: 'Verde',
                                hex: '#10B981'
                            }
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

                    return {
                        images,
                        colors,
                        sizes,
                        units,
                        flavors: []
                    };
                },

                openProductDetails(product, options = {}) {
                    this.modalProduct = product;
                    this.modalProductFeatures = this.getProductFeatures(product);

                    // Set default selected options
                    this.modalSelectedColor = options.selectedColor || (this.modalProductFeatures.colors && this
                        .modalProductFeatures.colors.length > 0 ? this
                        .modalProductFeatures.colors[0].name : '');
                    this.modalSelectedSize = this.modalProductFeatures.sizes && this.modalProductFeatures.sizes.length > 0 ?
                        this.modalProductFeatures.sizes[
                            0] : '';
                    this.modalSelectedUnit = this.modalProductFeatures.units && this.modalProductFeatures.units.length > 0 ?
                        this.modalProductFeatures.units[
                            0] : '';
                    this.modalSelectedFlavor = this.modalProductFeatures.flavors && this.modalProductFeatures.flavors
                        .length > 0 ? this.modalProductFeatures
                        .flavors[0] : '';
                    this.modalQty = options.qty || 1;
                    this.modalActiveSlide = 0;

                    this.showProductModal = true;
                },

                addToCartWithQty(product, quantity) {
                    let qty = parseInt(quantity) || 1;
                    const features = this.getProductFeatures(product);

                    const size = features.sizes && features.sizes.length > 0 ? features.sizes[0] : '';
                    const color = features.colors && features.colors.length > 0 ? features.colors[0].name : '';
                    const unit = features.units && features.units.length > 0 ? features.units[0] : '';
                    const flavor = features.flavors && features.flavors.length > 0 ? features.flavors[0] : '';

                    const variantKey = [size, color, unit, flavor].filter(Boolean).join('-');
                    const cartItemId = variantKey ? `${product.id}-${variantKey}` : product.id;

                    const variantLabel = [size, color, unit, flavor].filter(Boolean).join(', ');
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
                            selectedFlavor: flavor,
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
                    const flavor = this.modalSelectedFlavor;
                    const qty = this.modalQty;

                    const variantKey = [size, color, unit, flavor].filter(Boolean).join('-');
                    const cartItemId = variantKey ? `${product.id}-${variantKey}` : product.id;

                    const variantLabel = [size, color, unit, flavor].filter(Boolean).join(', ');
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
                            selectedFlavor: flavor,
                            image_path: product.image_path
                        });
                    }

                    this.playAddSound();

                    setTimeout(() => {
                        this.showProductModal = false;
                    }, 800);
                },

                confirmClearCart() {
                    if (this.cart.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'El carrito ya está vacío',
                            showConfirmButton: false,
                            timer: 1800,
                            toast: true,
                            position: 'top-end'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Vaciar carrito',
                        text: `¿Deseas eliminar los ${this.totalItems} artículos del carrito?`,
                        icon: 'warning',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: 'Sí, vaciar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'rounded-[28px] bg-white shadow-2xl border border-slate-200 overflow-hidden',
                            title: 'text-lg font-black text-slate-900',
                            content: 'text-sm text-slate-600 leading-6 mt-2',
                            confirmButton: 'inline-flex items-center justify-center rounded-2xl bg-[var(--color-primary)] px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-[var(--color-primary)]/20 transition hover:bg-slate-900',
                            cancelButton: 'inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-200',
                            actions: 'mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end'
                        },
                        confirmButtonColor: 'var(--color-primary)',
                        cancelButtonColor: '#9ca3af',
                        background: '#ffffff',
                        backdrop: 'rgba(15, 23, 42, 0.45)'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.cart = [];
                            Swal.fire({
                                icon: 'success',
                                title: 'Carrito vaciado',
                                showConfirmButton: false,
                                timer: 1400,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    });
                },

                confirmRemoveItem(id) {
                    const item = this.cart.find(i => i.id === id);
                    if (!item) return;

                    const message = item.quantity > 1 ?
                        `¿Eliminar este producto del carrito? Se eliminarán ${item.quantity} unidades.` :
                        '¿Eliminar este producto del carrito?';

                    Swal.fire({
                        title: 'Eliminar producto',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'rounded-[28px] bg-white shadow-2xl border border-slate-200 overflow-hidden',
                            title: 'text-lg font-black text-slate-900',
                            content: 'text-sm text-slate-600 leading-6 mt-2',
                            confirmButton: 'inline-flex items-center justify-center rounded-2xl bg-[var(--color-primary)] px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-[var(--color-primary)]/20 transition hover:bg-slate-900',
                            cancelButton: 'inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-200',
                            actions: 'mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end'
                        },
                        confirmButtonColor: 'var(--color-primary)',
                        cancelButtonColor: '#9ca3af',
                        background: '#ffffff',
                        backdrop: 'rgba(15, 23, 42, 0.45)'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.cart = this.cart.filter(i => i.id !== id);
                            Swal.fire({
                                icon: 'success',
                                title: 'Producto eliminado',
                                showConfirmButton: false,
                                timer: 1400,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    });
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

                    const targetElement = catId === 0 ? document.getElementById('products-container') : document
                        .getElementById('cat-' + catId);
                    if (targetElement) {
                        this.isProgrammaticScroll = true;
                        if (this.scrollTimeout) clearTimeout(this.scrollTimeout);

                        const offset =
                            120; // Ajuste para que la barra de categorías sticky quede visible y no tape los títulos
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
                    if (!finalName) return alert('Por favor ingresa tu nombre o marca la casilla de anónimo.');
                    if (!this.review.rating) return alert('Por favor selecciona una valoración en estrellas.');

                    this.isSubmitting = true;
                    try {
                        let response = await fetch('/{{ $company['slug'] }}/reviews', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                customer_name: finalName,
                                rating: parseInt(this.review.rating),
                                comment: this.review.comment
                            })
                        });
                        if (response.ok) {
                            // Inject into the list dynamically in real-time
                            this.reviewsList.unshift({
                                customer_name: finalName,
                                rating: parseInt(this.review.rating),
                                comment: this.review.comment
                            });
                            this.reviewSubmitted = true;
                            setTimeout(() => {
                                this.review = {
                                    name: '',
                                    rating: '5',
                                    comment: '',
                                    anonymous: false
                                };
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

                async submitBooking() {
                    if (!this.bookingName.trim() || !this.bookingPhone.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos requeridos',
                            text: 'Por favor completa tu nombre y teléfono para agendar la reserva.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Procesando reserva...',
                        text: 'Estamos agendando tu cita, por favor espera.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const response = await fetch('/{{ $company['slug'] }}/bookings', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                client_name: this.bookingName,
                                client_phone: this.bookingPhone,
                                date: this.bookingDate,
                                time_slot: this.bookingTimeSlot
                            })
                        });
                        
                        const resData = await response.json();
                        if (resData.success) {
                            this.showBookingModal = false;
                            
                            // Formatear fecha para JS
                            let d = new Date(this.bookingDate);
                            let offset = d.getTimezoneOffset() * 60000;
                            let localDate = new Date(d.getTime() + offset);
                            let formattedDate = localDate.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                            
                            let text = `*Nueva Solicitud de Reserva*%0A`;
                            text += `*Cliente:* ${this.bookingName}%0A`;
                            text += `*Teléfono:* ${this.bookingPhone}%0A`;
                            text += `*Fecha:* ${formattedDate}%0A`;
                            text += `*Horario:* ${this.bookingTimeSlot}%0A%0A`;
                            text += `*Estado:* Pendiente por Confirmar. ¡Espero tu confirmación!`;
                            
                            let whatsappUrl = 'https://api.whatsapp.com/send?phone={{ $company['whatsapp'] }}&text=' + text;

                            Swal.fire({
                                icon: 'success',
                                title: '¡Reserva Solicitada!',
                                text: 'Tu reserva ha sido registrada en el sistema. Presiona Aceptar para notificar al comercio vía WhatsApp.',
                                confirmButtonText: 'Notificar por WhatsApp',
                                confirmButtonColor: '#25D366'
                            }).then((resAlert) => {
                                if (resAlert.isConfirmed) {
                                    window.open(whatsappUrl, '_blank');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: resData.message || 'Ocurrió un error al agendar la reserva.',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                        }
                    } catch (e) {
                        console.error('Error agendando reserva:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar tu solicitud de reserva.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                    }
                },

                syncCartTelemetry() {
                    if (!this.customerPhone || this.customerPhone.trim().length < 7 || this.cart.length === 0) return;
                    
                    fetch('/{{ $company['slug'] }}/cart/telemetry', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            customer_phone: this.customerPhone,
                            customer_name: this.customerName,
                            cart_data: this.cart
                        })
                    }).catch(e => console.error('Error syncing cart telemetry:', e));
                },

                initMap() {
                    if (this.mapInitialized || !this.storeLat || !this.storeLng) return;
                    setTimeout(() => {
                        let center = [this.storeLat, this.storeLng];
                        this.map = L.map('delivery-map').setView(center, 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);

                        this.marker = L.marker(center, {
                            draggable: true
                        }).addTo(this.map);

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
                        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
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
                            let errMsg =
                                'No pudimos obtener tu ubicación. Por favor, asegúrate de activar el GPS y dar permisos.';
                            if (error.code === error.PERMISSION_DENIED) {
                                errMsg =
                                    'Has denegado el acceso al GPS. Por favor actívalo en los ajustes de tu navegador o selecciona en el mapa manualmente.';
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
                        }, {
                            enableHighAccuracy: true,
                            timeout: 8000,
                            maximumAge: 0
                        }
                    );
                },

                async sendWhatsApp() {
                    if (this.cart.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Carrito vacío',
                            text: 'Por favor agrega productos antes de enviar tu pedido.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }

                    this.showErrors = false;
                    if (!this.customerName.trim() || !this.customerPhone.trim() || !this.selectedPaymentMethod) {
                        this.showErrors = true;
                        // Focus on the first invalid field
                        setTimeout(() => {
                            const firstInvalid = document.querySelector('.border-rose-300');
                            if (firstInvalid) firstInvalid.focus();
                        }, 50);
                        return;
                    }

                    // Direct Gateway validations
                    if (this.selectedPaymentMethod === 'Tarjeta' && {{ $company['stripe_enabled'] ? 'true' : 'false' }}) {
                        if (!this.stripeCardNumber.trim() || !this.stripeExpiry.trim() || !this.stripeCvc.trim()) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Datos de Tarjeta Requeridos',
                                text: 'Por favor, ingresa los datos de tu tarjeta de crédito para procesar el pago.',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }
                    if (this.selectedPaymentMethod === 'Binance' && {{ $company['binance_enabled'] ? 'true' : 'false' }}) {
                        if (!this.binancePayId.trim()) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Binance Pay ID Requerido',
                                text: 'Por favor, ingresa tu Pay ID de Binance para registrar la transacción.',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }
                    if (this.selectedPaymentMethod === 'Pago Móvil' && {{ $company['pagomovil_enabled'] ? 'true' : 'false' }}) {
                        if (!this.pagomovilReference.trim()) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Referencia Requerida',
                                text: 'Por favor, ingresa los últimos 4-6 dígitos de la referencia de tu pago móvil.',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }
                    if (this.selectedPaymentMethod === 'Cashea') {
                        if (!this.casheaConfirmed) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Confirma Cashea',
                                text: 'Marca la casilla confirmando que pagarás con Cashea (QR).',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }
                    if (this.selectedPaymentMethod === 'Cashea Link') {
                        if (!this.casheaLinkConfirmed) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Confirma Cashea Link',
                                text: 'Marca la casilla confirmando que usarás el enlace de pago Cashea.',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }
                    if (this.selectedPaymentMethod === 'Krece') {
                        if (!this.kreceConfirmed) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Confirma Krece',
                                text: 'Marca la casilla confirmando que pagarás con Krece (QR).',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }
                    if (this.selectedPaymentMethod === 'Krece Link') {
                        if (!this.kreceLinkConfirmed) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Confirma Krece Link',
                                text: 'Marca la casilla confirmando que usarás el enlace de pago Krece.',
                                confirmButtonColor: 'var(--color-primary)'
                            });
                            return;
                        }
                    }

                    if (this.deliveryType === 'dine_in' && !this.tableNumber) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Mesa Requerida',
                            text: 'Por favor, ingresa el número de mesa para tu consumo.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }
                    if (this.deliveryType === 'delivery' && (!this.storeLat || !this.storeLng)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Servicio no disponible',
                            text: 'El servicio de delivery no está disponible. Coordenadas de tienda no configuradas.',
                            confirmButtonColor: 'var(--color-primary)'
                        });
                        return;
                    }

                    // Direct Gateway processing simulation & reference mapping
                    let paymentReference = null;
                    if (this.selectedPaymentMethod === 'Tarjeta' && {{ $company['stripe_enabled'] ? 'true' : 'false' }}) {
                        paymentReference = 'STRIPE-' + Math.random().toString(36).substr(2, 9).toUpperCase();
                    } else if (this.selectedPaymentMethod === 'Binance' && {{ $company['binance_enabled'] ? 'true' : 'false' }}) {
                        paymentReference = 'BINANCE-' + this.binancePayId.trim().toUpperCase();
                    } else if (this.selectedPaymentMethod === 'Pago Móvil' && {{ $company['pagomovil_enabled'] ? 'true' : 'false' }}) {
                        paymentReference = 'PM-' + this.pagomovilReference.trim().toUpperCase();
                    } else if (this.selectedPaymentMethod === 'Cashea') {
                        paymentReference = 'CASHEA-QR';
                    } else if (this.selectedPaymentMethod === 'Cashea Link') {
                        paymentReference = 'CASHEA-LINK';
                    }

                    // Mostrar SweetAlert2 Cargando
                    Swal.fire({
                        title: paymentReference && this.selectedPaymentMethod === 'Tarjeta' ? 'Procesando pago con Stripe...' : 'Procesando pedido...',
                        text: paymentReference && this.selectedPaymentMethod === 'Tarjeta' ? 'Autorizando tarjeta con la pasarela bancaria, por favor espera.' : 'Estamos registrando tu orden, por favor espera.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Simulated sleep for premium UI gateway feel (1.5 seconds)
                    if (paymentReference && this.selectedPaymentMethod === 'Tarjeta') {
                        await new Promise(resolve => setTimeout(resolve, 1500));
                    }

                    try {
                        await fetch('/{{ $company['slug'] }}/clients/quick-register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                name: this.customerName,
                                phone: this.customerPhone
                            })
                        });
                    } catch (e) {
                        console.error('Error en quick-register:', e);
                    }

                    // Notificar orden al backend para generar alerta y registrar en el sistema
                    const orderTotal = Math.max(this.total - this.discountAmount + this.actualDeliveryCost, 0);
                    try {
                        await fetch('/{{ $company['slug'] }}/orders/notify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                                },
                            body: JSON.stringify({
                                customer_name: this.customerName,
                                customer_phone: this.customerPhone,
                                total: orderTotal,
                                delivery_type: this.deliveryType,
                                table_number: this.tableNumber,
                                payment_method: this.selectedPaymentMethod,
                                coupon_code: this.appliedCoupon ? this.appliedCoupon.code : null,
                                payment_reference: paymentReference
                            })
                        });
                    } catch (e) {
                        console.error('Error registrando notificación de orden:', e);
                    }

                    let text = `*Pedido de ${this.customerName}*%0A`;
                    text += `*Teléfono:* ${this.customerPhone}%0A`;
                    text += `*Tipo:* ${this.deliveryType === 'delivery' ? 'Delivery' : (this.deliveryType === 'dine_in' ? 'Consumo en Mesa' : 'Retiro en local')}%0A`;
                    if (this.deliveryType === 'dine_in' && this.tableNumber) {
                        text += `📍 *Mesa:* #${this.tableNumber}%0A`;
                    }
                    if (this.selectedPaymentMethod) {
                        text += `*Método de Pago:* ${this.selectedPaymentMethod}%0A`;
                        if (paymentReference) {
                            text += `*Ref. de Pago:* ${paymentReference}%0A`;
                        }
                    }
                    text += `%0A`;

                    this.cart.forEach(i => {
                        text +=
                            `▫️ ${i.quantity}x ${i.name} - ${this.currencySymbol}${(i.price * i.quantity).toFixed(2)}%0A`;
                    });

                    if (this.appliedCoupon) {
                        text += `%0A*Subtotal:* ${this.currencySymbol}${this.total.toFixed(2)}`;
                        text +=
                            `%0A*Cupón [${this.appliedCoupon.code}]:* -${this.currencySymbol}${this.discountAmount.toFixed(2)}`;
                    }

                    if (this.deliveryType === 'delivery' && this.marker) {
                        const shippingText = this.actualDeliveryCost === 0 ? '¡Gratis! 🎁' :
                            `${this.currencySymbol}${this.actualDeliveryCost.toFixed(2)}`;
                        text += `%0A*Costo de Envío:* ${shippingText}`;
                        text +=
                            `%0A*Ubicación:* https://www.google.com/maps?q=${this.marker.getLatLng().lat},${this.marker.getLatLng().lng}`;
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
                                window.open(
                                    `https://wa.me/{{ $whatsapps[0]['number'] ?? preg_replace('/[^0-9]/', '', $company['whatsapp']) }}?text=${text}`,
                                    '_blank');
                            }
                        });
                    }
                },

                shareMenu() {
                    const shareUrl = window.location.href;
                    const shareTitle =
                        `Menú de ${this.$el.querySelector('h1')?.textContent.trim() || '{{ $company['name'] }}'}`;
                    const shareText =
                        `Descubre el menú en ${this.$el.querySelector('h1')?.textContent.trim() || '{{ $company['name'] }}'}`;

                    if (navigator.share) {
                        navigator.share({
                            title: shareTitle,
                            text: shareText,
                            url: shareUrl
                        }).catch(() => {
                            // Ignorar errores al cerrar el diálogo de compartir
                        });
                        return;
                    }

                    navigator.clipboard.writeText(shareUrl).then(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Enlace copiado al portapapeles',
                            showConfirmButton: false,
                            timer: 1800,
                            timerProgressBar: true
                        });
                    }).catch(() => {
                        Swal.fire({
                            icon: 'info',
                            title: 'Comparte este menú',
                            text: shareUrl,
                            confirmButtonColor: 'var(--color-primary)'
                        });
                    });
                },

                redirectToOrderWhatsApp(waNumber) {
                    this.showOrderWhatsappModal = false;
                    window.open(`https://wa.me/${waNumber}?text=${this.pendingOrderMessage}`, '_blank');
                },

                async applyCouponCode() {
                    if (this.appliedCoupon !== null) {
                        this.appliedCoupon = null;
                        this.couponCode = '';
                        this.couponError = '';
                        return;
                    }

                    const code = this.couponCode.trim().toUpperCase();
                    if (!code) return;

                    this.couponError = '';

                    try {
                        const response = await fetch(`/{{ $company['slug'] }}/coupons/validate`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                code: code,
                                subtotal: this.total
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            this.appliedCoupon = data.coupon;
                        } else {
                            this.couponError = data.message || 'Código de cupón inválido.';
                            this.appliedCoupon = null;
                        }
                    } catch (e) {
                        this.couponError = 'Error al conectar con el servidor.';
                        this.appliedCoupon = null;
                    }
                },

                applyAccessibilitySettings() {
                    document.documentElement.style.fontSize = this.accessibility.fontSize + 'px';
                    const body = document.body;
                    body.classList.remove('daltonism-protanopia', 'daltonism-deuteranopia', 'daltonism-tritanopia',
                        'daltonism-monochromacy');
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
                <feColorMatrix type="matrix"
                    values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
            <filter id="deuteranopia">
                <feColorMatrix type="matrix"
                    values="0.625, 0.375, 0, 0, 0, 0.7, 0.3, 0, 0, 0, 0, 0.3, 0.7, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
            <filter id="tritanopia">
                <feColorMatrix type="matrix"
                    values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 0, 1, 0" />
            </filter>
        </defs>
    </svg>

    @if (isset($announcements) && count($announcements) > 0)
        <!-- COMPONENTE: AnnouncementBanner (ANUNCIOS DESTACADOS) -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[2000]" x-show="showAnnouncementModal"
            @click="showAnnouncementModal = false; sessionStorage.setItem('announcements_closed', 'true')"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[92%] max-w-sm bg-white/95 backdrop-blur-xl rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.18)] z-[2001] flex flex-col overflow-hidden origin-center border border-white/50"
            x-show="showAnnouncementModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" style="display: none;">

            <!-- Botón de Cerrar (X) -->
            <button @click="showAnnouncementModal = false; sessionStorage.setItem('announcements_closed', 'true')"
                class="absolute top-4 right-4 z-50 text-slate-400 hover:text-slate-700 bg-slate-100/80 hover:bg-slate-200 w-8 h-8 flex items-center justify-center rounded-full transition active:scale-95 shadow-sm border border-slate-200/30">
                <i class="fas fa-times text-sm"></i>
            </button>

            <div class="relative w-full overflow-hidden flex-grow flex flex-col pt-6 pb-2">
                <!-- Cabecera del Anuncio -->
                <div class="flex items-center gap-2.5 px-6 mb-2 select-none">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs shadow-inner"
                        style="background-color: rgba(230, 0, 103, 0.1); color: var(--color-primary);">
                        <i class="fas fa-bullhorn animate-bounce text-xs"></i>
                    </div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Anuncio
                        Importante</span>
                </div>

                <!-- Carrusel de Anuncios -->
                <div class="relative flex-grow flex items-center justify-center min-h-[300px]">
                    <template x-for="(ann, idx) in announcements" :key="ann.id">
                        <div x-show="activeAnnouncementSlide === idx"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-8"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-200 absolute"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-8"
                            class="w-full flex flex-col px-6 pb-4 pt-2 items-center text-center space-y-4">

                            <!-- Imagen (si existe) -->
                            <template x-if="ann.image_path">
                                <div
                                    class="w-full h-40 rounded-2xl overflow-hidden shadow-inner border border-slate-100 bg-slate-50 shrink-0">
                                    <img :src="ann.image_path" class="w-full h-full object-cover" alt="Anuncio">
                                </div>
                            </template>

                            <!-- Texto -->
                            <div class="space-y-2 flex-grow">
                                <h3 class="text-md font-black text-slate-800 tracking-tight leading-snug"
                                    x-text="ann.title"></h3>
                                <p class="text-xs text-slate-550 leading-relaxed font-semibold max-h-[120px] overflow-y-auto scrollbar-none"
                                    x-text="ann.content" x-show="ann.content"></p>
                            </div>

                            <!-- Botón de Acción (si existe) -->
                            <template x-if="ann.button_text && ann.button_link">
                                <a :href="ann.button_link"
                                    class="w-full inline-flex items-center justify-center py-3 px-6 rounded-2xl text-white font-extrabold text-xs shadow-md transition-all duration-300 hover:scale-[1.01] active:scale-95 cursor-pointer mt-2"
                                    style="background-color: var(--color-primary);" x-text="ann.button_text"></a>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Controles y Puntos del Carrusel -->
                <div class="px-6 py-2 flex items-center justify-between border-t border-slate-100 select-none shrink-0"
                    x-show="announcements.length > 1">
                    <!-- Anterior -->
                    <button type="button"
                        @click="activeAnnouncementSlide = (activeAnnouncementSlide - 1 + announcements.length) % announcements.length"
                        class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-550 flex items-center justify-center font-bold text-xs transition active:scale-75 shadow-sm border border-slate-200/30">
                        <i class="fas fa-chevron-left text-[9px]"></i>
                    </button>

                    <!-- Puntos Indicadores -->
                    <div class="flex gap-1.5 py-1">
                        <template x-for="(ann, idx) in announcements" :key="idx">
                            <button type="button" @click="activeAnnouncementSlide = idx"
                                class="w-1.5 h-1.5 rounded-full transition-all duration-300"
                                :class="activeAnnouncementSlide === idx ? 'w-4' : 'bg-slate-350'"
                                :style="activeAnnouncementSlide === idx ? 'background-color: var(--color-primary);' : ''"></button>
                        </template>
                    </div>

                    <!-- Siguiente -->
                    <button type="button"
                        @click="activeAnnouncementSlide = (activeAnnouncementSlide + 1) % announcements.length"
                        class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-550 flex items-center justify-center font-bold text-xs transition active:scale-75 shadow-sm border border-slate-200/30">
                        <i class="fas fa-chevron-right text-[9px]"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
</body>

</html>
