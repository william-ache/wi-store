<!DOCTYPE html>
<html lang="es" class="scroll-smooth wistore-ui wistore-admin">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripción de Tienda | WIStore</title>

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
    @include('partials.admin.css-vars')
    @include('partials.admin.scrollbar')
    </style>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #070913;
        }

        .premium-glow {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.25);
        }

        .standard-glow {
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.2);
        }

        .neon-border-cyan {
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.15);
        }

        .neon-border-purple {
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.2);
        }
@keyframes wave {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.02); }
        }

        .wave-bg {
            animation: wave 12s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen text-slate-100 flex flex-col justify-between relative overflow-x-hidden selection:bg-purple-500 selection:text-white custom-scrollbar">

    <!-- BACKGROUND ANIMATIONS -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913]">
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/10 to-indigo-600/15 blur-[120px] wave-bg"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] wave-bg" style="animation-delay: -3s;"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/5 to-transparent blur-[160px] wave-bg" style="animation-delay: -6s;"></div>
    </div>

    <!-- HEADER -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <div class="flex items-center gap-2">
            <span class="text-xl font-black text-white tracking-wider uppercase">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Store</span>
            </span>
            <span class="bg-white/5 border border-white/10 px-2 py-0.5 rounded-md text-[9px] uppercase font-bold text-slate-400 tracking-wider">
                Facturación
            </span>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs font-bold text-slate-400 hover:text-rose-400 flex items-center gap-1.5 transition-colors group">
                <i class="fas fa-sign-out-alt text-xs group-hover:translate-x-0.5 transition-transform"></i>
                Cerrar Sesión
            </button>
        </form>
    </header>

    <!-- MAIN BODY -->
    <main class="flex-grow flex items-center justify-center px-4 py-8 relative z-10" 
          x-data="{
              plan: '{{ $defaultPlan }}',
              cycle: '{{ $shop->pending_billing_cycle ?: 'mensual' }}',
              exchangeRate: {{ $rate }},
              receiptPreview: null,
              
              get planPrice() {
                  if (this.plan === 'premium') {
                      return this.cycle === 'anual' ? 224.90 : 24.99;
                  } else {
                      return this.cycle === 'anual' ? 152.90 : 14.99;
                  }
              },
              
              get planPriceBs() {
                  return (this.planPrice * this.exchangeRate).toFixed(2);
              },
              
              get planName() {
                  return this.plan === 'premium' ? 'Premium 👑' : 'Standard ⚡';
              },

              get billingCycleName() {
                  return this.cycle === 'anual' ? 'Anual' : 'Mensual';
              },

              previewImage(event) {
                  const file = event.target.files[0];
                  if (file) {
                      const reader = new FileReader();
                      reader.onload = (e) => {
                          this.receiptPreview = e.target.result;
                      };
                      reader.readAsDataURL(file);
                  }
              }
          }">
        
        <div class="w-full max-w-4xl">
            
            <!-- EXPIRED / PAYMENT STATE -->
            @if ($shop->payment_status === 'none' || $shop->payment_status === 'rejected')
                
                <!-- SUSPENDED CARD -->
                <div class="w-full bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-48 h-48 rounded-full blur-2xl pointer-events-none transition-all duration-500"
                         :class="plan === 'premium' ? 'bg-purple-500/10' : 'bg-sky-500/10'"></div>
                    
                    <div class="text-center mb-8 relative z-10">
                        <div class="inline-flex items-center gap-2 bg-rose-500/10 border border-rose-500/30 rounded-full px-5 py-2 mb-4 shadow-[0_0_25px_rgba(239,68,68,0.15)] animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="text-rose-300 text-[10px] font-black uppercase tracking-widest">
                                @if ($shop->plan === 'free_trial')
                                    ⚠️ Tu Prueba Gratuita de 7 Días ha Terminado
                                @else
                                    ⚠️ Tu Plan ha Vencido
                                @endif
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Activa tu Suscripción para Continuar</h1>
                        <p class="text-xs text-slate-450 mt-2 max-w-md mx-auto leading-relaxed">
                            Para poder ingresar al panel administrativo de <span class="text-white font-bold">{{ $shop->name }}</span> y mantener tu tienda activa, por favor selecciona un plan y reporta tu pago móvil.
                        </p>
                    </div>

                    @if ($shop->payment_status === 'rejected')
                        <div class="mb-8 p-4 rounded-2xl bg-amber-500/[0.08] border border-amber-500/30 text-amber-300 flex items-start gap-3 shadow-lg">
                            <i class="fas fa-exclamation-circle text-lg mt-0.5 shrink-0"></i>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider mb-0.5">⚠️ Tu pago reportado anteriormente fue Rechazado</h4>
                                <p class="text-[11px] text-slate-400 leading-normal">
                                    Por favor, asegúrate de que el número de referencia sea idéntico al del comprobante y que la captura de pantalla sea legible e incluya los datos de la transferencia.
                                </p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.billing.pay', ['shop_slug' => $shop->slug]) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
                        @csrf
                        
                        <!-- LEFT SIDE: SELECTOR & DETAILS -->
                        <div class="lg:col-span-7 space-y-6">
                            
                            <!-- 1. SELECCIONAR PLAN -->
                            <div>
                                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400 block mb-3 pl-1">
                                    1. Selecciona tu Plan Comercial
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Plan Standard -->
                                    <button type="button" @click="plan = 'standard'"
                                            class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden"
                                            :class="plan === 'standard' 
                                                ? 'bg-sky-500/5 border-sky-500/50 shadow-[0_0_20px_rgba(14,165,233,0.15)]' 
                                                : 'bg-slate-900/30 border-white/5 hover:border-white/10'">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-black text-white">Plan Standard</span>
                                            <i class="fas fa-check-circle text-sky-400" x-show="plan === 'standard'"></i>
                                        </div>
                                        <p class="text-[10px] text-slate-400 leading-tight">Ideal para comenzar tu negocio.</p>
                                        <div class="mt-4 text-sm font-black text-white">
                                            $14.99 <span class="text-[9px] font-normal text-slate-450">/ mes</span>
                                        </div>
                                    </button>

                                    <!-- Plan Premium -->
                                    <button type="button" @click="plan = 'premium'"
                                            class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden"
                                            :class="plan === 'premium' 
                                                ? 'bg-purple-500/5 border-purple-500/50 shadow-[0_0_20px_rgba(168,85,247,0.15)]' 
                                                : 'bg-slate-900/30 border-white/5 hover:border-white/10'">
                                        <div class="absolute top-0 right-0 bg-purple-500 text-slate-950 font-black text-[8px] uppercase tracking-wider px-2 py-0.5 rounded-bl-lg">
                                            Ideal 👑
                                        </div>
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-black text-white">Plan Premium</span>
                                            <i class="fas fa-check-circle text-purple-400" x-show="plan === 'premium'"></i>
                                        </div>
                                        <p class="text-[10px] text-slate-400 leading-tight">Máximo alcance y control visual.</p>
                                        <div class="mt-4 text-sm font-black text-white">
                                            $24.99 <span class="text-[9px] font-normal text-slate-450">/ mes</span>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- 2. CICLO DE FACTURACION -->
                            <div>
                                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400 block mb-3 pl-1">
                                    2. Elige el Ciclo de Facturación
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Mensual -->
                                    <button type="button" @click="cycle = 'mensual'"
                                            class="py-3 px-4 rounded-xl border text-center transition-all duration-300 font-extrabold text-xs"
                                            :class="cycle === 'mensual' 
                                                ? 'bg-white/10 border-white/30 text-white' 
                                                : 'bg-slate-900/30 border-white/5 hover:border-white/10 text-slate-400'">
                                        Facturación Mensual
                                    </button>

                                    <!-- Anual -->
                                    <button type="button" @click="cycle = 'anual'"
                                            class="py-3 px-4 rounded-xl border text-center transition-all duration-300 font-extrabold text-xs relative"
                                            :class="cycle === 'anual' 
                                                ? 'bg-emerald-500/10 border-emerald-500/40 text-emerald-300' 
                                                : 'bg-slate-900/30 border-white/5 hover:border-white/10 text-slate-400'">
                                        Facturación Anual
                                        <span class="absolute -top-2.5 -right-1.5 bg-emerald-500 text-slate-950 font-black text-[7px] px-1.5 py-0.5 rounded-full uppercase tracking-wider">
                                            <span x-text="plan === 'premium' ? '-25%' : '-15%'"></span> Dto.
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- 3. DETALLES DE PAGO MÓVIL -->
                            <div class="bg-[#0f142e] border border-white/5 rounded-3xl p-5 shadow-inner">
                                <div class="flex items-center justify-between mb-4 border-b border-white/5 pb-3">
                                    <h4 class="text-xs font-black text-white uppercase tracking-wider flex items-center gap-2">
                                        <i class="fas fa-mobile-screen-button transition-colors duration-300" :class="plan === 'premium' ? 'text-purple-400' : 'text-sky-400'"></i>
                                        Pagar por Pago Móvil Banesco
                                    </h4>
                                    <span class="text-[10px] text-slate-450 font-bold uppercase tracking-wider">Monto Exacto</span>
                                </div>

                                <div class="space-y-3.5 mb-5 text-xs text-slate-350">
                                    <div class="flex justify-between items-center bg-slate-950/20 px-3 py-2 rounded-xl border border-white/5">
                                        <span class="text-[11px] font-bold">Banco:</span>
                                        <strong class="text-white font-extrabold">Banesco</strong>
                                    </div>
                                    <div class="flex justify-between items-center bg-slate-950/20 px-3 py-2 rounded-xl border border-white/5">
                                        <span class="text-[11px] font-bold">Teléfono:</span>
                                        <div class="flex items-center gap-1.5">
                                            <strong class="text-white font-extrabold">04121305420</strong>
                                            <button type="button" @click="navigator.clipboard.writeText('04121305420')" title="Copiar Teléfono" class="text-slate-450 hover:text-white transition-colors">
                                                <i class="far fa-copy text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center bg-slate-950/20 px-3 py-2 rounded-xl border border-white/5">
                                        <span class="text-[11px] font-bold">Cédula de Identidad:</span>
                                        <div class="flex items-center gap-1.5">
                                            <strong class="text-white font-extrabold">CI 27863106</strong>
                                            <button type="button" @click="navigator.clipboard.writeText('27863106')" title="Copiar Cédula" class="text-slate-450 hover:text-white transition-colors">
                                                <i class="far fa-copy text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-2xl p-4 flex justify-between items-center border transition-all duration-300"
                                     :class="plan === 'premium' ? 'bg-purple-500/10 border-purple-550/30' : 'bg-sky-500/10 border-sky-500/30'">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider transition-colors duration-300"
                                           :class="plan === 'premium' ? 'text-purple-300' : 'text-sky-300'">Total a Pagar</p>
                                        <p class="text-2xl font-black text-white mt-1">
                                            $<span x-text="planPrice.toFixed(2)"></span> <span class="text-[11px] font-normal text-slate-400">USD</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider flex items-center justify-end gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Tasa BCV: <span x-text="exchangeRate.toFixed(2)"></span> Bs.
                                        </p>
                                        <p class="text-xl font-black text-emerald-300 mt-1">
                                            <span x-text="planPriceBs"></span> <span class="text-[11px] font-normal text-slate-400">Bs.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT SIDE: REPORT PAYMENT UPLOAD -->
                        <div class="lg:col-span-5 space-y-5 flex flex-col justify-between">
                            <div class="space-y-5">
                                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400 block mb-1 pl-1">
                                    3. Reporta los Datos del Pago
                                </label>

                                <!-- REFERENCIA INPUT -->
                                <div class="space-y-1.5">
                                    <label for="payment_reference" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-350 block pl-1">
                                        Número de Referencia (Últimos 6 u 8 dígitos)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                            <i class="fas fa-hashtag text-xs"></i>
                                        </span>
                                        <input type="text" id="payment_reference" name="payment_reference" required 
                                               placeholder="Ej: 58493022" value="{{ old('payment_reference') }}"
                                               class="w-full bg-slate-800/80 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 transition-all shadow-inner"
                                               :class="plan === 'premium' ? 'focus:ring-purple-500/40' : 'focus:ring-sky-500/40'">
                                    </div>
                                    @error('payment_reference')
                                        <span class="text-[10px] text-rose-450 font-bold block pl-1 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- NOMBRE DE LA EMPRESA INPUT -->
                                <div class="space-y-1.5">
                                    <label for="payment_company_name" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-350 block pl-1">
                                        Nombre de la Empresa o Comercio
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                            <i class="fas fa-building text-xs"></i>
                                        </span>
                                        <input type="text" id="payment_company_name" name="payment_company_name" required 
                                               placeholder="Ej: Mi Comercio C.A." value="{{ old('payment_company_name', $shop->name) }}"
                                               class="w-full bg-slate-800/80 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 transition-all shadow-inner"
                                               :class="plan === 'premium' ? 'focus:ring-purple-500/40' : 'focus:ring-sky-500/40'">
                                    </div>
                                    @error('payment_company_name')
                                        <span class="text-[10px] text-rose-450 font-bold block pl-1 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- CORREO DE LA EMPRESA INPUT -->
                                <div class="space-y-1.5">
                                    <label for="payment_company_email" class="text-[10px] font-extrabold uppercase tracking-wider text-slate-350 block pl-1">
                                        Correo de la Empresa
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none w-4 flex justify-center">
                                            <i class="fas fa-envelope text-xs"></i>
                                        </span>
                                        <input type="email" id="payment_company_email" name="payment_company_email" required 
                                               placeholder="Ej: contacto@empresa.com" value="{{ old('payment_company_email', Auth::user()->email ?? '') }}"
                                               class="w-full bg-slate-800/80 border border-slate-700/60 rounded-2xl px-4 py-3.5 pl-11 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 transition-all shadow-inner"
                                               :class="plan === 'premium' ? 'focus:ring-purple-500/40' : 'focus:ring-sky-500/40'">
                                    </div>
                                    @error('payment_company_email')
                                        <span class="text-[10px] text-rose-450 font-bold block pl-1 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- COMPROBANTE IMAGE UPLOAD -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-extrabold uppercase tracking-wider text-slate-350 block pl-1">
                                        Captura del Comprobante / Recibo
                                    </label>
                                    
                                    <div class="relative border-2 border-dashed border-white/10 rounded-2xl p-6 transition-all bg-slate-900/10 flex flex-col items-center justify-center cursor-pointer group"
                                         :class="plan === 'premium' ? 'hover:border-purple-500/30' : 'hover:border-sky-500/30'">
                                        <input type="file" name="payment_receipt" id="payment_receipt" required accept="image/*"
                                               @change="previewImage"
                                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                        
                                        <!-- No preview -->
                                        <div x-show="!receiptPreview" class="text-center">
                                            <i class="far fa-image text-2xl text-slate-500 transition-colors mb-2 block group-hover:text-purple-400"
                                               :class="plan === 'premium' ? 'group-hover:text-purple-400' : 'group-hover:text-sky-400'"></i>
                                            <span class="text-[11px] font-black text-slate-300 block mb-1">Cargar Comprobante</span>
                                            <span class="text-[9px] text-slate-500 block">Formatos: JPG, PNG • Máx 4MB</span>
                                        </div>

                                        <!-- Preview -->
                                        <div x-show="receiptPreview" x-cloak class="w-full relative">
                                            <img :src="receiptPreview" class="max-h-[140px] w-auto mx-auto object-contain rounded-lg border border-white/10 shadow-lg">
                                            <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 flex items-center justify-center rounded-lg transition-opacity duration-200">
                                                <span class="text-[10px] font-black text-white uppercase tracking-wider px-3 py-1 rounded-full shadow-lg"
                                                      :class="plan === 'premium' ? 'bg-purple-600' : 'bg-sky-500'">
                                                    Cambiar Imagen
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @error('payment_receipt')
                                        <span class="text-[10px] text-rose-450 font-bold block pl-1 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="pt-4 lg:pt-0">
                                <!-- hidden inputs to pass plan and cycle -->
                                <input type="hidden" name="plan" :value="plan">
                                <input type="hidden" name="billing_cycle" :value="cycle">

                                <button type="submit" 
                                        class="block w-full text-center text-white font-extrabold py-4 rounded-2xl transition-all duration-300 text-xs uppercase tracking-widest active:scale-[0.98] border border-white/10"
                                        :class="plan === 'premium' 
                                            ? 'bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 shadow-[0_0_25px_rgba(168,85,247,0.3)]' 
                                            : 'bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 shadow-[0_0_25px_rgba(14,165,233,0.3)]'">
                                    <i class="fas fa-file-invoice-dollar mr-2"></i> Reportar Pago Realizado
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            <!-- PAYMENT PENDING STATE -->
            @elseif ($shop->payment_status === 'pending')
                
                <div class="w-full max-w-xl mx-auto bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-10 shadow-2xl relative overflow-hidden text-center">
                    <div class="absolute -top-20 -right-20 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

                    <!-- Glowing Pulsing Success indicator -->
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 border border-emerald-500/30 flex items-center justify-center mx-auto mb-6 shadow-[0_0_30px_rgba(16,185,129,0.3)] animate-pulse">
                        <i class="fas fa-circle-notch text-2xl text-emerald-400 animate-spin"></i>
                    </div>

                    <span class="inline-block bg-emerald-500/10 text-emerald-300 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)] mb-4">
                        El pago se está confirmando
                    </span>

                    <h1 class="text-2xl font-black text-white tracking-tight">Estamos Validando tu Transacción</h1>
                    
                    <p class="text-xs text-slate-400 mt-3 leading-relaxed max-w-sm mx-auto">
                        Tu reporte de pago móvil por el plan <strong class="text-white">{{ $shop->pending_plan === 'premium' ? 'Premium 👑' : 'Standard ⚡' }}</strong> (<span class="text-slate-300 font-bold">{{ ucfirst($shop->pending_billing_cycle) }}</span>) está siendo validado por nuestro equipo de soporte.
                    </p>

                    <!-- Resumen del Pago -->
                    <div class="my-6 bg-slate-950/30 border border-white/5 rounded-2xl p-4 text-left text-xs space-y-2.5 max-w-sm mx-auto">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Monto Reportado:</span>
                            <strong class="text-white font-extrabold">
                                @if($shop->pending_plan === 'premium')
                                    ${{ $shop->pending_billing_cycle === 'anual' ? '224.90' : '24.99' }} USD
                                @else
                                    ${{ $shop->pending_billing_cycle === 'anual' ? '152.90' : '14.99' }} USD
                                @endif
                            </strong>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Empresa:</span>
                            <span class="text-slate-300 font-bold">
                                {{ $shop->payment_company_name }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Correo:</span>
                            <span class="text-slate-300 font-bold">
                                {{ $shop->payment_company_email }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Referencia:</span>
                            <span class="font-mono text-emerald-300 font-bold bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                                {{ $shop->payment_reference }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-bold">Enviado el:</span>
                            <span class="text-slate-300 font-bold">
                                {{ $shop->payment_submitted_at ? $shop->payment_submitted_at->format('d/m/Y h:i A') : now()->format('d/m/Y h:i A') }}
                            </span>
                        </div>
                        
                        @if ($shop->payment_receipt_path)
                            <div class="border-t border-white/5 pt-2.5 flex items-center justify-between">
                                <span class="text-slate-500 font-bold">Comprobante adjunto:</span>
                                <a href="{{ asset('storage/' . $shop->payment_receipt_path) }}" target="_blank" class="text-purple-400 hover:text-purple-300 font-bold hover:underline flex items-center gap-1">
                                    <span>Ver Imagen</span>
                                    <i class="fas fa-external-link-alt text-[9px]"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-500 leading-normal max-w-sm mx-auto mb-6">
                        Una vez verificado el depósito en nuestra cuenta bancaria, se reactivará tu suscripción de inmediato y podrás ingresar a tu panel con total normalidad.
                    </p>

                    <!-- WhatsApp Notification button -->
                    <div class="pt-2 border-t border-white/5 max-w-sm mx-auto">
                        @php
                            $planLabel = $shop->pending_plan === 'premium' ? 'Premium ($' . ($shop->pending_billing_cycle === 'anual' ? '224.90' : '24.99') . ')' : 'Standard ($' . ($shop->pending_billing_cycle === 'anual' ? '152.90' : '14.99') . ')';
                            $messageText = "Hola! He realizado el pago para activar mi tienda en WIStore.\n\n"
                                         . "• Empresa: " . ($shop->payment_company_name ?: $shop->name) . "\n"
                                         . "• Correo: " . ($shop->payment_company_email ?: (Auth::user()->email ?? '')) . "\n"
                                         . "• Tienda (Slug): " . $shop->slug . "\n"
                                         . "• Plan seleccionado: " . $planLabel . " - " . ucfirst($shop->pending_billing_cycle) . "\n"
                                         . "• Referencia de Pago Móvil: " . $shop->payment_reference . "\n\n"
                                         . "Por favor validar mi comprobante para agilizar la activación de mi panel. ¡Muchas gracias!";
                        @endphp
                        
                        <a href="https://wa.me/584121305420?text={{ urlencode($messageText) }}" target="_blank"
                           class="block w-full text-center bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black py-4 rounded-2xl transition-all duration-300 text-xs uppercase tracking-wider shadow-[0_0_20px_rgba(16,185,129,0.25)] active:scale-[0.98] animate-bounce"
                           style="animation-duration: 2.5s;">
                            <i class="fab fa-whatsapp text-sm mr-1.5"></i> Notificar por WhatsApp (Soporte Rápido)
                        </a>
                        <p class="text-[10px] text-slate-500 mt-3 text-center">
                            O escribe a
                            <a href="mailto:{{ $wistoreSupportEmail }}" class="text-cyan-300/90 hover:text-cyan-200 font-bold">{{ $wistoreSupportEmail }}</a>
                        </p>
                    </div>
                </div>

            @endif

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="w-full py-6 text-xs text-slate-500 relative z-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© 2026 WIStore. Todos los derechos reservados.</p>
            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
                <a href="mailto:{{ $wistoreSupportEmail }}" class="hover:text-cyan-300 transition-colors">{{ $wistoreSupportEmail }}</a>
                <span class="hidden sm:inline">•</span>
                <a href="{{ route('legal.privacidad') }}" class="hover:text-white transition-colors">Políticas y Privacidad</a>
                <span>•</span>
                <a href="{{ route('contacto') }}" class="hover:text-white transition-colors">Contacto</a>
            </div>
        </div>
    </footer>

</body>

</html>
