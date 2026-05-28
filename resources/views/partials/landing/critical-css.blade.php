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
        overflow-x: clip;
        overflow-y: visible;
    }
    .landing-hero-surface {
        background:
            radial-gradient(ellipse 70% 45% at 8% 38%, rgba(168, 85, 247, 0.1), transparent 62%),
            radial-gradient(ellipse 72% 42% at 92% 18%, rgba(34, 211, 238, 0.12), transparent 64%),
            radial-gradient(ellipse 80% 48% at 50% 92%, rgba(217, 70, 239, 0.06), transparent 68%);
        background-repeat: no-repeat;
        background-color: transparent;
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
    @media (min-width: 1024px) and (max-height: 820px) {
        #inicio {
            min-height: auto;
            padding-top: 1rem;
            padding-bottom: 1.25rem;
        }
        #inicio .landing-hero-inner {
            align-items: flex-start;
        }
        #inicio h1 {
            font-size: clamp(2.2rem, 4vw, 3rem);
            line-height: 1.04;
        }
        #inicio .landing-hero-lead {
            font-size: 1.02rem;
            line-height: 1.55;
            margin-top: 1rem;
        }
        #inicio .landing-float-card:first-child {
            max-width: 300px;
            padding: 1rem 1.1rem;
        }
        #inicio .landing-float-card--delay {
            width: min(100%, 180px);
            padding: 0.75rem;
            bottom: 0;
        }
        #inicio .landing-hero-scroll-wrap {
            padding-top: 0.35rem;
        }
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
    .landing-hero-lead {
        color: #4b5563;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9);
    }
    .landing-hero-social__avatar {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 9999px;
        border: 2px solid #fff;
        background: #f1f5f9;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.12);
        overflow: hidden;
        margin-left: -0.45rem;
    }
    .landing-hero-social__stack .landing-hero-social__avatar:first-child {
        margin-left: 0;
    }
    .landing-hero-social__avatar--count {
        background: linear-gradient(to bottom right, #9333ea, #d946ef, #06b6d4);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        z-index: 10;
        box-shadow: 0 2px 10px rgba(168, 85, 247, 0.35);
    }
    .landing-hero-social__avatar--placeholder {
        background: linear-gradient(135deg, #9333ea, #06b6d4);
    }
    .landing-hero-social__initials {
        font-size: 0.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }
    .landing-hero-social__brand {
        font-weight: 800;
        letter-spacing: -0.03em;
        background: linear-gradient(90deg, #0f172a 0%, #4c1d95 22%, #7c3aed 48%, #6366f1 62%, #38bdf8 88%, #22d3ee 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .landing-hero-scroll-hint {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.875rem;
        height: 2.875rem;
        border-radius: 9999px;
        border: none;
        background: linear-gradient(90deg, #9333ea, #06b6d4);
        color: #fff;
        cursor: pointer;
        box-shadow: 0 6px 22px rgba(147, 51, 234, 0.38), 0 2px 8px rgba(6, 182, 212, 0.25);
        transition: filter 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        animation: landing-hero-scroll-bounce 2.2s ease-in-out infinite;
    }
    .landing-hero-scroll-hint:hover {
        filter: brightness(1.06);
        box-shadow: 0 8px 26px rgba(147, 51, 234, 0.45), 0 4px 12px rgba(6, 182, 212, 0.35);
    }
    .landing-hero-scroll-hint__ring {
        position: absolute;
        inset: -5px;
        border-radius: inherit;
        background: linear-gradient(90deg, rgba(147, 51, 234, 0.35), rgba(6, 182, 212, 0.35));
        opacity: 0.55;
        z-index: 0;
        filter: blur(6px);
    }
    .landing-hero-scroll-hint i {
        position: relative;
        z-index: 1;
        font-size: 0.95rem;
        font-weight: 700;
    }
    @keyframes landing-hero-scroll-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(5px); }
    }
    @media (prefers-reduced-motion: reduce) {
        .landing-hero-scroll-hint { animation: none; }
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
            linear-gradient(90deg, rgba(168, 85, 247, 0.08) 0%, rgba(217, 70, 239, 0.05) 44%, rgba(34, 211, 238, 0.08) 100%),
            radial-gradient(ellipse 78% 62% at 88% 14%, rgba(34, 211, 238, 0.34), transparent 64%),
            radial-gradient(ellipse 78% 62% at 14% 42%, rgba(168, 85, 247, 0.32), transparent 64%),
            radial-gradient(ellipse 50% 40% at 8% 55%, rgba(147, 51, 234, 0.14), transparent 58%);
        background-repeat: no-repeat;
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
        background-repeat: no-repeat;
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
