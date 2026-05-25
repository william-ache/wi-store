<!DOCTYPE html>
<html lang="es" class="scroll-smooth wistore-ui">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Prueba Gratis 7 Días | WIStore</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('partials.global.wistore-scrollbar')
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #070913;
        }

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

        @keyframes wave-1 {

            0%,
            100% {
                d: path("M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800");
            }

            33% {
                d: path("M-100,130 C170,260 430,-60 820,170 C1180,530 1330,860 1500,830");
            }

            66% {
                d: path("M-100,70 C230,340 370,-140 780,230 C1220,470 1270,940 1500,770");
            }
        }

        @keyframes wave-2 {

            0%,
            100% {
                d: path("M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950");
            }

            33% {
                d: path("M-50,170 C280,360 470,90 920,360 C1270,780 1230,1010 1600,920");
            }

            66% {
                d: path("M-50,230 C220,440 530,10 880,440 C1330,720 1170,1090 1600,980");
            }
        }

        @keyframes wave-3 {

            0%,
            100% {
                d: path("M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000");
            }

            50% {
                d: path("M1500,-20 C1070,180 970,470 630,570 C170,730 30,1070 -200,1030");
            }
        }

        @keyframes wave-4 {

            0%,
            100% {
                d: path("M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100");
            }

            33% {
                d: path("M1550,80 C1120,280 870,370 530,670 C70,1030 -70,870 -250,1130");
            }

            66% {
                d: path("M1550,20 C1180,220 930,430 470,730 C130,970 -130,930 -250,1070");
            }
        }

        @keyframes wave-5 {

            0%,
            100% {
                d: path("M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300");
            }

            50% {
                d: path("M-100,770 C330,570 470,930 870,830 C1330,670 1370,230 1600,270");
            }
        }

        .animate-wave-1 {
            animation: wave-1 8s ease-in-out infinite;
        }

        .animate-wave-2 {
            animation: wave-2 10s ease-in-out infinite;
        }

        .animate-wave-3 {
            animation: wave-3 12s ease-in-out infinite;
        }

        .animate-wave-4 {
            animation: wave-4 14s ease-in-out infinite;
        }

        .animate-wave-5 {
            animation: wave-5 16s ease-in-out infinite;
        }

        input[type="color"] {
            -webkit-appearance: none;
            width: 100%;
            height: 100%;
            border: none;
            cursor: pointer;
            background: transparent;
            padding: 0;
        }

        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
            border-radius: 50%;
        }

        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 50%;
        }

        /* Barra de seguridad */
        .strength-bar-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1), background 0.5s ease;
        }

        @keyframes spin-slow {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 1s linear infinite;
        }

        .field-valid {
            border-color: rgba(34, 197, 94, 0.5) !important;
        }

        .field-invalid {
            border-color: rgba(239, 68, 68, 0.5) !important;
        }

        .field-checking {
            border-color: rgba(14, 165, 233, 0.5) !important;
        }
    </style>
</head>

