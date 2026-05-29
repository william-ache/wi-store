    /* Planes — tarjetas claras con acentos cyan y púrpura */
    .landing-plan-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
    }
    .landing-plan-card--no-hover-lift:hover {
        transition: none !important;
        will-change: auto;
    }
    .landing-plan-card--no-hover-lift:hover {
        transform: none !important;
    }
    .landing-plan-card--emprendedor {
        border-color: rgba(6, 182, 212, 0.28);
        box-shadow:
            0 0 0 1px rgba(6, 182, 212, 0.06),
            0 6px 24px rgba(6, 182, 212, 0.08),
            0 2px 12px rgba(15, 23, 42, 0.04);
    }
    .landing-plan-card--emprendedor.landing-plan-card--no-hover-lift:hover {
        border-color: rgba(6, 182, 212, 0.35);
        box-shadow:
            0 0 0 1px rgba(6, 182, 212, 0.08),
            0 8px 32px rgba(6, 182, 212, 0.1),
            0 4px 16px rgba(15, 23, 42, 0.04);
    }
    .landing-plan-card--featured {
        padding: 2px;
        overflow: visible;
        background: linear-gradient(160deg, #c084fc, #9333ea, #06b6d4);
        border: none;
        box-shadow:
            0 0 0 1px rgba(147, 51, 234, 0.1),
            0 12px 40px rgba(147, 51, 234, 0.18),
            0 4px 16px rgba(15, 23, 42, 0.06);
    }
    .landing-plan-card--negocio-spotlight {
        position: relative;
        z-index: 2;
        padding: 3px;
        background: linear-gradient(155deg, #e879f9 0%, #a855f7 28%, #7c3aed 52%, #06b6d4 100%);
        box-shadow:
            0 0 0 1px rgba(168, 85, 247, 0.25),
            0 0 40px rgba(147, 51, 234, 0.35),
            0 0 72px rgba(34, 211, 238, 0.12),
            0 24px 56px rgba(124, 58, 237, 0.28);
    }
    .landing-plan-card--negocio-spotlight::before {
        content: '';
        position: absolute;
        inset: -10px;
        z-index: -1;
        border-radius: inherit;
        background: linear-gradient(160deg, rgba(168, 85, 247, 0.45), rgba(34, 211, 238, 0.2));
        filter: blur(22px);
        opacity: 0.55;
        pointer-events: none;
    }
    .landing-plan-card--featured.landing-plan-card--no-hover-lift:hover,
    .landing-plan-card--negocio-spotlight.landing-plan-card--no-hover-lift:hover {
        box-shadow:
            0 0 0 1px rgba(168, 85, 247, 0.25),
            0 0 40px rgba(147, 51, 234, 0.35),
            0 0 72px rgba(34, 211, 238, 0.12),
            0 24px 56px rgba(124, 58, 237, 0.28);
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
    .landing-pricing-grid {
        --landing-plan-recommended-bar-h: 2.75rem;
        --landing-plan-negocio-frame-pad: 3px;
        --landing-plan-footer-note-h: 2.75rem;
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-top: 0.25rem;
        padding-bottom: 0.5rem;
    }
    .landing-pricing-grid__col {
        display: flex;
        flex-direction: column;
        min-height: 0;
    }
    .landing-pricing-grid__offset {
        display: none;
    }
    .landing-plan-card__main {
        flex: 1 1 auto;
        min-height: 0;
    }
    .landing-plan-card-footer {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .landing-plan-card-footer__spacer {
        min-height: var(--landing-plan-footer-note-h);
    }
    @media (min-width: 768px) {
        .landing-pricing-grid {
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: stretch;
        }
        .landing-pricing-grid__offset {
            display: block;
            flex-shrink: 0;
            height: calc(var(--landing-plan-negocio-frame-pad) + var(--landing-plan-recommended-bar-h));
        }
        .landing-pricing-grid__col--standard .landing-plan-card,
        .landing-pricing-grid__col--premium .landing-plan-card {
            flex: 1 1 auto;
        }
        .landing-plan-card--negocio-spotlight::before {
            inset: -6px;
            opacity: 0.45;
        }
    }
    .landing-plan-inner {
        background: #ffffff;
        border-radius: calc(1.5rem - 2px);
    }
    .landing-plan-inner--negocio {
        background: linear-gradient(165deg, #f5f3ff 0%, #ffffff 48%, #ecfeff 100%);
        overflow: hidden;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }
    .landing-plan-recommended-bar {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: var(--landing-plan-recommended-bar-h, 2.75rem);
        min-height: var(--landing-plan-recommended-bar-h, 2.75rem);
        padding: 0 1rem;
        box-sizing: border-box;
        background: linear-gradient(90deg, #6d28d9 0%, #9333ea 40%, #7c3aed 70%, #0891b2 100%);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 6px 20px rgba(109, 40, 217, 0.35);
    }
    .landing-plan-negocio-body {
        flex: 1 1 auto;
        min-width: 0;
    }
    .landing-plan-trial-floating {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.38rem 0.65rem;
        border-radius: 9999px;
        border: 1px solid rgba(6, 182, 212, 0.35);
        background: rgba(236, 254, 255, 0.95);
        color: #0e7490;
        font-size: 0.54rem;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        line-height: 1;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.12);
    }
    .landing-plan-trial-floating i {
        font-size: 0.58rem;
    }
    @media (min-width: 768px) {
        .landing-plan-trial-floating {
            font-size: 0.58rem;
        }
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
    .landing-plan-badge--current {
        background: linear-gradient(135deg, #9333ea, #7c3aed);
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 14px rgba(147, 51, 234, 0.35);
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
        transition: filter 0.2s ease, opacity 0.2s ease;
    }
    .landing-plan-btn:hover {
        filter: brightness(1.05);
    }
    .landing-plan-btn--emprendedor {
        background: linear-gradient(90deg, #9333ea 0%, #6366f1 35%, #06b6d4 100%);
    }
    .landing-plan-btn--negocio {
        background: linear-gradient(90deg, #06b6d4 0%, #6366f1 45%, #9333ea 100%);
        box-shadow: 0 8px 28px rgba(6, 182, 212, 0.28), 0 10px 32px rgba(147, 51, 234, 0.32);
    }
    .landing-plan-btn--negocio:hover {
        filter: brightness(1.05);
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
        cursor: not-allowed;
    }
    .landing-plan-btn--soft:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
        filter: none;
    }
