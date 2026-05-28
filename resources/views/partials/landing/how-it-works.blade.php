<section id="como-funciona" class="py-14 md:py-20 relative overflow-hidden z-10 bg-transparent">
    <div class="landing-section-glow top-0 left-[-8%] w-96 h-96 bg-cyan-400/20" aria-hidden="true"></div>
    <div class="landing-section-glow bottom-8 right-0 w-[26rem] h-[26rem] bg-purple-400/18" aria-hidden="true"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-6 md:mb-8 text-center">
            <span class="text-[10px] font-black uppercase tracking-widest text-cyan-700 bg-cyan-50 border border-cyan-200 px-3 py-1 rounded-full">3 pasos + tutorial</span>
            <h2 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight mt-3">Así de fácil funciona</h2>
            <p class="text-xs md:text-sm text-slate-600 mt-2 max-w-xl mx-auto">
                Toca cada paso y mira el tutorial. No necesitas saber de tecnología.
            </p>
        </div>

        <div class="flex sm:hidden gap-2 justify-center mb-4 flex-wrap">
            @foreach ([1 => 'Productos', 2 => 'Estilo', 3 => 'Pedidos'] as $num => $label)
                <button type="button" @click="activeHowStep = {{ $num }}"
                        :class="activeHowStep === {{ $num }} ? 'landing-step-pill is-active' : ''"
                        class="landing-step-pill text-[10px] font-bold px-3 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white">
                    {{ $num }}. {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6 md:mb-8 max-w-5xl mx-auto">
            <button type="button" @click="activeHowStep = 1"
                    :class="activeHowStep === 1 ? 'landing-how-card is-active' : ''"
                    class="landing-how-card bg-white border border-slate-200 p-4 rounded-2xl flex items-start gap-3 text-left w-full shadow-sm sm:cursor-default">
                <span class="w-9 h-9 shrink-0 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-sm font-black">1</span>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-box-open text-purple-600 text-sm"></i>
                        <h3 class="text-sm font-black text-slate-900">Sube tus productos</h3>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-snug">Foto, nombre, precio y categorías en tu mostrador digital.</p>
                </div>
            </button>

            <button type="button" @click="activeHowStep = 2"
                    :class="activeHowStep === 2 ? 'landing-how-card is-active' : ''"
                    class="landing-how-card bg-white border border-slate-200 p-4 rounded-2xl flex items-start gap-3 text-left w-full shadow-sm sm:cursor-default">
                <span class="w-9 h-9 shrink-0 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-sm font-black">2</span>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-palette text-cyan-600 text-sm"></i>
                        <h3 class="text-sm font-black text-slate-900">Ponle tu estilo</h3>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-snug">Logo, portada y colores de tu marca al instante.</p>
                </div>
            </button>

            <button type="button" @click="activeHowStep = 3"
                    :class="activeHowStep === 3 ? 'landing-how-card is-active' : ''"
                    class="landing-how-card bg-white border border-slate-200 p-4 rounded-2xl flex items-start gap-3 text-left w-full shadow-sm sm:cursor-default">
                <span class="w-9 h-9 shrink-0 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-black">3</span>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fab fa-whatsapp text-emerald-600 text-sm"></i>
                        <h3 class="text-sm font-black text-slate-900">Recibe pedidos</h3>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-snug">Comparte tu enlace; el pedido llega ordenado a WhatsApp o Telegram.</p>
                </div>
            </button>
        </div>

        <div class="w-full max-w-6xl mx-auto">
            @include('partials.landing.tutorial-video-player')
        </div>

        <div class="mt-8 text-center">
            <a href="/register"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black px-6 py-3 rounded-xl shadow-lg hover:scale-[1.02] transition-transform text-sm">
                Empezar mi prueba gratis
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
