{{-- Tabla de precios mensual / anual (Plan Emprendedor y Plan Negocio) --}}
@php
    use App\Support\PlanPricing;
    $rows = PlanPricing::PLANS;
@endphp

<div x-data="{
    exchangeRate: null,
    loadingRate: true,
    rateDate: null,
    fetchedAt: null,
    init() {
        fetch('https://ve.dolarapi.com/v1/dolares/oficial')
            .then(r => r.json())
            .then(data => {
                this.exchangeRate = data.promedio;
                this.rateDate = data.fechaActualizacion || data.ultima_actualizacion || data.fecha || null;
                this.fetchedAt = new Date();
                this.loadingRate = false;
            })
            .catch(() => {
                this.fetchedAt = new Date();
                this.loadingRate = false;
            });
    },
    formatRateBs() {
        if (!this.exchangeRate) return '—';
        return this.exchangeRate.toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    lastUpdatedLabel() {
        const raw = this.rateDate || this.fetchedAt;
        if (!raw) return '—';
        try {
            const d = raw instanceof Date ? raw : new Date(raw);
            if (Number.isNaN(d.getTime())) return String(raw);
            return d.toLocaleString('es-VE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        } catch (e) {
            return String(raw);
        }
    }
}">
    <div class="text-center mb-5 md:mb-6">
        <h3 class="text-lg md:text-xl font-black text-white tracking-tight">Comparativa anual</h3>
        <p class="text-[11px] text-slate-400 mt-1 max-w-md mx-auto">Equivalente mensual, total facturado al año y cuántos meses ahorras con el descuento.</p>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[#0d1127]/80 backdrop-blur-md shadow-xl overflow-hidden">
        {{-- Escritorio: tabla horizontal --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[640px] text-sm border-collapse">
                <thead>
                    <tr class="border-b border-white/10 bg-white/[0.03]">
                        <th class="p-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-500 w-[22%]">Plan</th>
                        <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-500 border-l border-white/5">Precio mensual base</th>
                        <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-500 border-l border-white/5">Descuento anual</th>
                        <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest text-cyan-300/90 border-l border-white/5">Costo mensual equiv.</th>
                        <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest text-fuchsia-300/90 border-l border-white/5">Total facturado anual</th>
                        <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest text-cyan-300 border-l border-white/5">Ahorro real anual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($rows as $planKey => $plan)
                        <tr class="hover:bg-white/[0.02] transition-colors {{ $planKey === 'premium' ? 'bg-purple-500/[0.06] ring-1 ring-inset ring-purple-500/15' : '' }}">
                            <td class="p-4 pl-5">
                                <span class="font-black text-base {{ $planKey === 'premium' ? 'text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-fuchsia-300' : 'text-cyan-300' }}">{{ $plan['name'] }}</span>
                                @if ($planKey === 'premium')
                                    <span class="block text-[9px] font-bold uppercase tracking-wider text-purple-300 mt-0.5">Recomendado</span>
                                    <span class="block text-[9px] font-bold text-cyan-300/90 mt-0.5">14 días gratis</span>
                                @endif
                            </td>
                            <td class="p-4 text-center border-l border-white/5 text-slate-300 font-semibold">
                                {{ PlanPricing::formatUsd($plan['monthly']) }} <span class="text-slate-500 font-normal">/ mes</span>
                            </td>
                            <td class="p-4 text-center border-l border-white/5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 text-xs font-black">
                                    {{ $plan['annual_discount_percent'] }}% DTO.
                                </span>
                            </td>
                            <td class="p-4 text-center border-l border-white/5">
                                <span class="text-lg font-black text-white">{{ PlanPricing::formatUsd($plan['annual_monthly_equivalent']) }}</span>
                                <span class="text-slate-500 text-xs font-semibold"> / mes</span>
                            </td>
                            <td class="p-4 text-center border-l border-white/5">
                                <span class="text-lg font-black text-white">{{ PlanPricing::formatUsd($plan['annual_total']) }}</span>
                                <span class="text-slate-500 text-xs font-semibold"> / año</span>
                            </td>
                            <td class="p-4 text-center border-l border-white/5">
                                <span class="text-sm font-black text-cyan-300">{{ $plan['annual_savings_label'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Móvil: tarjetas comparativas verticales --}}
        <div class="md:hidden p-4 space-y-4">
            @foreach ($rows as $planKey => $plan)
                @php
                    $isNegocio = $planKey === 'premium';
                @endphp
                <article
                    class="rounded-2xl border p-4 {{ $isNegocio ? 'border-purple-500/30 bg-purple-500/[0.08] shadow-[0_0_24px_rgba(168,85,247,0.12)]' : 'border-cyan-500/20 bg-cyan-500/[0.04]' }}">
                    <div class="flex items-start justify-between gap-2 mb-4 pb-3 border-b border-white/10">
                        <div>
                            <h3 class="text-lg font-black {{ $isNegocio ? 'text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-fuchsia-300' : 'text-cyan-300' }}">
                                {{ $plan['name'] }}
                            </h3>
                            @if ($isNegocio)
                                <span class="inline-block mt-1 text-[9px] font-black uppercase tracking-wider text-purple-200 bg-purple-500/20 border border-purple-400/30 px-2 py-0.5 rounded-full">Recomendado</span>
                                <p class="text-[10px] font-bold text-cyan-300 mt-1.5">14 días gratis · luego {{ PlanPricing::formatUsd($plan['monthly']) }}/mes</p>
                            @endif
                        </div>
                    </div>

                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-[10px] font-bold uppercase tracking-wide text-slate-500 shrink-0">Precio mensual base</dt>
                            <dd class="text-white font-semibold text-right">{{ PlanPricing::formatUsd($plan['monthly']) }}<span class="text-slate-500 font-normal text-xs"> /mes</span></dd>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-[10px] font-bold uppercase tracking-wide text-slate-500 shrink-0">Descuento anual</dt>
                            <dd>
                                <span class="inline-flex px-2 py-0.5 rounded-lg bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 text-xs font-black">
                                    {{ $plan['annual_discount_percent'] }}% DTO.
                                </span>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-[10px] font-bold uppercase tracking-wide text-cyan-400/80 shrink-0">Costo mensual equiv.</dt>
                            <dd class="text-white font-black text-right">{{ PlanPricing::formatUsd($plan['annual_monthly_equivalent']) }}<span class="text-slate-500 font-semibold text-xs"> /mes</span></dd>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <dt class="text-[10px] font-bold uppercase tracking-wide text-fuchsia-300/80 shrink-0">Total facturado anual</dt>
                            <dd class="text-white font-black text-right">{{ PlanPricing::formatUsd($plan['annual_total']) }}<span class="text-slate-500 font-semibold text-xs"> /año</span></dd>
                        </div>
                        <div class="flex items-center justify-between gap-3 pt-2 border-t border-white/5">
                            <dt class="text-[10px] font-bold uppercase tracking-wide text-cyan-300 shrink-0">Ahorro real anual</dt>
                            <dd class="text-cyan-300 font-black text-right text-sm">{{ $plan['annual_savings_label'] }}</dd>
                        </div>
                    </dl>
                </article>
            @endforeach
        </div>

        <div class="px-5 py-4 md:px-6 md:py-5 border-t border-white/10 bg-white/[0.02] text-center space-y-2">
            <p class="text-[11px] md:text-xs text-slate-300 leading-relaxed">
                <span class="inline-flex items-center justify-center gap-1.5 flex-wrap">
                    @include('partials.landing.bcv-logo', ['class' => 'w-5 h-5 text-slate-300 shrink-0'])
                    <span>Precios en <strong class="text-white">USD</strong> · equivalente en <strong class="text-white">Bs.</strong> a tasa <strong class="text-amber-200/90">BCV</strong> a la fecha</span>
                </span>
            </p>

            <template x-if="loadingRate">
                <p class="text-[10px] text-slate-500 font-semibold flex items-center justify-center gap-2">
                    <span class="w-3.5 h-3.5 border-2 border-slate-600 border-t-slate-300 rounded-full animate-spin"></span>
                    Consultando tasa BCV…
                </p>
            </template>

            <template x-if="!loadingRate && exchangeRate">
                <div class="space-y-1.5">
                    <p class="text-lg md:text-xl font-black text-emerald-400 tabular-nums tracking-tight">
                        1 USD = <span x-text="formatRateBs()"></span> Bs.
                    </p>
                    <p class="text-[10px] text-slate-400 font-semibold">
                        Última actualización BCV:
                        <span class="text-slate-300 font-bold tabular-nums" x-text="lastUpdatedLabel()"></span>
                    </p>
                </div>
            </template>

            <template x-if="!loadingRate && !exchangeRate">
                <p class="text-[10px] text-slate-500 font-semibold">Tasa BCV no disponible en este momento.</p>
            </template>
        </div>
    </div>
</div>
