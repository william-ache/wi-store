@php
    use App\Support\PlanDetails;
    use App\Support\PlanPricing;

    $plan = $planKey === 'premium' ? PlanDetails::premium() : PlanDetails::standard();
    $pricing = PlanPricing::PLANS[$planKey];
    $isPremium = $planKey === 'premium';
@endphp

<div x-show="selectedPlan === '{{ $planKey }}'" class="p-6 md:p-10 space-y-6">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl {{ $isPremium ? 'bg-purple-500/10 border-purple-500/20 text-purple-400' : 'bg-cyan-500/10 border-cyan-500/20 text-cyan-300' }} border flex items-center justify-center">
            <i class="fas {{ $isPremium ? 'fa-crown' : 'fa-award' }} text-xl"></i>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest {{ $isPremium ? 'text-purple-300/80' : 'text-cyan-300/90' }}">
                Plan {{ $plan['technical_name'] }}
            </p>
            <h3 class="text-xl md:text-2xl font-black text-white uppercase">
                {{ $plan['marketing_name'] }}
            </h3>
            <p class="text-xs {{ $isPremium ? 'text-cyan-300' : 'text-cyan-300/80' }} font-bold uppercase tracking-wider mt-0.5">
                @if ($isPremium)
                    14 días gratis · luego {{ PlanPricing::formatUsd($pricing['monthly']) }} / mes
                @else
                    {{ PlanPricing::formatUsd($pricing['monthly']) }} / mes · {{ $pricing['annual_discount_percent'] }}% dto. anual
                @endif
            </p>
        </div>
    </div>

    <p class="text-xs md:text-sm text-slate-300 leading-relaxed">{{ $plan['purpose'] }}</p>

    <div class="border-t border-white/5 pt-6 space-y-4 max-h-[40vh] overflow-y-auto pr-1 scrollbar-none">
        @foreach ($plan['sections'] as $section)
            <div>
                <h4 class="text-[11px] uppercase font-black text-slate-200 tracking-wider mb-1">{{ $section['title'] }}</h4>
                <p class="text-xs text-slate-400 leading-relaxed">{{ $section['body'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="{{ $isPremium ? 'bg-purple-900/15 border-purple-500/20' : 'bg-white/[0.03] border-cyan-500/20' }} border rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-6">
        <div>
            <p class="text-xs {{ $isPremium ? 'text-purple-300' : 'text-cyan-300/80' }} font-semibold">Mensual · Anual</p>
            <p class="text-xl font-black text-white">{{ PlanPricing::formatUsd($pricing['monthly']) }}/mes</p>
            <p class="text-sm text-slate-400">
                {{ PlanPricing::formatUsd($pricing['annual_total']) }}/año
                ({{ PlanPricing::formatUsd($pricing['annual_monthly_equivalent']) }}/mes)
                @if ($isPremium)
                    · ahorro {{ $pricing['annual_savings_label'] }}
                @endif
            </p>
        </div>
        <a href="/register"
            class="{{ $isPremium ? 'landing-plan-btn landing-plan-btn--negocio' : 'landing-plan-btn' }} text-white font-black px-6 py-3 rounded-xl text-xs transition-all shrink-0 text-center">
            {{ $isPremium ? 'Probar 14 días gratis' : 'Adquirir Emprendedor' }}
        </a>
    </div>
</div>
