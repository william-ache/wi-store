<!DOCTYPE html>
<html lang="es" class="wistore-ui wistore-landing">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @include('partials.seo.head', ['seo' => \App\Support\SeoMeta::forContacto()])

    @include('partials.landing.head-assets')

    @include('partials.global.wistore-scrollbar')
    @include('partials.landing.landing-scrollbar')
    @include('partials.landing.ux-styles')
    <style>
body {
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
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
    <a href="{{ route('home') }}" class="fixed top-6 left-6 md:top-8 md:left-8 z-50 bg-[#0d1127]/80 backdrop-blur-md border border-white/10 hover:border-purple-500/50 text-white font-bold px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2 transition-all duration-300 text-xs md:text-sm group" aria-label="Volver al inicio de WIStore">
        <i class="fas fa-arrow-left text-purple-300 group-hover:-translate-x-1 transition-transform" aria-hidden="true"></i>
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
                <h2 id="contact-form-heading" class="text-xl font-black text-white mb-6">Envíanos un mensaje</h2>
                
                <form action="#" method="POST" class="space-y-6" aria-labelledby="contact-form-heading">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs text-slate-300 uppercase font-bold tracking-wider mb-2">Nombre completo</label>
                            <input type="text" id="name" name="name" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="Ej: Juan Pérez">
                        </div>
                        <div>
                            <label for="shop_name" class="block text-xs text-slate-300 uppercase font-bold tracking-wider mb-2">Nombre de tu comercio</label>
                            <input type="text" id="shop_name" name="shop_name" class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="Ej: Tienda Click">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-xs text-slate-300 uppercase font-bold tracking-wider mb-2">Correo electrónico</label>
                            <input type="email" id="email" name="email" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="juan@correo.com">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs text-slate-300 uppercase font-bold tracking-wider mb-2">Teléfono (WhatsApp / Telegram)</label>
                            <input type="tel" id="phone" name="phone" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600" placeholder="Ej: +58 412-0000000">
                        </div>
                    </div>

                    <div>
                        <label for="plan" class="block text-xs text-slate-300 uppercase font-bold tracking-wider mb-2">Plan de interés</label>
                        <select id="plan" name="plan" class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors">
                            <option value="standard" class="bg-[#0b0d19]">Plan Emprendedor ($8.99/mes)</option>
                            <option value="premium" class="bg-[#0b0d19]" selected>Plan Negocio (7 días gratis • $14.99/mes)</option>
                            <option value="custom" class="bg-[#0b0d19]">Plan Personalizado (A medida)</option>
                            <option value="general" class="bg-[#0b0d19]">Consulta General / Soporte</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-xs text-slate-300 uppercase font-bold tracking-wider mb-2">Mensaje o requerimientos</label>
                        <textarea id="message" name="message" rows="4" required class="w-full bg-[#070913]/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition-colors placeholder:text-slate-600 resize-none" placeholder="Cuéntanos un poco sobre tu negocio y cómo podemos ayudarte..."></textarea>
                    </div>

                    <p class="text-[11px] text-slate-500 text-center">
                        También puedes escribirnos a
                        <a href="mailto:{{ $wistoreSupportEmail }}" class="text-cyan-300/90 hover:text-cyan-200 font-bold">{{ $wistoreSupportEmail }}</a>
                    </p>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-extrabold py-4 rounded-xl transition-all duration-300 shadow-[0_0_20px_rgba(168,85,247,0.3)] text-xs md:text-sm tracking-widest uppercase">
                        Enviar Consulta <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            <!-- Columna Canales Directos (Derecha 5/12) -->
            <div class="lg:col-span-5 flex flex-col justify-between gap-6">
                <!-- Información Directa de Contacto -->
                <div class="bg-[#0d1127]/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 space-y-6">
                    <h2 class="text-xl font-black text-white mb-2">Soporte inmediato</h2>
                    
                    <div class="space-y-4">
                        <!-- Canal WhatsApp -->
                        <a href="https://wa.me/584121305420?text=Hola!%20Deseo%20más%20información%20sobre%20los%20planes%20de%20WIStore" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 bg-[#10b981]/10 hover:bg-[#10b981]/20 border border-[#10b981]/30 p-4 rounded-2xl transition-all duration-300 group">
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
                        <a href="mailto:{{ $wistoreSupportEmail }}" class="flex items-center gap-4 bg-cyan-500/5 hover:bg-cyan-500/10 border border-cyan-500/20 hover:border-cyan-500/35 p-4 rounded-2xl transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-full bg-cyan-500/15 flex items-center justify-center text-cyan-300">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-slate-400 uppercase font-black tracking-widest">Correo de Soporte</p>
                                <p class="text-sm font-bold text-white group-hover:text-cyan-200 transition-colors break-all">{{ $wistoreSupportEmail }}</p>
                            </div>
                            <i class="fas fa-chevron-right ml-auto text-slate-500 group-hover:translate-x-1 transition-transform shrink-0"></i>
                        </a>
                    </div>
                </div>

                <!-- Acordeón FAQs Rápido (AlpineJS) -->
                <div class="bg-[#0d1127]/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-8 flex-1" x-data="{ activeFaq: null }">
                    <h2 class="text-lg font-black text-white mb-4">Preguntas frecuentes</h2>
                    
                    <div class="space-y-3">
                        <!-- FAQ 1 -->
                        <div class="border-b border-white/5 pb-3">
                            <button type="button" id="faq-btn-1" @click="activeFaq = activeFaq === 1 ? null : 1"
                                :aria-expanded="activeFaq === 1"
                                aria-controls="faq-panel-1"
                                class="w-full flex items-center justify-between text-left text-xs font-bold text-slate-200 hover:text-white py-1.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/80 rounded">
                                <span>¿Hay cargos por instalación de catálogo?</span>
                                <i class="fas" :class="activeFaq === 1 ? 'fa-minus text-purple-300' : 'fa-plus text-slate-400'" aria-hidden="true"></i>
                            </button>
                            <div id="faq-panel-1" x-show="activeFaq === 1" x-transition.opacity role="region" aria-labelledby="faq-btn-1" class="text-[11px] text-slate-300 mt-2 leading-relaxed">
                                No, el registro y la habilitación de tu tienda en cualquiera de nuestros planes es inmediato. Configuras tu catálogo interactivo y comienzas a vender el mismo día.
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="border-b border-white/5 pb-3">
                            <button type="button" id="faq-btn-2" @click="activeFaq = activeFaq === 2 ? null : 2"
                                :aria-expanded="activeFaq === 2"
                                aria-controls="faq-panel-2"
                                class="w-full flex items-center justify-between text-left text-xs font-bold text-slate-200 hover:text-white py-1.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/80 rounded">
                                <span>¿Cobran comisiones por ventas en WhatsApp?</span>
                                <i class="fas" :class="activeFaq === 2 ? 'fa-minus text-purple-300' : 'fa-plus text-slate-400'" aria-hidden="true"></i>
                            </button>
                            <div id="faq-panel-2" x-show="activeFaq === 2" x-transition.opacity role="region" aria-labelledby="faq-btn-2" class="text-[11px] text-slate-300 mt-2 leading-relaxed">
                                Absolutamente 0%. En WIStore creemos en el crecimiento de los comercios. Pagas únicamente tu suscripción fija al mes; todas tus ventas y transacciones van directamente a tus cuentas bancarias.
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="pb-2">
                            <button type="button" id="faq-btn-3" @click="activeFaq = activeFaq === 3 ? null : 3"
                                :aria-expanded="activeFaq === 3"
                                aria-controls="faq-panel-3"
                                class="w-full flex items-center justify-between text-left text-xs font-bold text-slate-200 hover:text-white py-1.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/80 rounded">
                                <span>¿Cómo se realiza el pago a tasa BCV?</span>
                                <i class="fas" :class="activeFaq === 3 ? 'fa-minus text-purple-300' : 'fa-plus text-slate-400'" aria-hidden="true"></i>
                            </button>
                            <div id="faq-panel-3" x-show="activeFaq === 3" x-transition.opacity role="region" aria-labelledby="faq-btn-3" class="text-[11px] text-slate-300 mt-2 leading-relaxed">
                                El sistema genera tu recibo mensual indexado en dólares ($) y calcula el total en Bolívares (Bs.) basándose en la tasa oficial del día emitida por el Banco Central de Venezuela. Puedes pagar con Pago Móvil o transferencia bancaria.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <!-- FOOTER LIGERO -->
    <footer class="border-t border-white/5 py-8 text-center text-xs text-slate-400 relative z-10">
        <p>© 2026 WIStore. Todos los derechos reservados.</p>
    </footer>

    @include('partials.public.chat')
</body>
</html>
