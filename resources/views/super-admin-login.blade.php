<!DOCTYPE html>
<html lang="es" class="wistore-ui">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Super Admin - WYDEX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('partials.global.wistore-scrollbar')
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at center, #1b0f3e 0%, #060312 100%);
            min-height: 100vh;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .neon-border {
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.3);
        }
        .neon-btn {
            background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
        }
        .neon-btn:hover {
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.6);
            transform: translateY(-2px);
        }
        .neon-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="text-slate-100 flex items-center justify-center p-4 overflow-hidden relative">

    <!-- Decorative Glows -->
    <div class="absolute w-[500px] h-[500px] bg-violet-600/10 rounded-full blur-3xl -top-40 -left-40 pointer-events-none"></div>
    <div class="absolute w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-3xl -bottom-40 -right-40 pointer-events-none"></div>

    <main class="w-full max-w-md relative z-10" x-data="{ showPassword: false }">
        
        <!-- Logo Header -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center shadow-2xl shadow-violet-500/35 mb-4">
                <i class="fas fa-cubes text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black tracking-tight bg-gradient-to-r from-white via-slate-100 to-violet-400 bg-clip-text text-transparent">WYDEX SaaS</h1>
            <span class="text-[11px] text-violet-400 font-extrabold uppercase tracking-widest mt-1">Super Admin Gate</span>
        </div>

        <!-- Login Card -->
        <div class="glass-panel rounded-3xl p-6 md:p-8 neon-border shadow-2xl">
            
            <h2 class="text-base font-bold text-white mb-2 flex items-center gap-2">
                <i class="fas fa-shield-halved text-violet-400"></i>
                <span>Verificación de Seguridad</span>
            </h2>
            <p class="text-xs text-slate-400 mb-6">Esta zona es restringida para personal autorizado de la plataforma.</p>

            <!-- Alerts / Errors -->
            @if(session('success'))
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 flex items-center gap-2.5 text-xs font-semibold">
                    <i class="fas fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/25 text-rose-450 flex items-center gap-2.5 text-xs font-semibold">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('super-admin.login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-2">Contraseña del Sistema</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500 pointer-events-none">
                            <i class="fas fa-lock text-xs"></i>
                        </span>
                        
                        <input :type="showPassword ? 'text' : 'password'" name="password" required autofocus placeholder="Introduce la contraseña secreta"
                               class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-10 text-sm text-white placeholder-slate-650 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition duration-200">
                        
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-450 hover:text-white transition duration-200">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full neon-btn py-3 px-4 rounded-xl text-xs font-extrabold text-white flex items-center justify-center gap-2 transition duration-200">
                    <i class="fas fa-key"></i>
                    <span>Acceder al Panel</span>
                </button>
            </form>
        </div>

        <!-- Footer Info -->
        <p class="text-center text-[10px] text-slate-500 mt-8 uppercase tracking-wider font-semibold">
            &copy; {{ date('Y') }} Wydex SaaS. Todos los derechos reservados.
        </p>

    </main>

</body>
</html>
