@php
    use App\Support\PlanDetails;
    use App\Support\PlanPricing;

    $plan = $planKey === 'premium' ? PlanDetails::premium() : PlanDetails::standard();
    $pricing = \App\Support\PlanCatalog::pricingFor($planKey) ?? PlanPricing::PLANS[$planKey];
    $isPremium = $planKey === 'premium';
@endphp

<div x-show="selectedPlan === '{{ $planKey }}'" class="p-6 md:p-10 space-y-6">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl {{ $isPremium ? 'bg-purple-100 border-purple-200 text-purple-600' : 'bg-cyan-100 border-cyan-200 text-cyan-600' }} border flex items-center justify-center">
            <i class="fas {{ $isPremium ? 'fa-crown' : 'fa-award' }} text-xl"></i>
        </div>
        <div>
            <h3 class="text-xl md:text-2xl font-black text-slate-900 uppercase">
                Plan {{ $plan['marketing_name'] }}
            </h3>
            <p class="text-xs {{ $isPremium ? 'text-cyan-700' : 'text-cyan-600' }} font-bold uppercase tracking-wider mt-0.5">
                @if ($isPremium)
                    {{ $wiStoreTrialLabel }} · luego {{ PlanPricing::formatUsd($pricing['monthly']) }} / mes
                @else
                    {{ PlanPricing::formatUsd($pricing['monthly']) }} / mes · {{ $pricing['annual_discount_percent'] }}% dto. anual
                @endif
            </p>
        </div>
    </div>

    <p class="text-xs md:text-sm text-slate-600 leading-relaxed">{{ $plan['purpose'] }}</p>

    <div class="border-t border-slate-200 pt-6 space-y-4 max-h-[40vh] overflow-y-auto pr-1 scrollbar-none">
        @foreach ($plan['sections'] as $section)
            <div>
                <h4 class="text-[11px] uppercase font-black text-slate-800 tracking-wider mb-1">{{ $section['title'] }}</h4>
                <p class="text-xs text-slate-500 leading-relaxed">{{ $section['body'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="{{ $isPremium ? 'bg-purple-50 border-purple-200' : 'bg-cyan-50 border-cyan-200' }} border rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-6">
        <div>
            <p class="text-xs {{ $isPremium ? 'text-purple-700' : 'text-cyan-700' }} font-semibold">Mensual · Anual</p>
            <p class="text-xl font-black text-slate-900">{{ PlanPricing::formatUsd($pricing['monthly']) }}/mes</p>
            <p class="text-sm text-slate-500">
                {{ PlanPricing::formatUsd($pricing['annual_total']) }}/año
                ({{ PlanPricing::formatUsd($pricing['annual_monthly_equivalent']) }}/mes)
                @if ($isPremium)
                    · ahorro {{ $pricing['annual_savings_label'] }}
                @endif
            </p>
        </div>
        <a href="/register"
            class="{{ $isPremium ? 'landing-plan-btn landing-plan-btn--negocio' : 'landing-plan-btn' }} text-white font-black px-6 py-3 rounded-xl text-xs transition-all shrink-0 text-center">
            {{ $isPremium ? 'Probar ' . $wiStoreTrialLabel : 'Adquirir Emprendedor' }}
        </a>
    </div>
</div>
