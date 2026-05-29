<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Iniciar Sesión | WI-Store Admin</title>

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.motion-styles')
    @include('partials.landing.ux-styles')

    <style>
        .auth-login-page {
            min-height: 100vh;
            min-height: 100dvh;
            color: #1e293b;
            background: #ffffff;
        }
        .auth-login-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow:
                0 4px 24px rgba(15, 23, 42, 0.06),
                0 0 0 1px rgba(255, 255, 255, 0.8);
        }
        .auth-login-input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
        }
        .auth-login-input::placeholder {
            color: #94a3b8;
        }
        .auth-login-input:focus {
            outline: none;
            border-color: rgba(147, 51, 234, 0.45);
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.12);
            background: #ffffff;
        }
    </style>
</head>
@php
    $landingNavExternal = true;
    $hideLoginNavLink = true;
    $shopsWithCategories = $shopsWithCategories ?? collect();
@endphp
<body class="auth-login-page flex flex-col min-h-screen relative overflow-x-hidden selection:bg-purple-200 selection:text-slate-900"
      x-data="landingPage()" x-init="init()">

    @include('partials.landing.page-hero-background')

    @include('partials.landing.landing-header')

    @include('partials.landing.ux-chrome')

    <main class="flex-grow flex items-center justify-center px-4 py-6 md:py-10 relative z-10" x-data="{ showPassword: false }">
        <div class="w-full max-w-md auth-login-card rounded-[2rem] p-8 md:p-10 relative">

            <div class="text-center mb-8">
                <span class="inline-block text-[10px] uppercase font-black tracking-widest px-3 py-1.5 rounded-full border border-purple-200 bg-purple-50 text-purple-700 mb-4">
                    Centro de Control
                </span>
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Acceso Administrativo</h1>
                <p class="text-xs text-slate-500 mt-2 max-w-xs mx-auto leading-relaxed">
                    Ingresa tus credenciales para gestionar tu tienda, actualizar tu catálogo e interactuar con tus clientes.
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="text-[11px] font-black uppercase tracking-wider text-slate-500 block pl-1">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400" aria-hidden="true">
                            <i class="fas fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" required autofocus
                               placeholder="tu-correo@gmail.com"
                               value="{{ old('email') }}"
                               class="auth-login-input w-full rounded-2xl px-4 py-3 pl-11 text-xs transition-all">
                    </div>
                    @error('email')
                        <p class="text-[10px] text-rose-600 font-bold mt-1 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-[11px] font-black uppercase tracking-wider text-slate-500">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-cyan-700 hover:text-purple-700 transition-colors">¿La olvidaste?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400" aria-hidden="true">
                            <i class="fas fa-lock text-xs"></i>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                               placeholder="••••••••••••"
                               class="auth-login-input w-full rounded-2xl px-4 py-3 pl-11 pr-10 text-xs transition-all">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-3 text-slate-400 hover:text-slate-700 transition-colors focus:outline-none"
                                aria-label="Mostrar u ocultar contraseña">
                            <i :class="showPassword ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[10px] text-rose-600 font-bold mt-1 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pl-1 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group select-none">
                        <input type="checkbox" name="remember" id="remember"
                               class="rounded border-slate-300 text-purple-600 focus:ring-purple-500/30 focus:ring-offset-white">
                        <span class="text-[11px] font-bold text-slate-500 group-hover:text-slate-700 transition-colors">Recordar mi sesión</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="landing-plan-btn landing-plan-btn--negocio block w-full text-center text-white font-extrabold py-3.5 rounded-2xl text-xs transition-all active:scale-[0.98]">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </main>

    @include('partials.landing.light-footer')

    @include('partials.public.chat')

    @include('partials.landing.ux-script')
</body>
</html>
