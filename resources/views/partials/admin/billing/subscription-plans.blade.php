@php
    $pricingContext = 'admin';
    $shopForPricing = $shop;
@endphp

<div x-data="{ billingPeriod: 'monthly' }" class="admin-subscription-plans">
    @include('partials.landing.pricing-billing-toggle')

    <div class="landing-pricing-grid">
        @include('partials.landing.pricing-cards')
    </div>
</div>
