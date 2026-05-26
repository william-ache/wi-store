@php
    use App\Support\PlanPricing;
    $emprendedor = PlanPricing::PLANS['standard'];
    $negocio = PlanPricing::PLANS['premium'];
@endphp

<!-- Plan Emprendedor -->
<div id="plan-standard"
    class="landing-plan-card landing-plan-card--emprendedor rounded-3xl p-5 md:p-6 flex flex-col justify-between relative transition duration-300 hover:-translate-y-1">
    <div>
        <div class="flex justify-between items-start gap-2">
            <h3 class="text-base font-black text-white uppercase tracking-wider">
                Plan <span class="landing-plan-title--cyan">Emprendedor</span>
            </h3>
            <span class="landing-plan-badge landing-plan-badge--emprendedor text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shrink-0">Para empezar</span>
        </div>
        <p class="text-[11px] text-slate-400 mt-2 leading-snug">Digitaliza tu negocio con menú, pedidos y tu marca.</p>

        <div class="landing-plan-price--emprendedor my-5 rounded-2xl px-4 py-3">
            <p class="text-3xl font-black text-white tracking-tight">
                {{ PlanPricing::formatUsd($emprendedor['monthly']) }}
                <span class="text-sm font-semibold text-slate-400">/ mes</span>
            </p>
            <p class="text-[10px] text-slate-500 mt-1">
                Anual: <strong class="text-fuchsia-300">{{ PlanPricing::formatUsd($emprendedor['annual_monthly_equivalent']) }}/mes</strong>
                · {{ PlanPricing::formatUsd($emprendedor['annual_total']) }}/año
            </p>
        </div>

        <ul class="space-y-2 text-[11px] text-slate-300 border-t border-white/10 pt-4">
            <li class="flex gap-2"><span class="landing-plan-check--cyan font-bold">✓</span> Catálogo y pedidos a WhatsApp</li>
            <li class="flex gap-2"><span class="landing-plan-check--cyan font-bold">✓</span> Personalización de marca</li>
            <li class="flex gap-2"><span class="landing-plan-check--cyan font-bold">✓</span> Tasa BCV automática en pagos</li>
            <li class="flex gap-2"><span class="landing-plan-check--cyan font-bold">✓</span> Soporte prioritario</li>
        </ul>
    </div>
    <div class="mt-6 flex flex-col gap-2">
        <a href="/register" class="landing-plan-btn landing-plan-btn--emprendedor block w-full text-center text-white font-extrabold py-2.5 rounded-xl text-xs">Comenzar Emprendedor</a>
        <button type="button" @click="selectedPlan = 'standard'; openModal = true"
            class="landing-plan-ghost landing-plan-ghost--emprendedor w-full py-2 rounded-xl text-[10px] font-bold uppercase tracking-wide">
            Ver más detalle
        </button>
    </div>
</div>

<!-- Plan Negocio -->
<div id="plan-premium"
    class="landing-plan-card landing-plan-card--featured landing-plan-vip-elevated rounded-3xl flex flex-col transition duration-300">
    <div class="landing-plan-inner landing-plan-inner--negocio p-5 md:p-7 flex flex-col justify-between h-full flex-grow relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-purple-400/60 to-transparent"></div>

        <div class="relative z-10 flex flex-col flex-grow">
            <div class="flex justify-between items-center gap-2">
                <div class="flex items-center gap-2 min-w-0 flex-1">
                    <div class="landing-plan-icon--negocio w-9 h-9 shrink-0 rounded-xl flex items-center justify-center">
                        <i class="fas fa-crown text-sm text-purple-200"></i>
                    </div>
                    <h3 class="text-sm font-black text-white uppercase tracking-wide whitespace-nowrap leading-none">
                        Plan <span class="landing-plan-title--purple">Negocio</span>
                    </h3>
                </div>
                <span class="landing-plan-badge landing-plan-badge--negocio text-[7px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shrink-0">Recomendado</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-2.5 leading-snug">Pagos integrados, insignia premium en tienda y soporte prioritario.</p>

            <div class="mt-3 rounded-xl border border-cyan-400/35 bg-cyan-500/10 px-3 py-2">
                <p class="text-[10px] font-black uppercase tracking-wide text-cyan-200">
                    <i class="fas fa-gift text-cyan-300/90 mr-1"></i>14 días gratis
                </p>
                <p class="text-[9px] text-slate-400 mt-0.5 leading-snug">
                    Prueba todo el plan Negocio sin costo · luego {{ PlanPricing::formatUsd($negocio['monthly']) }}/mes
                </p>
            </div>

            <div class="landing-plan-price--negocio my-4 rounded-2xl px-4 py-3">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Después del periodo de prueba</p>
                <p class="text-3xl font-black text-white tracking-tight">
                    {{ PlanPricing::formatUsd($negocio['monthly']) }}
                    <span class="text-sm font-semibold text-slate-400">/ mes</span>
                </p>
                <p class="text-[10px] text-slate-500 mt-1">
                    Anual: {{ PlanPricing::formatUsd($negocio['annual_monthly_equivalent']) }}/mes
                    · <strong class="text-cyan-300">{{ $negocio['annual_savings_label'] }}</strong>
                </p>
            </div>

            <ul class="space-y-2.5 text-[11px] text-slate-300 border-t border-purple-500/20 pt-4 flex-grow">
                <li class="flex gap-2"><span class="landing-plan-check--purple font-bold">✓</span> Todo lo del plan Emprendedor</li>
                <li class="flex gap-2"><span class="landing-plan-check--purple font-bold">✓</span> Tasa BCV + Pago Móvil y Zelle</li>
                <li class="flex gap-2"><span class="landing-plan-check--purple font-bold">✓</span> Insignia premium y soporte 24/7</li>
            </ul>
            <div class="mt-6 flex flex-col gap-2">
                <a href="/register"
                    class="landing-plan-btn landing-plan-btn--negocio block w-full text-center text-white font-extrabold py-3 rounded-xl text-xs">
                    Probar 14 días gratis
                </a>
                <p class="text-[9px] text-center text-slate-500 -mt-1">Sin tarjeta · cancelas cuando quieras</p>
                <button type="button" @click="selectedPlan = 'premium'; openModal = true"
                    class="landing-plan-ghost landing-plan-ghost--negocio w-full py-2 rounded-xl text-[10px] font-bold uppercase tracking-wide">
                    Ver más detalle
                </button>
            </div>
        </div>
    </div>
</div>
