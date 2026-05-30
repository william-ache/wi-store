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

    :root {
        --landing-header-h: 4rem;
    }

    /* Hero = una pantalla completa (el header sticky queda encima) */
    #inicio {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 100svh;
        min-height: 100dvh;
        margin-top: calc(-1 * var(--landing-header-h));
        padding-top: calc(var(--landing-header-h) + 1.25rem);
        padding-bottom: 2rem;
        scroll-margin-top: var(--landing-header-h);
        overflow-x: clip;
        overflow-y: visible;
        isolation: isolate;
    }

    .landing-hero-backdrop {
        position: absolute;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        transform: translateZ(0);
        backface-visibility: hidden;
    }
    .landing-hero-surface {
        background:
            radial-gradient(ellipse 70% 45% at 8% 38%, rgba(168, 85, 247, 0.035), transparent 62%),
            radial-gradient(ellipse 72% 42% at 92% 18%, rgba(34, 211, 238, 0.04), transparent 64%),
            radial-gradient(ellipse 80% 48% at 50% 92%, rgba(217, 70, 239, 0.02), transparent 68%),
            radial-gradient(ellipse 68% 52% at 10% 98%, rgba(168, 85, 247, 0.04), transparent 62%),
            radial-gradient(ellipse 62% 48% at 90% 96%, rgba(34, 211, 238, 0.045), transparent 60%);
        background-repeat: no-repeat;
        background-color: transparent;
    }
    @media (min-width: 768px) {
        #inicio {
            padding-top: calc(var(--landing-header-h) + 1.5rem);
            padding-bottom: 2.5rem;
        }
    }
    @media (min-width: 1024px) {
        #inicio {
            padding-top: calc(var(--landing-header-h) + 2rem);
        }
    }
    @media (min-width: 1024px) and (max-height: 820px) {
        #inicio {
            padding-top: calc(var(--landing-header-h) + 1rem);
            padding-bottom: 1.25rem;
        }
        #inicio .landing-hero-inner {
            align-items: flex-start;
        }
        #inicio .landing-hero-title {
            font-size: clamp(1.4rem, 2.6vw, 1.75rem);
            line-height: 1.12;
        }
        #inicio .landing-hero-benefits {
            margin-top: 0.75rem;
            gap: 0.4rem;
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
    .landing-hero-glow,
    .landing-hero-fade {
        position: absolute;
        left: 0;
        right: 0;
    }
    #inicio .landing-hero-inner {
        flex: 1;
        display: flex;
        align-items: center;
        width: 100%;
    }

    #inicio .landing-hero-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 2.5rem;
        align-items: center;
        width: 100%;
    }
    #inicio .landing-hero-copy {
        text-align: left;
        width: 100%;
        min-width: 0;
        max-width: none;
    }
    @media (min-width: 1024px) {
        #inicio .landing-hero-grid {
            grid-template-columns: minmax(0, 1.15fr) minmax(0, 0.85fr);
            gap: 2rem 2.75rem;
        }
    }
    @media (min-width: 1280px) {
        #inicio .landing-hero-grid {
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.8fr);
            gap: 2.5rem 3rem;
        }
    }

    #inicio .landing-hero-actions {
        margin-top: 1.75rem;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    #inicio .landing-hero-actions__ctas {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.65rem 0.75rem;
        width: 100%;
    }
    @media (min-width: 640px) {
        #inicio .landing-hero-actions {
            gap: 1.1rem;
        }
        #inicio .landing-hero-actions__ctas {
            gap: 0.75rem 1rem;
        }
    }
    @media (min-width: 1024px) {
        #inicio .landing-hero-actions {
            margin-top: 1.85rem;
        }
    }
    #inicio .landing-hero-social {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        min-width: 0;
    }

    /* Título hero — tamaños en CSS crítico (no dependen del build de Tailwind) */
    #inicio .landing-hero-title {
        margin: 0;
        font-size: 1.5rem;
        line-height: 1.15;
        font-weight: 900;
        letter-spacing: -0.02em;
        color: #0f172a;
    }
    #inicio .landing-hero-title-accent {
        color: #7c3aed;
    }
    @media (min-width: 640px) {
        #inicio .landing-hero-title {
            font-size: 1.75rem;
        }
    }
    @media (min-width: 1024px) {
        #inicio .landing-hero-title {
            font-size: 2rem;
        }
    }
    @media (min-width: 1280px) {
        #inicio .landing-hero-title {
            font-size: 2.25rem;
        }
    }

    .landing-hero-lead {
        color: #4b5563;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9);
    }

    /* Lista de beneficios bajo el título (hero) */
    #inicio .landing-hero-benefits {
        list-style: none;
        margin: 1rem 0 0;
        padding: 0;
        max-width: none;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }
    #inicio .landing-hero-benefits__item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    #inicio .landing-hero-benefits__icon {
        flex-shrink: 0;
        width: 1.75rem;
        height: 1.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        font-size: 0.72rem;
        line-height: 1;
        border: 1px solid rgba(255, 255, 255, 0.85);
        box-shadow:
            0 1px 6px rgba(15, 23, 42, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.75);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    #inicio .landing-hero-benefits__item:hover .landing-hero-benefits__icon {
        transform: translateY(-1px);
        box-shadow:
            0 4px 14px rgba(15, 23, 42, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.85);
    }
    #inicio .landing-hero-benefits__icon--catalog {
        color: #7c3aed;
        background: linear-gradient(145deg, #f5f3ff 0%, #ede9fe 55%, #faf5ff 100%);
        border-color: rgba(167, 139, 250, 0.35);
    }
    #inicio .landing-hero-benefits__icon--cart {
        color: #0891b2;
        background: linear-gradient(145deg, #ecfeff 0%, #cffafe 55%, #f0fdfa 100%);
        border-color: rgba(34, 211, 238, 0.35);
    }
    #inicio .landing-hero-benefits__icon--panel {
        color: #4f46e5;
        background: linear-gradient(145deg, #eef2ff 0%, #e0e7ff 55%, #f5f3ff 100%);
        border-color: rgba(129, 140, 248, 0.35);
    }
    #inicio .landing-hero-benefits__icon--fast {
        color: #9333ea;
        background: linear-gradient(145deg, #faf5ff 0%, #f3e8ff 40%, #ecfeff 100%);
        border-color: rgba(147, 51, 234, 0.28);
        box-shadow:
            0 1px 8px rgba(147, 51, 234, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    #inicio .landing-hero-benefits__text {
        font-size: 0.8125rem;
        line-height: 1.35;
        color: #475569;
        font-weight: 500;
    }
    #inicio .landing-hero-benefits__emph {
        font-weight: 700;
        color: #1e293b;
    }
    @media (min-width: 768px) {
        #inicio .landing-hero-benefits {
            margin-top: 1.1rem;
            gap: 0.5rem;
        }
        #inicio .landing-hero-benefits__text {
            font-size: 0.875rem;
        }
        #inicio .landing-hero-benefits__icon {
            width: 1.85rem;
            height: 1.85rem;
            font-size: 0.75rem;
            border-radius: 0.55rem;
        }
    }
    @media (min-width: 1024px) and (max-height: 820px) {
        #inicio .landing-hero-benefits {
            margin-top: 0.75rem;
            gap: 0.35rem;
        }
        #inicio .landing-hero-benefits__text {
            font-size: 0.8rem;
        }
    }

    /* Barra inferior hero: icono + texto en fila (trial · activo · cancelar) */
    #inicio .landing-hero-trust-badges {
        list-style: none;
        margin: 2rem 0 0;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        max-width: none;
        column-gap: clamp(0.85rem, 3vw, 1.75rem);
        row-gap: 0.5rem;
    }
    #inicio .landing-hero-trust-badges__item {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.625rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #1e293b;
        line-height: 1.2;
        white-space: nowrap;
    }
    #inicio .landing-hero-trust-badges__icon {
        flex-shrink: 0;
        width: 0.95rem;
        text-align: center;
        font-size: 0.8rem;
        color: #334155;
        line-height: 1;
    }
    #inicio .landing-hero-trust-badges__icon.fa-rocket {
        font-size: 0.75rem;
        transform: translateY(-0.5px) rotate(-18deg);
    }
    @media (min-width: 640px) {
        #inicio .landing-hero-trust-badges {
            margin-top: 2.25rem;
            flex-wrap: nowrap;
            column-gap: clamp(1rem, 4.5vw, 2.25rem);
        }
        #inicio .landing-hero-trust-badges__item {
            font-size: 0.6875rem;
            letter-spacing: 0.13em;
        }
        #inicio .landing-hero-trust-badges__icon {
            width: 1rem;
            font-size: 0.85rem;
        }
    }
    @media (min-width: 1024px) {
        #inicio .landing-hero-trust-badges {
            justify-content: space-between;
            column-gap: 1rem;
        }
    }
    @media (min-width: 1024px) and (max-height: 820px) {
        #inicio .landing-hero-trust-badges {
            margin-top: 1.5rem;
            justify-content: flex-start;
            column-gap: 1.35rem;
        }
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

    .landing-hero-trustpilot {
        display: inline-flex;
        text-decoration: none;
        color: inherit;
    }

    .landing-hero-trustpilot__pill {
        display: inline-flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 0.3rem;
        min-height: 2.5rem;
        padding: 0.45rem 0.8rem;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid rgba(196, 181, 253, 0.9);
        box-shadow: 0 4px 16px rgba(88, 28, 135, 0.1);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .landing-hero-trustpilot:hover .landing-hero-trustpilot__pill {
        border-color: rgba(147, 51, 234, 0.45);
        box-shadow: 0 8px 22px rgba(147, 51, 234, 0.14);
        transform: translateY(-1px);
    }

    .landing-hero-trustpilot__label {
        font-size: 0.6rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #64748b;
        line-height: 1;
        padding-left: 0.1rem;
    }

    .landing-hero-trustpilot__logo-wrap {
        display: flex;
        align-items: center;
        min-height: 1.35rem;
        padding: 0.1rem 0.15rem;
        border-radius: 0.35rem;
        background: #fff;
    }

    .landing-hero-trustpilot__logo {
        display: block;
        height: 1.35rem;
        width: auto;
        max-width: 7.5rem;
        object-fit: contain;
        object-position: left center;
    }

    @media (min-width: 640px) {
        .landing-hero-trustpilot__pill {
            flex-direction: row;
            align-items: center;
            gap: 0.55rem;
            padding: 0.5rem 0.95rem 0.5rem 0.75rem;
        }

        .landing-hero-trustpilot__logo {
            height: 1.5rem;
            max-width: 8.25rem;
        }
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

    /* Cuadrícula + glow: sin mask-image (evita que desaparezcan al volver arriba tras scroll) */
    .landing-hero-grid {
        top: 0;
        bottom: 0;
        background-image:
            linear-gradient(to right, rgba(148, 163, 184, 0.1) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(148, 163, 184, 0.1) 1px, transparent 1px);
        background-size: 44px 44px;
    }
    .landing-hero-glow {
        top: 0;
        bottom: 0;
        background:
            linear-gradient(90deg, rgba(168, 85, 247, 0.025) 0%, rgba(217, 70, 239, 0.015) 44%, rgba(34, 211, 238, 0.025) 100%),
            radial-gradient(ellipse 78% 62% at 88% 18%, rgba(34, 211, 238, 0.1), transparent 64%),
            radial-gradient(ellipse 78% 62% at 14% 48%, rgba(168, 85, 247, 0.085), transparent 64%),
            radial-gradient(ellipse 50% 40% at 8% 62%, rgba(147, 51, 234, 0.04), transparent 58%),
            radial-gradient(ellipse 72% 58% at 6% 94%, rgba(168, 85, 247, 0.07), transparent 62%),
            radial-gradient(ellipse 68% 54% at 94% 90%, rgba(34, 211, 238, 0.08), transparent 60%);
        background-repeat: no-repeat;
    }
    .landing-hero-fade {
        bottom: 0;
        height: 8rem;
        z-index: 2;
        background: linear-gradient(
            to bottom,
            transparent 0%,
            rgba(255, 255, 255, 0.1) 40%,
            rgba(255, 255, 255, 0.45) 75%,
            rgba(255, 255, 255, 0.88) 100%
        );
    }

    /* Velo suave de color de marca sobre el blanco */
    .landing-ambient-base {
        background:
            radial-gradient(ellipse 90% 50% at 50% -5%, rgba(99, 102, 241, 0.022), transparent 55%),
            radial-gradient(ellipse 70% 40% at 100% 20%, rgba(34, 211, 238, 0.028), transparent 50%),
            radial-gradient(ellipse 60% 35% at 0% 45%, rgba(168, 85, 247, 0.02), transparent 50%),
            radial-gradient(ellipse 65% 40% at 85% 65%, rgba(34, 211, 238, 0.02), transparent 50%),
            radial-gradient(ellipse 80% 45% at 15% 88%, rgba(192, 132, 252, 0.022), transparent 55%);
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
