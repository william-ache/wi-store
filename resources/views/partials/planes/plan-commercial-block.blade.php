@php
    use App\Support\PlanDetails;
    use App\Support\PlanPricing;

    $plan = $planKey === 'premium' ? PlanDetails::premium() : PlanDetails::standard();
    $pricing = PlanPricing::PLANS[$planKey];
    $isPremium = $planKey === 'premium';
@endphp

<article class="rounded-2xl border overflow-hidden {{ $isPremium ? 'border-purple-500/30 bg-purple-500/[0.06]' : 'border-cyan-500/25 bg-cyan-500/[0.04]' }}">
    <div class="p-5 md:p-6 border-b border-white/10">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest {{ $isPremium ? 'text-purple-300' : 'text-cyan-300' }}">
                    Plan {{ $plan['technical_name'] }}
                </p>
                <h3 class="text-xl md:text-2xl font-black text-white mt-1">
                    {{ $plan['marketing_name'] }}
                    <span class="text-base font-semibold text-slate-400">· {{ PlanPricing::formatUsd($pricing['monthly']) }}/mes</span>
                </h3>
            </div>
            @if ($isPremium)
                <span class="landing-plan-badge landing-plan-badge--negocio text-[8px] px-2 py-0.5 rounded-full">Recomendado</span>
            @endif
        </div>
        <p class="text-xs md:text-sm text-slate-300 mt-4 leading-relaxed">{{ $plan['purpose'] }}</p>
    </div>
    <div class="p-5 md:p-6 space-y-4">
        @foreach ($plan['sections'] as $section)
            <div>
                <h4 class="text-[11px] font-black uppercase tracking-wide text-slate-200 mb-1">{{ $section['title'] }}</h4>
                <p class="text-[11px] text-slate-400 leading-relaxed">{{ $section['body'] }}</p>
            </div>
        @endforeach
    </div>
</article>
