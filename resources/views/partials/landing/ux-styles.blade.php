<style>
    /* Evita scroll horizontal por glows, SVG del roadmap y cards del hero */
    html.wi-store-ui.wi-store-landing,
    html.wi-store-ui.wi-store-landing body {
        overflow-x: clip;
        max-width: 100%;
    }

    /* Contenedor fluido: ancho máximo + márgenes laterales generosos en pantallas grandes */
      .wi-store-landing .landing-container {
        width: 100%;
        max-width: 76rem;
        min-width: 0;
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

    #landing-header.landing-header--top {
        background-color: rgba(255, 255, 255, 0.95);
        border-color: #f1f5f9;
        box-shadow: none;
    }

    #landing-header.landing-header--scrolled {
        background-color: rgba(255, 255, 255, 0.72);
        border-color: rgba(226, 232, 240, 0.65);
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
        -webkit-backdrop-filter: blur(16px);
        backdrop-filter: blur(16px);
    }

    .landing-back-to-top {
        --wi-fab-size: 3.5rem;
        --wi-fab-offset: 1.25rem;
        --wi-fab-gap: 0.75rem;
        position: fixed;
        bottom: var(--wi-fab-offset);
        right: calc(var(--wi-fab-offset) + var(--wi-fab-size) + var(--wi-fab-gap));
        z-index: 10000;
        width: var(--wi-fab-size);
        height: var(--wi-fab-size);
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(255, 255, 255, 0.9);
        color: #fff;
        background: linear-gradient(135deg, #9333ea 0%, #d946ef 50%, #06b6d4 100%);
        box-shadow: 0 8px 28px rgba(168, 85, 247, 0.45);
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: scale(0.95);
        transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s ease, filter 0.2s ease;
    }

    .landing-back-to-top i {
        font-size: 1.125rem;
        line-height: 1;
    }

    .landing-back-to-top.is-visible:hover {
        filter: brightness(1.05);
        transform: scale(1.05);
    }

    .landing-back-to-top.is-visible:active {
        transform: scale(0.95);
    }

    .landing-back-to-top.is-visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: scale(1);
    }

    .landing-back-to-top.is-visible:focus-visible {
        outline: none;
        box-shadow: 0 8px 28px rgba(168, 85, 247, 0.45), 0 0 0 2px rgba(34, 211, 238, 0.8);
    }

    @media (min-width: 640px) {
        .landing-back-to-top {
            --wi-fab-offset: 1.5rem;
        }
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

    /* 3 pasos — mismas proporciones y paleta que landing-why-card */
    .landing-how-grid {
        align-items: stretch;
    }
    .landing-how-step {
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
    .landing-how-step:hover {
        border-color: rgba(147, 51, 234, 0.25);
        box-shadow: 0 12px 32px rgba(147, 51, 234, 0.08);
    }
    .landing-how-step__visual {
        position: relative;
        flex: 0 0 13.6rem;
        height: 13.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem 1.35rem;
        box-sizing: border-box;
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .landing-how-mock {
        width: 100%;
        height: 11.75rem;
        margin-inline: auto;
        border-radius: 0.75rem;
        background: #fff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
        padding: 0.96rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
    }
    .landing-how-mock--catalog {
        justify-content: flex-start;
    }
    .landing-how-form-demo {
        position: relative;
        display: grid;
        gap: 0.34rem;
    }
    .landing-how-form-field {
        border: 1px solid #dbeafe;
        background: #f8fafc;
        border-radius: 0.55rem;
        padding: 0.44rem 0.68rem;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        animation: landing-how-field-focus 8s ease-in-out infinite;
    }
    .landing-how-form-field--category {
        animation-delay: 2.2s;
    }
    .landing-how-form-field--color {
        animation-delay: 4.2s;
    }
    .landing-how-form-label {
        display: block;
        font-size: 0.42rem;
        line-height: 1;
        letter-spacing: 0.08em;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 0.17rem;
    }
    .landing-how-form-value {
        display: block;
        font-size: 0.54rem;
        line-height: 1.2;
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .landing-how-form-value--typing {
        width: 0;
        white-space: nowrap;
        border-right: 1px solid transparent;
        animation: landing-how-typing 8s steps(17, end) infinite;
    }
    .landing-how-category-pills {
        display: flex;
        gap: 0.3rem;
        flex-wrap: nowrap;
        padding: 0.1rem 0.04rem 0;
    }
    .landing-how-category-chip {
        border: 1px solid #dbeafe;
        background: #ffffff;
        color: #64748b;
        border-radius: 9999px;
        padding: 0.17rem 0.44rem;
        font-size: 0.45rem;
        font-weight: 800;
        line-height: 1.05;
        animation: none;
    }
    .landing-how-category-chip--selected {
        animation: landing-how-chip-idle 8s ease-in-out infinite;
        animation-delay: 2.5s;
    }
    .landing-how-color-palette {
        display: flex;
        align-items: center;
        gap: 0.34rem;
        padding: 0.11rem 0.1rem 0 0.08rem;
    }
    .landing-how-color-swatch {
        width: 0.78rem;
        height: 0.78rem;
        border-radius: 0.28rem;
        border: 1px solid rgba(148, 163, 184, 0.42);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.55);
        animation: none;
    }
    .landing-how-color-swatch--a {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
    }
    .landing-how-color-swatch--b {
        background: linear-gradient(135deg, #9333ea, #c026d3);
    }
    .landing-how-color-swatch--c {
        background: linear-gradient(135deg, #7c3aed, #06b6d4);
    }
    .landing-how-color-swatch--selected {
        animation: landing-how-palette-idle 8s ease-in-out infinite;
        animation-delay: 4.8s;
    }
    .landing-how-form-submit {
        margin-top: 0.24rem;
        width: fit-content;
        min-width: 6.9rem;
        align-self: center;
        border-radius: 0.62rem;
        padding: 0.34rem 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.28rem;
        color: #ffffff;
        font-size: 0.55rem;
        line-height: 1;
        font-weight: 900;
        letter-spacing: 0.04em;
        background: linear-gradient(90deg, #c026d3 0%, #7c3aed 48%, #3b82f6 100%);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.24);
        animation: landing-how-submit-focus 8s ease-in-out infinite;
        animation-delay: 6.2s;
    }
    .landing-how-demo-cursor {
        position: absolute;
        top: 0;
        left: 0;
        font-size: 0.72rem;
        color: #0f172a;
        pointer-events: none;
        filter: drop-shadow(0 1px 2px rgba(15, 23, 42, 0.18));
        transition: transform 0.32s ease;
        z-index: 5;
    }
    .landing-how-form-demo--js .landing-how-demo-cursor {
        animation: none;
    }
    .landing-how-demo-cursor__dot {
        display: none;
    }
    @keyframes landing-how-field-focus {
        0%, 6%, 100% {
            border-color: #dbeafe;
            background: #f8fafc;
            box-shadow: none;
        }
        8%, 20% {
            border-color: rgba(6, 182, 212, 0.5);
            background: #eff6ff;
            box-shadow: 0 0 0 2px rgba(6, 182, 212, 0.15);
        }
    }
    @keyframes landing-how-typing {
        0%, 8% {
            width: 0;
            border-right-color: transparent;
        }
        10%, 26% {
            width: 15.5ch;
            border-right-color: #64748b;
        }
        30%, 100% {
            width: 15.5ch;
            border-right-color: transparent;
        }
    }
    @keyframes landing-how-chip-idle {
        0%, 100% {
            border-color: #dbeafe;
            background: #ffffff;
            color: #64748b;
            box-shadow: none;
            transform: scale(1);
        }
        10%, 24% {
            border-color: rgba(124, 58, 237, 0.45);
            background: #eef2ff;
            color: #5b21b6;
            box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.12);
            transform: scale(1.03);
        }
    }
    @keyframes landing-how-palette-idle {
        0%, 100% {
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.55);
            transform: scale(1);
        }
        8%, 22% {
            box-shadow: 0 0 0 2px rgba(14, 116, 144, 0.18), inset 0 0 0 1px rgba(255, 255, 255, 0.7);
            transform: scale(1.08);
        }
    }
    @keyframes landing-how-submit-focus {
        0%, 70%, 100% {
            filter: none;
            transform: scale(1);
        }
        74%, 86% {
            filter: brightness(1.03);
            transform: scale(1.02);
        }
    }
    .landing-how-brand-gradient {
        background: linear-gradient(135deg, #c026d3 0%, #a855f7 42%, #3b82f6 100%);
    }
    .landing-how-brand-gradient-h {
        background: linear-gradient(90deg, #c026d3 0%, #a855f7 50%, #3b82f6 100%);
    }
    .landing-how-step__body {
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        min-height: 8.75rem;
        padding: 1.25rem 1.35rem 1.5rem;
        background: #f8fafc;
        box-sizing: border-box;
        text-align: left;
    }
    .landing-how-step__body > p {
        flex: 1 1 auto;
        margin-bottom: 0;
        color: #64748b;
    }
    .landing-reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.55s ease, transform 0.55s ease;
        will-change: opacity, transform;
    }
    .landing-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Fondos de sección siempre visibles (no participan en scroll-reveal) */
    .landing-section-glow,
    .landing-hero-backdrop,
    .landing-hero-backdrop > * {
        opacity: 1 !important;
        transform: none !important;
    }
    @media (min-width: 768px) {
        .landing-how-step__visual {
            flex-basis: 14rem;
            height: 14rem;
        }
        .landing-how-step__body {
            min-height: 9rem;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .landing-reveal,
        .landing-reveal.is-visible {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
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
    .landing-dark-zone .landing-billing-toggle-wrap > p:last-child {
        color: #94a3b8;
    }
    .landing-dark-zone .landing-billing-toggle-wrap > p:last-child strong {
        color: #e2e8f0;
    }
    .landing-dark-zone .landing-bcv-in-dark p,
    .landing-dark-zone .landing-bcv-in-dark span {
        color: #94a3b8 !important;
    }
    .landing-dark-zone .landing-bcv-in-dark strong {
        color: #f1f5f9 !important;
    }
    .landing-dark-zone .landing-bcv-in-dark .landing-bcv-rate-value {
        color: #34d399 !important;
    }
    .landing-dark-zone .landing-billing-commission {
        background: rgba(16, 185, 129, 0.12);
        border-color: rgba(52, 211, 153, 0.28);
        color: #6ee7b7;
    }
    .landing-dark-zone .landing-billing-commission span:first-child {
        background: #34d399;
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

    /* Fondo hero reutilizable (login, marketplace, etc.) */
    .landing-page-hero-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        isolation: isolate;
    }
    .landing-page-hero-bg .landing-hero-backdrop {
        position: absolute;
        inset: 0;
    }

    @include('partials.landing.plan-card-styles')

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
        gap: 1.1rem;
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
        flex: 0 0 12.35rem;
        height: 12.35rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.05rem 1.15rem;
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
        max-width: 16.6rem;
        margin-inline: auto;
        border-radius: 0.75rem;
        background: #fff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
        padding: 0.75rem 0.9rem;
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
        min-height: 8.15rem;
        padding: 1rem 1.15rem 1.25rem;
        background: #f8fafc;
        box-sizing: border-box;
    }
    .landing-why-card__body > p {
        flex: 1 1 auto;
        margin-bottom: 0;
    }
    @media (min-width: 768px) {
        .landing-why-grid {
            gap: 1.25rem;
        }
        .landing-why-card__visual {
            flex-basis: 12.9rem;
            height: 12.9rem;
        }
        .landing-why-card__body {
            min-height: 8.4rem;
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
