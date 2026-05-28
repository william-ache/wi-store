<section id="como-funciona" class="py-14 md:py-20 relative overflow-hidden z-10 bg-transparent">
    <div class="landing-section-glow top-0 left-[-8%] w-96 h-96 bg-purple-400/15" aria-hidden="true"></div>
    <div class="landing-section-glow bottom-8 right-0 w-[26rem] h-[26rem] bg-fuchsia-400/12" aria-hidden="true"></div>
    <div class="landing-container relative z-10">
        <div class="mb-10 md:mb-12 text-center">
            <span class="text-[10px] font-black uppercase tracking-widest text-purple-700 bg-purple-50 border border-purple-200 px-3 py-1 rounded-full">3 pasos</span>
            <h2 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight mt-3">Así de fácil funciona</h2>
            <p class="text-sm md:text-base text-slate-500 mt-2 max-w-xl mx-auto leading-relaxed">
                En tres pasos tienes tu menú listo. Sin saber de páginas web.
            </p>
        </div>

        <div class="landing-how-grid grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6 max-w-6xl mx-auto">
            {{-- Paso 1: Registro --}}
            <article class="landing-how-step h-full">
                <div class="landing-how-step__visual" aria-hidden="true">
                    <div class="landing-how-mock">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="w-8 h-8 rounded-lg landing-how-brand-gradient flex items-center justify-center shrink-0 shadow-sm shadow-purple-500/20">
                                    <i class="fas fa-arrow-up-right text-white text-[10px]"></i>
                                </span>
                                <span class="text-xs font-black text-slate-900 truncate">Crear cuenta</span>
                            </div>
                            <span class="text-[8px] font-black uppercase tracking-wide px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200 shrink-0">
                                {{ $wiStoreTrialDays }} días
                            </span>
                        </div>
                        <div class="space-y-2 mb-3">
                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-2">
                                <p class="text-[8px] font-bold uppercase text-slate-400">Correo</p>
                                <p class="text-[10px] font-semibold text-slate-700 truncate">hola@tunegocio.com</p>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-2">
                                <p class="text-[8px] font-bold uppercase text-slate-400">Negocio</p>
                                <p class="text-[10px] font-semibold text-slate-700 truncate">Mi tienda WI-Store</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-1.5 rounded-xl landing-how-brand-gradient-h text-white text-[10px] font-black py-2 shadow-sm shadow-purple-500/15">
                            <i class="fas fa-check text-[9px]"></i>
                            Cuenta creada
                        </div>
                    </div>
                </div>
                <div class="landing-how-step__body">
                    <h3 class="text-lg font-black text-slate-900">1. Regístrate</h3>
                    <p class="mt-2 text-sm leading-relaxed">
                        Crea tu cuenta gratis en segundos y activa tu prueba de {{ $wiStoreTrialDays }} días. Cancela cuando quieras.
                    </p>
                </div>
            </article>

            {{-- Paso 2: Catálogo --}}
            <article class="landing-how-step h-full">
                <div class="landing-how-step__visual" aria-hidden="true">
                    <div class="landing-how-mock landing-how-mock--catalog">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[9px] font-black uppercase tracking-wide text-slate-400">Catálogo</span>
                            <span class="text-[9px] font-bold text-slate-500">5 productos</span>
                        </div>
                        <div class="grid grid-cols-3 gap-1.5 flex-1">
                            @foreach ([
                                ['Café', '$2.50', 'from-fuchsia-600 to-purple-500'],
                                ['Jugo', '$3.00', 'from-purple-500 to-indigo-500'],
                                ['Torta', '$4.50', 'from-pink-500 to-fuchsia-500'],
                                ['Combo', '$6.00', 'from-violet-600 to-blue-500'],
                                ['Agua', '$1.00', 'from-indigo-500 to-blue-400'],
                            ] as $item)
                                <div class="rounded-lg overflow-hidden border border-slate-100">
                                    <div class="h-10 bg-gradient-to-br {{ $item[2] }}"></div>
                                    <div class="px-1 py-1 bg-white">
                                        <p class="text-[7px] font-bold text-slate-800 truncate">{{ $item[0] }}</p>
                                        <p class="text-[7px] font-black text-purple-600">{{ $item[1] }}</p>
                                    </div>
                                </div>
                            @endforeach
                            <button type="button" class="rounded-lg border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center min-h-[3.25rem] text-purple-600" tabindex="-1">
                                <span class="w-5 h-5 rounded-full bg-purple-50 flex items-center justify-center text-[10px] font-black">+</span>
                                <span class="text-[7px] font-bold mt-0.5">Añadir</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="landing-how-step__body">
                    <h3 class="text-lg font-black text-slate-900">2. Agregar productos</h3>
                    <p class="mt-2 text-sm leading-relaxed">
                        Sube tu menú con fotos, precios y categorías. Actualiza en segundos desde tu panel.
                    </p>
                </div>
            </article>

            {{-- Paso 3: Vender --}}
            <article class="landing-how-step h-full">
                <div class="landing-how-step__visual" aria-hidden="true">
                    <div class="landing-how-mock">
                        <div class="flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 mb-3">
                            <span class="text-[9px] font-semibold text-slate-600 truncate flex-1">wi-store.com/tu-menu</span>
                            <span class="shrink-0 w-6 h-6 rounded-md landing-how-brand-gradient flex items-center justify-center shadow-sm shadow-purple-500/15">
                                <i class="fas fa-link text-white text-[8px]"></i>
                            </span>
                        </div>
                        <div class="text-center mb-3">
                            <p class="text-[9px] font-black uppercase tracking-wide text-slate-400">Pedidos hoy</p>
                            <div class="flex items-center justify-center gap-2 mt-0.5">
                                <p class="text-3xl font-black text-slate-900 tabular-nums leading-none">12</p>
                                <span class="inline-flex items-center gap-1 text-[8px] font-black uppercase text-purple-700 bg-purple-50 border border-purple-200 px-1.5 py-0.5 rounded-full">
                                    <span class="w-1 h-1 rounded-full bg-fuchsia-500 animate-pulse"></span>
                                    En vivo
                                </span>
                            </div>
                        </div>
                        <div class="rounded-xl border border-purple-200/80 bg-gradient-to-r from-purple-50 to-fuchsia-50 px-2.5 py-2 flex items-center justify-between gap-2">
                            <div class="min-w-0 text-left">
                                <p class="text-[8px] font-black uppercase text-purple-700">Nuevo pedido</p>
                                <p class="text-[10px] font-semibold text-slate-800 truncate">Ana R. · hace 1 min</p>
                            </div>
                            <span class="text-sm font-black text-purple-700 tabular-nums shrink-0">$14.50</span>
                        </div>
                    </div>
                </div>
                <div class="landing-how-step__body">
                    <h3 class="text-lg font-black text-slate-900">3. Comenzar a vender</h3>
                    <p class="mt-2 text-sm leading-relaxed">
                        Comparte tu enlace y recibe pedidos ordenados al instante en WhatsApp o Telegram.
                    </p>
                </div>
            </article>
        </div>

        <div class="mt-10 md:mt-12 text-center">
            <a href="/register"
               class="inline-flex items-center gap-2 landing-how-brand-gradient-h text-white font-black px-6 py-3 rounded-xl shadow-lg shadow-purple-500/20 hover:brightness-105 active:scale-[0.98] transition-all text-sm">
                Empezar mi prueba gratis
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
