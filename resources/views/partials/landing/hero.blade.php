<section id="inicio" class="relative pt-12 md:pt-20 pb-12 md:pb-20 px-4 max-w-7xl mx-auto overflow-hidden z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">

        <div class="lg:col-span-6 text-center lg:text-left space-y-6">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.08]">
                Tu negocio vende solo con un
                <span class="block mt-1 bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent">
                    menú por WhatsApp
                </span>
            </h1>

            <p class="text-base md:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                Arma tu catálogo con fotos y precios. Tus clientes eligen, pedidos y te llegan ordenados al WhatsApp o Telegram.
                <strong class="text-white font-semibold">Listo en minutos</strong>, sin saber de páginas web.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-xl mx-auto lg:mx-0 text-left">
                <div class="landing-benefit-card flex items-start gap-3 bg-white/[0.04] border border-white/10 rounded-2xl p-3 transition-all backdrop-blur-sm">
                    <span class="text-xl shrink-0">📱</span>
                    <div>
                        <p class="text-xs font-black text-white">Fácil de usar</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Como usar el celular</p>
                    </div>
                </div>
                <div class="landing-benefit-card flex items-start gap-3 bg-white/[0.04] border border-white/10 rounded-2xl p-3 transition-all backdrop-blur-sm">
                    <span class="text-xl shrink-0">💬</span>
                    <div>
                        <p class="text-xs font-black text-white">Pedidos claros</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Directo a tu chat</p>
                    </div>
                </div>
                <div class="landing-benefit-card flex items-start gap-3 bg-white/[0.04] border border-white/10 rounded-2xl p-3 transition-all backdrop-blur-sm">
                    <span class="text-xl shrink-0">🎨</span>
                    <div>
                        <p class="text-xs font-black text-white">Tu marca</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Logo y colores</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                <a href="/register"
                   class="w-full sm:w-auto text-center bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-black px-8 py-4 rounded-2xl shadow-[0_0_25px_rgba(168,85,247,0.35)] transition-all text-sm md:text-base">
                    Probar gratis 7 días
                </a>
                <button type="button" @click="scrollTo('explorar')"
                        class="w-full sm:w-auto text-center border border-white/15 bg-white/5 hover:bg-white/10 text-white font-extrabold px-8 py-4 rounded-2xl transition-all text-sm md:text-base">
                    Ver tiendas de ejemplo
                </button>
            </div>
            <p class="text-[11px] text-purple-200/80 font-semibold">7 días gratis · Sin tarjeta · Cancelas cuando quieras</p>
        </div>

        <!-- Demo interactiva -->
        <div class="lg:col-span-6 relative flex flex-col items-center">
            <div class="flex flex-wrap justify-center gap-2 mb-5 w-full max-w-md">
                <button type="button" @click="heroDemoStep = 1"
                        :class="heroDemoStep === 1 ? 'landing-step-pill is-active' : ''"
                        class="landing-step-pill text-[11px] font-bold px-3 py-2 rounded-full border border-slate-700 text-slate-400 transition-all">
                    ① Productos
                </button>
                <button type="button" @click="heroDemoStep = 2"
                        :class="heroDemoStep === 2 ? 'landing-step-pill is-active' : ''"
                        class="landing-step-pill text-[11px] font-bold px-3 py-2 rounded-full border border-slate-700 text-slate-400 transition-all">
                    ② Colores
                </button>
                <button type="button" @click="heroDemoStep = 3"
                        :class="heroDemoStep === 3 ? 'landing-step-pill is-active' : ''"
                        class="landing-step-pill text-[11px] font-bold px-3 py-2 rounded-full border border-slate-700 text-slate-400 transition-all">
                    ③ Pedido
                </button>
            </div>

            <div class="relative w-full max-w-[340px] landing-float">
                <div class="absolute -top-3 -right-2 z-20 bg-cyan-500 text-slate-950 text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg">
                    Toca los pasos ↑
                </div>
                <div class="bg-slate-900 border-[10px] border-slate-800 rounded-[2.5rem] p-4 shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden">
                    <div class="bg-slate-50 rounded-[1.75rem] overflow-hidden min-h-[380px] flex flex-col">
                        <div class="bg-gradient-to-r from-purple-600 to-cyan-500 p-4 text-center text-white">
                            <div class="w-14 h-14 mx-auto rounded-full bg-white/20 flex items-center justify-center text-lg font-black mb-2">YB</div>
                            <p class="font-black text-sm">Tu tienda aquí</p>
                        </div>

                        <div class="p-4 flex-1" x-show="heroDemoStep === 1" x-transition>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-3 text-center">Sube tus productos</p>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ([['🍔', 'Combo', '$12'], ['🥤', 'Bebida', '$3'], ['🍰', 'Postre', '$8'], ['⭐', 'Especial', '$15']] as $product)
                                    <div class="bg-white rounded-xl p-3 border border-slate-100 text-center shadow-sm">
                                        <p class="text-lg mb-1">{{ $product[0] }}</p>
                                        <p class="text-[10px] font-bold text-slate-700">{{ $product[1] }}</p>
                                        <p class="text-[9px] text-purple-600 font-black mt-1">{{ $product[2] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-4 flex-1" x-show="heroDemoStep === 2" x-transition>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-3 text-center">Elige tus colores</p>
                            <div class="flex justify-center gap-3 mb-4">
                                <span class="w-12 h-12 rounded-full bg-[#E60067] ring-4 ring-purple-200 shadow-md"></span>
                                <span class="w-12 h-12 rounded-full bg-[#C6A100] ring-2 ring-slate-200"></span>
                                <span class="w-12 h-12 rounded-full bg-[#0b0f19] ring-2 ring-slate-200"></span>
                            </div>
                            <p class="text-xs text-slate-500 text-center">Así se verá tu menú con tu estilo</p>
                        </div>

                        <div class="p-4 flex-1 flex flex-col justify-center" x-show="heroDemoStep === 3" x-transition>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-3 text-center">Llega a tu WhatsApp</p>
                            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-3 text-[11px] text-slate-700 leading-relaxed shadow-inner">
                                <p class="font-black text-emerald-700 mb-1">Nuevo pedido 🛒</p>
                                <p>2x Hamburguesa especial</p>
                                <p>1x Refresco</p>
                                <p class="font-black mt-2">Total: $28 · Delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Accesos rápidos -->
<nav class="relative z-10 max-w-4xl mx-auto px-4 -mt-2 mb-6" aria-label="Accesos rápidos">
    <div class="grid grid-cols-3 gap-2 md:gap-3 bg-white/[0.05] border border-white/12 rounded-2xl p-2 md:p-3 backdrop-blur-md">
        <button type="button" @click="scrollTo('explorar')"
                class="flex flex-col items-center gap-1 py-3 md:py-4 rounded-xl hover:bg-purple-500/15 transition-all text-center">
            <i class="fas fa-store text-purple-400 text-lg"></i>
            <span class="text-[10px] md:text-xs font-black text-white">Tiendas</span>
        </button>
        <button type="button" @click="scrollTo('como-funciona')"
                class="flex flex-col items-center gap-1 py-3 md:py-4 rounded-xl hover:bg-cyan-500/15 transition-all text-center">
            <i class="fas fa-hand-pointer text-cyan-400 text-lg"></i>
            <span class="text-[10px] md:text-xs font-black text-white">Cómo funciona</span>
        </button>
        <button type="button" @click="scrollTo('precios')"
                class="flex flex-col items-center gap-1 py-3 md:py-4 rounded-xl hover:bg-pink-500/15 transition-all text-center">
            <i class="fas fa-gem text-pink-400 text-lg"></i>
            <span class="text-[10px] md:text-xs font-black text-white">Precios</span>
        </button>
    </div>
</nav>
