@php
    use App\Support\PlanCatalog;
    use App\Support\PlanPricing;
    $emprendedor = PlanCatalog::pricingFor('standard') ?? [];
    $negocio = PlanCatalog::pricingFor('premium') ?? [];
    $emprendedorMonthly = $emprendedor['monthly'] ?? 0;
    $emprendedorAnnualEquiv = $emprendedor['annual_monthly_equivalent'] ?? $emprendedorMonthly;
    $negocioMonthly = $negocio['monthly'] ?? 0;
    $negocioAnnualEquiv = $negocio['annual_monthly_equivalent'] ?? $negocioMonthly;
@endphp

<div
    x-data="{
        exchangeRate: null,
        loadingRate: true,
        rateDate: null,
        fetchedAt: null,
        emprendedorUsdMonthly: {{ $emprendedorMonthly }},
        emprendedorUsdAnnualEquiv: {{ $emprendedorAnnualEquiv }},
        negocioUsdMonthly: {{ $negocioMonthly }},
        negocioUsdAnnualEquiv: {{ $negocioAnnualEquiv }},
        planUsd(monthly, annual) {
            return this.$parent.billingPeriod === 'annual' ? annual : monthly;
        },
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
        formatBs(usd) {
            if (!this.exchangeRate) return '—';
            return (usd * this.exchangeRate).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
        },
        hasUpdateDate() {
            return !this.loadingRate && !!(this.rateDate || this.fetchedAt);
        }
    }"
    class="mt-10 md:mt-12 mb-4 max-w-5xl mx-auto overflow-hidden rounded-[1.35rem] border border-slate-500/40 shadow-[0_12px_32px_-8px_rgba(0,0,0,0.45)] grid grid-cols-1 lg:grid-cols-5">

    {{-- Tasa BCV + planes --}}
    <div class="lg:col-span-3 bg-gradient-to-br from-[#5A6370] to-[#3B424D] p-5 md:p-6 shadow-[inset_0_1px_2px_rgba(255,255,255,0.12)]">
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5 md:items-end">
            <div>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 mb-2">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300/95">
                        Tasa oficial BCV (USD)
                    </p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-[10px] font-bold text-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                        Sin comisiones por cada venta
                    </span>
                </div>

                <template x-if="loadingRate">
                    <div class="flex items-center gap-2 text-slate-300 text-sm font-bold py-2">
                        <span class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        Cargando tasa BCV…
                    </div>
                </template>

                <template x-if="!loadingRate && exchangeRate">
                    <div>
                        <p class="text-3xl sm:text-4xl font-black text-white tabular-nums leading-none tracking-tight">
                            Bs. <span x-text="exchangeRate.toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>
                        </p>
                        <div class="mt-3 w-full sm:w-auto py-2.5 px-3 rounded-lg bg-black/25 border border-white/15 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-slate-300 font-semibold">
                            <span class="inline-flex items-center gap-1.5 text-slate-400">
                                <i class="far fa-clock"></i>
                                Fecha de actualización BCV:
                            </span>
                            <span class="text-white font-bold tabular-nums" x-text="lastUpdatedLabel()"></span>
                            <span class="text-[9px] text-slate-500 font-medium w-full sm:w-auto sm:ml-1" x-show="rateDate">Fuente: Banco Central de Venezuela</span>
                        </div>
                    </div>
                </template>

                <template x-if="!loadingRate && !exchangeRate">
                    <div>
                        <p class="text-sm text-slate-300 font-semibold py-2">Tasa no disponible en este momento.</p>
                        <p x-show="hasUpdateDate()" class="text-[10px] text-slate-500 mt-1">
                            Último intento: <span class="text-slate-400 font-semibold" x-text="lastUpdatedLabel()"></span>
                        </p>
                    </div>
                </template>
            </div>

            <div class="hidden md:block text-[11px] text-slate-300/90 leading-relaxed pb-1">
                Planes en <strong class="text-white">USD</strong> con equivalente en bolívares según la tasa del
                <strong class="text-white">Banco Central de Venezuela</strong>.
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-white/10">
            <p class="text-xs text-slate-300/90 leading-relaxed mb-3 md:hidden">
                Planes en <strong class="text-white">USD</strong> · equivalente en bolívares con la tasa del
                <strong class="text-white">Banco Central de Venezuela</strong>.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="rounded-xl bg-black/20 border border-white/10 px-4 py-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Plan Emprendedor</p>
                    <p class="text-sm font-black text-white mt-1" x-show="$parent.billingPeriod === 'monthly'">
                        {{ PlanPricing::formatUsd($emprendedorMonthly) }} <span class="text-slate-400 font-semibold">USD/mes</span>
                    </p>
                    <p class="text-sm font-black text-white mt-1" x-show="$parent.billingPeriod === 'annual'" x-cloak>
                        {{ PlanPricing::formatUsd($emprendedorAnnualEquiv) }} <span class="text-slate-400 font-semibold">USD/mes equiv.</span>
                    </p>
                    <p class="text-base font-black text-amber-200 mt-1 tabular-nums" x-show="exchangeRate">
                        ≈ Bs. <span x-text="formatBs(planUsd(emprendedorUsdMonthly, emprendedorUsdAnnualEquiv))"></span><span class="text-xs text-slate-400 font-semibold">/mes</span>
                    </p>
                </div>
                <div class="rounded-xl bg-black/20 border border-white/10 px-4 py-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Plan Negocio</p>
                    <p class="text-sm font-black text-white mt-1" x-show="$parent.billingPeriod === 'monthly'">
                        {{ PlanPricing::formatUsd($negocioMonthly) }} <span class="text-slate-400 font-semibold">USD/mes</span>
                    </p>
                    <p class="text-sm font-black text-white mt-1" x-show="$parent.billingPeriod === 'annual'" x-cloak>
                        {{ PlanPricing::formatUsd($negocioAnnualEquiv) }} <span class="text-slate-400 font-semibold">USD/mes equiv.</span>
                    </p>
                    <p class="text-base font-black text-purple-200 mt-1 tabular-nums" x-show="exchangeRate">
                        ≈ Bs. <span x-text="formatBs(planUsd(negocioUsdMonthly, negocioUsdAnnualEquiv))"></span><span class="text-xs text-slate-400 font-semibold">/mes</span>
                    </p>
                </div>
            </div>
            <p class="mt-3 text-[10px] text-slate-400 flex items-center gap-1.5">
                <i class="fas fa-mobile-screen text-slate-300/70"></i>
                Pago Móvil y transferencia a tasa BCV desde tu panel.
            </p>
            <p x-show="hasUpdateDate() && exchangeRate" class="mt-2 text-[10px] text-slate-500 border-t border-white/5 pt-2 flex flex-wrap items-center gap-1.5">
                <i class="far fa-clock text-slate-500"></i>
                <span>Tasa vigente al</span>
                <strong class="text-slate-300 font-bold tabular-nums" x-text="lastUpdatedLabel()"></strong>
            </p>
        </div>
    </div>

    {{-- Colombia (panel lateral, misma altura) --}}
    <div class="lg:col-span-2 border-t-2 lg:border-t-0 lg:border-l-2 border-dashed border-yellow-400/50 bg-gradient-to-br from-yellow-500/[0.12] via-[#1a1520]/98 to-[#0d1127]/98 p-5 md:p-6 flex flex-col justify-between gap-4 min-h-0">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.18em] text-yellow-300/90">Expansión regional</p>
                <p class="text-xl font-black text-white leading-tight mt-0.5">Colombia</p>
            </div>
            <span class="shrink-0 px-2.5 py-1 rounded-full bg-yellow-400 text-yellow-950 text-[9px] font-black uppercase tracking-wider">
                Próximamente
            </span>
        </div>

        <p class="text-sm text-slate-200 leading-snug">
            Menús digitales, pedidos por WhatsApp y pagos adaptados al mercado colombiano.
        </p>

        <div class="grid grid-cols-2 gap-2 text-[10px] font-semibold text-slate-300">
            <div class="rounded-lg bg-black/25 border border-yellow-400/20 px-2.5 py-2">
                <i class="fas fa-store text-yellow-400/90 mr-1"></i> Tiendas en COP
            </div>
            <div class="rounded-lg bg-black/25 border border-yellow-400/20 px-2.5 py-2">
                <i class="fas fa-credit-card text-yellow-400/90 mr-1"></i> Pagos locales
            </div>
            <div class="rounded-lg bg-black/25 border border-yellow-400/20 px-2.5 py-2">
                <i class="fab fa-whatsapp text-yellow-400/90 mr-1"></i> Pedidos por WA
            </div>
            <div class="rounded-lg bg-black/25 border border-yellow-400/20 px-2.5 py-2">
                <i class="fas fa-qrcode text-yellow-400/90 mr-1"></i> Menú digital QR
            </div>
        </div>

        <div class="flex flex-wrap gap-2 pt-1 border-t border-yellow-400/20">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/15 text-[10px] font-bold uppercase tracking-wide text-emerald-300">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Venezuela · Activo
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-yellow-400/15 text-[10px] font-bold uppercase tracking-wide text-yellow-200">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Colombia · Próximamente
            </span>
        </div>
    </div>
</div>
