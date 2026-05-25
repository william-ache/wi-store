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
</style>
