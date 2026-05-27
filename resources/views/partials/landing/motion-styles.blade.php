{{-- Sistema de movimiento WI-Store (landing y páginas públicas de marca) --}}
<style>
    :root {
        --landing-ease-out: cubic-bezier(0.22, 1, 0.36, 1);
        --landing-ease-in-out: cubic-bezier(0.45, 0, 0.55, 1);
        --landing-ease-spring: cubic-bezier(0.34, 1.2, 0.64, 1);
        --landing-duration-fast: 0.25s;
        --landing-duration: 0.4s;
        --landing-duration-slow: 0.55s;
        --landing-header-offset: 4.5rem;
    }

    html.wi-store-ui.wi-store-landing {
        scroll-behavior: smooth;
        scroll-padding-top: var(--landing-header-offset);
    }

    @media (prefers-reduced-motion: reduce) {
        html.wi-store-ui.wi-store-landing {
            scroll-behavior: auto;
        }

        html.wi-store-ui.wi-store-landing *,
        html.wi-store-ui.wi-store-landing *::before,
        html.wi-store-ui.wi-store-landing *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Interacciones base más suaves */
    .wi-store-landing :where(a, button, [role="button"]):not(.landing-no-motion) {
        transition-property: color, background-color, border-color, opacity, transform, box-shadow, filter;
        transition-duration: var(--landing-duration);
        transition-timing-function: var(--landing-ease-out);
    }

    .landing-nav-link::after {
        transition: transform var(--landing-duration-slow) var(--landing-ease-out),
            opacity var(--landing-duration) var(--landing-ease-out);
    }

    .landing-step-pill {
        transition:
            background var(--landing-duration-slow) var(--landing-ease-out),
            border-color var(--landing-duration-slow) var(--landing-ease-out),
            color var(--landing-duration) var(--landing-ease-out),
            box-shadow var(--landing-duration-slow) var(--landing-ease-out),
            transform var(--landing-duration) var(--landing-ease-out);
    }

    .landing-step-pill:active {
        transform: scale(0.97);
    }

    .landing-how-card {
        transition:
            border-color var(--landing-duration-slow) var(--landing-ease-out),
            background var(--landing-duration-slow) var(--landing-ease-out),
            transform var(--landing-duration-slow) var(--landing-ease-spring),
            box-shadow var(--landing-duration-slow) var(--landing-ease-out);
    }

    .landing-benefit-card {
        transition:
            transform var(--landing-duration-slow) var(--landing-ease-spring),
            border-color var(--landing-duration) var(--landing-ease-out),
            background var(--landing-duration) var(--landing-ease-out);
    }

    .landing-scroll-progress {
        transition: transform 0.45s var(--landing-ease-out);
        will-change: transform;
    }

    /* Hero demo — crossfade entre pasos */
    .landing-hero-demo-stage {
        position: relative;
        min-height: 17.5rem;
        flex: 1;
    }

    .landing-hero-demo-panel {
        position: absolute;
        inset: 0;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }

    .landing-hero-demo-header {
        transition:
            background var(--landing-duration-slow) var(--landing-ease-out),
            box-shadow var(--landing-duration-slow) var(--landing-ease-out);
    }

    /* Utilidades Alpine (clases compartidas) */
    .landing-motion-enter {
        transition-property: opacity, transform;
        transition-duration: var(--landing-duration-slow);
        transition-timing-function: var(--landing-ease-out);
    }

    .landing-motion-leave {
        transition-property: opacity, transform;
        transition-duration: 0.35s;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Planes — crossfade mensual/anual (solo opacidad, sin salto) */
    .landing-billing-swap {
        position: relative;
    }

    .landing-billing-swap--sm {
        min-height: 5.25rem;
    }

    .landing-billing-swap--md {
        min-height: 6.75rem;
    }

    .landing-billing-swap--xs {
        min-height: 2.5rem;
    }

    .landing-billing-swap__layer {
        position: absolute;
        inset: 0;
        width: 100%;
        padding: 0.375rem 0.625rem;
    }

    .landing-billing-fade-enter {
        transition: opacity 0.35s ease;
    }

    .landing-billing-fade-leave {
        transition: opacity 0.28s ease;
    }

    @keyframes landing-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    .landing-float {
        animation: landing-float 6s var(--landing-ease-in-out) infinite;
    }

    @media (prefers-reduced-motion: reduce) {
        .landing-float {
            animation: none;
        }
    }
</style>
