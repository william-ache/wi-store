@php
    use App\Support\PlanDetails;
    use App\Support\PlanFeatures;
    use App\Support\PlanPricing;
    use App\Support\PlatformPlanSettings;
    $planPricing = PlanPricing::plans();
    $emprendedor = $planPricing['standard'] ?? PlanPricing::PLANS['standard'];
    $negocio = $planPricing['premium'] ?? PlanPricing::PLANS['premium'];
    $standardHighlights = PlanDetails::standard()['card_highlights'];
    $premiumHighlights = PlanDetails::premium()['card_highlights'];
    $standardPurpose = PlatformPlanSettings::purpose('standard') ?: 'Para PYMES que inician su gestión digital: pedidos, inventario y operación en un solo panel.';
    $premiumPurpose = PlatformPlanSettings::purpose('premium') ?: 'Para negocios que escalan: panel administrativo completo, más capacidad y control operativo.';
    $isAdminPricing = ($pricingContext ?? 'landing') === 'admin';
    $shopPlan = $shopForPricing ?? null;
    $resolvedShopPlan = $shopPlan ? PlanFeatures::resolvePlan($shopPlan) : null;
    $isCurrentStandard = $isAdminPricing && $resolvedShopPlan === 'standard';
    $isCurrentPremium = $isAdminPricing && in_array($resolvedShopPlan, ['premium', 'free_trial'], true);
    $billingPlanUrl = static function (string $plan) use ($shopPlan): string {
        if (!$shopPlan) {
            return '#';
        }

        return route('admin.billing.expired', ['shop_slug' => $shopPlan->slug, 'plan' => $plan]);
    };
@endphp

<div class="landing-pricing-grid__col landing-pricing-grid__col--standard">
    <div class="landing-pricing-grid__offset" aria-hidden="true"></div>

    <!-- Plan Emprendedor -->
    <div id="plan-standard"
        class="landing-plan-card landing-plan-card--emprendedor landing-plan-card--no-hover-lift rounded-3xl flex flex-col h-full min-h-0">
        <div class="landing-plan-card__main flex flex-col flex-1 min-h-0 p-5 md:p-6">
            <div class="flex justify-between items-start gap-2">
                <h3 class="text-sm md:text-base font-black text-slate-900 uppercase tracking-wider">
                    Plan <span class="landing-plan-title--cyan">Emprendedor</span>
                </h3>
                @if ($isCurrentStandard)
                    <span class="landing-plan-badge landing-plan-badge--current text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shrink-0">Plan actual</span>
                @else
                    <span class="landing-plan-badge landing-plan-badge--emprendedor text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shrink-0">Para empezar</span>
                @endif
            </div>
            <p class="text-[11px] text-slate-400 mt-2 leading-snug">{{ $standardPurpose }}</p>

            <div class="landing-plan-price--emprendedor landing-billing-swap landing-billing-swap--sm my-4 rounded-2xl px-4 py-4">
                <div class="landing-billing-swap__layer"
                     x-show="billingPeriod === 'monthly'"
                     x-transition:enter="landing-billing-fade-enter"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="landing-billing-fade-leave"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <p class="text-3xl font-black text-slate-900 tracking-tight">
                        {{ PlanPricing::formatUsd($emprendedor['monthly']) }}
                        <span class="text-sm font-semibold text-slate-500">/ mes</span>
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1">
                        <span class="text-cyan-600">Anual: <strong class="text-cyan-600">{{ PlanPricing::formatUsd($emprendedor['annual_monthly_equivalent']) }}/mes</strong></span>
                        · ahorro anual: {{ $emprendedor['annual_savings_label'] }}
                    </p>
                </div>
                <div class="landing-billing-swap__layer"
                     x-show="billingPeriod === 'annual'"
                     x-cloak
                     x-transition:enter="landing-billing-fade-enter"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="landing-billing-fade-leave"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 mb-1">
                        {{ $emprendedor['annual_discount_percent'] }}% dto. · facturación anual
                    </p>
                    <p class="text-3xl font-black text-slate-900 tracking-tight">
                        {{ PlanPricing::formatUsd($emprendedor['annual_monthly_equivalent']) }}
                        <span class="text-sm font-semibold text-slate-500">/ mes</span>
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight">
                        Total <strong class="text-slate-600">{{ PlanPricing::formatUsd($emprendedor['annual_total']) }}/año</strong>
                        · ahorro anual: {{ $emprendedor['annual_savings_label'] }}
                    </p>
                </div>
            </div>

            <ul class="space-y-1.5 text-[10px] md:text-[11px] text-slate-600 border-t border-slate-200 pt-3">
                @foreach ($standardHighlights as $highlight)
                    <li class="flex gap-2 leading-snug"><span class="landing-plan-check--cyan font-bold shrink-0">✓</span><span>{{ $highlight }}</span></li>
                @endforeach
            </ul>
        </div>

        <div class="landing-plan-card-footer shrink-0 px-5 md:px-6 pb-5 md:pb-6 pt-0">
            @if ($isAdminPricing && $shopPlan)
                @if ($isCurrentStandard)
                    <span class="landing-plan-btn landing-plan-btn--soft block w-full text-center font-extrabold py-3 rounded-xl text-xs">Plan actual</span>
                @else
                    <a href="{{ $billingPlanUrl('standard') }}"
                        class="landing-plan-btn landing-plan-btn--emprendedor block w-full text-center text-white font-extrabold py-3 rounded-xl text-xs">
                        {{ $isCurrentPremium ? 'Cambiar a Emprendedor' : 'Contratar Emprendedor' }}
                    </a>
                @endif
                <div class="landing-plan-card-footer__spacer" aria-hidden="true"></div>
            @else
                <a href="/register" class="landing-plan-btn landing-plan-btn--emprendedor block w-full text-center text-white font-extrabold py-3 rounded-xl text-xs">Probar gestión Emprendedor</a>
                <div class="landing-plan-card-footer__spacer" aria-hidden="true"></div>
            @endif
        </div>
    </div>
