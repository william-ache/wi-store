<section id="inicio" class="relative bg-slate-900 py-20 md:py-24 overflow-hidden z-10">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-10 items-center">

            <div class="text-left space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-white leading-[1.08]">
                    Tu negocio vende solo con un menú por
                    <span class="bg-gradient-to-r from-emerald-300 via-cyan-300 to-purple-300 bg-clip-text text-transparent font-extrabold">
                        WhatsApp
                    </span>
                </h1>

                <p class="text-base md:text-lg text-gray-300 max-w-xl leading-relaxed">
                    Arma tu catálogo con fotos y precios. Tus clientes eligen y los pedidos te llegan ordenados al WhatsApp o Telegram.
                    <strong class="text-white font-semibold">Listo en minutos</strong>, sin saber de páginas web.
                </p>

                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 bg-white/5 border border-white/10 rounded-2xl px-4 py-3 backdrop-blur-sm">
                        <span class="text-lg">📱</span>
                        <div>
                            <p class="text-xs font-black text-white leading-none">Fácil de usar</p>
                            <p class="text-[11px] text-slate-400 mt-1 leading-none">Como usar el celular</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/5 border border-white/10 rounded-2xl px-4 py-3 backdrop-blur-sm">
                        <span class="text-lg">💬</span>
                        <div>
                            <p class="text-xs font-black text-white leading-none">Pedidos claros</p>
                            <p class="text-[11px] text-slate-400 mt-1 leading-none">Directo a tu chat</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-white/5 border border-white/10 rounded-2xl px-4 py-3 backdrop-blur-sm">
                        <span class="text-lg">🎨</span>
                        <div>
                            <p class="text-xs font-black text-white leading-none">Tu marca</p>
                            <p class="text-[11px] text-slate-400 mt-1 leading-none">Logo y colores</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                    <a href="/register"
                       class="w-full sm:w-auto text-center bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-black px-8 py-4 rounded-2xl shadow-2xl shadow-cyan-500/20 active:scale-[0.98]">
                        Probar gratis {{ $wiStoreTrialDays }} días
                    </a>
                    <button type="button" @click="scrollTo('explorar')"
                            class="w-full sm:w-auto text-center border border-white/20 bg-transparent hover:bg-white/5 text-white font-extrabold px-8 py-4 rounded-2xl active:scale-[0.98]">
                        Ver tiendas de ejemplo
                    </button>
                </div>

                <p class="text-[11px] text-purple-200/80 font-semibold">
                    {{ $wiStoreTrialLabel }} · {{ $wiStoreTrialDisclaimer }} · Cancelas cuando quieras
                </p>
            </div>

            {{-- Columna derecha: Phone Mockup (CSS, NO floating cards) --}}
            <div class="flex justify-center md:justify-end">
                <div class="relative mx-auto border-gray-900 bg-gray-900 border-[14px] rounded-[3rem] h-[700px] w-[340px] shadow-2xl shadow-cyan-500/20 ring-1 ring-white/10 flex flex-col overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-6 bg-gray-900 rounded-b-2xl w-32 mx-auto z-50"></div>

                    <div class="relative h-full w-full bg-white overflow-y-auto scrollbar-none pb-24">

                        {{-- ========================================= --}}
                        {{-- AQUI ADENTRO PEGA TODO EL CÓDIGO DEL MENÚ   --}}
                        {{-- (El banner de la pizza, el logo de Sabores Y&B, --}}
                        {{-- los botones de categorías y las tarjetas) --}}
                        {{-- ========================================= --}}

                        {{-- Header --}}
                        <div class="relative h-36">
                            <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=900&q=70"
                                 alt="Portada del menú" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/35"></div>
                            <div class="absolute inset-x-0 bottom-0 h-14 bg-gradient-to-t from-black/55 to-transparent"></div>
                            <div class="absolute left-1/2 -translate-x-1/2 bottom-[-20px] w-12 h-12 rounded-full bg-white/25 border border-white/40 backdrop-blur-md flex items-center justify-center text-white font-black text-[12px] shadow-lg">
                                YB
                            </div>
                        </div>

                        <div class="pt-8 pb-2 px-4 text-center">
                            <p class="text-[13px] font-black text-slate-900 leading-none">Bistro Italiano</p>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Menú</p>
                        </div>

                        {{-- Tabs --}}
                        <div class="px-4 pb-2">
                            <div class="flex items-center justify-center gap-2 text-[9px] font-black uppercase tracking-wide">
                                @foreach (['Pizza', 'Pasta', 'Bebidas'] as $tab)
                                    <span class="px-3 py-1 rounded-full border border-slate-200 text-slate-500">{{ $tab }}</span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Productos --}}
                        <div class="px-4 pb-4">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ([
                                    ['https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?auto=format&fit=crop&w=500&q=70', 'Spaghetti Carbonara', '$16.00'],
                                    ['https://images.unsplash.com/photo-1542281286-9e0a16bb7366?auto=format&fit=crop&w=500&q=70', 'Pizza Margherita', '$14.00'],
                                    ['https://images.unsplash.com/photo-1528731708534-816fe59f90cb?auto=format&fit=crop&w=500&q=70', 'Spaghetti Peshants', '$14.00'],
                                    ['https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=500&q=70', 'Postre de la casa', '$16.00'],
                                ] as $item)
                                    <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                        <div class="h-20 bg-slate-100">
                                            <img src="{{ $item[0] }}" alt="{{ $item[1] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="p-2">
                                            <p class="text-[9px] font-extrabold text-slate-800 leading-tight line-clamp-1">{{ $item[1] }}</p>
                                            <p class="text-[9px] font-black text-emerald-700 mt-1">{{ $item[2] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- CTA inferior --}}
                        <div class="px-4 pb-6">
                            <div class="rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 text-white py-3 text-center text-[10px] font-black shadow-md">
                                Confirmar pedido al WhatsApp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Accesos rápidos -->
<nav class="relative z-20 max-w-4xl mx-auto px-4 -mt-8 mb-6" aria-label="Accesos rápidos">
    <div class="grid grid-cols-3 gap-2 md:gap-3 bg-white/[0.06] border border-white/12 rounded-2xl p-2 md:p-3 backdrop-blur-md shadow-xl shadow-black/30">
        <button type="button" @click="scrollTo('explorar')"
                class="flex flex-col items-center gap-1 py-3 md:py-4 rounded-xl hover:bg-purple-500/15 hover:scale-[1.02] active:scale-[0.98] text-center">
            <i class="fas fa-store text-purple-400 text-lg"></i>
            <span class="text-[10px] md:text-xs font-black text-white">Tiendas</span>
        </button>
        <button type="button" @click="scrollTo('como-funciona')"
                class="flex flex-col items-center gap-1 py-3 md:py-4 rounded-xl hover:bg-cyan-500/15 hover:scale-[1.02] active:scale-[0.98] text-center">
            <i class="fas fa-hand-pointer text-cyan-400 text-lg"></i>
            <span class="text-[10px] md:text-xs font-black text-white">Cómo funciona</span>
        </button>
        <button type="button" @click="scrollTo('precios')"
                class="flex flex-col items-center gap-1 py-3 md:py-4 rounded-xl hover:bg-pink-500/15 hover:scale-[1.02] active:scale-[0.98] text-center">
            <i class="fas fa-gem text-pink-400 text-lg"></i>
            <span class="text-[10px] md:text-xs font-black text-white">Precios</span>
        </button>
    </div>
</nav>
