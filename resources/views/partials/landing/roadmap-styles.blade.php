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
        aspect-ratio: 16 / 11;
        min-height: 28rem;
        max-height: 42rem;
        transform: rotateX(1.5deg);
        transform-origin: center center;
        overflow: hidden;
    }

    @media (min-width: 1024px) {
        .roadmap-path-wrap {
            aspect-ratio: 16 / 10;
            min-height: 32rem;
            max-height: 46rem;
        }
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
        z-index: 10;
        animation: roadmap-float 5s ease-in-out infinite;
    }

    .roadmap-milestone__layout {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.2rem;
        width: 100%;
        max-width: 12.75rem;
    }

    .roadmap-milestone__layout .roadmap-card {
        width: 100%;
    }

    .roadmap-milestone--1 {
        left: 2%;
        top: 1%;
        width: 12.75rem;
        animation-delay: 0s;
    }

    .roadmap-milestone--2 {
        left: 34%;
        top: 11%;
        width: 12.75rem;
        animation-delay: -1.1s;
    }

    .roadmap-milestone--3 {
        left: 2%;
        top: 39%;
        width: 12.75rem;
        animation-delay: -2.2s;
    }

    .roadmap-milestone--4 {
        right: 2%;
        top: 26%;
        width: 12.75rem;
        animation-delay: -0.5s;
    }

    .roadmap-milestone--5 {
        right: 2%;
        top: 56%;
        width: 13.25rem;
        animation-delay: -1.8s;
    }

    .roadmap-milestone--5 .roadmap-milestone__layout {
        max-width: 13.25rem;
    }

    @media (min-width: 1280px) {
        .roadmap-milestone--1 { left: 4%; top: 0; }
        .roadmap-milestone--2 { left: 36%; top: 9%; }
        .roadmap-milestone--3 { left: 4%; top: 37%; }
        .roadmap-milestone--4 { right: 4%; top: 24%; }
        .roadmap-milestone--5 { right: 4%; top: 54%; }
    }

    /* Tarjeta glass — bloque compacto casi cuadrado */
    .roadmap-card {
        position: relative;
        width: 100%;
        border-radius: 0.75rem;
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
        border-radius: calc(0.75rem - 2px);
        background: rgba(15, 23, 42, 0.42);
        backdrop-filter: blur(16px) saturate(1.15);
        -webkit-backdrop-filter: blur(16px) saturate(1.15);
        border: 1px solid rgba(148, 163, 184, 0.14);
        padding: 0.7rem 0.75rem;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.06),
            0 6px 20px rgba(2, 6, 23, 0.35);
    }

    .roadmap-card__meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.3rem 0.4rem;
        margin-top: 0.45rem;
    }

    .roadmap-card__extras {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        margin-top: 0.45rem;
    }

    .roadmap-card--purple .roadmap-card__inner {
        background: linear-gradient(145deg, rgba(124, 58, 237, 0.18), rgba(15, 23, 42, 0.5));
        border-color: rgba(167, 139, 250, 0.28);
        box-shadow:
            inset 0 1px 0 rgba(196, 181, 253, 0.12),
            0 8px 28px rgba(124, 58, 237, 0.15);
    }

    .roadmap-card--cyan .roadmap-card__inner {
        background: linear-gradient(145deg, rgba(8, 145, 178, 0.16), rgba(15, 23, 42, 0.5));
        border-color: rgba(34, 211, 238, 0.26);
        box-shadow:
            inset 0 1px 0 rgba(103, 232, 249, 0.1),
            0 8px 28px rgba(6, 182, 212, 0.14);
    }

    .roadmap-card--indigo .roadmap-card__inner {
        background: linear-gradient(145deg, rgba(67, 56, 202, 0.18), rgba(15, 23, 42, 0.5));
        border-color: rgba(129, 140, 248, 0.28);
        box-shadow:
            inset 0 1px 0 rgba(165, 180, 252, 0.1),
            0 8px 28px rgba(99, 102, 241, 0.14);
    }

    .roadmap-card--pink .roadmap-card__inner {
        background: linear-gradient(145deg, rgba(190, 24, 93, 0.14), rgba(15, 23, 42, 0.5));
        border-color: rgba(232, 121, 249, 0.26);
        box-shadow:
            inset 0 1px 0 rgba(244, 114, 182, 0.1),
            0 8px 28px rgba(217, 70, 239, 0.14);
    }

    .roadmap-card--yellow .roadmap-card__inner {
        background: linear-gradient(145deg, rgba(161, 98, 7, 0.16), rgba(15, 23, 42, 0.5));
        border-color: rgba(250, 204, 21, 0.28);
        box-shadow:
            inset 0 1px 0 rgba(253, 224, 71, 0.1),
            0 8px 28px rgba(202, 138, 4, 0.12);
    }

    .roadmap-milestone--5 .roadmap-card {
        z-index: 11;
    }

    .roadmap-card__badge-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .roadmap-card--purple .roadmap-card__badge-icon {
        background: rgba(124, 58, 237, 0.22);
        border: 1px solid rgba(167, 139, 250, 0.4);
        color: #c4b5fd;
    }

    .roadmap-card--cyan .roadmap-card__badge-icon {
        background: rgba(8, 145, 178, 0.22);
        border: 1px solid rgba(34, 211, 238, 0.38);
        color: #67e8f9;
    }

    .roadmap-card--indigo .roadmap-card__badge-icon {
        background: rgba(67, 56, 202, 0.22);
        border: 1px solid rgba(129, 140, 248, 0.4);
        color: #a5b4fc;
    }

    .roadmap-card--pink .roadmap-card__badge-icon {
        background: rgba(190, 24, 93, 0.2);
        border: 1px solid rgba(232, 121, 249, 0.38);
        color: #f0abfc;
    }

    .roadmap-card--yellow .roadmap-card__badge-icon {
        background: rgba(161, 98, 7, 0.22);
        border: 1px solid rgba(250, 204, 21, 0.42);
        color: #fde047;
    }

    .roadmap-tag {
        font-size: 0.5625rem;
        font-weight: 900;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 0.2rem 0.4rem;
        border-radius: 9999px;
        border: 1px solid;
    }

    .roadmap-status {
        font-size: 0.5625rem;
        font-weight: 900;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .roadmap-extra-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.5rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        padding: 0.2rem 0.35rem;
        border-radius: 0.3rem;
        border-width: 1px;
        border-style: solid;
    }

    .roadmap-title {
        font-size: 0.9375rem;
        font-weight: 900;
        color: #f8fafc;
        line-height: 1.2;
        margin-top: 0.35rem;
        letter-spacing: -0.01em;
    }

    .roadmap-desc {
        font-size: 0.6875rem;
        line-height: 1.45;
        color: #cbd5e1;
        margin-top: 0.35rem;
    }

    @media (min-width: 1024px) {
        .roadmap-card__inner {
            padding: 0.75rem 0.8rem;
        }

        .roadmap-title {
            font-size: 1rem;
        }

        .roadmap-desc {
            font-size: 0.71875rem;
            line-height: 1.48;
        }

        .roadmap-tag,
        .roadmap-status {
            font-size: 0.59375rem;
        }

        .roadmap-milestone .roadmap-holo {
            width: 3.15rem;
            height: 2.85rem;
            margin-top: 0;
        }

        .roadmap-milestone .roadmap-holo__platform {
            width: 2.35rem;
            height: 2.35rem;
            margin-left: -1.175rem;
        }

        .roadmap-milestone .roadmap-holo__icon {
            font-size: 1rem;
            bottom: 0.85rem;
        }
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
