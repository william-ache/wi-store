<style>
    [x-cloak] { display: none !important; }
    @include('partials.landing.plan-card-styles')
    .landing-billing-swap { position: relative; }
    .landing-billing-swap--sm { min-height: 4.95rem; }
    .landing-billing-swap--md { min-height: 5.4rem; }
    .landing-billing-swap__layer {
        position: absolute;
        inset: 0;
        width: 100%;
        padding: 0.375rem 0.625rem;
    }
    .landing-billing-fade-enter { transition: opacity 0.35s ease; }
    .landing-billing-fade-leave { transition: opacity 0.28s ease; }
</style>
