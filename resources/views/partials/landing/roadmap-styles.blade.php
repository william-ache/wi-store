<style>
    .roadmap-scene {
        position: relative;
        overflow: hidden;
        max-width: 100%;
    }

    .roadmap-path-wrap {
        position: relative;
        width: 100%;
        max-width: 100%;
        aspect-ratio: 16 / 14;
        min-height: 34rem;
        max-height: 48rem;
        transform: rotateX(1.5deg);
        transform-origin: center center;
        overflow: hidden;
    }

    .roadmap-path-svg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 6;
    }

    .roadmap-path-glow {
        fill: none;
        stroke: url(#roadmapPathGradient);
        stroke-width: 22;
        stroke-linecap: round;
        stroke-linejoin: round;
        filter: url(#roadmapPathBlur);
        opacity: 0.52;
        animation: roadmap-path-pulse 3s ease-in-out infinite;
    }

    .roadmap-path-core {
        fill: none;
        stroke: url(#roadmapPathGradient);
        stroke-width: 7;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 8 12;
        animation: roadmap-path-dash 5s linear infinite;
    }

    .roadmap-milestone {
        position: absolute;
        width: min(100%, 15.5rem);
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        animation: roadmap-float 5s ease-in-out infinite;
    }

    .roadmap-milestone--1 { left: 1%; top: 0; animation-delay: 0s; }
    .roadmap-milestone--2 { left: 38%; top: 20%; animation-delay: -1.1s; }
    .roadmap-milestone--3 { left: 0; top: 46%; animation-delay: -2.2s; }
    .roadmap-milestone--4 { right: 2%; top: 34%; animation-delay: -0.5s; }
    .roadmap-milestone--5 { right: 0; top: 68%; animation-delay: -1.8s; }

    @media (min-width: 1280px) {
        .roadmap-milestone {
            width: min(100%, 17rem);
        }

        .roadmap-milestone--2 { left: 40%; top: 22%; }
        .roadmap-milestone--3 { top: 48%; }
        .roadmap-milestone--4 { top: 36%; }
        .roadmap-milestone--5 { top: 70%; }
    }

    /* Tarjeta glass */
    .roadmap-card {
        position: relative;
        width: 100%;
        border-radius: 0.85rem;
        padding: 2px;
        overflow: hidden;
    }

    .roadmap-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 2px;
        background-size: 300% 100%;
        animation: roadmap-border-flow 4s linear infinite;
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    .roadmap-card--purple::before {
        background-image: linear-gradient(90deg, #7c3aed, #a855f7, #c084fc, #7c3aed);
    }

    .roadmap-card--cyan::before {
        background-image: linear-gradient(90deg, #0891b2, #22d3ee, #67e8f9, #0891b2);
        animation-duration: 3.5s;
    }

    .roadmap-card--indigo::before {
        background-image: linear-gradient(90deg, #4338ca, #6366f1, #818cf8, #4338ca);
        animation-duration: 3.9s;
    }

    .roadmap-card--pink::before {
        background-image: linear-gradient(90deg, #db2777, #e879f9, #f472b6, #db2777);
        animation-duration: 4.2s;
    }

    .roadmap-card--yellow::before {
        background-image: linear-gradient(90deg, #ca8a04, #facc15, #fde047, #ca8a04);
        animation-duration: 3.8s;
    }

    .roadmap-card__inner {
        position: relative;
        border-radius: calc(0.85rem - 2px);
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 0.95rem 1.05rem;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.9),
            0 4px 24px rgba(15, 23, 42, 0.08);
    }

    .roadmap-card--purple .roadmap-card__inner {
        box-shadow:
            inset 0 1px 0 rgba(167, 139, 250, 0.2),
            0 4px 24px rgba(124, 58, 237, 0.1);
    }

    .roadmap-card--cyan .roadmap-card__inner {
        box-shadow:
            inset 0 1px 0 rgba(34, 211, 238, 0.2),
            0 4px 24px rgba(6, 182, 212, 0.1);
    }

    .roadmap-card--indigo .roadmap-card__inner {
        box-shadow:
            inset 0 1px 0 rgba(129, 140, 248, 0.2),
            0 4px 24px rgba(99, 102, 241, 0.1);
    }

    .roadmap-card--pink .roadmap-card__inner {
        box-shadow:
            inset 0 1px 0 rgba(232, 121, 249, 0.2),
            0 4px 24px rgba(217, 70, 239, 0.1);
    }

    .roadmap-card--yellow .roadmap-card__inner {
        box-shadow:
            inset 0 1px 0 rgba(250, 204, 21, 0.25),
            0 4px 24px rgba(202, 138, 4, 0.1);
    }

    .roadmap-milestone--5 .roadmap-card {
        z-index: 11;
    }

    .roadmap-card__badge-icon {
        width: 1.85rem;
        height: 1.85rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
        margin-bottom: 0.55rem;
    }

    .roadmap-card--purple .roadmap-card__badge-icon {
        background: rgba(124, 58, 237, 0.12);
        border: 1px solid rgba(124, 58, 237, 0.3);
        color: #7c3aed;
    }

    .roadmap-card--cyan .roadmap-card__badge-icon {
        background: rgba(8, 145, 178, 0.12);
        border: 1px solid rgba(8, 145, 178, 0.3);
        color: #0891b2;
    }

    .roadmap-card--indigo .roadmap-card__badge-icon {
        background: rgba(67, 56, 202, 0.12);
        border: 1px solid rgba(67, 56, 202, 0.3);
        color: #4f46e5;
    }

    .roadmap-card--pink .roadmap-card__badge-icon {
        background: rgba(190, 24, 93, 0.1);
        border: 1px solid rgba(190, 24, 93, 0.3);
        color: #db2777;
    }

    .roadmap-card--yellow .roadmap-card__badge-icon {
        background: rgba(161, 98, 7, 0.12);
        border: 1px solid rgba(202, 138, 4, 0.35);
        color: #ca8a04;
    }

    .roadmap-tag {
        font-size: 8px;
        font-weight: 900;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0.22rem 0.45rem;
        border-radius: 9999px;
        border: 1px solid;
    }

    .roadmap-status {
        font-size: 8px;
        font-weight: 900;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .roadmap-extra-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 0.22rem 0.45rem;
        border-radius: 0.375rem;
        border-width: 1px;
        border-style: solid;
    }

    .roadmap-title {
        font-size: 1rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.25;
        margin-top: 0.4rem;
    }

    .roadmap-desc {
        font-size: 11px;
        line-height: 1.55;
        color: #475569;
        margin-top: 0.4rem;
    }

    /* Base isométrica + icono holográfico */
    .roadmap-holo {
        --rm-accent: #a855f7;
        --rm-accent-soft: rgba(168, 85, 247, 0.45);
        --rm-glow: rgba(168, 85, 247, 0.55);
        position: relative;
        width: 5.75rem;
        height: 5.25rem;
        margin-top: 0.5rem;
        flex-shrink: 0;
        animation: roadmap-float 4.5s ease-in-out infinite;
    }

    .roadmap-holo--purple { --rm-accent: #a855f7; --rm-accent-soft: rgba(168, 85, 247, 0.5); --rm-glow: rgba(168, 85, 247, 0.6); }
    .roadmap-holo--cyan { --rm-accent: #22d3ee; --rm-accent-soft: rgba(34, 211, 238, 0.45); --rm-glow: rgba(34, 211, 238, 0.55); animation-delay: -1s; }
    .roadmap-holo--indigo { --rm-accent: #818cf8; --rm-accent-soft: rgba(129, 140, 248, 0.45); --rm-glow: rgba(99, 102, 241, 0.55); animation-delay: -1.5s; }
    .roadmap-holo--pink { --rm-accent: #e879f9; --rm-accent-soft: rgba(232, 121, 249, 0.45); --rm-glow: rgba(232, 121, 249, 0.55); animation-delay: -2s; }
    .roadmap-holo--yellow { --rm-accent: #facc15; --rm-accent-soft: rgba(250, 204, 21, 0.4); --rm-glow: rgba(250, 204, 21, 0.5); animation-delay: -0.5s; }

    .roadmap-holo__platform {
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 4.35rem;
        height: 4.35rem;
        margin-left: -2.175rem;
        border-radius: 1.15rem;
        background: linear-gradient(155deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.02) 55%, rgba(255, 255, 255, 0.01) 100%);
        transform: rotateX(62deg) rotateZ(45deg);
        transform-style: preserve-3d;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.1),
            0 0 22px var(--rm-glow),
            0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .roadmap-holo__platform::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        border: 2px solid transparent;
        border-top-color: var(--rm-accent);
        border-left-color: var(--rm-accent-soft);
        box-shadow: inset 0 0 12px var(--rm-accent-soft);
        animation: roadmap-edge-pulse 2.8s ease-in-out infinite;
    }

    .roadmap-holo__platform::after {
        content: '';
        position: absolute;
        inset: 0.45rem;
        border-radius: 0.75rem;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.04), transparent);
        opacity: 0.6;
    }

    .roadmap-holo__icon {
        position: absolute;
        left: 50%;
        bottom: 1.55rem;
        transform: translateX(-50%);
        font-size: 1.75rem;
        color: var(--rm-accent);
        text-shadow:
            0 0 12px var(--rm-glow),
            0 0 24px var(--rm-glow),
            0 3px 6px rgba(0, 0, 0, 0.6);
        filter: drop-shadow(0 0 8px var(--rm-glow));
        animation: roadmap-icon-holo 3.2s ease-in-out infinite;
    }

    .roadmap-holo__icon i {
        display: block;
        transform: translateZ(0);
    }

    .roadmap-mobile {
        display: none;
    }

    .roadmap-desktop {
        display: block;
    }

    @keyframes roadmap-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @keyframes roadmap-border-flow {
        0% { background-position: 0% 50%; }
        100% { background-position: 300% 50%; }
    }

    @keyframes roadmap-path-dash {
        0% { stroke-dashoffset: 0; }
        100% { stroke-dashoffset: -96; }
    }

    @keyframes roadmap-path-pulse {
        0%, 100% { opacity: 0.4; }
        50% { opacity: 0.65; }
    }

    @keyframes roadmap-icon-holo {
        0%, 100% { transform: translateX(-50%) translateY(0) scale(1); }
        50% { transform: translateX(-50%) translateY(-6px) scale(1.05); }
    }

    @keyframes roadmap-edge-pulse {
        0%, 100% { opacity: 0.75; filter: brightness(1); }
        50% { opacity: 1; filter: brightness(1.2); }
    }

    @media (max-width: 1023px) {
        .roadmap-desktop {
            display: none;
        }

        .roadmap-mobile {
            display: block;
        }

        .roadmap-mobile-wave {
            position: relative;
        }

        .roadmap-mobile-svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .roadmap-mobile-path-glow {
            fill: none;
            stroke: url(#roadmapMobileGradient);
            stroke-width: 5.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter: url(#roadmapMobileBlur);
            opacity: 0.55;
            animation: roadmap-path-pulse 3s ease-in-out infinite;
        }

        .roadmap-mobile-path-core {
            fill: none;
            stroke: url(#roadmapMobileGradient);
            stroke-width: 1.75;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 3 4;
            animation: roadmap-path-dash 10s linear infinite;
        }

        .roadmap-mobile-steps {
            position: relative;
            z-index: 2;
            padding: 0.15rem 0 0.25rem;
        }

        .roadmap-mobile-step {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 4.5rem minmax(0, 1fr);
            align-items: center;
            gap: 0.25rem;
            min-height: 7.5rem;
            margin-bottom: 0.1rem;
        }

        .roadmap-mobile-step__node {
            grid-column: 2;
            grid-row: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 3;
        }

        .roadmap-mobile-step__spacer {
            grid-row: 1;
        }

        .roadmap-mobile-step--left .roadmap-mobile-step__card {
            grid-column: 1;
            grid-row: 1;
        }

        .roadmap-mobile-step--left .roadmap-mobile-step__spacer {
            grid-column: 3;
        }

        .roadmap-mobile-step--right .roadmap-mobile-step__card {
            grid-column: 3;
            grid-row: 1;
        }

        .roadmap-mobile-step--right .roadmap-mobile-step__spacer {
            grid-column: 1;
        }

        .roadmap-mobile .roadmap-card {
            width: 100%;
        }

        .roadmap-mobile .roadmap-holo {
            width: 3.65rem;
            height: 3.35rem;
            margin-top: 0;
        }

        .roadmap-mobile .roadmap-holo__platform {
            width: 2.85rem;
            height: 2.85rem;
            margin-left: -1.425rem;
        }

        .roadmap-mobile .roadmap-holo__icon {
            font-size: 1.2rem;
            bottom: 1.05rem;
        }
    }

    @media (min-width: 1024px) {
        .roadmap-milestone--2 {
            animation: roadmap-float-alt 5.5s ease-in-out infinite;
            animation-delay: -1.4s;
        }
    }

    @keyframes roadmap-float-alt {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
