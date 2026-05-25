{{-- Tarjetas resumidas. Precios ocultos (reestructuración). Detalle en modal. --}}

@php
    $soonBlock = <<<'HTML'
        <div class="my-5">
            <p class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-300/90 to-cyan-300/90 tracking-tight">Muy pronto</p>
            <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest font-bold">Precios en actualización</p>
        </div>
    HTML;
    $soonBlockVip = <<<'HTML'
        <div class="my-5 rounded-2xl border border-amber-400/25 bg-gradient-to-br from-amber-500/12 via-purple-500/8 to-transparent px-4 py-4">
            <p class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-fuchsia-200 to-purple-200 tracking-tight">Muy pronto</p>
            <p class="text-[10px] text-amber-200/70 mt-1.5 uppercase tracking-[0.2em] font-black">Lanzamiento exclusivo</p>
        </div>
    HTML;
@endphp

<!-- PLAN Standard -->
<div id="plan-standard"
    class="landing-plan-card rounded-3xl p-5 md:p-6 flex flex-col justify-between relative transition duration-300 hover:-translate-y-1 md:order-1">
    <div>
        <div class="flex justify-between items-start gap-2">
            <h3 class="text-base font-black text-white uppercase tracking-wider">Plan <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-cyan-300">Standard</span>
            </h3>
            <span class="landing-plan-badge text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shrink-0">Para empezar</span>
        </div>
        <p class="text-[11px] text-slate-400 mt-2 leading-snug">Digitaliza tu negocio con menú, pedidos y tu marca.</p>
        {!! $soonBlock !!}
        <ul class="space-y-2 text-[11px] text-slate-300 border-t border-white/10 pt-4">
            <li class="flex gap-2"><span class="text-purple-400/75">✓</span> Catálogo y pedidos ilimitados</li>
            <li class="flex gap-2"><span class="text-purple-400/75">✓</span> Personalización de marca</li>
            <li class="flex gap-2"><span class="text-purple-400/75">✓</span> Soporte por WhatsApp</li>
        </ul>
    </div>
    <div class="mt-6 flex flex-col gap-2">
        <a href="/register" class="landing-plan-btn block w-full text-center text-white font-extrabold py-2.5 rounded-xl text-xs">Comenzar Standard</a>
        <button type="button" @click="selectedPlan = 'standard'; openModal = true"
            class="w-full py-2 rounded-xl border border-white/10 text-purple-300/80 hover:text-white hover:border-purple-500/30 text-[10px] font-bold uppercase tracking-wide transition-colors">
            Ver más detalle
        </button>
    </div>
</div>

<!-- PLAN VIP (centro · destaca) -->
<div id="plan-vip"
    class="landing-plan-card landing-plan-card--vip-premium landing-plan-vip-elevated rounded-3xl flex flex-col transition duration-300 md:order-2">
    <div class="landing-plan-inner landing-plan-inner--vip p-5 md:p-7 flex flex-col justify-between h-full flex-grow relative overflow-hidden">
        <div class="landing-plan-vip-glow pointer-events-none" aria-hidden="true"></div>
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-amber-400/50 to-transparent"></div>

        <div class="relative z-10 flex flex-col flex-grow">
            <div class="flex justify-between items-start gap-2">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-11 h-11 shrink-0 rounded-2xl bg-gradient-to-br from-amber-400/25 to-purple-500/20 border border-amber-400/30 flex items-center justify-center shadow-lg shadow-amber-500/10">
                        <i class="fas fa-crown text-lg text-amber-200"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-black text-white uppercase tracking-wider leading-tight">Plan <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-fuchsia-200 to-purple-200">VIP</span>
                    </h3>
                </div>
                <span class="landing-plan-badge landing-plan-badge--vip-premium text-[8px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full shrink-0">Premium</span>
            </div>
            <p class="text-[11px] text-slate-300/90 mt-3 leading-snug max-w-[95%]">La experiencia más exclusiva: corona VIP, marca a medida y soporte dedicado.</p>
            {!! $soonBlockVip !!}
            <ul class="space-y-2.5 text-[11px] text-slate-200 border-t border-amber-500/15 pt-4 flex-grow">
                <li class="flex gap-2"><span class="text-amber-300/90">✦</span> Corona VIP en tu menú digital</li>
                <li class="flex gap-2"><span class="text-amber-300/90">✦</span> Marca blanca y diseño exclusivo</li>
                <li class="flex gap-2"><span class="text-amber-300/90">✦</span> Soporte VIP y ajustes a medida</li>
            </ul>
            <div class="mt-6 flex flex-col gap-2">
                <a href="https://wa.me/584121305420?text=Hola,%20quiero%20el%20Plan%20VIP%20de%20WIStore" target="_blank"
                    class="landing-plan-btn landing-plan-btn--vip block w-full text-center text-white font-extrabold py-3 rounded-xl text-xs">
                    Reservar interés VIP
                </a>
                <button type="button" @click="selectedPlan = 'vip'; openModal = true"
                    class="w-full py-2 rounded-xl border border-amber-400/25 bg-amber-500/5 text-amber-100/90 hover:text-white hover:border-amber-400/40 text-[10px] font-bold uppercase tracking-wide transition-colors">
                    Ver más detalle
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PLAN Premium -->
<div id="plan-premium"
    class="landing-plan-card rounded-3xl p-5 md:p-6 flex flex-col justify-between relative transition duration-300 hover:-translate-y-1 md:order-3">
    <div>
        <div class="flex justify-between items-start gap-2">
            <h3 class="text-base font-black text-white uppercase tracking-wider">Plan <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-cyan-300">Premium</span>
            </h3>
            <span class="landing-plan-badge text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shrink-0">Recomendado</span>
        </div>
        <p class="text-[11px] text-slate-400 mt-2 leading-snug">Herramientas avanzadas, pagos integrados y soporte prioritario.</p>
        {!! $soonBlock !!}
        <ul class="space-y-2 text-[11px] text-slate-300 border-t border-white/10 pt-4">
            <li class="flex gap-2"><span class="text-purple-400/75">✓</span> Todo lo del plan Standard</li>
            <li class="flex gap-2"><span class="text-purple-400/75">✓</span> Pago Móvil y Zelle integrados</li>
            <li class="flex gap-2"><span class="text-purple-400/75">✓</span> Soporte 24/7 e insignia Premium</li>
        </ul>
    </div>
    <div class="mt-6 flex flex-col gap-2">
        <a href="/register" class="landing-plan-btn block w-full text-center text-white font-extrabold py-2.5 rounded-xl text-xs">Comenzar Premium</a>
        <button type="button" @click="selectedPlan = 'premium'; openModal = true"
            class="w-full py-2 rounded-xl border border-white/10 text-purple-300/80 hover:text-white hover:border-purple-500/30 text-[10px] font-bold uppercase tracking-wide transition-colors">
            Ver más detalle
        </button>
    </div>
</div>
