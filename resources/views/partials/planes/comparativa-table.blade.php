@php
    use App\Support\PlanDetails;
    use App\Support\PlanPricing;
    $preview = $preview ?? false;
    $showDetailButton = $showDetailButton ?? false;
    $rows = $preview ? PlanDetails::comparisonRowsPreview() : PlanDetails::comparisonRows();
    $standard = PlanPricing::PLANS['standard'];
    $premium = PlanPricing::PLANS['premium'];
    $pricingRows = [
        [
            'feature' => 'Descuento anual',
            'standard' => $standard['annual_discount_percent'] . '% DTO.',
            'premium' => $premium['annual_discount_percent'] . '% DTO.',
            'badge' => true,
        ],
        [
            'feature' => 'Costo mensual equiv.',
            'standard' => PlanPricing::formatUsd($standard['annual_monthly_equivalent']) . ' / mes',
            'premium' => PlanPricing::formatUsd($premium['annual_monthly_equivalent']) . ' / mes',
        ],
        [
            'feature' => 'Total facturado anual',
            'standard' => PlanPricing::formatUsd($standard['annual_total']) . ' / año',
            'premium' => PlanPricing::formatUsd($premium['annual_total']) . ' / año',
        ],
        [
            'feature' => 'Ahorro real anual',
            'standard' => $standard['annual_savings_label'],
            'premium' => $premium['annual_savings_label'],
            'highlight' => true,
        ],
    ];
@endphp

<div class="mb-8">
    <h2 class="text-lg md:text-xl font-black text-white text-center mb-2">Tabla comparativa de características técnicas</h2>
    <p class="text-[11px] text-slate-400 text-center max-w-lg mx-auto">Plan Standard (Emprendedor) vs Plan Premium (Negocio). Precios en USD.</p>
</div>

<div class="overflow-x-auto pb-2 scrollbar-none rounded-2xl border border-white/10 bg-[#0d1127]/80 backdrop-blur-md shadow-xl">
    <table class="w-full text-left border-collapse min-w-[520px] text-sm">
        <thead>
            <tr class="border-b border-white/10 bg-white/[0.03]">
                <th class="p-4 w-[34%] text-[10px] font-black uppercase tracking-widest text-slate-500">Característica / Módulo</th>
                <th class="p-4 border-l border-white/5 text-center w-[33%]">
                    <span class="text-xs font-black text-cyan-300 uppercase">Plan Standard</span>
                    <p class="text-[10px] text-slate-400 mt-0.5">Emprendedor</p>
                    <p class="text-sm font-black text-white mt-1">{{ PlanPricing::formatUsd($standard['monthly']) }}<span class="text-[10px] text-slate-500 font-semibold">/mes</span></p>
                </th>
                <th class="p-4 border-l border-purple-500/25 text-center w-[33%] bg-purple-500/[0.06] relative">
                    <span class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-purple-500/50 via-fuchsia-500/40 to-cyan-400/50"></span>
                    <span class="landing-plan-badge landing-plan-badge--negocio text-[8px] px-2 py-0.5 rounded-full inline-block mb-1">Recomendado</span>
                    <span class="text-xs font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-fuchsia-300 uppercase">Plan Premium</span>
                    <p class="text-[10px] text-slate-400 mt-0.5">Negocio · {{ $wiStoreTrialLabel }}</p>
                    <p class="text-sm font-black text-white mt-1">{{ PlanPricing::formatUsd($premium['monthly']) }}<span class="text-[10px] text-slate-500 font-semibold">/mes</span></p>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach ($pricingRows as $pricingRow)
                <tr class="bg-white/[0.025] hover:bg-white/[0.04] transition-colors">
                    <td class="p-3.5 pl-4 font-bold text-[11px] text-slate-300 uppercase tracking-wide">{{ $pricingRow['feature'] }}</td>
                    <td class="p-3.5 border-l border-white/5 text-center text-xs text-slate-200 font-semibold">
                        @if (!empty($pricingRow['badge']))
                            <span class="inline-flex px-2 py-0.5 rounded-lg bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 text-[11px] font-black">{{ $pricingRow['standard'] }}</span>
                        @elseif (!empty($pricingRow['highlight']))
                            <span class="text-cyan-300 font-black">{{ $pricingRow['standard'] }}</span>
                        @else
                            {{ $pricingRow['standard'] }}
                        @endif
                    </td>
                    <td class="p-3.5 border-l border-purple-500/15 text-center text-xs text-slate-100 bg-purple-500/[0.03] font-semibold">
                        @if (!empty($pricingRow['badge']))
                            <span class="inline-flex px-2 py-0.5 rounded-lg bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 text-[11px] font-black">{{ $pricingRow['premium'] }}</span>
                        @elseif (!empty($pricingRow['highlight']))
                            <span class="text-cyan-300 font-black">{{ $pricingRow['premium'] }}</span>
                        @else
                            {{ $pricingRow['premium'] }}
                        @endif
                    </td>
                </tr>
            @endforeach
            @foreach ($rows as $row)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="p-3.5 pl-4 font-semibold text-xs text-slate-200">{{ $row['feature'] }}</td>
                    <td class="p-3.5 border-l border-white/5 text-center text-xs text-slate-300">{{ $row['standard'] }}</td>
                    <td class="p-3.5 border-l border-purple-500/15 text-center text-xs text-slate-200 bg-purple-500/[0.03] font-medium">{{ $row['premium'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($showDetailButton)
    <div class="mt-6 text-center">
        <a href="{{ route('planes.comparativa') }}"
            class="inline-flex items-center gap-2 landing-plan-btn text-white font-extrabold px-6 py-3 rounded-xl text-xs uppercase tracking-wide transition-all hover:brightness-110">
            Ver más detalle de los planes
            <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>
@endif
