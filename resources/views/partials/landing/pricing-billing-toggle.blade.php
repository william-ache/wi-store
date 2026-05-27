{{-- Toggle mensual / anual (usa billingPeriod del x-data de #precios) --}}
<div class="flex flex-col items-center gap-3 mb-8 md:mb-10">
    <div class="inline-flex items-center gap-3 p-1.5 rounded-2xl border border-white/10 bg-[#0d1127]/70 backdrop-blur-md shadow-lg">
        <button type="button"
            @click="billingPeriod = 'monthly'"
            :class="billingPeriod === 'monthly'
                ? 'bg-white/10 text-white shadow-sm border border-white/15'
                : 'text-slate-400 hover:text-slate-200 border border-transparent'"
            class="px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-200">
            Mensual
        </button>
        <button type="button"
            @click="billingPeriod = 'annual'"
            :class="billingPeriod === 'annual'
                ? 'bg-gradient-to-r from-emerald-500/25 to-cyan-500/20 text-white shadow-sm border border-emerald-400/30'
                : 'text-slate-400 hover:text-slate-200 border border-transparent'"
            class="px-4 py-2 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-200 flex items-center gap-2">
            <span>Anual</span>
            <span class="text-[9px] font-black uppercase tracking-wide px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
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
                ? 'bg-emerald-600/80 border-emerald-500/50'
                : 'bg-slate-700 border-slate-600'">
            <span class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow-md transition-transform duration-200"
                :class="billingPeriod === 'annual' ? 'translate-x-5' : 'translate-x-0'"></span>
        </span>
        <span class="text-xs font-semibold text-slate-400 group-hover:text-slate-300 transition-colors">
            <span x-show="billingPeriod === 'monthly'">Activar precio anual con descuento</span>
            <span x-show="billingPeriod === 'annual'" x-cloak class="text-emerald-300">Precio anual activado</span>
        </span>
    </label>

    <p class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-[11px] font-bold text-emerald-300">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></span>
        0% comisión por ventas
    </p>
</div>
