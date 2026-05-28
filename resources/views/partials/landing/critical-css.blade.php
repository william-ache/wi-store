{{-- CSS crítico above-the-fold: hero + shell (≈1–2 KB). El resto va en build/landing.css --}}
<style>
    html { background: #ffffff; }
    body {
        margin: 0;
        min-height: 100vh;
        background: #ffffff;
        color: #1e293b;
        font-family: 'Outfit', ui-sans-serif, system-ui, -apple-system, sans-serif;
        -webkit-font-smoothing: antialiased;
        -webkit-tap-highlight-color: transparent;
    }
    [x-cloak] { display: none !important; }

    /* Hero = primera pantalla (debajo del header 4rem) */
    #inicio {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: calc(100svh - 4rem);
        min-height: calc(100dvh - 4rem);
        padding-top: 1.25rem;
        padding-bottom: 2rem;
        overflow: visible;
    }
    @media (min-width: 768px) {
        #inicio {
            padding-top: 1.5rem;
            padding-bottom: 2.5rem;
        }
    }
    @media (min-width: 1024px) {
        #inicio { padding-top: 2rem; }
    }
    .landing-hero-grid,
    .landing-hero-glow {
        position: absolute;
    }
    #inicio .landing-hero-inner {
        flex: 1;
        display: flex;
        align-items: center;
        width: 100%;
    }

    /* Cuadrícula: baja un poco más y se desvanece hacia «3 pasos + tutorial» */
    .landing-hero-grid {
        top: 0;
        left: 0;
        right: 0;
        height: calc(100% + 13rem);
        background-image:
            linear-gradient(to right, rgba(148, 163, 184, 0.26) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(148, 163, 184, 0.26) 1px, transparent 1px);
        background-size: 44px 44px;
        mask-image: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 1) 0%,
            rgba(0, 0, 0, 0.96) 42%,
            rgba(0, 0, 0, 0.88) 62%,
            rgba(0, 0, 0, 0.62) 78%,
            rgba(0, 0, 0, 0.28) 90%,
            rgba(0, 0, 0, 0.06) 97%,
            transparent 100%
        );
        -webkit-mask-image: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 1) 0%,
            rgba(0, 0, 0, 0.96) 42%,
            rgba(0, 0, 0, 0.88) 62%,
            rgba(0, 0, 0, 0.62) 78%,
            rgba(0, 0, 0, 0.28) 90%,
            rgba(0, 0, 0, 0.06) 97%,
            transparent 100%
        );
    }
    .landing-hero-glow {
        top: 0;
        left: 0;
        right: 0;
        height: calc(100% + 6rem);
        background:
            radial-gradient(ellipse 75% 60% at 88% 12%, rgba(34, 211, 238, 0.32), transparent 62%),
            radial-gradient(ellipse 55% 45% at 12% 35%, rgba(168, 85, 247, 0.18), transparent 58%);
        mask-image: linear-gradient(to bottom, #000 0%, #000 55%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, #000 0%, #000 55%, transparent 100%);
    }

    /* Velo suave de color de marca sobre el blanco */
    .landing-ambient-base {
        background:
            radial-gradient(ellipse 90% 50% at 50% -5%, rgba(99, 102, 241, 0.07), transparent 55%),
            radial-gradient(ellipse 70% 40% at 100% 20%, rgba(34, 211, 238, 0.08), transparent 50%),
            radial-gradient(ellipse 60% 35% at 0% 45%, rgba(168, 85, 247, 0.06), transparent 50%),
            radial-gradient(ellipse 65% 40% at 85% 65%, rgba(34, 211, 238, 0.06), transparent 50%),
            radial-gradient(ellipse 80% 45% at 15% 88%, rgba(192, 132, 252, 0.07), transparent 55%);
    }

    @keyframes landing-float-card {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    .landing-float-card {
        animation: landing-float-card 5s ease-in-out infinite;
    }
    .landing-float-card--delay {
        animation-delay: -2.5s;
    }
    @media (prefers-reduced-motion: reduce) {
        .landing-float-card { animation: none; }
    }

    /* Acentos locales por sección (refuerzan el fondo global) */
    .landing-section-glow {
        position: absolute;
        border-radius: 9999px;
        pointer-events: none;
        filter: blur(100px);
    }

    .gpu-accelerated {
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
    }
</style>
