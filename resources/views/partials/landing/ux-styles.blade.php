<style>
    .landing-nav-link {
        position: relative;
    }
    .landing-nav-link.is-active::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -6px;
        height: 2px;
        border-radius: 9999px;
        background: linear-gradient(90deg, #a855f7, #22d3ee);
    }
    .landing-scroll-progress {
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 0.15s ease-out;
    }
    .landing-step-pill.is-active {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.35), rgba(34, 211, 238, 0.2));
        border-color: rgba(168, 85, 247, 0.55);
        color: #fff;
        box-shadow: 0 0 20px rgba(168, 85, 247, 0.25);
    }
    .landing-how-card.is-active {
        border-color: rgba(168, 85, 247, 0.45);
        background: rgba(88, 28, 135, 0.12);
        transform: translateY(-2px);
        box-shadow: 0 0 24px rgba(168, 85, 247, 0.12);
    }
    .landing-tutorial-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.5rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(168, 85, 247, 0.25);
        background: rgba(255, 255, 255, 0.06);
        color: #e2e8f0;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }
    .landing-tutorial-btn:hover:not(:disabled) {
        background: rgba(168, 85, 247, 0.2);
        border-color: rgba(34, 211, 238, 0.35);
        color: #fff;
    }
    .landing-tutorial-btn--label {
        padding: 0 0.65rem;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .landing-tutorial-btn--accent {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.35), rgba(34, 211, 238, 0.2));
        border-color: rgba(34, 211, 238, 0.35);
    }
    .landing-tutorial-btn--accent:hover:not(:disabled) {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.5), rgba(34, 211, 238, 0.35));
    }
    .landing-tutorial-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }
    .landing-category-pill.is-active {
        background: rgba(147, 51, 234, 0.22);
        color: #e9d5ff;
        border-color: rgba(168, 85, 247, 0.45);
        box-shadow: 0 0 16px rgba(168, 85, 247, 0.2);
    }
    .landing-benefit-card:hover {
        transform: translateY(-2px);
    }
    @keyframes landing-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    .landing-float {
        animation: landing-float 5s ease-in-out infinite;
    }

    /* Planes — cyan (Emprendedor) + púrpura neón (Negocio) */
    .landing-plan-card {
        background: rgba(10, 14, 22, 0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s;
    }
    .landing-plan-card--emprendedor {
        border-color: rgba(34, 211, 238, 0.35);
        box-shadow:
            0 0 0 1px rgba(34, 211, 238, 0.12),
            0 0 28px rgba(34, 211, 238, 0.12),
            0 16px 40px rgba(0, 0, 0, 0.35);
    }
    .landing-plan-card--emprendedor:hover {
        border-color: rgba(34, 211, 238, 0.55);
        box-shadow:
            0 0 0 1px rgba(34, 211, 238, 0.2),
            0 0 36px rgba(34, 211, 238, 0.18),
            0 20px 48px rgba(0, 0, 0, 0.4);
    }
    .landing-plan-card--featured {
        padding: 2px;
        background: linear-gradient(160deg, rgba(188, 78, 216, 0.85), rgba(147, 51, 234, 0.7), rgba(34, 211, 238, 0.35));
        border: none;
        box-shadow:
            0 0 0 1px rgba(188, 78, 216, 0.25),
            0 0 40px rgba(188, 78, 216, 0.28),
            0 0 80px rgba(147, 51, 234, 0.15);
    }
    .landing-plan-card--featured:hover {
        box-shadow:
            0 0 0 1px rgba(188, 78, 216, 0.35),
            0 0 48px rgba(188, 78, 216, 0.35),
            0 0 96px rgba(147, 51, 234, 0.2);
    }
    .landing-plan-card--vip-ring {
        padding: 1px;
        background: linear-gradient(165deg, rgba(168, 85, 247, 0.28), rgba(245, 158, 11, 0.18), rgba(34, 211, 238, 0.22));
        border: none;
        box-shadow: none;
    }
    .landing-plan-card--vip-premium {
        padding: 2px;
        background: linear-gradient(155deg, rgba(251, 191, 36, 0.55), rgba(217, 70, 239, 0.45), rgba(168, 85, 247, 0.5), rgba(34, 211, 238, 0.35));
        border: none;
        box-shadow:
            0 0 0 1px rgba(251, 191, 36, 0.12),
            0 24px 48px rgba(245, 158, 11, 0.14),
            0 12px 32px rgba(168, 85, 247, 0.18);
    }
    .landing-plan-card--vip-premium:hover {
        box-shadow:
            0 0 0 1px rgba(251, 191, 36, 0.2),
            0 28px 56px rgba(245, 158, 11, 0.18),
            0 16px 40px rgba(168, 85, 247, 0.22);
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
        background: rgba(10, 12, 20, 0.96);
        border-radius: calc(1.5rem - 2px);
    }
    .landing-plan-inner--negocio {
        background: linear-gradient(165deg, rgba(28, 18, 42, 0.98) 0%, rgba(12, 14, 28, 0.97) 100%);
    }
    .landing-plan-price--emprendedor {
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .landing-plan-price--negocio {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(34, 211, 238, 0.45);
        box-shadow:
            0 0 0 1px rgba(34, 211, 238, 0.15),
            0 0 24px rgba(34, 211, 238, 0.2),
            inset 0 0 20px rgba(34, 211, 238, 0.04);
    }
    .landing-plan-check--cyan { color: #22d3ee; }
    .landing-plan-check--purple { color: #c084fc; }
    .landing-plan-title--cyan {
        color: #22d3ee;
    }
    .landing-plan-title--purple {
        background: linear-gradient(90deg, #e9d5ff, #c084fc);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .landing-plan-inner--vip {
        background: linear-gradient(165deg, rgba(35, 28, 55, 0.97) 0%, rgba(18, 16, 38, 0.95) 45%, rgba(14, 18, 40, 0.92) 100%);
        border-radius: calc(1.5rem - 3px);
    }
    .landing-plan-vip-glow {
        position: absolute;
        inset: -20% -10% auto -10%;
        height: 55%;
        background: radial-gradient(ellipse at 50% 0%, rgba(251, 191, 36, 0.18), transparent 68%);
        pointer-events: none;
    }
    .landing-plan-badge--vip-premium {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.22), rgba(168, 85, 247, 0.2));
        color: rgba(254, 243, 199, 0.95);
        border: 1px solid rgba(251, 191, 36, 0.35);
    }
    .landing-plan-btn--vip {
        background: linear-gradient(to right, rgba(180, 120, 20, 0.95), rgba(126, 34, 206, 0.9), rgba(8, 145, 178, 0.85));
        box-shadow: 0 8px 28px rgba(245, 158, 11, 0.22);
    }
    .landing-plan-btn--vip:hover {
        filter: brightness(1.1);
        box-shadow: 0 10px 32px rgba(245, 158, 11, 0.28);
    }
    .landing-plan-badge {
        background: rgba(168, 85, 247, 0.12);
        color: rgba(233, 213, 255, 0.9);
        border: 1px solid rgba(168, 85, 247, 0.22);
        box-shadow: none;
    }
    .landing-plan-badge--emprendedor {
        background: #22d3ee;
        color: #0a1628;
        border: none;
        box-shadow: 0 0 12px rgba(34, 211, 238, 0.35);
    }
    .landing-plan-badge--negocio {
        background: linear-gradient(135deg, #a855f7, #bc4ed8);
        color: #0f0618;
        border: none;
        box-shadow: 0 0 14px rgba(188, 78, 216, 0.4);
    }
    .landing-plan-badge--accent {
        background: rgba(34, 211, 238, 0.08);
        color: rgba(165, 243, 252, 0.85);
        border-color: rgba(34, 211, 238, 0.18);
    }
    .landing-plan-badge--vip {
        background: rgba(245, 158, 11, 0.1);
        color: rgba(253, 230, 138, 0.9);
        border-color: rgba(245, 158, 11, 0.2);
    }
    .landing-plan-save {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(168, 85, 247, 0.18);
        box-shadow: none;
    }
    .landing-plan-save:hover {
        background: rgba(168, 85, 247, 0.08);
        border-color: rgba(168, 85, 247, 0.28);
    }
    .landing-plan-btn {
        background: linear-gradient(90deg, #9333ea 0%, #7c3aed 40%, #06b6d4 100%);
        box-shadow: 0 6px 24px rgba(147, 51, 234, 0.35), 0 4px 16px rgba(34, 211, 238, 0.2);
    }
    .landing-plan-btn:hover {
        filter: brightness(1.1);
        box-shadow: 0 8px 28px rgba(147, 51, 234, 0.45), 0 6px 20px rgba(34, 211, 238, 0.28);
    }
    .landing-plan-btn--emprendedor {
        background: linear-gradient(90deg, #9333ea 0%, #6366f1 35%, #22d3ee 100%);
    }
    .landing-plan-btn--negocio {
        background: linear-gradient(90deg, #22d3ee 0%, #6366f1 45%, #a855f7 100%);
        box-shadow: 0 6px 28px rgba(34, 211, 238, 0.25), 0 8px 32px rgba(168, 85, 247, 0.35);
    }
    .landing-plan-btn--negocio:hover {
        box-shadow: 0 8px 32px rgba(34, 211, 238, 0.35), 0 10px 40px rgba(168, 85, 247, 0.45);
    }
    .landing-plan-ghost {
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(226, 232, 240, 0.85);
        background: transparent;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .landing-plan-ghost:hover {
        border-color: rgba(255, 255, 255, 0.22);
        color: #fff;
        background: rgba(255, 255, 255, 0.04);
    }
    .landing-plan-ghost--emprendedor:hover {
        border-color: rgba(34, 211, 238, 0.35);
    }
    .landing-plan-ghost--negocio:hover {
        border-color: rgba(168, 85, 247, 0.4);
    }
    .landing-plan-icon--negocio {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.35), rgba(34, 211, 238, 0.15));
        border: 1px solid rgba(188, 78, 216, 0.45);
        box-shadow: 0 0 20px rgba(188, 78, 216, 0.25);
    }
    .landing-plan-btn--soft {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: none;
        color: #fff;
    }
    .landing-plan-btn--soft:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(245, 158, 11, 0.25);
    }

    /* WCAG AA — texto secundario sobre fondo #0e1228 (no aplica dentro de tarjetas claras) */
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

    .wi-store-landing :where(.text-slate-500):not(:where(.bg-white *, .bg-emerald-50 *, .bg-white, .bg-emerald-50)) {
        color: #b8c5d6;
    }

    .wi-store-landing :where(.text-slate-400):not(:where(.bg-white *, .bg-emerald-50 *, .bg-white, .bg-emerald-50)) {
        color: #cbd5e1;
    }

    .wi-store-landing :where(.text-purple-400):not(:where(.bg-white *, .bg-emerald-50 *)) {
        color: #d8b4fe;
    }

    .wi-store-landing :where(.placeholder-slate-500)::placeholder {
        color: #94a3b8;
        opacity: 1;
    }
</style>
