@php
    use App\Support\PlanDetails;
    use App\Support\PlanPricing;
    $preview = $preview ?? false;
    $showDetailButton = $showDetailButton ?? false;
    $light = $light ?? false;
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
    <h2 class="text-lg md:text-xl font-black {{ $light ? 'text-slate-900' : 'text-white' }} text-center mb-2">Tabla comparativa de características técnicas</h2>
    <p class="text-[11px] {{ $light ? 'text-slate-600' : 'text-slate-400' }} text-center max-w-lg mx-auto">Plan Standard (Emprendedor) vs Plan Premium (Negocio). Precios en USD.</p>
</div>

<div class="overflow-x-auto pb-2 scrollbar-none rounded-2xl border {{ $light ? 'border-slate-200 bg-white shadow-lg shadow-slate-200/50' : 'border-white/10 bg-[#0d1127]/80 backdrop-blur-md shadow-xl' }}">
    <table class="w-full text-left border-collapse min-w-[520px] text-sm">
        <thead>
            <tr class="border-b {{ $light ? 'border-slate-200 bg-slate-50' : 'border-white/10 bg-white/[0.03]' }}">
                <th class="p-4 w-[34%] text-[10px] font-black uppercase tracking-widest text-slate-500">Característica / Módulo</th>
                <th class="p-4 border-l {{ $light ? 'border-slate-200' : 'border-white/5' }} text-center w-[33%]">
                    <span class="text-xs font-black {{ $light ? 'text-cyan-700' : 'text-cyan-300' }} uppercase">Plan Standard</span>
                    <p class="text-[10px] text-slate-500 mt-0.5">Emprendedor</p>
                    <p class="text-sm font-black {{ $light ? 'text-slate-900' : 'text-white' }} mt-1">{{ PlanPricing::formatUsd($standard['monthly']) }}<span class="text-[10px] text-slate-500 font-semibold">/mes</span></p>
                </th>
                <th class="p-4 border-l {{ $light ? 'border-purple-200 bg-purple-50/80' : 'border-purple-500/25 bg-purple-500/[0.06]' }} text-center w-[33%] relative">
                    <span class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-purple-500/50 via-fuchsia-500/40 to-cyan-400/50"></span>
                    <span class="landing-plan-badge landing-plan-badge--negocio text-[8px] px-2 py-0.5 rounded-full inline-block mb-1">Recomendado</span>
                    <span class="text-xs font-black text-transparent bg-clip-text bg-gradient-to-r {{ $light ? 'from-purple-700 to-fuchsia-600' : 'from-purple-200 to-fuchsia-300' }} uppercase">Plan Premium</span>
                    <p class="text-[10px] text-slate-500 mt-0.5">Negocio · {{ $wiStoreTrialLabel }}</p>
                    <p class="text-sm font-black {{ $light ? 'text-slate-900' : 'text-white' }} mt-1">{{ PlanPricing::formatUsd($premium['monthly']) }}<span class="text-[10px] text-slate-500 font-semibold">/mes</span></p>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y {{ $light ? 'divide-slate-100' : 'divide-white/5' }}">
            @foreach ($pricingRows as $pricingRow)
                <tr class="{{ $light ? 'bg-white hover:bg-slate-50' : 'bg-white/[0.025] hover:bg-white/[0.04]' }} transition-colors">
                    <td class="p-3.5 pl-4 font-bold text-[11px] {{ $light ? 'text-slate-600' : 'text-slate-300' }} uppercase tracking-wide">{{ $pricingRow['feature'] }}</td>
                    <td class="p-3.5 border-l {{ $light ? 'border-slate-100' : 'border-white/5' }} text-center text-xs {{ $light ? 'text-slate-700' : 'text-slate-200' }} font-semibold">
                        @if (!empty($pricingRow['badge']))
                            <span class="inline-flex px-2 py-0.5 rounded-lg {{ $light ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-emerald-500/15 border-emerald-500/25 text-emerald-300' }} border text-[11px] font-black">{{ $pricingRow['standard'] }}</span>
                        @elseif (!empty($pricingRow['highlight']))
                            <span class="{{ $light ? 'text-cyan-600' : 'text-cyan-300' }} font-black">{{ $pricingRow['standard'] }}</span>
                        @else
                            {{ $pricingRow['standard'] }}
                        @endif
                    </td>
                    <td class="p-3.5 border-l {{ $light ? 'border-purple-100 bg-purple-50/50 text-slate-800' : 'border-purple-500/15 text-slate-100 bg-purple-500/[0.03]' }} text-center text-xs font-semibold">
                        @if (!empty($pricingRow['badge']))
                            <span class="inline-flex px-2 py-0.5 rounded-lg {{ $light ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-emerald-500/15 border-emerald-500/25 text-emerald-300' }} border text-[11px] font-black">{{ $pricingRow['premium'] }}</span>
                        @elseif (!empty($pricingRow['highlight']))
                            <span class="{{ $light ? 'text-cyan-600' : 'text-cyan-300' }} font-black">{{ $pricingRow['premium'] }}</span>
                        @else
                            {{ $pricingRow['premium'] }}
                        @endif
                    </td>
                </tr>
            @endforeach
            @foreach ($rows as $row)
                <tr class="{{ $light ? 'hover:bg-slate-50' : 'hover:bg-white/[0.02]' }} transition-colors">
                    <td class="p-3.5 pl-4 font-semibold text-xs {{ $light ? 'text-slate-700' : 'text-slate-200' }}">{{ $row['feature'] }}</td>
                    <td class="p-3.5 border-l {{ $light ? 'border-slate-100 text-slate-600' : 'border-white/5 text-slate-300' }} text-center text-xs">{{ $row['standard'] }}</td>
                    <td class="p-3.5 border-l {{ $light ? 'border-purple-100 text-slate-700 bg-purple-50/40' : 'border-purple-500/15 text-slate-200 bg-purple-500/[0.03]' }} text-center text-xs font-medium">{{ $row['premium'] }}</td>
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
