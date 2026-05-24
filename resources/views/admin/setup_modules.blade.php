<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configura tu Menú | WIStore</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ config('current_shop')->color_primary ?? '#6366f1' }}',
                        secondary: '{{ config('current_shop')->color_secondary ?? '#22d3ee' }}',
                    },
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #070913;
        }

        .custom-glow {
            box-shadow: 0 0 35px rgba(255, 255, 255, 0.03), 0 0 15px rgba(var(--color-primary-rgb, 99, 102, 241), 0.05);
        }

        @keyframes wave {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.01); }
        }

        .wave-bg {
            animation: wave 14s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen text-slate-100 flex flex-col justify-between relative overflow-x-hidden selection:bg-primary selection:text-white">

    <!-- BACKGROUND ANIMATIONS -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913]">
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-primary/10 to-secondary/15 blur-[120px] wave-bg"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-secondary/10 to-blue-600/10 blur-[160px] wave-bg" style="animation-delay: -3s;"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-primary/5 via-secondary/5 to-transparent blur-[160px] wave-bg" style="animation-delay: -6s;"></div>
    </div>

    <!-- HEADER -->
    <header class="w-full max-w-6xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <div class="flex items-center gap-2">
            <span class="text-xl font-black text-white tracking-wider uppercase">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Store</span>
            </span>
            <span class="bg-white/5 border border-white/10 px-3 py-1 rounded-full text-[9px] uppercase font-bold text-slate-400 tracking-wider">
                Bienvenido
            </span>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs font-extrabold text-slate-400 hover:text-rose-400 flex items-center gap-1.5 transition-colors group">
                <i class="fas fa-sign-out-alt text-xs group-hover:translate-x-0.5 transition-transform"></i>
                Cerrar Sesión
            </button>
        </form>
    </header>    <!-- MAIN BODY -->
    <main class="flex-grow flex items-center justify-center px-4 py-6 relative z-10" 
          x-data="{
              selectedModules: ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals'],
              toggleModule(module) {
                  if (this.selectedModules.includes(module)) {
                      this.selectedModules = this.selectedModules.filter(m => m !== module);
                  } else {
                      this.selectedModules.push(module);
                  }
              }
          }">
        
        <div class="w-full max-w-3xl">
            
            <div class="w-full bg-[#0d1127]/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-6 md:p-10 shadow-2xl relative overflow-hidden custom-glow">
                <div class="absolute -top-20 -right-20 w-48 h-48 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>
                
                <!-- HEADER WIZARD -->
                <div class="text-center mb-8 relative z-10">
                    <div class="inline-flex items-center gap-2 bg-gradient-to-r from-primary/15 to-secondary/15 border border-white/10 rounded-full px-5 py-2 mb-5 shadow-lg backdrop-blur-md">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-slate-200 text-[10px] font-black uppercase tracking-widest">
                            🚀 Primer ingreso al panel administrativo
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight leading-tight">
                        Personaliza tu Espacio de Trabajo
                    </h1>
                    <p class="text-xs text-slate-400 mt-3 max-w-lg mx-auto leading-relaxed font-medium">
                        Elige qué secciones u opciones del menú deseas tener visibles en tu panel de administración para <span class="text-white font-bold">{{ $shop->name }}</span>. Podrás cambiar esto después desde la configuración.
                    </p>
                </div>

                <form action="{{ route('admin.setup-modules.save', ['shop_slug' => $shop->slug]) }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    
                    <!-- MODULE CARDS GRID -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Categorías -->
                        <div @click="toggleModule('categories')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('categories') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('categories') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📦</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('categories') ? 'text-white' : 'text-slate-400'">
                                    Categorías
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Crea y organiza tus productos por grupos o clasificaciones personalizadas.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('categories') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('categories')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="categories" class="hidden" :checked="selectedModules.includes('categories')">
                        </div>

                        <!-- Productos -->
                        <div @click="toggleModule('products')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('products') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('products') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🍔</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('products') ? 'text-white' : 'text-slate-400'">
                                    Productos
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Gestiona tus artículos con precios, imágenes, descripciones y stock.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('products') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('products')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="products" class="hidden" :checked="selectedModules.includes('products')">
                        </div>

                        <!-- Pedidos -->
                        <div @click="toggleModule('orders')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('orders') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('orders') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📋</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('orders') ? 'text-white' : 'text-slate-400'">
                                    Pedidos
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Recibe, procesa y despacha pedidos en tiempo real con facturas rápidas.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('orders') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('orders')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="orders" class="hidden" :checked="selectedModules.includes('orders')">
                        </div>

                        <!-- Clientes -->
                        <div @click="toggleModule('clients')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('clients') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('clients') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">👥</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('clients') ? 'text-white' : 'text-slate-400'">
                                    Clientes
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Visualiza tus compradores recurrentes y sus canales directos de contacto.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('clients') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('clients')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="clients" class="hidden" :checked="selectedModules.includes('clients')">
                        </div>

                        <!-- Facturas -->
                        <div @click="toggleModule('invoices')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('invoices') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('invoices') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🧾</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('invoices') ? 'text-white' : 'text-slate-400'">
                                    Facturas
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Gestiona y descarga los comprobantes y reportes de facturación.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('invoices') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('invoices')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="invoices" class="hidden" :checked="selectedModules.includes('invoices')">
                        </div>

                        <!-- Delivery -->
                        <div @click="toggleModule('delivery')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('delivery') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('delivery') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🛵</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('delivery') ? 'text-white' : 'text-slate-400'">
                                    Delivery
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Configura tarifas de envío, motorizados, y coberturas de entrega.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('delivery') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('delivery')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="delivery" class="hidden" :checked="selectedModules.includes('delivery')">
                        </div>

                        <!-- Analítica -->
                        <div @click="toggleModule('analytics')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('analytics') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('analytics') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📊</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('analytics') ? 'text-white' : 'text-slate-400'">
                                    Analítica
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Visualiza estadísticas, reportes de ventas y desempeño comercial.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('analytics') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('analytics')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="analytics" class="hidden" :checked="selectedModules.includes('analytics')">
                        </div>

                        <!-- Referidos -->
                        <div @click="toggleModule('referrals')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group flex gap-4"
                             :class="selectedModules.includes('referrals') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('referrals') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🔗</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('referrals') ? 'text-white' : 'text-slate-400'">
                                    Referidos
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Crea enlaces de recomendación y recompensa a tus promotores.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('referrals') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('referrals')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="referrals" class="hidden" :checked="selectedModules.includes('referrals')">
                        </div>

                        <!-- Anuncios -->
                        <div @click="toggleModule('announcements')"
                             class="p-5 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none md:col-span-2 group flex gap-4"
                             :class="selectedModules.includes('announcements') 
                                 ? 'bg-slate-900/80 border-primary/50 shadow-[0_0_20px_rgba(var(--color-primary-rgb,99,102,241),0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            
                            <!-- Icon Container -->
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300"
                                 :class="selectedModules.includes('announcements') ? 'bg-primary/20 text-white shadow-inner' : 'bg-white/5 text-slate-400'">
                                <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📢</span>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-grow space-y-1 pr-6">
                                <h4 class="text-xs font-black tracking-wider uppercase"
                                    :class="selectedModules.includes('announcements') ? 'text-white' : 'text-slate-400'">
                                    Marketing
                                </h4>
                                <p class="text-[10px] text-slate-400 leading-normal font-medium">
                                    Crea banners promocionales u ofertas destacadas en la cabecera de tu menú para atraer más atención.
                                </p>
                            </div>

                            <!-- Selection Indicator -->
                            <div class="absolute right-4 top-5 w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300"
                                 :class="selectedModules.includes('announcements') ? 'bg-primary border-primary text-slate-950 scale-110' : 'border-white/20 text-transparent'">
                                <i class="fas fa-check text-[9px] font-black" x-show="selectedModules.includes('announcements')"></i>
                            </div>

                            <input type="checkbox" name="enabled_modules[]" value="announcements" class="hidden" :checked="selectedModules.includes('announcements')">
                        </div>

                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="block w-full text-center bg-gradient-to-r from-primary to-secondary hover:brightness-110 text-white font-extrabold py-4.5 rounded-2xl transition-all duration-300 text-xs uppercase tracking-widest shadow-[0_4px_25px_rgba(var(--color-primary-rgb,99,102,241),0.3)] active:scale-[0.98] border border-white/10">
                            Comenzar e ir al panel <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>

                </form>
            </div>
            
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="w-full py-6 text-xs text-slate-500 relative z-10 border-t border-white/5">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
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
