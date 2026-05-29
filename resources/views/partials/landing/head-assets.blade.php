@include('partials.landing.critical-css')

{{-- Tailwind compilado — npm run build:landing (public/build/landing.css; no está en git si falta el ! en .gitignore) --}}
@php
    $landingCssBuilt = file_exists(public_path('build/landing.css'));
@endphp
@if ($landingCssBuilt)
    <link rel="preload" href="{{ asset('build/landing.css') }}?v={{ filemtime(public_path('build/landing.css')) }}" as="style">
    <link rel="stylesheet" href="{{ asset('build/landing.css') }}?v={{ filemtime(public_path('build/landing.css')) }}">
@else
    {{-- Fallback si el deploy no incluyó el build (ejecutar: npm ci && npm run build:landing) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f5f3ff', 100: '#ede9fe', 500: '#6366f1',
                            600: '#4f46e5', 700: '#4338ca', 900: '#312e81',
                        },
                    },
                },
            },
        };
    </script>
@endif

{{-- Fuentes: no bloquean el primer paint --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" media="print" onload="this.media='all'">
<noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap">
</noscript>

{{-- Font Awesome: carga diferida (solo iconos; ~70KB) --}}
<link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
<noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</noscript>

@include('partials.landing.tutorial-video-script')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
