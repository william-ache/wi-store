<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Acceso Super Admin - WYDEX</title>

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.motion-styles')
    <style>
        .super-admin-login-page {
            min-height: 100vh;
            min-height: 100dvh;
            color: #1e293b;
            background: #ffffff;
        }
        .super-admin-login-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow:
                0 4px 24px rgba(15, 23, 42, 0.06),
                0 0 0 1px rgba(255, 255, 255, 0.9);
        }
        .super-admin-login-input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
        }
        .super-admin-login-input::placeholder {
            color: #94a3b8;
        }
        .super-admin-login-input:focus {
            outline: none;
            border-color: rgba(147, 51, 234, 0.45);
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.12);
            background: #ffffff;
        }
        .super-admin-login-btn {
            background: linear-gradient(135deg, #9333ea 0%, #0891b2 100%);
            box-shadow: 0 4px 14px rgba(147, 51, 234, 0.25);
            transition: filter 0.2s ease, transform 0.15s ease;
        }
        .super-admin-login-btn:hover {
            filter: brightness(1.05);
        }
        .super-admin-login-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="super-admin-login-page flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden selection:bg-purple-200 selection:text-slate-900">

    @include('partials.landing.page-hero-background')

    <div class="absolute w-[28rem] h-[28rem] bg-purple-400/8 rounded-full blur-3xl -top-32 -left-32 pointer-events-none" aria-hidden="true"></div>
    <div class="absolute w-[28rem] h-[28rem] bg-cyan-400/8 rounded-full blur-3xl -bottom-32 -right-32 pointer-events-none" aria-hidden="true"></div>

    <main class="w-full max-w-md relative z-10" x-data="{ showPassword: false }">

        <div class="flex flex-col items-center mb-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-purple-500/25 mb-4">
                <i class="fas fa-cubes text-white text-3xl" aria-hidden="true"></i>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">WYDEX SaaS</h1>
            <span class="text-[11px] text-slate-600 font-extrabold uppercase tracking-widest mt-1">Super Admin Gate</span>
        </div>

        <div class="super-admin-login-card rounded-[2rem] p-8 md:p-10">

            <h2 class="text-base font-bold text-slate-900 mb-2 flex items-center gap-2">
                <i class="fas fa-shield-halved text-purple-600 text-sm" aria-hidden="true"></i>
                <span>Verificación de Seguridad</span>
            </h2>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed">Esta zona es restringida para personal autorizado de la plataforma.</p>

            @if(session('success'))
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-2.5 text-xs font-semibold">
                    <i class="fas fa-circle-check" aria-hidden="true"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 flex items-center gap-2.5 text-xs font-semibold">
                    <i class="fas fa-circle-exclamation" aria-hidden="true"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('super-admin.login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 pl-0.5">Contraseña del Sistema</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none" aria-hidden="true">
                            <i class="fas fa-lock text-xs"></i>
                        </span>

                        <input :type="showPassword ? 'text' : 'password'" name="password" required autofocus
                               placeholder="Introduce la contraseña secreta"
                               class="super-admin-login-input w-full rounded-xl py-3 pl-10 pr-10 text-sm transition duration-200">

                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 transition duration-200"
                                :aria-label="showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="super-admin-login-btn w-full py-3 px-4 rounded-xl text-xs font-extrabold text-white flex items-center justify-center gap-2">
                    <i class="fas fa-key" aria-hidden="true"></i>
                    <span>Acceder al Panel</span>
                </button>
            </form>
        </div>

        <p class="text-center text-[10px] text-slate-400 mt-8 uppercase tracking-wider font-semibold">
            &copy; {{ date('Y') }} Wydex SaaS. Todos los derechos reservados.
        </p>

    </main>
</body>
</html>
