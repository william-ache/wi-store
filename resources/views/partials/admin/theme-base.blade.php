    html.wi-store-admin,
    html.wi-store-ui.wi-store-admin {
        height: 100%;
        min-height: 100dvh;
        min-height: 100vh;
        background-color: var(--ui-bg);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    body.wi-store-admin-body {
        display: flex;
        flex-direction: column;
        min-height: 100dvh;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        background-color: var(--ui-bg);
        color: var(--ui-text);
        position: relative;
    }

    body.wi-store-admin-body::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background-color: var(--ui-bg);
        pointer-events: none;
    }

    .wi-store-admin {
        --admin-sidebar-w: 16rem;
        --admin-topbar-h: 4.25rem;
        --admin-bottombar-h: 0px;
    }

    @media (min-width: 768px) {
        .wi-store-admin {
            --admin-topbar-h: 4.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .wi-store-admin {
            --admin-topbar-h: 3.5rem;
        }
    }

    .wi-store-admin .admin-viewport {
        display: flex;
        flex: 1 1 auto;
        flex-direction: row;
        align-items: stretch;
        width: 100%;
        min-height: 100dvh;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        background-color: var(--ui-bg);
        overflow-x: hidden;
    }

    .wi-store-admin .admin-main-column {
        display: flex;
        flex: 1 1 auto;
        flex-direction: column;
        min-width: 0;
        width: 100%;
        min-height: 100dvh;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        padding-bottom: env(safe-area-inset-bottom, 0px);
        background-color: var(--ui-bg);
    }

    .wi-store-admin .admin-sidebar {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        width: var(--admin-sidebar-w);
        min-height: 0;
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .wi-store-admin .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 35;
            height: 100dvh;
            max-height: 100dvh;
        }

        .wi-store-admin .admin-main-column {
            margin-left: var(--admin-sidebar-w);
            width: calc(100% - var(--admin-sidebar-w));
        }
    }

    /* Móvil: sidebar oculto por defecto, overlay al abrir */
    @media (max-width: 767.98px) {
        .wi-store-admin .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            flex: none;
            width: min(18rem, 88vw);
            max-width: 18rem;
            min-width: 0;
            height: 100dvh;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.25s ease;
            box-shadow: none;
        }

        .wi-store-admin .admin-sidebar.admin-sidebar--open,
        .wi-store-admin.admin-sidebar-open .admin-sidebar {
            transform: translateX(0);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.35);
        }

        .wi-store-admin .admin-sidebar-backdrop {
            position: fixed;
            inset: 0;
            z-index: 45;
            background-color: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(2px);
        }
    }

    /* Topbar fijo */
    .wi-store-admin .admin-topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        margin: 0;
        padding-top: calc(0.75rem + env(safe-area-inset-top, 0px));
        padding-bottom: 0.75rem;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        outline: none;
        box-sizing: border-box;
        z-index: 40;
    }

    @media (min-width: 768px) {
        .wi-store-admin .admin-topbar {
            left: var(--admin-sidebar-w);
            width: calc(100% - var(--admin-sidebar-w));
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    }

    .wi-store-admin .admin-topbar-inner {
        width: 100%;
        max-width: 80rem;
        margin-left: auto;
        margin-right: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        min-width: 0;
    }

    @media (min-width: 768px) {
        .wi-store-admin .admin-topbar-inner {
            gap: 1.25rem;
        }
    }

    .wi-store-admin .admin-topbar-brand {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        min-width: 0;
        flex: 1 1 auto;
    }

    .wi-store-admin .admin-topbar-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .wi-store-admin .admin-topbar-actions {
            gap: 1.25rem;
        }
    }

    .wi-store-admin .admin-topbar-spacer {
        flex-shrink: 0;
        height: calc(var(--admin-topbar-h) + env(safe-area-inset-top, 0px));
        margin: 0;
        padding: 0;
        background-color: var(--color-primary);
        pointer-events: none;
    }

    @media (min-width: 768px) {
        .wi-store-admin .admin-topbar-spacer {
            height: var(--admin-topbar-h);
        }
    }

    .wi-store-admin .admin-main-content {
        flex: 1 1 auto;
    }

    .wi-store-admin header.accent-surface,
    .wi-store-admin nav.accent-surface {
        background-color: var(--color-primary);
        color: var(--color-on-primary);
    }

  .dark .wi-store-admin .dark\:bg-slate-900 {
      background-color: var(--ui-surface) !important;
  }

  .dark .wi-store-admin .dark\:bg-slate-850 {
      background-color: #2A2A2A !important;
  }

  .wi-store-admin .ui-overlay {
      background-color: color-mix(in srgb, var(--ui-surface) 95%, transparent);
  }

  .dark .wi-store-admin .dark\:border-slate-800,
  .dark .wi-store-admin .dark\:border-slate-850 {
      border-color: var(--ui-border) !important;
  }

  .wi-store-admin .ui-surface {
      background-color: var(--ui-surface);
      color: var(--ui-text);
  }

  .wi-store-admin .ui-card {
      background-color: var(--ui-surface);
      color: var(--ui-text);
      border: 1px solid var(--ui-border);
  }

  .wi-store-admin .ui-field {
      background-color: var(--ui-surface);
      color: var(--ui-text);
      border-color: var(--ui-border);
  }

  .wi-store-admin .ui-field::placeholder {
      color: var(--ui-text-muted);
  }

  .wi-store-admin .ui-inset {
      background-color: #ECEEF1;
      color: var(--ui-text);
      border-color: var(--ui-border);
  }

  .dark .wi-store-admin .ui-inset {
      background-color: #161616;
  }

  /* Modo claro: tarjetas oscuras legacy → superficie off-white */
  html:not(.dark) .wi-store-admin main .bg-slate-900 {
      background-color: var(--ui-surface) !important;
      border-color: var(--ui-border) !important;
  }

  html:not(.dark) .wi-store-admin main .bg-slate-900 .text-white,
  html:not(.dark) .wi-store-admin main .bg-slate-900 .text-slate-100 {
      color: var(--ui-text) !important;
  }

  html:not(.dark) .wi-store-admin main .from-slate-900 {
      --tw-gradient-from: var(--ui-surface) var(--tw-gradient-from-position) !important;
      --tw-gradient-to: rgb(250 251 252 / 0) var(--tw-gradient-to-position) !important;
      --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
  }

  .dark .wi-store-admin .dark\:bg-slate-950,
  .dark .wi-store-admin .dark\:bg-slate-800,
  .dark .wi-store-admin .dark\:bg-slate-800\/50,
  .dark .wi-store-admin .dark\:bg-slate-800\/40 {
      background-color: var(--ui-inset, #161616) !important;
  }

  .dark .wi-store-admin .bg-slate-900 {
      background-color: var(--ui-surface) !important;
  }

  .dark .wi-store-admin .border-slate-800 {
      border-color: var(--ui-border) !important;
  }

  .dark .wi-store-admin .dark\:text-slate-200,
  .dark .wi-store-admin .dark\:text-slate-300 {
      color: var(--ui-text);
  }

  .dark .wi-store-admin .dark\:text-slate-400,
  .dark .wi-store-admin .dark\:text-slate-500 {
      color: var(--ui-text-muted);
  }

  .dark .wi-store-admin .dark\:border-slate-750,
  .dark .wi-store-admin .dark\:border-slate-700,
  .dark .wi-store-admin .dark\:border-slate-800\/80,
  .dark .wi-store-admin .dark\:border-slate-800\/50,
  .dark .wi-store-admin .dark\:border-slate-850\/80 {
      border-color: var(--ui-border) !important;
  }

  /* Superficies con color de acento sólido (header, nav móvil) */
  .wi-store-admin .accent-surface {
      background-color: var(--color-primary);
      color: var(--color-on-primary);
      border-color: rgba(var(--color-on-primary-rgb), 0.1);
  }

  .wi-store-admin .accent-surface .accent-muted {
      color: rgba(var(--color-on-primary-rgb), 0.6);
  }

  .wi-store-admin .accent-surface .accent-subtle-bg {
      background-color: rgba(var(--color-on-primary-rgb), 0.12);
  }

  .wi-store-admin .accent-surface .accent-subtle-bg-active {
      background-color: rgba(var(--color-on-primary-rgb), 0.18);
  }

  .wi-store-admin .accent-surface-input {
      background-color: rgba(var(--color-on-primary-rgb), 0.1);
      border-color: rgba(var(--color-on-primary-rgb), 0.12);
      color: var(--color-on-primary);
  }

  .wi-store-admin .accent-surface-input::placeholder {
      color: rgba(var(--color-on-primary-rgb), 0.55);
  }

  .wi-store-admin .accent-surface-input:focus {
      background-color: rgba(var(--color-on-primary-rgb), 0.16);
      border-color: rgba(var(--color-on-primary-rgb), 0.28);
      outline: none;
      box-shadow: 0 0 0 1px rgba(var(--color-on-primary-rgb), 0.2);
  }

  .wi-store-admin .accent-icon-btn {
      color: var(--color-on-primary);
      opacity: 0.85;
  }

  .wi-store-admin .accent-icon-btn:hover {
      opacity: 1;
      background-color: rgba(var(--color-on-primary-rgb), 0.12);
  }

  .wi-store-admin .accent-nav-link {
      color: rgba(var(--color-on-primary-rgb), 0.65);
  }

  .wi-store-admin .accent-nav-link:hover,
  .wi-store-admin .accent-nav-link--active {
      color: var(--color-on-primary);
  }

  .wi-store-admin .accent-nav-link--active {
      background-color: rgba(var(--color-on-primary-rgb), 0.18);
  }

  /* Avatar de perfil: borde según conexión a internet */
  .wi-store-admin .admin-avatar-status {
      display: inline-flex;
      border-radius: 9999px;
      padding: 2px;
      transition: box-shadow 0.2s ease, outline-color 0.2s ease;
  }

  .wi-store-admin .admin-avatar-status--online {
      outline: 2.5px solid #22c55e;
      outline-offset: 1px;
      box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.45);
  }

  .wi-store-admin .admin-avatar-status--offline {
      outline: 2.5px solid #ef4444;
      outline-offset: 1px;
      box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.45);
  }

  /* Botones principales con contraste automático */
  .wi-store-admin .btn-accent,
  .wi-store-admin .settings-save-btn,
  .wi-store-admin .tab-btn.active,
  .wi-store-admin button.bg-primary:not([class*="bg-primary/"]),
  .wi-store-admin a.bg-primary:not([class*="bg-primary/"]) {
      color: var(--color-on-primary) !important;
  }

  .wi-store-admin .btn-accent {
      background-color: var(--color-primary);
      border-color: transparent;
  }

  .wi-store-admin .btn-accent:hover {
      filter: brightness(0.95);
  }

  .wi-store-admin .swal2-confirm {
      color: var(--color-on-primary) !important;
  }

  /* Sidebar: enlaces con borde degradado en ítem activo */
  .wi-store-admin .admin-nav-link {
      display: flex;
      align-items: center;
      gap: 0.625rem;
      width: 100%;
      padding: 0.625rem 0.75rem;
      border-radius: 0.75rem;
      font-size: 0.875rem;
      font-weight: 600;
      color: #94a3b8;
      background: transparent;
      border: 1px solid transparent;
      transition: color 0.15s ease, background 0.15s ease;
      position: relative;
      text-align: left;
      text-decoration: none;
      cursor: pointer;
  }

  .wi-store-admin .admin-nav-link:hover {
      color: #f8fafc;
      background: rgba(30, 41, 59, 0.55);
  }

  .wi-store-admin .admin-nav-link--sub {
      font-size: 0.75rem;
      padding: 0.5rem 0.75rem;
      border-radius: 0.5rem;
  }

  .wi-store-admin .admin-nav-link--parent {
      justify-content: space-between;
  }

  .wi-store-admin .admin-nav-link--active {
      color: #fff;
      font-weight: 700;
      background: rgba(15, 23, 42, 0.92);
      border-color: transparent;
  }

  .wi-store-admin .admin-nav-link--active::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      padding: 1px;
      background: linear-gradient(135deg, #a855f7 0%, #ec4899 35%, #22d3ee 70%, #6366f1 100%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
  }

  .wi-store-admin .admin-nav-link--active svg {
      color: #e2e8f0;
  }

  .wi-store-admin .admin-sidebar-submenu {
      display: grid;
      grid-template-rows: 0fr;
      transition: grid-template-rows 0.22s ease;
  }

  .wi-store-admin .admin-sidebar-submenu--open {
      grid-template-rows: 1fr;
  }

  .wi-store-admin .admin-sidebar-submenu__inner {
      overflow: hidden;
      min-height: 0;
  }

  .wi-store-admin .admin-sidebar-submenu:not(.admin-sidebar-submenu--open) .admin-sidebar-submenu__inner {
      pointer-events: none;
  }

  /* Modal modo oscuro (SweetAlert — renderizado en body) */
  .admin-dark-mode-swal {
      border: 1px solid rgba(148, 163, 184, 0.22) !important;
      border-radius: 1.25rem !important;
      box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.55) !important;
      padding: 1.75rem 1.5rem 1.35rem !important;
      color: #ffffff !important;
  }

  .admin-dark-mode-swal .swal2-title,
  .admin-dark-mode-swal .swal2-html-container,
  .admin-dark-mode-swal .swal2-content {
      color: #ffffff !important;
  }

  .admin-dark-mode-swal__title,
  .admin-dark-mode-swal .swal2-title {
      color: #ffffff !important;
      font-size: 1.375rem !important;
      font-weight: 800 !important;
      letter-spacing: -0.02em !important;
      line-height: 1.3 !important;
      margin-bottom: 0.35rem !important;
  }

  .admin-dark-mode-swal__text,
  .admin-dark-mode-swal .swal2-html-container {
      color: #ffffff !important;
      font-size: 0.9375rem !important;
      font-weight: 500 !important;
      line-height: 1.6 !important;
  }

  .admin-dark-mode-swal__icon,
  .admin-dark-mode-swal .swal2-icon.swal2-info {
      margin-top: 0.25rem !important;
      margin-bottom: 0.85rem !important;
      border-color: rgba(125, 211, 252, 0.45) !important;
      color: #7dd3fc !important;
  }

  .admin-dark-mode-swal__btn,
  .admin-dark-mode-swal .swal2-confirm {
      color: #ffffff !important;
      font-weight: 700 !important;
      font-size: 0.875rem !important;
      border-radius: 0.75rem !important;
      padding: 0.625rem 1.5rem !important;
      box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35) !important;
  }

  /* Dashboard home */
  .wi-store-admin .admin-dash-welcome {
      background: #fff;
      border: 1px solid var(--ui-border);
      box-shadow: 0 4px 24px -8px rgba(15, 23, 42, 0.12);
  }

  .dark .wi-store-admin .admin-dash-welcome {
      background: var(--ui-surface);
  }

  .wi-store-admin .admin-btn-store-live {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.625rem 1.125rem;
      border-radius: 0.75rem;
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--color-on-primary);
      background-color: var(--color-primary);
      border: 1px solid color-mix(in srgb, var(--color-primary) 85%, #000);
      box-shadow: 0 4px 14px color-mix(in srgb, var(--color-primary) 35%, transparent);
      transition: filter 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
  }

  .wi-store-admin .admin-btn-store-live:hover {
      filter: brightness(1.06);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px color-mix(in srgb, var(--color-primary) 42%, transparent);
  }

  .wi-store-admin .admin-dash-stat {
      background: #fff;
      border: 1px solid var(--ui-border);
      box-shadow: 0 2px 16px -6px rgba(15, 23, 42, 0.1);
  }

  .dark .wi-store-admin .admin-dash-stat {
      background: var(--ui-surface);
  }

  .wi-store-admin .admin-dash-panel {
      background: #fff;
      border: 1px solid var(--ui-border);
      box-shadow: 0 4px 24px -10px rgba(15, 23, 42, 0.12);
  }

  .dark .wi-store-admin .admin-dash-panel {
      background: var(--ui-surface);
  }

  .wi-store-admin .admin-quick-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.875rem 1rem;
      border-radius: 0.875rem;
      border: 1px solid var(--ui-border);
      background: #f8fafc;
      transition: background 0.15s ease, border-color 0.15s ease;
  }

  .wi-store-admin .admin-quick-link:hover {
      background: #f1f5f9;
      border-color: color-mix(in srgb, var(--color-primary) 25%, var(--ui-border));
  }

  .dark .wi-store-admin .admin-quick-link {
      background: var(--ui-inset, #161616);
  }

  .wi-store-admin .admin-quick-icon {
      width: 2.25rem;
      height: 2.25rem;
      border-radius: 0.625rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
  }

  /* Dashboard inicio: cabe en una pantalla (escritorio) */
  @media (min-width: 1024px) {
      .wi-store-admin .admin-main-column:has(.admin-dashboard-page) {
          min-height: 100dvh;
          max-height: 100dvh;
          overflow: hidden;
      }

      .wi-store-admin .admin-main-content:has(.admin-dashboard-page) {
          flex: 1 1 auto;
          min-height: 0;
          overflow: hidden;
          padding-top: 0.875rem;
          padding-bottom: 0.875rem;
          display: flex;
          flex-direction: column;
      }

      .wi-store-admin .admin-dashboard-page {
          display: grid;
          grid-template-rows: auto auto minmax(0, 1fr);
          gap: 0.75rem;
          flex: 1;
          min-height: 0;
          height: 100%;
      }

      .wi-store-admin .admin-dash-kpis {
          margin-top: 0 !important;
      }

      .wi-store-admin .admin-dash-bottom {
          margin-top: 0 !important;
          min-height: 0;
      }

      .wi-store-admin .admin-dash-bottom > * {
          min-height: 0;
      }

      .wi-store-admin .admin-dash-chart-wrap {
          flex: 1;
          min-height: 0;
          position: relative;
      }

      .wi-store-admin .admin-dash-quick-list {
          display: flex;
          flex-direction: column;
          gap: 0.5rem;
          min-height: 0;
      }

      .wi-store-admin .admin-dashboard-page .admin-dash-welcome {
          padding: 1rem 1.25rem;
      }

      .wi-store-admin .admin-dashboard-page .admin-dash-stat {
          padding: 0.875rem 1rem;
      }

      .wi-store-admin .admin-dashboard-page .admin-dash-panel {
          padding: 1rem 1.25rem;
          display: flex;
          flex-direction: column;
          min-height: 0;
      }

      .wi-store-admin .admin-dashboard-page .admin-quick-link {
          padding: 0.5rem 0.75rem;
      }

      .wi-store-admin .admin-dashboard-page .admin-quick-icon {
          width: 1.875rem;
          height: 1.875rem;
          font-size: 0.875rem;
      }
  }
