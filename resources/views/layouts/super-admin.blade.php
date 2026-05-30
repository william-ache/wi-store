<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Panel Super Admin — WI-Store')</title>

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.motion-styles')

    @include('partials.super-admin.styles')
    @stack('styles')
</head>
<body class="sa-page flex flex-col min-h-screen min-h-[100dvh] text-slate-800" @stack('body-attributes')>

    @include('partials.super-admin.navbar', [
        'pendingCount' => isset($pendingShops) ? $pendingShops->count() : 0,
    ])

    <div class="sa-shell flex flex-1 w-full max-w-[100rem] mx-auto">
        @include('partials.super-admin.sidebar', [
            'activeModule' => $activeModule ?? '',
        ])

        <div class="sa-main flex-1 min-w-0 flex flex-col">
            <div class="sa-main__inner flex-1 px-4 py-6 md:px-8 md:py-8 lg:px-10">
                @hasSection('page-header')
                    <div class="sa-page-header mb-6">
                        @yield('page-header')
                    </div>
                @endif

                @if (session('success'))
                    <div class="sa-alert sa-alert--success mb-6">
                        <i class="fas fa-circle-check" aria-hidden="true"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="sa-alert sa-alert--error mb-6">
                        <i class="fas fa-circle-exclamation" aria-hidden="true"></i>
                        <div>
                            <p class="font-bold text-sm">Corrige los siguientes errores:</p>
                            <ul class="list-disc pl-5 mt-2 text-xs space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
</body>
</html>
