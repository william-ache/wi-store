<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | WIStore Admin</title>

    <!-- Tailwind CSS (CDN) -->
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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts (Outfit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #070913;
        }
        /* GPU hardware acceleration for ultra smooth scrolling on heavy blurs */
        .gpu-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: transform;
        }
        .blur-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: filter;
        }
    </style>
</head>
<body class="min-h-screen text-slate-100 flex flex-col justify-between relative overflow-hidden selection:bg-purple-500 selection:text-white">

    <!-- ============================================== -->
    <!-- CAPA DE FONDO GLOBAL (Base Canvas & Neón - Match Landing) -->
    <!-- ============================================== -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        
        <!-- 1. Destellos de Luz (Auras/Glows) -->
        <!-- Glow Top Right -->
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated"></div>
        
        <!-- Glow Middle Left -->
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] blur-accelerated"></div>

        <!-- Glow Bottom Center -->
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated"></div>

        <!-- 2. Ondas Fluidas de Neón (SVG Abstract Mesh) -->
        <svg class="absolute inset-0 w-full h-full opacity-40" preserveAspectRatio="none" viewBox="0 0 1440 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Gradiente Cian a Morado -->
                <linearGradient id="neonGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.8" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#a855f7" stop-opacity="0" />
                </linearGradient>
                <!-- Gradiente Morado a Rosa -->
                <linearGradient id="neonGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                    <stop offset="50%" stop-color="#ec4899" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0" />
                </linearGradient>
            </defs>

            <!-- Curvas Bezier Entrelazadas imitando estelas de luz -->
            <path d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800" stroke="url(#neonGradient1)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000" stroke="url(#neonGradient2)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100" stroke="url(#neonGradient2)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.6" />
            <path d="M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300" stroke="url(#neonGradient1)" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.4" />
        </svg>
    </div>

    <!-- Header / Logo -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <a href="/" class="flex items-center gap-2 group transition-transform duration-300 active:scale-95">
            <span class="text-xl font-black text-white tracking-wider uppercase">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span>
            </span>
        </a>
        <a href="/" class="text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1.5 transition-colors group">
            <i class="fas fa-arrow-left text-[10px] group-hover:-translate-x-0.5 transition-transform"></i>
            Volver al Inicio
        </a>
    </header>

    <!-- Main Container -->
    <main class="flex-grow flex items-center justify-center px-4 py-8 relative z-10" x-data="{ showPassword: false }">
        <div class="w-full max-w-md bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-10 shadow-2xl relative group overflow-hidden">
            
            <!-- Destello de esquina -->
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-purple-500/15 rounded-full blur-2xl pointer-events-none transition-all duration-700 group-hover:bg-cyan-500/15"></div>

            <div class="text-center mb-8 relative z-10">
                <span class="inline-block bg-purple-600/20 text-purple-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.15)] mb-4">
                    Centro de Control
                </span>
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Acceso Administrativo</h1>
                <p class="text-xs text-slate-400 mt-2 max-w-xs mx-auto leading-relaxed">
                    Ingresa tus credenciales para gestionar tu tienda, actualizar tu catálogo e interactuar con tus clientes.
                </p>
            </div>

            <!-- Formulario de Login -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5 relative z-10">
                @csrf

                <!-- Campo: Email -->
                <div class="space-y-1.5">
                    <label for="email" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-500">
                            <i class="fas fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" name="email" required autofocus
                               placeholder="admin@tu-marca.com"
                               class="w-full bg-slate-900/80 border border-slate-800/80 rounded-2xl px-4 py-3 pl-11 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all shadow-inner">
                    </div>
                    @error('email')
                        <p class="text-[10px] text-rose-500 font-bold mt-1 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Contraseña -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-[11px] font-black uppercase tracking-wider text-slate-400">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-cyan-400 hover:text-cyan-300 transition-colors">¿La olvidaste?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-500">
                            <i class="fas fa-lock text-xs"></i>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                               placeholder="••••••••••••"
                               class="w-full bg-slate-900/80 border border-slate-800/80 rounded-2xl px-4 py-3 pl-11 pr-10 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all shadow-inner">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-3 text-slate-500 hover:text-white transition-colors focus:outline-none">
                            <i :class="showPassword ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[10px] text-rose-500 font-bold mt-1 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recordar Sesión -->
                <div class="flex items-center justify-between pl-1 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group select-none">
                        <input type="checkbox" name="remember" id="remember"
                               class="rounded bg-slate-900 border-slate-800 text-purple-600 focus:ring-purple-500/30 focus:ring-offset-slate-950 transition-all">
                        <span class="text-[11px] font-bold text-slate-400 group-hover:text-slate-300 transition-colors">Recordar mi sesión</span>
                    </label>
                </div>

                <!-- Botón de Envío -->
                <div class="pt-2">
                    <button type="submit"
                            class="block w-full text-center bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-extrabold py-3.5 rounded-2xl transition-all duration-300 text-xs shadow-[0_0_15px_rgba(168,85,247,0.3)] transform active:scale-[0.98]">
                        Iniciar Sesión
                    </button>
                </div>
            </form>



        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-xs text-slate-500 relative z-10 border-t border-white/5 bg-transparent">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© 2026 WIStore. Todos los derechos reservados.</p>
            <div class="flex items-center gap-6">
                <a href="{{ route('legal.privacidad') }}" class="hover:text-white transition-colors">Políticas y Privacidad</a>
                <span>•</span>
                <a href="{{ route('contacto') }}" class="hover:text-white transition-colors">Contacto</a>
            </div>
        </div>
    </footer>

</body>
</html>
