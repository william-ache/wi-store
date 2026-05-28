{{-- Toggle mensual / anual (usa billingPeriod del x-data de #precios) --}}
<div class="landing-billing-toggle-wrap flex flex-col items-center gap-3 mb-8 md:mb-10">
    <div class="inline-flex items-center gap-3 p-1.5 rounded-2xl border border-slate-200 bg-white shadow-md">
        <button type="button"
            @click="billingPeriod = 'monthly'"
            :class="billingPeriod === 'monthly'
                ? 'bg-slate-100 text-slate-900 shadow-sm border border-slate-200'
                : 'text-slate-500 hover:text-slate-700 border border-transparent'"
            class="px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-200">
            Mensual
        </button>
        <button type="button"
            @click="billingPeriod = 'annual'"
            :class="billingPeriod === 'annual'
                ? 'bg-gradient-to-r from-emerald-50 to-cyan-50 text-slate-900 shadow-sm border border-emerald-300'
                : 'text-slate-500 hover:text-slate-700 border border-transparent'"
            class="px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2">
            <span>Anual</span>
            <span class="text-[9px] font-black uppercase tracking-wide px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                Ahorra hasta 25%
            </span>
        </button>
    </div>

    <label class="inline-flex items-center gap-2.5 cursor-pointer select-none group">
        <input type="checkbox"
            class="sr-only"
            :checked="billingPeriod === 'annual'"
            @change="billingPeriod = $event.target.checked ? 'annual' : 'monthly'"
            aria-label="Pagar plan anual con descuento">
        <span class="relative w-11 h-6 rounded-full border transition-colors duration-200"
            :class="billingPeriod === 'annual'
                ? 'bg-emerald-500 border-emerald-400'
                : 'bg-slate-200 border-slate-300'">
            <span class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow-md transition-transform duration-200"
                :class="billingPeriod === 'annual' ? 'translate-x-5' : 'translate-x-0'"></span>
        </span>
        <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition-colors">
            <span x-show="billingPeriod === 'monthly'">Activar precio anual con descuento</span>
            <span x-show="billingPeriod === 'annual'" x-cloak class="text-emerald-600">Precio anual activado</span>
        </span>
    </label>

    <p class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-[11px] font-bold text-emerald-700">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
        0% comisión por ventas
    </p>

    <p class="text-[11px] text-slate-500 font-semibold text-center max-w-sm leading-relaxed">
        Precios de los planes actualizados y vigentes para todo el <strong class="text-slate-700 font-bold">2026</strong>.
    </p>
</div>
