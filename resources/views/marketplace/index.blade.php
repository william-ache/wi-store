<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @include('partials.seo.head', ['seo' => \App\Support\SeoMeta::forMarketplace()])

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.ux-styles')
    @include('partials.landing.motion-styles')
    @include('partials.marketplace.chrome-script')
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #ffffff;
            color: #1e293b;
            -webkit-tap-highlight-color: transparent;
        }
        .marketplace-soon {
            max-width: 42rem;
            margin: 0 auto;
            padding-inline: 0.25rem;
        }
        @media (min-width: 640px) {
            .marketplace-soon {
                padding-inline: 0.5rem;
            }
        }
        .marketplace-soon__card {
            position: relative;
            overflow: hidden;
        }
        .marketplace-soon__card::before {
            content: '';
            position: absolute;
            inset: -40% -20% auto;
            height: 55%;
            background: radial-gradient(ellipse at 50% 0%, rgba(147, 51, 234, 0.08), transparent 70%);
            pointer-events: none;
        }
        .marketplace-soon__card > * {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
@php
    $landingNavExternal = true;
@endphp
<body class="flex flex-col min-h-screen min-h-[100dvh] relative overflow-x-hidden selection:bg-purple-200 selection:text-slate-900"
      x-data="marketplaceChrome()" x-init="init()">

    @include('partials.landing.page-hero-background')

    @include('partials.landing.landing-header')

    @include('partials.landing.ux-chrome')

    <main class="flex-grow relative z-10 flex flex-col justify-center max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
        <div class="flex justify-end mb-6 md:mb-0 md:absolute md:top-10 md:right-6 lg:right-8">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-purple-700 hover:text-cyan-700 transition-colors shrink-0">
                <i class="fas fa-arrow-left text-[10px]" aria-hidden="true"></i> Volver a la landing
            </a>
        </div>

        @include('partials.marketplace.coming-soon')
    </main>

    @include('partials.landing.light-footer')

    @include('partials.public.chat')
</body>
</html>
