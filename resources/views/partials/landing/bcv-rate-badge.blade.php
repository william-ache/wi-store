@props([
    'class' => '',
    'compact' => false,
])

<div
    x-data="{
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
    }"
    @class([
        'max-w-xl mx-auto text-center mb-7 md:mb-9 px-4 py-4 md:px-5 md:py-5 space-y-2.5' => ! $compact,
        'max-w-3xl mx-auto text-center' => $compact,
        $class,
    ])
    aria-live="polite">

    @if ($compact)
        <div class="flex flex-wrap items-center justify-center gap-x-2 gap-y-1 text-[10px] md:text-[11px] leading-snug">
            <span class="text-slate-500">
                Precios equivalente a tasa oficial del <strong class="text-amber-400/90">BDV</strong>
            </span>
            <span class="text-slate-600 hidden sm:inline" aria-hidden="true">·</span>
            <template x-if="loadingRate">
                <span class="text-slate-500 font-semibold inline-flex items-center gap-1.5">
                    <span class="w-3 h-3 border-2 border-slate-500 border-t-slate-300 rounded-full animate-spin"></span>
                    Cargando tasa…
                </span>
            </template>
            <template x-if="!loadingRate && exchangeRate">
                <span class="landing-bcv-rate-value font-black text-emerald-400 tabular-nums whitespace-nowrap">
                    1 USD = <span x-text="formatRateBs()"></span> Bs
                </span>
            </template>
            <template x-if="!loadingRate && !exchangeRate">
                <span class="text-slate-500 font-semibold">Tasa BCV no disponible</span>
            </template>
            <template x-if="!loadingRate && exchangeRate">
                <span class="text-slate-500 hidden md:inline" aria-hidden="true">·</span>
                <span class="text-slate-500 font-medium tabular-nums w-full md:w-auto text-center">
                    Act. <span class="text-slate-400" x-text="lastUpdatedLabel()"></span>
                </span>
            </template>
        </div>
    @else
        <p class="text-[11px] md:text-xs text-slate-600 leading-relaxed">
            Precios en <strong class="text-slate-900">USD</strong> · equivalente en <strong class="text-slate-900">Bs.</strong> a tasa <strong class="text-amber-600">BCV</strong> a la fecha
        </p>

        <template x-if="loadingRate">
            <p class="text-[10px] text-slate-500 font-semibold flex items-center justify-center gap-2 py-1">
                <span class="w-3.5 h-3.5 border-2 border-slate-600 border-t-slate-300 rounded-full animate-spin"></span>
                Consultando tasa BCV…
            </p>
        </template>

        <template x-if="!loadingRate && exchangeRate">
            <div class="space-y-1.5">
                <p class="text-lg md:text-xl font-black text-emerald-600 tabular-nums tracking-tight">
                    1 USD = <span x-text="formatRateBs()"></span> Bs.
                </p>
                <p class="text-[10px] text-slate-400 font-semibold">
                    Última actualización BCV:
                    <span class="text-slate-700 font-bold tabular-nums" x-text="lastUpdatedLabel()"></span>
                </p>
            </div>
        </template>

        <template x-if="!loadingRate && !exchangeRate">
            <p class="text-[10px] text-slate-500 font-semibold py-1">Tasa BCV no disponible en este momento.</p>
        </template>
    @endif
</div>