</div>

<div class="landing-pricing-grid__col landing-pricing-grid__col--premium">
    <!-- Plan Negocio -->
    <div id="plan-premium"
        class="landing-plan-card landing-plan-card--featured landing-plan-card--negocio-spotlight landing-plan-card--no-hover-lift rounded-3xl flex flex-col h-full min-h-0">
        <div class="landing-plan-inner landing-plan-inner--negocio flex flex-col h-full min-h-0">
            <div class="landing-plan-recommended-bar">{{ $isCurrentPremium ? 'Plan actual' : 'Recomendado' }}</div>

            <div class="landing-plan-card__main flex flex-col flex-1 min-h-0 p-5 md:p-6">
                <div class="flex justify-between items-center gap-3">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="landing-plan-icon--negocio w-9 h-9 shrink-0 rounded-xl flex items-center justify-center">
                            <i class="fas fa-crown text-sm text-purple-600"></i>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide whitespace-nowrap leading-none">
                            Plan <span class="landing-plan-title--purple">Negocio</span>
                        </h3>
                    </div>
                    <span class="landing-plan-trial-floating shrink-0">
                        <i class="fas fa-gift" aria-hidden="true"></i>{{ $wiStoreTrialLabel }}
                    </span>
                </div>
                <p class="text-[11px] text-slate-400 mt-2 leading-snug">{{ $premiumPurpose }}</p>

                <div class="landing-plan-price--negocio my-4 rounded-2xl px-4 py-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Después del periodo de prueba</p>
                    <div class="landing-billing-swap landing-billing-swap--md mt-1">
                        <div class="landing-billing-swap__layer"
                             x-show="billingPeriod === 'monthly'"
                             x-transition:enter="landing-billing-fade-enter"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="landing-billing-fade-leave"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <p class="text-3xl font-black text-slate-900 tracking-tight">
                                {{ PlanPricing::formatUsd($negocio['monthly']) }}
                                <span class="text-sm font-semibold text-slate-500">/ mes</span>
                            </p>
                            <p class="text-[10px] text-slate-500 mt-1">
                                <span class="text-purple-600">Anual: <strong class="text-purple-600">{{ PlanPricing::formatUsd($negocio['annual_monthly_equivalent']) }}/mes</strong></span>
                                · <strong class="text-slate-600">estás ahorrando {{ $negocio['annual_savings_label'] }} por pago anual</strong>
                            </p>
                        </div>
                        <div class="landing-billing-swap__layer"
                             x-show="billingPeriod === 'annual'"
                             x-cloak
                             x-transition:enter="landing-billing-fade-enter"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="landing-billing-fade-leave"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 mb-1">
                                {{ $negocio['annual_discount_percent'] }}% dto. · facturación anual
                            </p>
                            <p class="text-3xl font-black text-slate-900 tracking-tight">
                                {{ PlanPricing::formatUsd($negocio['annual_monthly_equivalent']) }}
                                <span class="text-sm font-semibold text-slate-500">/ mes</span>
                            </p>
                            <p class="text-[10px] text-slate-500 mt-1">
                                Total <strong class="text-slate-600">{{ PlanPricing::formatUsd($negocio['annual_total']) }}/año</strong>
                                · <strong class="text-slate-600">estás ahorrando {{ $negocio['annual_savings_label'] }} por pago anual</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <ul class="space-y-1.5 text-[10px] text-slate-600 border-t border-purple-200 pt-3">
                    @foreach ($premiumHighlights as $highlight)
                        <li class="flex gap-2 leading-snug"><span class="landing-plan-check--purple font-bold shrink-0">✓</span><span>{{ $highlight }}</span></li>
                    @endforeach
                </ul>
            </div>

            <div class="landing-plan-card-footer shrink-0 px-5 md:px-6 pb-5 md:pb-6 pt-0">
                @if ($isAdminPricing && $shopPlan)
                    @if ($isCurrentPremium)
                        <span class="landing-plan-btn landing-plan-btn--soft block w-full text-center font-extrabold py-3 rounded-xl text-xs">Plan actual</span>
                        @if ($resolvedShopPlan === 'free_trial')
                            <p class="text-[9px] text-center text-slate-500 leading-snug px-1 mt-2">{{ $wiStoreTrialDisclaimer }}</p>
                        @else
                            <div class="landing-plan-card-footer__spacer" aria-hidden="true"></div>
                        @endif
                    @else
                        <a href="{{ $billingPlanUrl('premium') }}"
                            class="landing-plan-btn landing-plan-btn--negocio block w-full text-center text-white font-extrabold py-3 rounded-xl text-xs">
                            Actualizar a Negocio
                        </a>
                        <div class="landing-plan-card-footer__spacer" aria-hidden="true"></div>
                    @endif
                @else
                    <a href="/register"
                        class="landing-plan-btn landing-plan-btn--negocio block w-full text-center text-white font-extrabold py-3 rounded-xl text-xs">
                        Probar gestión Negocio
                    </a>
                    <p class="text-[9px] text-center text-slate-500 leading-snug px-1 mt-2">{{ $wiStoreTrialDisclaimer }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