<body
    class="min-h-screen text-slate-100 flex flex-col justify-between relative overflow-x-hidden selection:bg-purple-500 selection:text-white"
    x-data="{
        /* ── Campos ──────────────────────────────── */
        shopName: '',
        email: '',
        password: '',
        confirm: '',
    
        /* ── Visibilidad ─────────────────────────── */
        showPassword: false,
        showConfirm: false,
        showTrialModal: false,
        isSubmitting: false,
    
        /* ── Colores ─────────────────────────────── */
        primaryColor: '#6366f1',
        accentColor: '#22d3ee',
        bgColor: '#070913',
        selectedPreset: 0,
        presets: [
            { primary: '#6366f1', accent: '#22d3ee', bg: '#070913', name: 'Índigo' },
            { primary: '#a855f7', accent: '#f472b6', bg: '#0d0616', name: 'Rosa' },
            { primary: '#0ea5e9', accent: '#06b6d4', bg: '#020e1a', name: 'Cielo' },
            { primary: '#10b981', accent: '#34d399', bg: '#020f0a', name: 'Esmeralda' },
            { primary: '#f59e0b', accent: '#fb923c', bg: '#120900', name: 'Ámbar' },
            { primary: '#ec4899', accent: '#a855f7', bg: '#120012', name: 'Fucsia' },
            { primary: '#ef4444', accent: '#f97316', bg: '#130202', name: 'Rojo' },
            { primary: '#e2e8f0', accent: '#94a3b8', bg: '#0f1117', name: 'Negro' },
            { primary: '#84cc16', accent: '#22d3ee', bg: '#040e02', name: 'Lima' },
            { primary: '#64748b', accent: '#cbd5e1', bg: '#0c0f13', name: 'Plata' },
            { primary: '#14b8a6', accent: '#0ea5e9', bg: '#061b23', name: 'Océano' },
            { primary: '#f97316', accent: '#facc15', bg: '#1a1205', name: 'Naranja' },
        ],
        applyPreset(i) {
            this.selectedPreset = i;
            this.primaryColor = this.presets[i].primary;
            this.accentColor = this.presets[i].accent;
            this.bgColor = this.presets[i].bg;
        },
    
        /* ── Estado nombre ───────────────────────── */
        nameStatus: 'idle',
        /* idle | checking | available | taken | short */
        _nameTimer: null,
        checkName() {
            const v = this.shopName.trim();
            clearTimeout(this._nameTimer);
            if (v.length === 0) { this.nameStatus = 'idle'; return; }
            if (v.length < 3) { this.nameStatus = 'short'; return; }
            this.nameStatus = 'checking';
            this._nameTimer = setTimeout(() => {
                /* Simulación: nombres «tomados» de ejemplo */
                const taken = ['wistore', 'demo', 'test', 'admin', 'tienda'];
                this.nameStatus = taken.includes(v.toLowerCase()) ? 'taken' : 'available';
            }, 800);
        },
        get nameBorderClass() {
            if (this.nameStatus === 'available') return 'field-valid';
            if (this.nameStatus === 'taken' || this.nameStatus === 'short') return 'field-invalid';
            if (this.nameStatus === 'checking') return 'field-checking';
            return '';
        },
    
        /* ── Estado email ────────────────────────── */
        emailTouched: false,
        get emailValid() {
            return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(this.email);
        },
        get emailBorderClass() {
            if (!this.emailTouched || this.email === '') return '';
            return this.emailValid ? 'field-valid' : 'field-invalid';
        },
    
        /* ── Seguridad contraseña ────────────────── */
        get pwLen() { return this.password.length >= 8; },
        get pwUpper() { return /[A-Z]/.test(this.password); },
        get pwNumber() { return /[0-9]/.test(this.password); },
        get pwSpecial() { return /[^A-Za-z0-9]/.test(this.password); },
        get pwScore() {
            let s = 0;
            if (this.pwLen) s++;
            if (this.pwUpper) s++;
            if (this.pwNumber) s++;
            if (this.pwSpecial) s++;
            return s;
        },
        get pwStrengthLabel() {
            if (this.password.length === 0) return '';
            if (this.pwScore <= 1) return 'Débil';
            if (this.pwScore === 2) return 'Regular';
            if (this.pwScore === 3) return 'Buena';
            return 'Fuerte';
        },
        get pwStrengthWidth() {
            if (this.password.length === 0) return '0%';
            return ['0%', '25%', '50%', '75%', '100%'][this.pwScore];
        },
        get pwStrengthGradient() {
            if (this.pwScore <= 1) return 'linear-gradient(90deg,#ef4444,#f97316)';
            if (this.pwScore === 2) return 'linear-gradient(90deg,#ef4444,#f97316,#eab308)';
            if (this.pwScore === 3) return 'linear-gradient(90deg,#ef4444,#f97316,#eab308,#84cc16)';
            return 'linear-gradient(90deg,#ef4444,#f97316,#eab308,#84cc16,#22c55e)';
        },
        get pwStrengthTextColor() {
            if (this.pwScore <= 1) return 'text-red-400';
            if (this.pwScore === 2) return 'text-yellow-400';
            if (this.pwScore === 3) return 'text-lime-400';
            return 'text-emerald-400';
        },
        get pwBorderClass() {
            if (this.password.length === 0) return '';
            if (this.pwScore <= 1) return 'field-invalid';
            if (this.pwScore === 4) return 'field-valid';
            return 'field-checking';
        },
    
        /* ── Confirmación ────────────────────────── */
        confirmTouched: false,
        get confirmMatch() {
            return this.confirm === this.password && this.confirm.length > 0;
        },
        get confirmBorderClass() {
            if (!this.confirmTouched || this.confirm === '') return '';
            return this.confirmMatch ? 'field-valid' : 'field-invalid';
        },
    
        /* ── Formulario ──────────────────────────── */
        get formValid() {
            return this.nameStatus === 'available' &&
                this.emailValid &&
                this.pwScore >= 2 &&
                this.confirmMatch;
        },
        submitForm() {
            if (!this.formValid) return;
            this.showTrialModal = true;
        }
    }">

    <!-- FONDO -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        <div
            class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated">
        </div>
        <div
            class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-purple-500/10 to-cyan-600/10 blur-[160px] blur-accelerated">
        </div>
        <div
            class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated">
        </div>
        <svg class="absolute inset-0 w-full h-full opacity-40" preserveAspectRatio="none" viewBox="0 0 1440 1024"
            fill="none">
            <defs>
                <linearGradient id="ng1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.8" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#a855f7" stop-opacity="0" />
                </linearGradient>
                <linearGradient id="ng2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                    <stop offset="50%" stop-color="#ec4899" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0" />
                </linearGradient>
            </defs>
            <path class="animate-wave-1" d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800"
                stroke="url(#ng1)" stroke-width="1.5" fill="none" />
            <path class="animate-wave-2" d="M-50,200 C250,400 500,50 900,400 C1300,750 1200,1050 1600,950"
                stroke="url(#ng1)" stroke-width="1" fill="none" opacity="0.6" />
            <path class="animate-wave-3" d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000"
                stroke="url(#ng2)" stroke-width="1.5" fill="none" />
            <path class="animate-wave-4" d="M1550,50 C1150,250 900,400 500,700 C100,1000 -100,900 -250,1100"
                stroke="url(#ng2)" stroke-width="1" fill="none" opacity="0.6" />
            <path class="animate-wave-5" d="M-100,800 C300,600 500,900 900,800 C1300,700 1400,200 1600,300"
                stroke="url(#ng1)" stroke-width="1" fill="none" opacity="0.4" />
        </svg>
    </div>

    <!-- HEADER -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <a href="/" class="flex items-center gap-2 group transition-transform duration-300 active:scale-95">
            <span class="text-xl font-black text-white tracking-wider uppercase">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span>
            </span>
        </a>
        <a href="/"
            class="text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1.5 transition-colors group">
            <i class="fas fa-arrow-left text-[10px] group-hover:-translate-x-0.5 transition-transform"></i>
            Volver al Inicio
        </a>
    </header>

    <!-- MAIN -->
    <main class="flex-grow flex items-center justify-center px-4 py-8 relative z-10">
        <div class="w-full max-w-lg">

            <!-- Badge trial -->
            <div class="flex justify-center mb-5">
                <div
                    class="inline-flex items-center gap-2 bg-purple-500/10 border border-purple-500/30 rounded-full px-5 py-2 shadow-[0_0_25px_rgba(168,85,247,0.18)]">
                    <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                    <span class="text-purple-300 text-[11px] font-black uppercase tracking-widest">🎁 7 Días de Prueba
                        Gratuita — Sin Tarjeta</span>
                </div>
            </div>

            <!-- Card -->
            <div
                class="w-full bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-10 shadow-2xl relative group overflow-hidden">
                <div
                    class="absolute -top-20 -right-20 w-48 h-48 bg-purple-500/15 rounded-full blur-2xl pointer-events-none group-hover:bg-cyan-500/15 transition-all duration-700">
                </div>
                <div
                    class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-500/10 rounded-full blur-2xl pointer-events-none">
                </div>

                <div class="text-center mb-8 relative z-10">
                    <span
                        class="inline-block bg-gradient-to-r from-purple-500 to-cyan-400 text-slate-950 text-[10px] uppercase font-black tracking-widest px-5 py-1.5 rounded-full shadow-[0_0_15px_rgba(168,85,247,0.35)] mb-4">
                        Plan Premium
                    </span>
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Crea tu Catálogo Digital</h1>
                    <p class="text-xs text-slate-400 mt-2 max-w-xs mx-auto leading-relaxed">
                        Configura tu marca y comienza a vender en segundos. <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400 font-black">Gratis por 7 días.</span>
                    </p>
                </div>

                <!-- FORMULARIO -->
                <form id="registerForm" action="{{ route('register.submit') }}" method="POST" @submit.prevent="submitForm()" class="space-y-5 relative z-10">
                    @csrf
                    <div
                        class="rounded-3xl border border-purple-400/15 bg-purple-400/5 px-4 py-3 text-slate-100 text-sm font-bold tracking-wide shadow-sm shadow-purple-500/10">
                        <i class="fas fa-info-circle mr-2 text-purple-300"></i>
                        Completa los datos del formulario para iniciar tu prueba gratis de 7 días.
                    </div>

                    <!-- ── NOMBRE DEL COMERCIO ── -->
                    <div class="space-y-1.5">
                        <label for="shop_name"
                            class="text-[11px] font-black uppercase tracking-wider text-slate-300 block pl-1">
                            Nombre de tu Empresa / Comercio
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                <i class="fas fa-store text-xs"></i>
                            </span>
                            <input type="text" id="shop_name" name="shop_name" required x-model="shopName"
                                @input="checkName()" placeholder="Ej: Tienda Click, Sabores Y&B..."
                                :class="nameBorderClass"
                                class="w-full bg-slate-800/90 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-purple-500/40 transition-all shadow-inner">
                            @error('shop_name')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 pl-1">{{ $message }}</p>
                            @enderror
                            <!-- Indicador derecho -->
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs">
                                <template x-if="nameStatus === 'checking'">
                                    <i class="fas fa-circle-notch text-purple-400 animate-spin-slow"></i>
                                </template>
                                <template x-if="nameStatus === 'available'">
                                    <i class="fas fa-circle-check text-emerald-400"></i>
                                </template>
                                <template x-if="nameStatus === 'taken' || nameStatus === 'short'">
                                    <i class="fas fa-circle-xmark text-red-400"></i>
                                </template>
                            </span>
                        </div>
                        <!-- Mensajes -->
                        <div class="pl-1 text-[10px] font-bold flex items-center gap-1.5 transition-all" x-cloak>
                            <template x-if="nameStatus === 'checking'">
                                <span class="text-purple-400"><i class="fas fa-circle-notch animate-spin-slow mr-1"></i>
                                    Verificando disponibilidad...</span>
                            </template>
                            <template x-if="nameStatus === 'available'">
                                <span class="text-emerald-400"><i class="fas fa-check mr-1"></i> ¡Nombre
                                    disponible!</span>
                            </template>
                            <template x-if="nameStatus === 'taken'">
                                <span class="text-red-400"><i class="fas fa-xmark mr-1"></i> Ese nombre ya está en
                                    uso.</span>
                            </template>
                            <template x-if="nameStatus === 'short'">
                                <span class="text-amber-400"><i class="fas fa-triangle-exclamation mr-1"></i> Mínimo 3
                                    caracteres.</span>
                            </template>
                        </div>
                    </div>

                    <!-- ── CORREO ── -->
                    <div class="space-y-1.5">
                        <label for="email"
                            class="text-[11px] font-black uppercase tracking-wider text-slate-300 block pl-1">Correo
                            Electrónico</label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                            <input type="email" id="email" name="email" required x-model="email"
                                @input="emailTouched = true" placeholder="tu@correo.com" :class="emailBorderClass"
                                class="w-full bg-slate-800/90 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-purple-500/40 transition-all shadow-inner">
                            @error('email')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 pl-1">{{ $message }}</p>
                            @enderror
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs"
                                x-show="emailTouched && email.length > 0" x-cloak>
                                <i
                                    :class="emailValid ? 'fas fa-circle-check text-emerald-400' :
                                        'fas fa-circle-xmark text-red-400'"></i>
                            </span>
                        </div>
                        <div class="pl-1 text-[10px] font-bold"
                            x-show="emailTouched && email.length > 0 && !emailValid" x-cloak>
                            <span class="text-red-400"><i class="fas fa-xmark mr-1"></i> Ingresa un correo válido
                                (ejemplo@dominio.com).</span>
                        </div>
                        <div class="pl-1 text-[10px] font-bold" x-show="emailTouched && emailValid" x-cloak>
                            <span class="text-emerald-400"><i class="fas fa-check mr-1"></i> Correo con formato
                                correcto.</span>
                        </div>
                    </div>

                    <!-- ── CONTRASEÑA ── -->
                    <div class="space-y-1.5">
                        <label for="password"
                            class="text-[11px] font-black uppercase tracking-wider text-slate-300 block pl-1">Contraseña</label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                x-model="password" placeholder="Mínimo 8 caracteres" :class="pwBorderClass"
                                class="w-full bg-slate-800/90 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-purple-500/40 transition-all shadow-inner">
                            @error('password')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 pl-1">{{ $message }}</p>
                            @enderror
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors focus:outline-none">
                                <i :class="showPassword ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs'"></i>
                            </button>
                        </div>

                        <!-- Barra de seguridad + etiqueta -->
                        <div x-show="password.length > 0" x-cloak class="space-y-2 pt-1">
                            <div class="flex items-center justify-between px-1">
                                <span
                                    class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Seguridad</span>
                                <span class="text-[10px] font-black uppercase tracking-wider"
                                    :class="pwStrengthTextColor" x-text="pwStrengthLabel"></span>
                            </div>
                            <!-- Barra gradiente -->
                            <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="strength-bar-fill"
                                    :style="`width:${pwStrengthWidth}; background:${pwStrengthGradient}`">
                                </div>
                            </div>
                            <!-- Checklist de requisitos -->
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1 pt-1">
                                <div class="flex items-center gap-1.5 text-[10px]"
                                    :class="pwLen ? 'text-emerald-400' : 'text-slate-500'">
                                    <i :class="pwLen ? 'fas fa-circle-check' : 'far fa-circle'"
                                        class="text-[9px] w-3 shrink-0"></i>
                                    Mínimo 8 caracteres
                                </div>
                                <div class="flex items-center gap-1.5 text-[10px]"
                                    :class="pwUpper ? 'text-emerald-400' : 'text-slate-500'">
                                    <i :class="pwUpper ? 'fas fa-circle-check' : 'far fa-circle'"
                                        class="text-[9px] w-3 shrink-0"></i>
                                    Una mayúscula (A-Z)
                                </div>
                                <div class="flex items-center gap-1.5 text-[10px]"
                                    :class="pwNumber ? 'text-emerald-400' : 'text-slate-500'">
                                    <i :class="pwNumber ? 'fas fa-circle-check' : 'far fa-circle'"
                                        class="text-[9px] w-3 shrink-0"></i>
                                    Un número (0-9)
                                </div>
                                <div class="flex items-center gap-1.5 text-[10px]"
                                    :class="pwSpecial ? 'text-emerald-400' : 'text-slate-500'">
                                    <i :class="pwSpecial ? 'fas fa-circle-check' : 'far fa-circle'"
                                        class="text-[9px] w-3 shrink-0"></i>
                                    Un símbolo (!@#$...)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── CONFIRMAR CONTRASEÑA ── -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation"
                            class="text-[11px] font-black uppercase tracking-wider text-slate-300 block pl-1">Confirmar
                            Contraseña</label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                <i class="fas fa-shield-halved text-xs"></i>
                            </span>
                            <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation"
                                name="password_confirmation" required x-model="confirm"
                                @input="confirmTouched = true" placeholder="Repite tu contraseña"
                                :class="confirmBorderClass"
                                class="w-full bg-slate-800/90 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-purple-500/40 transition-all shadow-inner">
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors focus:outline-none">
                                <i :class="showConfirm ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs'"></i>
                            </button>
                        </div>
                        <div class="pl-1 text-[10px] font-bold" x-show="confirmTouched && confirm.length > 0" x-cloak>
                            <span x-show="confirmMatch" class="text-emerald-400"><i class="fas fa-check mr-1"></i>
                                Las contraseñas coinciden.</span>
                            <span x-show="!confirmMatch" class="text-red-400"><i class="fas fa-xmark mr-1"></i> Las
                                contraseñas no coinciden.</span>
                        </div>
                    </div>

                    <!-- ── COLORES DE MARCA ── -->
                    <div class="border-t border-white/5 pt-5">
                        <label class="text-[11px] font-black uppercase tracking-wider text-slate-300 block pl-1 mb-3">
                            <i class="fas fa-palette mr-1.5 text-purple-400"></i> Colores de tu Marca
                        </label>
                        <p class="text-[10px] text-slate-400 mb-3 pl-1 leading-snug">
                            Personalízalo tú mismo: ajusta los colores rápidos o edita cada tono manualmente usando el
                            selector.
                        </p>

                        <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold mb-2 pl-1">Paletas
                            rápidas:</p>
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 mb-4">
                            <template x-for="(preset, idx) in presets" :key="idx">
                                <button type="button" @click="applyPreset(idx)" :title="preset.name"
                                    class="w-full h-12 rounded-2xl border transition-all duration-200 flex items-center justify-center gap-2 px-2"
                                    :class="selectedPreset === idx ?
                                        'border-purple-400/60 bg-white/5 shadow-[0_0_10px_rgba(168,85,247,0.22)]' :
                                        'border-white/10 hover:border-white/20 bg-slate-950/30'">
                                    <span class="w-3 h-3 rounded-full shadow-inner"
                                        :style="`background:${preset.primary}`"></span>
                                    <span class="w-3 h-3 rounded-full shadow-inner"
                                        :style="`background:${preset.accent}`"></span>
                                    <span class="w-3 h-3 rounded-full border border-white/10"
                                        :style="`background:${preset.bg}`"></span>
                                </button>
                            </template>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div
                                class="bg-slate-900/60 border border-white/5 rounded-2xl p-3 flex flex-col items-center gap-2">
                                <span
                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Primario</span>
                                <div
                                    class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-white/20 shadow-lg cursor-pointer hover:border-white/40 transition-colors">
                                    <div class="absolute inset-0" :style="`background:${primaryColor}`"></div>
                                    <input type="color" x-model="primaryColor" name="color_primary"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <i class="fas fa-eye-dropper text-white/70 text-[8px] drop-shadow"></i>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 font-mono" x-text="primaryColor"></span>
                            </div>
                            <div
                                class="bg-slate-900/60 border border-white/5 rounded-2xl p-3 flex flex-col items-center gap-2">
                                <span
                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Acento</span>
                                <div
                                    class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-white/20 shadow-lg cursor-pointer hover:border-white/40 transition-colors">
                                    <div class="absolute inset-0" :style="`background:${accentColor}`"></div>
                                    <input type="color" x-model="accentColor" name="color_accent"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <i class="fas fa-eye-dropper text-white/70 text-[8px] drop-shadow"></i>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 font-mono" x-text="accentColor"></span>
                            </div>
                            <div
                                class="bg-slate-900/60 border border-white/5 rounded-2xl p-3 flex flex-col items-center gap-2">
                                <span
                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Fondo</span>
                                <div
                                    class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-white/20 shadow-lg cursor-pointer hover:border-white/40 transition-colors">
                                    <div class="absolute inset-0" :style="`background:${bgColor}`"></div>
                                    <input type="color" x-model="bgColor" name="color_bg"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <i class="fas fa-eye-dropper text-white/70 text-[8px] drop-shadow"></i>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 font-mono" x-text="bgColor"></span>
                            </div>
                        </div>

                        <!-- Preview de marca -->
                        <div class="mt-3 rounded-2xl overflow-hidden border border-white/5 shadow-inner transition-all duration-300"
                            :style="`background:${bgColor}`">
                            <div class="px-4 py-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-[11px] font-black shrink-0 shadow-md"
                                    :style="`background:${primaryColor}`">WI</div>
                                <div class="flex-1 min-w-0">
                                    <div class="h-2 rounded-full w-3/4 mb-1.5 opacity-80"
                                        :style="`background:${primaryColor}`"></div>
                                    <div class="h-1.5 rounded-full w-1/2 opacity-50"
                                        :style="`background:${accentColor}`"></div>
                                </div>
                                <div class="px-3 py-1.5 rounded-xl text-[9px] font-black text-white shrink-0 shadow-md"
                                    :style="`background:${accentColor}`">Ver Menú</div>
                            </div>
                        </div>
                    </div>

                    <!-- ── CTA ── -->
                    <div class="pt-2">
                        <button type="submit" :disabled="!formValid"
                            :class="formValid
                                ?
                                'bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white shadow-[0_0_25px_rgba(168,85,247,0.35)] cursor-pointer active:scale-[0.98]' :
                                'bg-slate-800 text-slate-500 cursor-not-allowed'"
                            class="block w-full text-center font-extrabold py-4 rounded-2xl transition-all duration-300 text-sm tracking-wide">
                            <i class="fas fa-rocket mr-2"></i>
                            <span
                                x-text="formValid ? 'Iniciar Prueba Gratis — 7 Días' : 'Completa el formulario correctamente'"></span>
                        </button>
                        <!-- Indicador de progreso -->
                        <div class="mt-3 flex items-center gap-2">
                            <div class="flex-1 h-1 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-500 to-cyan-400 rounded-full transition-all duration-500"
                                    :style="`width:${
                                                                             ((nameStatus==='available'?1:0)
                                                                             +(emailValid?1:0)
                                                                             +(pwScore>=2?1:0)
                                                                             +(confirmMatch?1:0)) * 25
                                                                         }%`">
                                </div>
                            </div>
                            <span class="text-[10px] text-slate-500 font-bold shrink-0"
                                x-text="`${((nameStatus==='available'?1:0)+(emailValid?1:0)+(pwScore>=2?1:0)+(confirmMatch?1:0))}/4 completado`">
                            </span>
                        </div>
                    </div>

                    <p class="text-center text-[10px] text-slate-500 leading-relaxed">
                        ¿Ya tienes cuenta?
                        <a href="/login" class="text-purple-400 font-bold hover:text-purple-300 transition-colors">Inicia
                            Sesión aquí</a>
                    </p>
                </form>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="w-full py-6 text-xs text-slate-500 relative z-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© 2026 WIStore. Todos los derechos reservados.</p>
            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
                <a href="mailto:{{ $wistoreSupportEmail }}" class="hover:text-cyan-300 transition-colors">{{ $wistoreSupportEmail }}</a>
                <span class="hidden sm:inline">•</span>
                <a href="{{ route('legal.privacidad') }}" class="hover:text-white transition-colors">Políticas y
                    Privacidad</a>
                <span>•</span>
                <a href="{{ route('contacto') }}" class="hover:text-white transition-colors">Contacto</a>
            </div>
        </div>
    </footer>

    <!-- MODAL AVISO PRUEBA -->
    <div x-show="showTrialModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4" x-cloak>
        <div x-show="showTrialModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="showTrialModal = false"
            class="fixed inset-0 bg-[#070913]/85 backdrop-blur-md">
        </div>

        <div x-show="showTrialModal" x-transition:enter="transition ease-out duration-350"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95"
            class="relative z-10 w-full max-w-md bg-[#0d1127] border border-white/10 rounded-[2rem] overflow-hidden shadow-[0_0_60px_rgba(168,85,247,0.2)]">

            <div class="h-1.5 w-full bg-gradient-to-r from-purple-600 via-indigo-500 to-cyan-400"></div>

            <div class="px-8 pt-7 pb-0 text-center">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500/20 to-cyan-500/10 border border-purple-500/30 flex items-center justify-center mx-auto mb-3 shadow-[0_0_20px_rgba(168,85,247,0.2)]">
                    <i class="fas fa-rocket text-2xl text-purple-400"></i>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">¡Tu Prueba Comienza Ahora!</h2>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed max-w-xs mx-auto">
                    <span class="text-purple-400 font-black">7 días</span> sin pagos, sin comisiones. <span
                        class="text-white font-bold">Totalmente gratis</span> para que pruebes.
                </p>
            </div>

            <div
                class="mx-8 mt-6 bg-gradient-to-r from-purple-500/10 to-cyan-500/10 border border-purple-500/20 rounded-2xl p-4 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div
                        class="flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-purple-500/15 border border-purple-500/25 shrink-0">
                        <span class="text-2xl font-black text-purple-300">7</span>
                        <span class="text-[8px] text-purple-400 font-bold uppercase tracking-wider">días</span>
                    </div>
                    <div>
                        <p class="text-xs font-black text-white">Prueba Gratuita</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Sin tarjeta requerida</p>
                    </div>
                </div>
                <i class="fas fa-gift text-2xl text-purple-400/50 shrink-0"></i>
            </div>

            <div
                class="mx-8 mt-4 bg-amber-500/[0.07] border border-amber-500/25 rounded-2xl p-4 flex items-start gap-3">
                <div class="shrink-0 mt-0.5 w-6 h-6 rounded-lg bg-amber-500/15 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-amber-400 text-[10px]"></i>
                </div>
                <div>
                    <p class="text-[11px] font-black text-amber-300 uppercase tracking-wide mb-1">Aviso de Suscripción
                    </p>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Al finalizar los 7 días tu cuenta será
                        <span class="text-amber-300 font-bold">suspendida automáticamente</span>
                        si no activas la suscripción al
                        <span class="text-white font-bold">Plan Premium ($24.99/mes)</span>.
                        Tus datos se conservan por 30 días adicionales.
                    </p>
                </div>
            </div>

            <!-- Semana gratuita: grid compacto -->
            <div class="mx-6 mt-4">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 pl-1">Incluye durante los
                    7 días:</p>
                <div class="grid grid-cols-2 gap-1.5">
                    <div class="flex items-center gap-2 bg-white/[0.03] border border-white/5 rounded-xl px-2.5 py-2">
                        <i class="fas fa-box text-purple-400 text-[10px] w-3 shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-white leading-tight">50 Productos</p>
                            <p class="text-[8px] text-slate-500">máximo en prueba</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/[0.03] border border-white/5 rounded-xl px-2.5 py-2">
                        <i class="fas fa-tags text-purple-400 text-[10px] w-3 shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-white leading-tight">10 Categorías</p>
                            <p class="text-[8px] text-slate-500">personalizadas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/[0.03] border border-white/5 rounded-xl px-2.5 py-2">
                        <i class="fab fa-whatsapp text-emerald-400 text-[10px] w-3 shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-white leading-tight">Pedidos WhatsApp</p>
                            <p class="text-[8px] text-slate-500">notificación instantánea</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/[0.03] border border-white/5 rounded-xl px-2.5 py-2">
                        <i class="fas fa-palette text-purple-400 text-[10px] w-3 shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-white leading-tight">Branding Completo</p>
                            <p class="text-[8px] text-slate-500">colores y logo propios</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/[0.03] border border-white/5 rounded-xl px-2.5 py-2">
                        <i class="fas fa-chart-line text-purple-400 text-[10px] w-3 shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-white leading-tight">Panel de Órdenes</p>
                            <p class="text-[8px] text-slate-500">gestiona tus pedidos</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/[0.03] border border-white/5 rounded-xl px-2.5 py-2">
                        <i class="fas fa-percent text-purple-400 text-[10px] w-3 shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-white leading-tight">0% Comisiones</p>
                            <p class="text-[8px] text-slate-500">todo es tuyo</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-5">
                <button @click="isSubmitting = true; document.getElementById('registerForm').submit()"
                    :disabled="isSubmitting"
                    class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-extrabold py-3.5 rounded-2xl transition-all duration-300 text-xs shadow-[0_0_15px_rgba(168,85,247,0.3)] tracking-widest uppercase active:scale-[0.98] flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
                    <template x-if="!isSubmitting">
                        <span><i class="fas fa-rocket mr-2"></i> ¡Comenzar Ahora!</span>
                    </template>
                    <template x-if="isSubmitting">
                        <span><i class="fas fa-circle-notch animate-spin mr-2"></i> Registrando...</span>
                    </template>
                </button>
            </div>
        </div>
    </div>

    @include('partials.public.chat')
</body>

</html>
