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
        transform: translateY(-4px);
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

    /* Planes — alineados con la landing (sin neón cyan/dorado fuerte) */
    .landing-plan-card {
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: border-color 0.3s, transform 0.3s;
    }
    .landing-plan-card:hover {
        border-color: rgba(168, 85, 247, 0.22);
    }
    .landing-plan-card--featured {
        padding: 1px;
        background: linear-gradient(165deg, rgba(168, 85, 247, 0.35), rgba(217, 70, 239, 0.2), rgba(34, 211, 238, 0.28));
        border: none;
        box-shadow: none;
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
            transform: translateY(-14px) scale(1.05);
            z-index: 5;
        }
        .landing-plan-vip-elevated:hover {
            transform: translateY(-16px) scale(1.055);
        }
    }
    .landing-plan-inner {
        background: rgba(14, 18, 40, 0.88);
        border-radius: calc(1.5rem - 2px);
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
        background: linear-gradient(to right, rgba(126, 34, 206, 0.9), rgba(8, 145, 178, 0.85));
        box-shadow: 0 4px 20px rgba(88, 28, 135, 0.2);
    }
    .landing-plan-btn:hover {
        filter: brightness(1.08);
        box-shadow: 0 6px 24px rgba(88, 28, 135, 0.28);
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
</style>
