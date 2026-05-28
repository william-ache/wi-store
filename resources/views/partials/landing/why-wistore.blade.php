<section id="por-que" class="py-14 md:py-20 relative z-10 overflow-x-clip" aria-labelledby="por-que-heading">
    <div class="landing-section-glow top-0 right-[-5%] w-[22rem] h-[22rem] bg-cyan-400/14" aria-hidden="true"></div>

    <div class="landing-container relative z-10">
        <header class="mb-10 md:mb-12 max-w-3xl">
            <p class="inline-flex items-center gap-2 text-[11px] font-black uppercase tracking-[0.16em] text-purple-700 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-gradient-to-r from-purple-500 to-cyan-500" aria-hidden="true"></span>
                Por qué WI-Store
            </p>
            <h2 id="por-que-heading" class="text-3xl sm:text-4xl lg:text-[2.75rem] font-black text-slate-900 tracking-tight leading-[1.1]">
                Todo lo que necesitas para hacer crecer tu negocio
            </h2>
            <p class="mt-3 text-base md:text-lg text-slate-500 leading-relaxed">
                Herramientas simples para vender más y administrar menos.
            </p>
        </header>

        <div class="landing-why-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            {{-- 1. Canales --}}
            <article class="landing-why-card">
                <div class="landing-why-card__visual" aria-hidden="true">
                    <div class="landing-why-card__scene">
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center shadow-lg shadow-purple-500/20 z-10">
                            <i class="fas fa-arrow-up-right text-white text-lg"></i>
                        </div>
                        <span class="landing-why-pill absolute top-2 left-0"><i class="fab fa-whatsapp text-emerald-600"></i> WhatsApp</span>
                        <span class="landing-why-pill absolute top-8 right-0"><i class="fas fa-store text-purple-600"></i> Tu menú</span>
                        <span class="landing-why-pill absolute bottom-2 left-4"><i class="fab fa-telegram text-sky-500"></i> Telegram</span>
                        <svg class="absolute inset-0 w-full h-full text-slate-300" viewBox="0 0 260 160" fill="none" aria-hidden="true">
                            <path d="M130 80 L55 45" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 3"/>
                            <path d="M130 80 L205 55" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 3"/>
                            <path d="M130 80 L95 125" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 3"/>
                        </svg>
                    </div>
                </div>
                <div class="landing-why-card__body">
                    <h3 class="text-lg font-black text-slate-900">Vende en cualquier canal</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Comparte tu menú por WhatsApp, Telegram o enlace. Tus clientes piden donde ya te escriben.
                    </p>
                </div>
            </article>

            {{-- 2. Tiempo --}}
            <article class="landing-why-card">
                <div class="landing-why-card__visual" aria-hidden="true">
                    <div class="landing-why-mock landing-why-mock--flow">
                        <p class="text-[9px] font-black uppercase tracking-wider text-slate-400 mb-3">Flujo automático</p>
                        <ul class="space-y-2.5 text-[11px] font-semibold text-slate-600">
                            <li class="flex items-center gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-gradient-to-br from-purple-500 to-cyan-500 flex items-center justify-center shrink-0">
                                    <i class="fas fa-check text-white text-[8px]"></i>
                                </span>
                                Pedido recibido en WhatsApp
                            </li>
                            <li class="flex items-center gap-2.5 opacity-70">
                                <span class="w-5 h-5 rounded-full border-2 border-slate-200 shrink-0"></span>
                                Revisar items y total
                            </li>
                            <li class="flex items-center gap-2.5 opacity-70">
                                <span class="w-5 h-5 rounded-full border-2 border-slate-200 shrink-0"></span>
                                Confirmar al cliente
                            </li>
                            <li class="flex items-center gap-2.5 opacity-70">
                                <span class="w-5 h-5 rounded-full border-2 border-slate-200 shrink-0"></span>
                                Marcar listo / entregado
                            </li>
                        </ul>
                        <p class="mt-3 pt-3 border-t border-slate-100 text-[10px] font-black uppercase tracking-wide text-purple-600">
                            Menos mensajes sueltos · más orden
                        </p>
                    </div>
                </div>
                <div class="landing-why-card__body">
                    <h3 class="text-lg font-black text-slate-900">Ahorra tiempo</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Los pedidos llegan claros: productos, cantidades y datos del cliente. Sin copiar y pegar chats.
                    </p>
                </div>
            </article>

            {{-- 3. Ingresos --}}
            <article class="landing-why-card">
                <div class="landing-why-card__visual" aria-hidden="true">
                    <div class="landing-why-mock landing-why-mock--chart">
                        <p class="text-[9px] font-black uppercase tracking-wider text-slate-400">Ventas · últimos días</p>
                        <div class="flex items-end gap-2 mt-2">
                            <p class="text-2xl font-black text-slate-900 tabular-nums">$ 4,287</p>
                            <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md border border-emerald-100 mb-1">+28%</span>
                        </div>
                        <div class="flex items-end justify-between gap-1 h-16 mt-4">
                            @foreach ([32, 45, 38, 52, 48, 68, 85] as $i => $h)
                                <span class="flex-1 rounded-sm {{ $i >= 5 ? 'bg-gradient-to-t from-purple-600 to-cyan-400' : 'bg-slate-200' }}"
                                      style="height: {{ $h }}%"></span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="landing-why-card__body">
                    <h3 class="text-lg font-black text-slate-900">Aumenta ingresos</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Un catálogo con fotos y precios transmite confianza. Más gente completa el pedido sin dudar.
                    </p>
                </div>
            </article>

            {{-- 4. Organizado --}}
            <article class="landing-why-card">
                <div class="landing-why-card__visual" aria-hidden="true">
                    <div class="landing-why-mock landing-why-mock--panel">
                        <p class="text-[9px] font-black uppercase tracking-wider text-slate-400 mb-3 text-center">Panel de control</p>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="landing-why-stat">
                                <span class="text-[9px] font-bold uppercase text-slate-400">Pedidos</span>
                                <span class="text-lg font-black text-slate-900 tabular-nums">38</span>
                            </div>
                            <div class="landing-why-stat">
                                <span class="text-[9px] font-bold uppercase text-slate-400">Productos</span>
                                <span class="text-lg font-black text-slate-900 tabular-nums">142</span>
                            </div>
                            <div class="landing-why-stat">
                                <span class="text-[9px] font-bold uppercase text-slate-400">Clientes</span>
                                <span class="text-lg font-black text-slate-900 tabular-nums">1.2k</span>
                            </div>
                            <div class="landing-why-stat landing-why-stat--active">
                                <span class="text-[9px] font-bold uppercase text-purple-600">Resumen</span>
                                <span class="text-lg font-black text-purple-700 tabular-nums">+28%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="landing-why-card__body">
                    <h3 class="text-lg font-black text-slate-900">Mantente organizado</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Pedidos, catálogo y estado de tu tienda en un solo panel para decidir con datos, no a ciegas.
                    </p>
                </div>
            </article>

            {{-- 5. Tipos de negocio (solo iconos) --}}
            <article class="landing-why-card">
                <div class="landing-why-card__visual" aria-hidden="true">
                    <div class="landing-why-icons-grid">
                        @foreach ([
                            ['fa-shirt', 'purple'],
                            ['fa-utensils', 'orange'],
                            ['fa-screwdriver-wrench', 'amber'],
                            ['fa-pills', 'cyan'],
                            ['fa-basket-shopping', 'emerald'],
                            ['fa-gift', 'pink'],
                        ] as [$bizIcon, $bizTone])
                            <span class="landing-why-icon landing-why-icon--sm landing-why-icon--{{ $bizTone }}">
                                <i class="fas {{ $bizIcon }}" aria-hidden="true"></i>
                            </span>
                        @endforeach
                    </div>
                    <span class="landing-why-card__badge">+50</span>
                </div>
                <div class="landing-why-card__body">
                    <h3 class="text-lg font-black text-slate-900">Para todo tipo de negocio</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Ropa, restaurantes, ferreterías, farmacias, minimarkets y más. Tu catálogo se adapta a cómo vendes.
                    </p>
                </div>
            </article>

            {{-- 6. Multiplataforma --}}
            <article class="landing-why-card">
                <div class="landing-why-card__visual" aria-hidden="true">
                    <div class="landing-why-card__scene">
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-600 via-fuchsia-500 to-cyan-500 flex items-center justify-center shadow-lg shadow-purple-500/25 z-10">
                            <i class="fas fa-layer-group text-white text-lg"></i>
                        </div>
                        <span class="landing-why-pill absolute top-2 left-0"><i class="fas fa-mobile-screen-button text-purple-600"></i> Móvil</span>
                        <span class="landing-why-pill absolute top-8 right-0"><i class="fas fa-laptop text-cyan-600"></i> Web</span>
                        <span class="landing-why-pill absolute bottom-2 left-6"><i class="fas fa-tablet-screen-button text-indigo-500"></i> Tablet</span>
                        <svg class="absolute inset-0 w-full h-full text-slate-300" viewBox="0 0 260 160" fill="none" aria-hidden="true">
                            <path d="M130 80 L60 48" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 3"/>
                            <path d="M130 80 L200 52" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 3"/>
                            <path d="M130 80 L100 122" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 3"/>
                        </svg>
                    </div>
                </div>
                <div class="landing-why-card__body">
                    <h3 class="text-lg font-black text-slate-900">Multiplataforma</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Tu tienda funciona en celular, tablet y computadora. Tus clientes compran desde cualquier dispositivo.
                    </p>
                </div>
            </article>
        </div>
    </div>
</section>
