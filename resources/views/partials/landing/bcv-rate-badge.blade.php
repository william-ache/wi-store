@props([
    'class' => '',
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
    class="max-w-xl mx-auto mb-7 md:mb-9 px-4 py-4 md:px-5 md:py-5 text-center space-y-2.5 {{ $class }}"
    aria-live="polite">
    <p class="text-[11px] md:text-xs text-slate-300 leading-relaxed">
        Precios en <strong class="text-white">USD</strong> · equivalente en <strong class="text-white">Bs.</strong> a tasa <strong class="text-amber-200/90">BCV</strong> a la fecha
    </p>

    <template x-if="loadingRate">
        <p class="text-[10px] text-slate-500 font-semibold flex items-center justify-center gap-2 py-1">
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
        <p class="text-[10px] text-slate-500 font-semibold py-1">Tasa BCV no disponible en este momento.</p>
    </template>
</div>
