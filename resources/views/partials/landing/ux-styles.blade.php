<style>
    /* Evita scroll horizontal por glows, SVG del roadmap y cards del hero */
    html.wi-store-ui.wi-store-landing,
    html.wi-store-ui.wi-store-landing body {
        overflow-x: clip;
        max-width: 100%;
    }

    /* Contenedor fluido: ancho máximo + márgenes laterales generosos en pantallas grandes */
    .wi-store-landing .landing-container {
        min-width: 0;
    }
    .wi-store-landing .landing-container {
        width: 100%;
        max-width: 76rem;
        margin-left: auto;
        margin-right: auto;
        padding-left: clamp(1.25rem, 4.5vw, 3rem);
        padding-right: clamp(1.25rem, 4.5vw, 3rem);
    }
    @media (min-width: 1280px) {
        .wi-store-landing .landing-container {
            padding-left: clamp(2rem, 5.5vw, 3.5rem);
            padding-right: clamp(2rem, 5.5vw, 3.5rem);
        }
    }
    @media (min-width: 1536px) {
        .wi-store-landing .landing-container {
            max-width: 72rem;
            padding-left: clamp(2.5rem, 7vw, 5rem);
            padding-right: clamp(2.5rem, 7vw, 5rem);
        }
    }

    #landing-header {
        --landing-header-h: 4rem;
    }

    #landing-header .landing-header-bar__brand {
        flex: 0 0 auto;
    }

    #landing-header .landing-header-bar {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        column-gap: 1rem;
    }

    #landing-header .landing-header-bar__brand {
        grid-column: 1;
        grid-row: 1;
    }

    #landing-header .landing-header-bar__nav {
        grid-column: 2;
        grid-row: 1;
    }

    #landing-header .landing-header-bar__actions {
        grid-column: 3;
        grid-row: 1;
        z-index: 2;
        justify-self: end;
    }

    #landing-header .landing-nav-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 2.5rem;
        padding: 0 0.125rem;
        font-size: 0.875rem;
        font-weight: 600;
        line-height: 1;
        color: #475569;
        white-space: nowrap;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    #landing-header .landing-nav-link:hover,
    #landing-header .landing-nav-link.is-active {
        color: #0f172a;
    }

    #landing-header .landing-nav-link.is-active::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0.35rem;
        height: 2px;
        border-radius: 9999px;
        background: linear-gradient(90deg, #9333ea, #06b6d4);
        pointer-events: none;
    }

    #landing-header .landing-header-action-link {
        display: none;
        align-items: center;
        height: 2.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        white-space: nowrap;
        transition: color 0.2s ease;
    }

    #landing-header .landing-header-cta {
        display: none;
    }

    @media (min-width: 768px) {
        #landing-header .landing-header-action-link,
        #landing-header .landing-header-cta {
            display: inline-flex;
        }
    }

    #landing-header .landing-header-action-link:hover {
        color: #0f172a;
    }

    #landing-header .landing-header-cta {
        align-items: center;
        justify-content: center;
        height: 2.5rem;
        padding: 0 1.25rem;
        font-size: 0.875rem;
        font-weight: 700;
        color: #fff;
        text-decoration: none;
        white-space: nowrap;
        border-radius: 9999px;
        background: linear-gradient(90deg, #9333ea, #06b6d4);
        box-shadow: 0 4px 14px rgba(147, 51, 234, 0.22);
        transition: filter 0.2s ease, transform 0.2s ease;
    }

    #landing-header .landing-header-cta:hover {
        filter: brightness(1.05);
    }

    @media (max-width: 767px) {
        #landing-header .landing-nav-link.is-active::after {
            display: none;
        }
    }
    .landing-scroll-progress-track {
        margin: 0;
        padding: 0;
    }

    .landing-scroll-progress {
        width: 0;
        max-width: 100%;
        transform: none;
        transform-origin: left center;
        transition: width 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: width;
    }
    .landing-step-pill.is-active {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.12), rgba(34, 211, 238, 0.1));
        border-color: rgba(147, 51, 234, 0.45);
        color: #6b21a8;
        box-shadow: 0 4px 16px rgba(147, 51, 234, 0.12);
    }
    .landing-how-card.is-active {
        border-color: rgba(147, 51, 234, 0.4);
        background: linear-gradient(135deg, rgba(250, 245, 255, 0.95), rgba(236, 254, 255, 0.9));
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(147, 51, 234, 0.1);
    }

    /* 3 pasos — tarjetas con mockup (estilo Zenifi) */
    .landing-how-step {
        display: flex;
        flex-direction: column;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(15, 23, 42, 0.06);
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
    }
    .landing-how-step:hover {
        border-color: rgba(147, 51, 234, 0.22);
        box-shadow: 0 14px 40px rgba(147, 51, 234, 0.1);
        transform: translateY(-2px);
    }
    .landing-how-step__visual {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 13.5rem;
        padding: 1.25rem 1rem;
    }
    .landing-how-step__visual--purple {
        background: linear-gradient(160deg, rgba(250, 245, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 45%, rgba(236, 254, 255, 0.35) 100%);
    }
    .landing-how-step__visual--cyan {
        background: linear-gradient(160deg, rgba(236, 254, 255, 0.5) 0%, rgba(255, 255, 255, 0.95) 50%, rgba(250, 245, 255, 0.4) 100%);
    }
    .landing-how-step__visual--blend {
        background: linear-gradient(160deg, rgba(250, 245, 255, 0.6) 0%, rgba(255, 255, 255, 0.95) 40%, rgba(224, 242, 254, 0.45) 100%);
    }
    .landing-how-step__body {
        padding: 1.25rem 1.35rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        text-align: left;
    }

    /* FAQ acordeón */
    .landing-faq-item {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .landing-faq-item.is-open {
        border-color: #e2e8f0;
        border-left: 3px solid #9333ea;
        box-shadow: 0 8px 28px rgba(147, 51, 234, 0.08);
    }
    .landing-faq-trigger {
        background: transparent;
        border: none;
        cursor: pointer;
    }
    .landing-faq-trigger:focus-visible {
        outline: 2px solid rgba(147, 51, 234, 0.45);
        outline-offset: 2px;
        border-radius: 0.75rem;
    }
    .landing-faq-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.75rem;
        height: 1.75rem;
        color: #9333ea;
        font-weight: 700;
    }
    .landing-faq-item.is-open .landing-faq-toggle {
        color: #0891b2;
    }
    .landing-faq-panel {
        border-top: 1px solid #f1f5f9;
        padding-top: 0.75rem;
    }

    /* Zona oscura compartida: planes, footer, etc. */
    .landing-dark-zone {
        position: relative;
        background: #0b1426;
        color: #e2e8f0;
        isolation: isolate;
        overflow-x: clip;
    }
    .landing-dark-zone::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background-image:
            linear-gradient(to right, rgba(255, 255, 255, 0.06) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
        background-size: 40px 40px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.35) 100%);
        -webkit-mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.35) 100%);
    }
    .landing-dark-zone::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            radial-gradient(ellipse 70% 50% at 15% 0%, rgba(147, 51, 234, 0.18), transparent 55%),
            radial-gradient(ellipse 55% 45% at 90% 20%, rgba(34, 211, 238, 0.12), transparent 50%),
            radial-gradient(ellipse 60% 40% at 50% 100%, rgba(147, 51, 234, 0.1), transparent 55%);
    }
    .landing-dark-zone > .landing-container,
    .landing-dark-zone > .landing-final-cta__panel,
    .landing-dark-zone .landing-container {
        position: relative;
        z-index: 1;
    }
    .landing-dark-zone .landing-billing-toggle-wrap label span,
    .landing-dark-zone .landing-billing-toggle-wrap > p:last-child {
        color: #94a3b8;
    }
    .landing-dark-zone .landing-billing-toggle-wrap > p:last-child strong {
        color: #e2e8f0;
    }
    .landing-dark-zone .landing-bcv-in-dark p {
        color: #94a3b8 !important;
    }
    .landing-dark-zone .landing-bcv-in-dark strong {
        color: #f1f5f9 !important;
    }
    .landing-footer {
        margin-top: 0;
        border-top: none;
    }

    /* CTA final — solo la tarjeta es oscura; la sección queda en blanco */
    .landing-final-cta__panel {
        background: #0b1426;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 20px 50px rgba(11, 20, 38, 0.2);
    }
    .landing-final-cta__grid {
        background-image:
            linear-gradient(to right, rgba(255, 255, 255, 0.06) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
        background-size: 40px 40px;
        mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.4) 100%);
        -webkit-mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.4) 100%);
    }
    .landing-final-cta__glow {
        background:
            radial-gradient(ellipse 70% 80% at 0% 0%, rgba(147, 51, 234, 0.22), transparent 55%),
            radial-gradient(ellipse 50% 60% at 100% 100%, rgba(34, 211, 238, 0.12), transparent 50%);
    }
    .landing-final-cta__inner {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 1.75rem;
    }
    @media (min-width: 768px) {
        .landing-final-cta__inner {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 2.5rem;
        }
    }
    .landing-final-cta__copy {
        flex: 1 1 auto;
        min-width: 0;
    }
    .landing-final-cta__actions {
        flex: 0 0 auto;
        width: 100%;
        display: flex;
        justify-content: flex-start;
    }
    @media (min-width: 768px) {
        .landing-final-cta__actions {
            width: auto;
            justify-content: flex-end;
        }
    }
    .landing-final-cta__btn {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        width: auto;
        max-width: 100%;
        flex: 0 0 auto;
        padding: 0.625rem 0.5rem 0.625rem 1.5rem;
        border-radius: 9999px;
        background: linear-gradient(90deg, #9333ea, #22d3ee);
        color: #fff;
        font-size: 0.875rem;
        font-weight: 700;
        line-height: 1.2;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 8px 24px rgba(147, 51, 234, 0.35);
        transition: filter 0.2s ease, transform 0.2s ease;
    }
    @media (min-width: 768px) {
        .landing-final-cta__btn {
            font-size: 1rem;
        }
    }
    .landing-final-cta__btn:hover {
        filter: brightness(1.08);
    }
    .landing-final-cta__btn:active {
        transform: scale(0.98);
    }
    .landing-final-cta__btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        flex-shrink: 0;
        border-radius: 9999px;
        background: #0f172a;
    }
    .landing-final-cta__btn-icon i {
        font-size: 0.625rem;
        color: #fff;
    }
    .landing-tutorial-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.5rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(147, 51, 234, 0.2);
        background: #fff;
        color: #475569;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }
    .landing-tutorial-btn:hover:not(:disabled) {
        background: rgba(147, 51, 234, 0.08);
        border-color: rgba(6, 182, 212, 0.35);
        color: #6b21a8;
    }
    .landing-tutorial-btn--label {
        padding: 0 0.65rem;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .landing-tutorial-btn--accent {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.12), rgba(34, 211, 238, 0.1));
        border-color: rgba(6, 182, 212, 0.35);
        color: #6b21a8;
    }
    .landing-tutorial-btn--accent:hover:not(:disabled) {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.18), rgba(34, 211, 238, 0.14));
    }
    .landing-tutorial-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }
    .landing-category-pill.is-active {
        background: rgba(147, 51, 234, 0.1);
        color: #6b21a8;
        border-color: rgba(147, 51, 234, 0.4);
        box-shadow: 0 4px 14px rgba(147, 51, 234, 0.12);
    }
    .landing-benefit-card:hover {
        transform: translateY(-2px);
    }

    /* Planes — tarjetas claras con acentos cyan y púrpura */
    .landing-plan-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
        transition: border-color 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s cubic-bezier(0.22, 1, 0.36, 1), transform 0.45s cubic-bezier(0.34, 1.2, 0.64, 1);
    }
    .landing-plan-card--emprendedor {
        border-color: rgba(6, 182, 212, 0.35);
        box-shadow:
            0 0 0 1px rgba(6, 182, 212, 0.08),
            0 8px 32px rgba(6, 182, 212, 0.1),
            0 4px 16px rgba(15, 23, 42, 0.04);
    }
    .landing-plan-card--emprendedor:hover {
        border-color: rgba(6, 182, 212, 0.55);
        box-shadow:
            0 0 0 1px rgba(6, 182, 212, 0.12),
            0 12px 40px rgba(6, 182, 212, 0.14),
            0 6px 20px rgba(15, 23, 42, 0.06);
    }
    .landing-plan-card--featured {
        padding: 2px;
        background: linear-gradient(160deg, #c084fc, #9333ea, #06b6d4);
        border: none;
        box-shadow:
            0 0 0 1px rgba(147, 51, 234, 0.1),
            0 12px 40px rgba(147, 51, 234, 0.18),
            0 4px 16px rgba(15, 23, 42, 0.06);
    }
    .landing-plan-card--featured:hover {
        box-shadow:
            0 0 0 1px rgba(147, 51, 234, 0.15),
            0 16px 48px rgba(147, 51, 234, 0.22),
            0 6px 20px rgba(15, 23, 42, 0.08);
    }
    .landing-plan-card--vip-ring {
        padding: 1px;
        background: linear-gradient(165deg, rgba(168, 85, 247, 0.4), rgba(245, 158, 11, 0.25), rgba(34, 211, 238, 0.35));
        border: none;
        box-shadow: none;
    }
    .landing-plan-card--vip-premium {
        padding: 2px;
        background: linear-gradient(155deg, #fbbf24, #d946ef, #9333ea, #06b6d4);
        border: none;
        box-shadow:
            0 0 0 1px rgba(251, 191, 36, 0.15),
            0 16px 40px rgba(245, 158, 11, 0.12),
            0 8px 24px rgba(147, 51, 234, 0.12);
    }
    .landing-plan-card--vip-premium:hover {
        box-shadow:
            0 0 0 1px rgba(251, 191, 36, 0.2),
            0 20px 48px rgba(245, 158, 11, 0.16),
            0 10px 32px rgba(147, 51, 234, 0.16);
    }
    @media (min-width: 768px) {
        .landing-plan-vip-elevated {
            transform: scale(1.02);
            z-index: 5;
        }
        .landing-plan-vip-elevated:hover {
            transform: scale(1.03);
        }
    }
    .landing-plan-inner {
        background: #ffffff;
        border-radius: calc(1.5rem - 2px);
    }
    .landing-plan-inner--negocio {
        background: linear-gradient(165deg, #faf5ff 0%, #ffffff 55%, #ecfeff 100%);
    }
    .landing-plan-price--emprendedor {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .landing-plan-price--negocio {
        background: linear-gradient(135deg, #f0fdfa, #faf5ff);
        border: 1px solid rgba(6, 182, 212, 0.35);
        box-shadow: 0 4px 16px rgba(6, 182, 212, 0.08);
    }
    .landing-plan-check--cyan { color: #0891b2; }
    .landing-plan-check--purple { color: #9333ea; }
    .landing-plan-title--cyan {
        color: #0891b2;
    }
    .landing-plan-title--purple {
        background: linear-gradient(90deg, #7c3aed, #9333ea);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .landing-plan-inner--vip {
        background: linear-gradient(165deg, #fffbeb 0%, #faf5ff 45%, #ffffff 100%);
        border-radius: calc(1.5rem - 3px);
    }
    .landing-plan-vip-glow {
        position: absolute;
        inset: -20% -10% auto -10%;
        height: 55%;
        background: radial-gradient(ellipse at 50% 0%, rgba(251, 191, 36, 0.12), transparent 68%);
        pointer-events: none;
    }
    .landing-plan-badge--vip-premium {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(168, 85, 247, 0.15));
        color: #92400e;
        border: 1px solid rgba(251, 191, 36, 0.4);
    }
    .landing-plan-btn--vip {
        background: linear-gradient(to right, #d97706, #9333ea, #0891b2);
        box-shadow: 0 8px 24px rgba(147, 51, 234, 0.2);
    }
    .landing-plan-btn--vip:hover {
        filter: brightness(1.05);
        box-shadow: 0 10px 28px rgba(147, 51, 234, 0.28);
    }
    .landing-plan-badge {
        background: rgba(147, 51, 234, 0.1);
        color: #6b21a8;
        border: 1px solid rgba(147, 51, 234, 0.25);
        box-shadow: none;
    }
    .landing-plan-badge--emprendedor {
        background: #06b6d4;
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
    }
    .landing-plan-badge--negocio {
        background: linear-gradient(135deg, #9333ea, #a855f7);
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 14px rgba(147, 51, 234, 0.3);
    }
    .landing-plan-badge--accent {
        background: rgba(6, 182, 212, 0.1);
        color: #0e7490;
        border-color: rgba(6, 182, 212, 0.25);
    }
    .landing-plan-badge--vip {
        background: rgba(245, 158, 11, 0.12);
        color: #b45309;
        border-color: rgba(245, 158, 11, 0.3);
    }
    .landing-plan-save {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        box-shadow: none;
    }
    .landing-plan-save:hover {
        background: rgba(147, 51, 234, 0.06);
        border-color: rgba(147, 51, 234, 0.25);
    }
    .landing-plan-btn {
        background: linear-gradient(90deg, #9333ea 0%, #7c3aed 40%, #06b6d4 100%);
        box-shadow: 0 6px 20px rgba(147, 51, 234, 0.25), 0 4px 12px rgba(6, 182, 212, 0.15);
    }
    .landing-plan-btn:hover {
        filter: brightness(1.05);
        box-shadow: 0 8px 24px rgba(147, 51, 234, 0.32), 0 6px 16px rgba(6, 182, 212, 0.2);
    }
    .landing-plan-btn--emprendedor {
        background: linear-gradient(90deg, #9333ea 0%, #6366f1 35%, #06b6d4 100%);
    }
    .landing-plan-btn--negocio {
        background: linear-gradient(90deg, #06b6d4 0%, #6366f1 45%, #9333ea 100%);
        box-shadow: 0 6px 24px rgba(6, 182, 212, 0.2), 0 8px 28px rgba(147, 51, 234, 0.25);
    }
    .landing-plan-btn--negocio:hover {
        box-shadow: 0 8px 28px rgba(6, 182, 212, 0.28), 0 10px 36px rgba(147, 51, 234, 0.32);
    }
    .landing-plan-ghost {
        border: 1px solid #e2e8f0;
        color: #475569;
        background: transparent;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .landing-plan-ghost:hover {
        border-color: #cbd5e1;
        color: #1e293b;
        background: #f8fafc;
    }
    .landing-plan-ghost--emprendedor:hover {
        border-color: rgba(6, 182, 212, 0.45);
        color: #0e7490;
    }
    .landing-plan-ghost--negocio:hover {
        border-color: rgba(147, 51, 234, 0.4);
        color: #6b21a8;
    }
    .landing-plan-icon--negocio {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.15), rgba(34, 211, 238, 0.1));
        border: 1px solid rgba(147, 51, 234, 0.3);
        box-shadow: 0 4px 16px rgba(147, 51, 234, 0.12);
    }
    .landing-plan-btn--soft {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        box-shadow: none;
        color: #334155;
    }
    .landing-plan-btn--soft:hover {
        background: #e2e8f0;
        border-color: rgba(245, 158, 11, 0.35);
    }

    /* Por qué WI-Store — badges + categorías */
    .landing-why-card__badge {
        position: absolute;
        right: 0.85rem;
        bottom: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.4rem;
        border-radius: 9999px;
        border: 2px solid #fff;
        background: linear-gradient(to bottom right, #9333ea, #d946ef, #06b6d4);
        color: #fff;
        font-size: 0.6rem;
        font-weight: 800;
        line-height: 1;
        box-shadow: 0 2px 10px rgba(168, 85, 247, 0.35);
        z-index: 2;
    }
    .landing-why-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 4.5rem;
        height: 4.5rem;
        border-radius: 1.15rem;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }
    .landing-why-icon i {
        font-size: 1.65rem;
    }
    .landing-why-icon--purple {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.14), rgba(99, 102, 241, 0.1));
        color: #7c3aed;
    }
    .landing-why-icon--orange {
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.16), rgba(251, 191, 36, 0.12));
        color: #ea580c;
    }
    .landing-why-icon--amber {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18), rgba(234, 179, 8, 0.12));
        color: #d97706;
    }
    .landing-why-icon--cyan {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.16), rgba(34, 211, 238, 0.1));
        color: #0891b2;
    }
    .landing-why-icon--emerald {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.16), rgba(52, 211, 153, 0.1));
        color: #059669;
    }
    .landing-why-icon--pink {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.16), rgba(244, 114, 182, 0.12));
        color: #db2777;
    }
    .landing-why-icon--indigo {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.16), rgba(129, 140, 248, 0.12));
        color: #4f46e5;
    }
    .landing-why-icon--slate {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.14), rgba(148, 163, 184, 0.1));
        color: #475569;
    }
    .landing-why-icon--sm {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
    }
    .landing-why-icon--sm i {
        font-size: 1.05rem;
    }
    .landing-why-icons-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.55rem;
        width: 100%;
        max-width: 11rem;
        margin-inline: auto;
    }

    /* Por qué WI-Store — grid 3 columnas, alturas uniformes */
    .landing-why-grid {
        align-items: stretch;
    }
    .landing-why-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.04);
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .landing-why-card:hover {
        border-color: rgba(147, 51, 234, 0.25);
        box-shadow: 0 12px 32px rgba(147, 51, 234, 0.08);
    }
    .landing-why-card__visual {
        position: relative;
        flex: 0 0 13.25rem;
        height: 13.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem 1.35rem;
        box-sizing: border-box;
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .landing-why-card__scene {
        position: relative;
        width: 100%;
        max-width: 15.5rem;
        height: 8.75rem;
        margin-inline: auto;
        flex-shrink: 0;
    }
    .landing-why-mock {
        width: 100%;
        max-width: 17.5rem;
        margin-inline: auto;
        border-radius: 0.75rem;
        background: #fff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
        padding: 0.85rem 1rem;
        box-sizing: border-box;
    }
    .landing-why-mock--flow {
        min-height: 8.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .landing-why-mock--chart {
        min-height: 8.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .landing-why-mock--panel {
        min-height: 8.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .landing-why-card__body {
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        min-height: 8.75rem;
        padding: 1.25rem 1.35rem 1.5rem;
        background: #f8fafc;
        box-sizing: border-box;
    }
    .landing-why-card__body > p {
        flex: 1 1 auto;
        margin-bottom: 0;
    }
    @media (min-width: 768px) {
        .landing-why-card__visual {
            flex-basis: 14rem;
            height: 14rem;
        }
        .landing-why-card__body {
            min-height: 9rem;
        }
    }
    .landing-why-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.65rem;
        font-size: 10px;
        font-weight: 700;
        color: #334155;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        white-space: nowrap;
    }
    .landing-why-stat {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        padding: 0.75rem;
        border-radius: 0.75rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        text-align: left;
    }
    .landing-why-stat--active {
        border-color: rgba(147, 51, 234, 0.45);
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.08), rgba(34, 211, 238, 0.06));
        box-shadow: 0 0 0 1px rgba(147, 51, 234, 0.12);
    }

    /* Tarjetas de tienda (landing) */
    .landing-shop-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s;
    }
    .landing-shop-card:hover {
        border-color: rgba(147, 51, 234, 0.35);
        box-shadow: 0 12px 32px rgba(147, 51, 234, 0.1);
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .wi-store-landing :where(.text-slate-500):not(:where(.landing-plan-card *, .landing-plan-inner *)) {
        color: #64748b;
    }

    .wi-store-landing :where(.placeholder-slate-500)::placeholder {
        color: #94a3b8;
        opacity: 1;
    }
</style>
