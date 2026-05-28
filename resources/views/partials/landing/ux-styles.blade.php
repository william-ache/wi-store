<style>
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

    /* Por qué WI-Store — grid 2×2 */
    .landing-why-card {
        display: flex;
        flex-direction: column;
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
        min-height: 11rem;
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    .landing-why-card__body {
        padding: 1.25rem 1.35rem 1.5rem;
        background: #f8fafc;
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
