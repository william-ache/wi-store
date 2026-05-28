{{-- Toggle mensual / anual (usa billingPeriod del x-data de #precios) --}}
<div class="landing-billing-toggle-wrap flex flex-col items-center gap-2 mb-4 md:mb-5">
    <div class="flex flex-col items-center gap-1.5">
        <div class="inline-flex items-center gap-1 p-1 rounded-xl border border-slate-200 bg-white shadow-sm">
            <button type="button"
                @click="billingPeriod = 'monthly'"
                :class="billingPeriod === 'monthly'
                    ? 'bg-slate-100 text-slate-900 shadow-sm border border-slate-200'
                    : 'text-slate-500 hover:text-slate-700 border border-transparent'"
                class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200">
                Mensual
            </button>
            <button type="button"
                @click="billingPeriod = 'annual'"
                :class="billingPeriod === 'annual'
                    ? 'bg-gradient-to-r from-emerald-50 to-cyan-50 text-slate-900 shadow-sm border border-emerald-300'
                    : 'text-slate-500 hover:text-slate-700 border border-transparent'"
                class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-1.5">
                <span>Anual</span>
                <span class="text-[8px] font-black uppercase tracking-wide px-1.5 py-px rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 whitespace-nowrap">
                    −25%
                </span>
            </button>
        </div>

        <p class="landing-billing-commission inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-[10px] font-bold text-emerald-700 whitespace-nowrap">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
            0% comisión por ventas
        </p>
    </div>

    <p class="text-[10px] text-slate-500 font-medium text-center">
        Precios vigentes <strong class="text-slate-600 font-bold">2026</strong>
    </p>
</div>
