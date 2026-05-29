<!DOCTYPE html>
<html lang="es" class="wi-store-ui wi-store-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Iniciar Prueba Gratis {{ $wiStoreTrialDays }} Días | WI-Store</title>

    @include('partials.landing.head-assets')

    @include('partials.global.wi-store-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.motion-styles')
    @include('partials.landing.ux-styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .auth-register-page {
            min-height: 100vh;
            min-height: 100dvh;
            font-family: 'Outfit', sans-serif;
            color: #1e293b;
            background: #ffffff;
        }

        .auth-register-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow:
                0 4px 24px rgba(15, 23, 42, 0.06),
                0 0 0 1px rgba(255, 255, 255, 0.8);
        }

        .auth-register-input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
        }

        .auth-register-input::placeholder {
            color: #94a3b8;
        }

        .auth-register-input:focus {
            outline: none;
            border-color: rgba(147, 51, 234, 0.45);
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.12);
            background: #ffffff;
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
@php
    $landingNavExternal = true;
    $shopsWithCategories = $shopsWithCategories ?? collect();
@endphp
<body class="auth-register-page flex flex-col min-h-screen relative overflow-x-hidden selection:bg-purple-200 selection:text-slate-900"
      x-data="landingPage()" x-init="init()">

    @include('partials.landing.page-hero-background')

    @include('partials.landing.landing-header')

    @include('partials.landing.ux-chrome')

    <main class="flex-grow flex items-center justify-center px-4 py-6 md:py-10 relative z-10">
        <div class="w-full max-w-lg" x-data="{
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
        bgColor: '#FEFFFD',
        selectedPreset: 0,
        presets: [
            { primary: '#6366f1', accent: '#22d3ee', bg: '#FEFFFD', name: 'Índigo' },
            { primary: '#a855f7', accent: '#f472b6', bg: '#FEFFFD', name: 'Rosa' },
            { primary: '#0ea5e9', accent: '#06b6d4', bg: '#FEFFFD', name: 'Cielo' },
            { primary: '#10b981', accent: '#34d399', bg: '#FEFFFD', name: 'Esmeralda' },
            { primary: '#f59e0b', accent: '#fb923c', bg: '#FEFFFD', name: 'Ámbar' },
            { primary: '#ec4899', accent: '#a855f7', bg: '#FEFFFD', name: 'Fucsia' },
            { primary: '#ef4444', accent: '#f97316', bg: '#FEFFFD', name: 'Rojo' },
            { primary: '#e2e8f0', accent: '#94a3b8', bg: '#FEFFFD', name: 'Negro' },
            { primary: '#84cc16', accent: '#22d3ee', bg: '#FEFFFD', name: 'Lima' },
            { primary: '#64748b', accent: '#cbd5e1', bg: '#FEFFFD', name: 'Plata' },
            { primary: '#14b8a6', accent: '#0ea5e9', bg: '#FEFFFD', name: 'Océano' },
            { primary: '#f97316', accent: '#facc15', bg: '#FEFFFD', name: 'Naranja' },
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
                const taken = ['wi-store', 'wistore', 'demo', 'test', 'admin', 'tienda'];
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
            if (this.pwScore <= 1) return 'text-red-600';
            if (this.pwScore === 2) return 'text-amber-600';
            if (this.pwScore === 3) return 'text-lime-600';
            return 'text-emerald-600';
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

            <!-- Badge trial -->
            <div class="flex justify-center mb-5">
                <div class="inline-flex items-center gap-2 bg-purple-50 border border-purple-200 rounded-full px-4 py-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                    <span class="text-purple-800 text-[10px] sm:text-[11px] font-black uppercase tracking-wide text-center">🎁 {{ $wiStoreTrialDays }} Días de Prueba Gratuita — {{ $wiStoreTrialDisclaimer }}</span>
                </div>
            </div>

            <!-- Card -->
            <div class="w-full auth-register-card rounded-[2rem] p-8 md:p-10 relative">

                <div class="text-center mb-8">
                    <span class="inline-block text-[10px] uppercase font-black tracking-widest px-3 py-1.5 rounded-full border border-purple-200 bg-purple-50 text-purple-700 mb-4">
                        Plan Negocio
                    </span>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Crea tu Catálogo Digital</h1>
                    <p class="text-xs text-slate-500 mt-2 max-w-xs mx-auto leading-relaxed">
                        Configura tu marca y comienza a vender en segundos. <span class="text-purple-700 font-black">Gratis por {{ $wiStoreTrialDays }} días.</span>
                    </p>
                </div>

                <!-- FORMULARIO -->
                <form id="registerForm" action="{{ route('register.submit') }}" method="POST" @submit.prevent="submitForm()" class="space-y-5">
                    @csrf
                    <div class="rounded-2xl border border-purple-200 bg-purple-50 px-4 py-3 text-slate-700 text-sm font-bold tracking-wide">
                        <i class="fas fa-info-circle mr-2 text-purple-600"></i>
                        Completa los datos del formulario para iniciar tu prueba gratis de {{ $wiStoreTrialDays }} días.
                    </div>

                    <!-- ── NOMBRE DEL COMERCIO ── -->
                    <div class="space-y-1.5">
                        <label for="shop_name"
                            class="text-[11px] font-black uppercase tracking-wider text-slate-500 block pl-1">
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
                                class="auth-register-input w-full rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs transition-all">
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
                            class="text-[11px] font-black uppercase tracking-wider text-slate-500 block pl-1">Correo
                            Electrónico</label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                            <input type="email" id="email" name="email" required x-model="email"
                                @input="emailTouched = true" placeholder="tu@correo.com" :class="emailBorderClass"
                                class="auth-register-input w-full rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs transition-all">
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
                            class="text-[11px] font-black uppercase tracking-wider text-slate-500 block pl-1">Contraseña</label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                x-model="password" placeholder="Mínimo 8 caracteres" :class="pwBorderClass"
                                class="auth-register-input w-full rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs transition-all">
                            @error('password')
                                <p class="text-[10px] text-rose-500 font-bold mt-1 pl-1">{{ $message }}</p>
                            @enderror
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors focus:outline-none">
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
                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
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
                            class="text-[11px] font-black uppercase tracking-wider text-slate-500 block pl-1">Confirmar
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
                                class="auth-register-input w-full rounded-2xl px-4 py-3.5 pl-11 pr-11 text-xs transition-all">
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors focus:outline-none">
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
                    <div class="border-t border-slate-200 pt-5">
                        <label class="text-[11px] font-black uppercase tracking-wider text-slate-500 block pl-1 mb-3">
                            <i class="fas fa-palette mr-1.5 text-purple-600"></i> Colores de tu Marca
                        </label>
                        <p class="text-[10px] text-slate-500 mb-3 pl-1 leading-snug">
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
                                        'border-purple-400/60 bg-purple-50 shadow-sm' :
                                        'border-slate-200 hover:border-slate-300 bg-slate-50'">
                                    <span class="w-3 h-3 rounded-full shadow-inner"
                                        :style="`background:${preset.primary}`"></span>
                                    <span class="w-3 h-3 rounded-full shadow-inner"
                                        :style="`background:${preset.accent}`"></span>
                                    <span class="w-3 h-3 rounded-full border border-slate-200"
                                        :style="`background:${preset.bg}`"></span>
                                </button>
                            </template>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div
                                class="bg-slate-50 border border-slate-200 rounded-2xl p-3 flex flex-col items-center gap-2">
                                <span
                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Primario</span>
                                <div
                                    class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 shadow-md cursor-pointer hover:border-purple-300 transition-colors">
                                    <div class="absolute inset-0" :style="`background:${primaryColor}`"></div>
                                    <input type="color" x-model="primaryColor" name="color_primary"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <i class="fas fa-eye-dropper text-slate-600/80 text-[8px] drop-shadow"></i>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 font-mono" x-text="primaryColor"></span>
                            </div>
                            <div
                                class="bg-slate-50 border border-slate-200 rounded-2xl p-3 flex flex-col items-center gap-2">
                                <span
                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Acento</span>
                                <div
                                    class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 shadow-md cursor-pointer hover:border-purple-300 transition-colors">
                                    <div class="absolute inset-0" :style="`background:${accentColor}`"></div>
                                    <input type="color" x-model="accentColor" name="color_accent"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <i class="fas fa-eye-dropper text-slate-600/80 text-[8px] drop-shadow"></i>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 font-mono" x-text="accentColor"></span>
                            </div>
                            <div
                                class="bg-slate-50 border border-slate-200 rounded-2xl p-3 flex flex-col items-center gap-2">
                                <span
                                    class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Fondo</span>
                                <div
                                    class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 shadow-md cursor-pointer hover:border-purple-300 transition-colors">
                                    <div class="absolute inset-0" :style="`background:${bgColor}`"></div>
                                    <input type="color" x-model="bgColor" name="color_bg"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <i class="fas fa-eye-dropper text-slate-600/80 text-[8px] drop-shadow"></i>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 font-mono" x-text="bgColor"></span>
                            </div>
                        </div>

                        <!-- Preview de marca -->
                        <div class="mt-3 rounded-2xl overflow-hidden border border-slate-200 shadow-sm transition-all duration-300"
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
                                ? 'landing-plan-btn landing-plan-btn--negocio text-white cursor-pointer active:scale-[0.98]'
                                : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                            class="block w-full text-center font-extrabold py-4 rounded-2xl transition-all duration-300 text-sm tracking-wide">
                            <i class="fas fa-rocket mr-2"></i>
                            <span
                                x-text="formValid ? 'Iniciar Prueba Gratis — {{ $wiStoreTrialDays }} Días' : 'Completa el formulario correctamente'"></span>
                        </button>
                        <!-- Indicador de progreso -->
                        <div class="mt-3 flex items-center gap-2">
                            <div class="flex-1 h-1 bg-slate-200 rounded-full overflow-hidden">
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
                        <a href="/login" class="text-purple-700 font-bold hover:text-cyan-700 transition-colors">Inicia
                            Sesión aquí</a>
                    </p>
                </form>
            </div>

            <!-- MODAL AVISO PRUEBA -->
            <div x-show="showTrialModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4" x-cloak>
                <div x-show="showTrialModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="showTrialModal = false"
                    class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm">
                </div>

                <div x-show="showTrialModal" x-transition:enter="transition ease-out duration-350"
                    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                    class="relative z-10 w-full max-w-md auth-register-card rounded-[2rem] overflow-hidden">

                    <div class="h-1.5 w-full bg-gradient-to-r from-purple-600 via-indigo-500 to-cyan-400"></div>

                    <div class="px-8 pt-7 pb-0 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 border border-purple-200 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-rocket text-2xl text-purple-600"></i>
                        </div>
                        <h2 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">¡Tu Prueba Comienza Ahora!</h2>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed max-w-xs mx-auto">
                            <span class="text-purple-700 font-black">{{ $wiStoreTrialDays }} días</span> sin pagos, sin comisiones.
                            <span class="text-slate-900 font-bold">Totalmente gratis</span> para que pruebes.
                        </p>
                    </div>

                    <div class="mx-8 mt-6 bg-purple-50 border border-purple-200 rounded-2xl p-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-white border border-purple-200 shrink-0">
                                <span class="text-2xl font-black text-purple-700">{{ $wiStoreTrialDays }}</span>
                                <span class="text-[8px] text-purple-600 font-bold uppercase tracking-wider">días</span>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-900">Prueba Gratuita</p>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ $wiStoreTrialDisclaimer }}</p>
                            </div>
                        </div>
                        <i class="fas fa-gift text-2xl text-purple-400 shrink-0"></i>
                    </div>

                    <div class="mx-8 mt-4 bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
                        <div class="shrink-0 mt-0.5 w-6 h-6 rounded-lg bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-amber-600 text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-amber-800 uppercase tracking-wide mb-1">Aviso de Suscripción</p>
                            <p class="text-[11px] text-slate-600 leading-relaxed">
                                Al finalizar los {{ $wiStoreTrialDays }} días tu cuenta será
                                <span class="text-amber-700 font-bold">suspendida automáticamente</span>
                                si no activas la suscripción al
                                <span class="text-slate-900 font-bold">Plan Negocio ({{ \App\Support\PlanPricing::formatUsd(\App\Support\PlanPricing::PLANS['premium']['monthly']) }}/mes)</span>.
                                Tus datos se conservan por 30 días adicionales.
                            </p>
                        </div>
                    </div>

                    <div class="mx-6 mt-4">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 pl-1">Incluye durante los {{ $wiStoreTrialDays }} días:</p>
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ([['fa-box', '50 Productos', 'máximo en prueba'], ['fa-tags', '10 Categorías', 'personalizadas'], ['fa-whatsapp', 'Pedidos WhatsApp', 'notificación instantánea', 'fab'], ['fa-palette', 'Branding Completo', 'colores y logo propios'], ['fa-chart-line', 'Panel de Órdenes', 'gestiona tus pedidos'], ['fa-percent', '0% Comisiones', 'todo es tuyo']] as $feat)
                                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-2">
                                    <i class="{{ ($feat[3] ?? 'fas') }} {{ $feat[0] }} text-purple-600 text-[10px] w-3 shrink-0"></i>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-900 leading-tight">{{ $feat[1] }}</p>
                                        <p class="text-[8px] text-slate-500">{{ $feat[2] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="px-6 py-5">
                        <button @click="isSubmitting = true; document.getElementById('registerForm').submit()"
                            :disabled="isSubmitting"
                            class="landing-plan-btn landing-plan-btn--negocio w-full text-center text-white font-extrabold py-3.5 rounded-2xl text-xs tracking-widest uppercase active:scale-[0.98] flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
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

        </div>
    </main>

    @include('partials.landing.light-footer')

    @include('partials.public.chat')

    @include('partials.landing.ux-script')
</body>

</html>
