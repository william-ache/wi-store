<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Contacto y Soporte - WIStore</title>
    
    <!-- Tailwind CSS -->
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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        html {
            scroll-behavior: smooth;
            scrollbar-width: thin;
            scrollbar-color: #a855f7 #070913;
        }
        body {
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #070913;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #a855f7 0%, #22d3ee 100%);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #c084fc 0%, #67e8f9 100%);
        }

        /* GPU hardware acceleration */
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
<body class="bg-[#070913] text-gray-100 min-h-screen selection:bg-purple-500 selection:text-white relative">

    <!-- CAPA DE FONDO GLOBAL (Base Canvas & Neón GPU) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] blur-accelerated"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated"></div>

        <svg class="absolute inset-0 w-full h-full opacity-35" preserveAspectRatio="none" viewBox="0 0 1440 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="neonGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.8" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#a855f7" stop-opacity="0" />
                </linearGradient>
                <linearGradient id="neonGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                    <stop offset="50%" stop-color="#ec4899" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0" />
                </linearGradient>
            </defs>
            <path d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800" stroke="url(#neonGradient1)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000" stroke="url(#neonGradient2)" stroke-width="1.5" stroke-linecap="round" fill="none" />
        </svg>
    </div>

    <!-- Botón Flotante Volver -->
    <a href="{{ route('home') }}" class="fixed top-6 left-6 md:top-8 md:left-8 z-50 bg-[#0d1127]/80 backdrop-blur-md border border-white/10 hover:border-purple-500/50 text-white font-bold px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2 transition-all duration-300 text-xs md:text-sm group">
        <i class="fas fa-arrow-left text-purple-400 group-hover:-translate-x-1 transition-transform"></i>
        <span>Volver al Inicio</span>
    </a>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="relative z-10 py-24 md:py-32 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        
        <!-- Cabecera -->
        <div class="text-center mb-16">
            <span class="bg-cyan-600/20 text-cyan-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-cyan-500/30 shadow-[0_0_15px_rgba(34,211,238,0.2)]">
                Canales de Atención
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">Ponte en Contacto</h1>
            <p class="text-sm md:text-base text-slate-400 mt-3 max-w-2xl mx-auto leading-relaxed">
                ¿Tienes dudas sobre nuestros planes, necesitas una demo personalizada o deseas cotizar el Plan Personalizado? Escríbenos y te responderemos en tiempo récord.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Columna Formulario (Izquierda 7/12) -->
            <div class="lg:col-span-7 bg-[#0d1127]/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-10 shadow-2xl">
                <h3 class="text-xl font-black text-white mb-6">Envíanos un Mensaje</h3>
                
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Nombre Completo</label>
                            <input type="text" id="name" name="name" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="Ej: Juan Pérez">
                        </div>
                        <div>
                            <label for="shop_name" class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Nombre de tu Comercio</label>
                            <input type="text" id="shop_name" name="shop_name" class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="Ej: Tienda Click">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Correo Electrónico</label>
                            <input type="email" id="email" name="email" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="juan@correo.com">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Teléfono (WhatsApp / Telegram)</label>
                            <input type="tel" id="phone" name="phone" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="Ej: +58 412-0000000">
                        </div>
                    </div>

                    <div>
                        <label for="plan" class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Plan de Interés</label>
                        <select id="plan" name="plan" class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors">
                            <option value="standard" class="bg-[#0b0d19]">Plan Standard ($14.99/mes)</option>
                            <option value="premium" class="bg-[#0b0d19]" selected>Plan Premium (7 Días Gratis • $24.99/mes)</option>
                            <option value="custom" class="bg-[#0b0d19]">Plan Personalizado (A medida)</option>
                            <option value="general" class="bg-[#0b0d19]">Consulta General / Soporte</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Mensaje o Requerimientos</label>
                        <textarea id="message" name="message" rows="4" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600 resize-none" placeholder="Cuéntanos un poco sobre tu negocio y cómo podemos ayudarte..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-extrabold py-4 rounded-xl transition-all duration-300 shadow-[0_0_20px_rgba(168,85,247,0.3)] text-xs md:text-sm tracking-widest uppercase">
                        Enviar Consulta <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            <!-- Columna Canales Directos (Derecha 5/12) -->
            <div class="lg:col-span-5 flex flex-col justify-between gap-6">
                <!-- Información Directa de Contacto -->
                <div class="bg-[#0d1127]/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 space-y-6">
                    <h3 class="text-xl font-black text-white mb-2">Soporte Inmediato</h3>
                    
                    <div class="space-y-4">
                        <!-- Canal WhatsApp -->
                        <a href="https://wa.me/584121305420?text=Hola!%20Deseo%20más%20información%20sobre%20los%20planes%20de%20WIStore" target="_blank" class="flex items-center gap-4 bg-[#10b981]/10 hover:bg-[#10b981]/20 border border-[#10b981]/30 p-4 rounded-2xl transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-full bg-[#10b981]/20 flex items-center justify-center text-[#10b981]">
                                <i class="fab fa-whatsapp text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-black tracking-widest">WhatsApp / Telegram</p>
                                <p class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">+58 (412) 130-5420</p>
                            </div>
                            <i class="fas fa-chevron-right ml-auto text-slate-500 group-hover:translate-x-1 transition-transform"></i>
                        </a>

                        <!-- Canal Email -->
                        <div class="flex items-center gap-4 bg-white/5 border border-white/5 p-4 rounded-2xl">
                            <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-slate-500">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase font-black tracking-widest">Correo de Soporte</p>
                                <p class="text-sm font-bold text-slate-400">Próximamente</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acordeón FAQs Rápido (AlpineJS) -->
                <div class="bg-[#0d1127]/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 flex-1" x-data="{ activeFaq: null }">
                    <h3 class="text-lg font-black text-white mb-4">Preguntas Frecuentes</h3>
                    
                    <div class="space-y-3">
                        <!-- FAQ 1 -->
                        <div class="border-b border-white/5 pb-3">
                            <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full flex items-center justify-between text-left text-xs font-bold text-slate-200 hover:text-white py-1.5 focus:outline-none">
                                <span>¿Hay cargos por instalación de catálogo?</span>
                                <i class="fas" :class="activeFaq === 1 ? 'fa-minus text-purple-400' : 'fa-plus text-slate-500'"></i>
                            </button>
                            <div x-show="activeFaq === 1" x-transition.opacity class="text-[11px] text-slate-400 mt-2 leading-relaxed">
                                No, el registro y la habilitación de tu tienda en cualquiera de nuestros planes es inmediato. Configuras tu catálogo interactivo y comienzas a vender el mismo día.
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="border-b border-white/5 pb-3">
                            <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full flex items-center justify-between text-left text-xs font-bold text-slate-200 hover:text-white py-1.5 focus:outline-none">
                                <span>¿Cobran comisiones por ventas en WhatsApp?</span>
                                <i class="fas" :class="activeFaq === 2 ? 'fa-minus text-purple-400' : 'fa-plus text-slate-500'"></i>
                            </button>
                            <div x-show="activeFaq === 2" x-transition.opacity class="text-[11px] text-slate-400 mt-2 leading-relaxed">
                                Absolutamente 0%. En WIStore creemos en el crecimiento de los comercios. Pagas únicamente tu suscripción fija al mes; todas tus ventas y transacciones van directamente a tus cuentas bancarias.
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="pb-2">
                            <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full flex items-center justify-between text-left text-xs font-bold text-slate-200 hover:text-white py-1.5 focus:outline-none">
                                <span>¿Cómo se realiza el pago a tasa BCV?</span>
                                <i class="fas" :class="activeFaq === 3 ? 'fa-minus text-purple-400' : 'fa-plus text-slate-500'"></i>
                            </button>
                            <div x-show="activeFaq === 3" x-transition.opacity class="text-[11px] text-slate-400 mt-2 leading-relaxed">
                                El sistema genera tu recibo mensual indexado en dólares ($) y calcula el total en Bolívares (Bs.) basándose en la tasa oficial del día emitida por el Banco Central de Venezuela. Puedes pagar con Pago Móvil o transferencia bancaria.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <!-- FOOTER LIGERO -->
    <footer class="border-t border-white/5 py-8 text-center text-xs text-slate-500 relative z-10">
        <p>© 2026 WIStore. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
