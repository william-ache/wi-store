<section id="como-funciona" class="py-20 md:py-28 relative overflow-hidden z-10 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-12 md:mb-16 text-center">
            <span class="text-[10px] font-black uppercase tracking-widest text-cyan-300 bg-cyan-500/10 border border-cyan-500/25 px-3 py-1 rounded-full">3 pasos</span>
            <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight mt-4">Así de fácil funciona</h2>
            <p class="text-sm md:text-base text-slate-400 mt-3 max-w-2xl mx-auto">
                Toca cada paso para ver qué haces. No necesitas saber de tecnología.
            </p>
        </div>

        <!-- Selector móvil / tablet -->
        <div class="flex md:hidden gap-2 justify-center mb-8 flex-wrap">
            @foreach ([1 => 'Productos', 2 => 'Colores', 3 => 'Pedidos'] as $num => $label)
                <button type="button" @click="activeHowStep = {{ $num }}"
                        :class="activeHowStep === {{ $num }} ? 'landing-step-pill is-active' : ''"
                        class="landing-step-pill text-xs font-bold px-4 py-2 rounded-full border border-slate-700 text-slate-400">
                    {{ $num }}. {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            <button type="button" @click="activeHowStep = 1"
                    :class="activeHowStep === 1 ? 'landing-how-card is-active' : ''"
                    class="landing-how-card bg-slate-900/20 border border-white/5 p-8 md:p-10 rounded-[2rem] flex flex-col items-center text-center transition-all duration-300 text-left md:cursor-default">
                <span class="w-12 h-12 rounded-2xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-xl font-black mb-4">1</span>
                <div class="w-16 h-16 rounded-full bg-slate-950 border border-purple-500/30 flex items-center justify-center mb-5 shadow-[0_0_25px_rgba(168,85,247,0.2)]">
                    <i class="fas fa-box-open text-2xl text-purple-400"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">Sube tus productos</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Foto, nombre, precio y listo. Agrupa por categorías como en un mostrador digital.</p>
            </button>

            <button type="button" @click="activeHowStep = 2"
                    :class="activeHowStep === 2 ? 'landing-how-card is-active' : ''"
                    class="landing-how-card bg-slate-900/20 border border-white/5 p-8 md:p-10 rounded-[2rem] flex flex-col items-center text-center transition-all duration-300 md:cursor-default">
                <span class="w-12 h-12 rounded-2xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center text-xl font-black mb-4">2</span>
                <div class="w-16 h-16 rounded-full bg-slate-950 border border-cyan-500/30 flex items-center justify-center mb-5 shadow-[0_0_25px_rgba(34,211,238,0.2)]">
                    <i class="fas fa-palette text-2xl text-cyan-400"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">Ponle tu estilo</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Logo, portada y colores de tu marca. El menú se ve profesional al instante.</p>
            </button>

            <button type="button" @click="activeHowStep = 3"
                    :class="activeHowStep === 3 ? 'landing-how-card is-active' : ''"
                    class="landing-how-card bg-slate-900/20 border border-white/5 p-8 md:p-10 rounded-[2rem] flex flex-col items-center text-center transition-all duration-300 md:cursor-default">
                <span class="w-12 h-12 rounded-2xl bg-pink-500/20 text-pink-300 flex items-center justify-center text-xl font-black mb-4">3</span>
                <div class="w-16 h-16 rounded-full bg-slate-950 border border-pink-500/30 flex items-center justify-center mb-5 shadow-[0_0_25px_rgba(236,72,153,0.2)]">
                    <i class="fab fa-whatsapp text-2xl text-emerald-400"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">Recibe pedidos</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Comparte tu enlace. El cliente pide y tú recibes el detalle ordenado en WhatsApp o Telegram.</p>
            </button>
        </div>

        <div class="mt-12 text-center">
            <a href="/register"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black px-8 py-4 rounded-2xl shadow-lg hover:scale-[1.02] transition-transform text-sm md:text-base">
                Empezar mi prueba gratis
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
