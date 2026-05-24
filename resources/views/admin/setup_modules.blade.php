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

        .premium-glow {
            box-shadow: 0 0 25px rgba(var(--color-primary-rgb, 99, 102, 241), 0.2);
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

<body class="min-h-screen text-slate-100 flex flex-col justify-between relative overflow-x-hidden selection:bg-primary selection:text-white">

    <!-- BACKGROUND ANIMATIONS -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913]">
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-primary/10 to-secondary/15 blur-[120px] wave-bg"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-secondary/10 to-blue-600/10 blur-[160px] wave-bg" style="animation-delay: -3s;"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-primary/5 via-secondary/5 to-transparent blur-[160px] wave-bg" style="animation-delay: -6s;"></div>
    </div>

    <!-- HEADER -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <div class="flex items-center gap-2">
            <span class="text-xl font-black text-white tracking-wider uppercase">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Store</span>
            </span>
            <span class="bg-white/5 border border-white/10 px-2.5 py-0.5 rounded-md text-[9px] uppercase font-bold text-slate-400 tracking-wider">
                Bienvenido
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
              selectedModules: ['categories', 'products', 'orders', 'clients', 'announcements'],
              toggleModule(module) {
                  if (this.selectedModules.includes(module)) {
                      this.selectedModules = this.selectedModules.filter(m => m !== module);
                  } else {
                      this.selectedModules.push(module);
                  }
              }
          }">
        
        <div class="w-full max-w-2xl">
            
            <div class="w-full bg-[#0d1127]/60 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-8 md:p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-48 h-48 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="text-center mb-8 relative z-10">
                    <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/30 rounded-full px-5 py-2 mb-4 shadow-[0_0_25px_rgba(99,102,241,0.15)]">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span class="text-primary text-[10px] font-black uppercase tracking-widest">
                            🚀 Primer ingreso al panel administrativo
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Personaliza tu Espacio de Trabajo</h1>
                    <p class="text-xs text-slate-400 mt-2 max-w-md mx-auto leading-relaxed">
                        Selecciona qué módulos u opciones del menú deseas tener visibles en tu panel de administración para <span class="text-white font-bold">{{ $shop->name }}</span>. Podrás cambiar esto después desde la configuración.
                    </p>
                </div>

                <form action="{{ route('admin.setup-modules.save', ['shop_slug' => $shop->slug]) }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    
                    <!-- MODULE CARDS GRID -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Categorías -->
                        <div @click="toggleModule('categories')"
                             class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group"
                             :class="selectedModules.includes('categories') 
                                 ? 'bg-primary/5 border-primary/50 shadow-[0_0_15px_rgba(99,102,241,0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📦</span>
                                    <h4 class="text-xs font-black text-white uppercase tracking-wider">Categorías</h4>
                                </div>
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                     :class="selectedModules.includes('categories') ? 'bg-primary border-primary text-white' : 'border-white/20'">
                                    <i class="fas fa-check text-[9px]" x-show="selectedModules.includes('categories')"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 leading-normal">
                                Crea y organiza tus productos por grupos, pasillos o clasificaciones personalizadas.
                            </p>
                            <input type="checkbox" name="enabled_modules[]" value="categories" class="hidden" :checked="selectedModules.includes('categories')">
                        </div>

                        <!-- Productos -->
                        <div @click="toggleModule('products')"
                             class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group"
                             :class="selectedModules.includes('products') 
                                 ? 'bg-primary/5 border-primary/50 shadow-[0_0_15px_rgba(99,102,241,0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🍔</span>
                                    <h4 class="text-xs font-black text-white uppercase tracking-wider">Productos</h4>
                                </div>
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                     :class="selectedModules.includes('products') ? 'bg-primary border-primary text-white' : 'border-white/20'">
                                    <i class="fas fa-check text-[9px]" x-show="selectedModules.includes('products')"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 leading-normal">
                                Gestiona tus artículos o platillos con precios, imágenes, descripciones y disponibilidad.
                            </p>
                            <input type="checkbox" name="enabled_modules[]" value="products" class="hidden" :checked="selectedModules.includes('products')">
                        </div>

                        <!-- Órdenes -->
                        <div @click="toggleModule('orders')"
                             class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group"
                             :class="selectedModules.includes('orders') 
                                 ? 'bg-primary/5 border-primary/50 shadow-[0_0_15px_rgba(99,102,241,0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📋</span>
                                    <h4 class="text-xs font-black text-white uppercase tracking-wider">Órdenes</h4>
                                </div>
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                     :class="selectedModules.includes('orders') ? 'bg-primary border-primary text-white' : 'border-white/20'">
                                    <i class="fas fa-check text-[9px]" x-show="selectedModules.includes('orders')"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 leading-normal">
                                Recibe, procesa y despacha pedidos en tiempo real con facturación y notificaciones.
                            </p>
                            <input type="checkbox" name="enabled_modules[]" value="orders" class="hidden" :checked="selectedModules.includes('orders')">
                        </div>

                        <!-- Clientes -->
                        <div @click="toggleModule('clients')"
                             class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none group"
                             :class="selectedModules.includes('clients') 
                                 ? 'bg-primary/5 border-primary/50 shadow-[0_0_15px_rgba(99,102,241,0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">👥</span>
                                    <h4 class="text-xs font-black text-white uppercase tracking-wider">Clientes</h4>
                                </div>
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                     :class="selectedModules.includes('clients') ? 'bg-primary border-primary text-white' : 'border-white/20'">
                                    <i class="fas fa-check text-[9px]" x-show="selectedModules.includes('clients')"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 leading-normal">
                                Visualiza tus clientes recurrentes, historiales de compra y canales directos de contacto.
                            </p>
                            <input type="checkbox" name="enabled_modules[]" value="clients" class="hidden" :checked="selectedModules.includes('clients')">
                        </div>

                        <!-- Anuncios -->
                        <div @click="toggleModule('announcements')"
                             class="p-4 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden cursor-pointer select-none md:col-span-2 group"
                             :class="selectedModules.includes('announcements') 
                                 ? 'bg-primary/5 border-primary/50 shadow-[0_0_15px_rgba(99,102,241,0.15)] scale-[1.01]' 
                                 : 'bg-slate-900/30 border-white/5 hover:border-white/10 hover:bg-slate-900/50'">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📢</span>
                                    <h4 class="text-xs font-black text-white uppercase tracking-wider">Banners / Anuncios</h4>
                                </div>
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                     :class="selectedModules.includes('announcements') ? 'bg-primary border-primary text-white' : 'border-white/20'">
                                    <i class="fas fa-check text-[9px]" x-show="selectedModules.includes('announcements')"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 leading-normal">
                                Crea banners promocionales, alertas flotantes u ofertas en la cabecera de tu menú para atraer más atención.
                            </p>
                            <input type="checkbox" name="enabled_modules[]" value="announcements" class="hidden" :checked="selectedModules.includes('announcements')">
                        </div>

                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-6">
                        <button type="submit" 
                                class="block w-full text-center bg-gradient-to-r from-primary to-secondary hover:brightness-110 text-slate-950 font-black py-4.5 rounded-2xl transition-all duration-300 text-xs uppercase tracking-widest shadow-[0_0_30px_rgba(99,102,241,0.25)] active:scale-[0.98]">
                            Comenzar e ir al panel <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>

                </form>
            </div>
            
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="w-full py-6 text-xs text-slate-500 relative z-10 border-t border-white/5">
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
