    html.wistore-admin,
    html.wistore-ui.wistore-admin {
        height: 100%;
        min-height: 100dvh;
        min-height: 100vh;
        background-color: var(--ui-bg);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    body.wistore-admin-body {
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

    body.wistore-admin-body::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background-color: var(--ui-bg);
        pointer-events: none;
    }

    .wistore-admin {
        --admin-sidebar-w: 16rem;
        --admin-topbar-h: 4.25rem;
        --admin-bottombar-h: 0px;
    }

    @media (min-width: 768px) {
        .wistore-admin {
            --admin-topbar-h: 4.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .wistore-admin {
            --admin-topbar-h: 3.5rem;
        }
    }

    .wistore-admin .admin-viewport {
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

    .wistore-admin .admin-main-column {
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

    .wistore-admin .admin-sidebar {
        flex-shrink: 0;
        display: flex;
        width: var(--admin-sidebar-w);
        min-height: 100dvh;
        min-height: 100vh;
        align-self: stretch;
        height: auto;
    }

    /* Móvil: sidebar oculto por defecto, overlay al abrir */
    @media (max-width: 767.98px) {
        .wistore-admin .admin-sidebar {
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

        .wistore-admin .admin-sidebar.admin-sidebar--open,
        .wistore-admin.admin-sidebar-open .admin-sidebar {
            transform: translateX(0);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.35);
        }

        .wistore-admin .admin-sidebar-backdrop {
            position: fixed;
            inset: 0;
            z-index: 45;
            background-color: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(2px);
        }
    }

    /* Topbar fijo */
    .wistore-admin .admin-topbar {
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
        .wistore-admin .admin-topbar {
            left: var(--admin-sidebar-w);
            width: calc(100% - var(--admin-sidebar-w));
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    }

    .wistore-admin .admin-topbar-inner {
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
        .wistore-admin .admin-topbar-inner {
            gap: 1.25rem;
        }
    }

    .wistore-admin .admin-topbar-brand {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        min-width: 0;
        flex: 1 1 auto;
    }

    .wistore-admin .admin-topbar-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .wistore-admin .admin-topbar-actions {
            gap: 1.25rem;
        }
    }

    .wistore-admin .admin-topbar-spacer {
        flex-shrink: 0;
        height: calc(var(--admin-topbar-h) + env(safe-area-inset-top, 0px));
        margin: 0;
        padding: 0;
        background-color: var(--color-primary);
        pointer-events: none;
    }

    @media (min-width: 768px) {
        .wistore-admin .admin-topbar-spacer {
            height: var(--admin-topbar-h);
        }
    }

    .wistore-admin .admin-main-content {
        flex: 1 1 auto;
    }

    .wistore-admin header.accent-surface,
    .wistore-admin nav.accent-surface {
        background-color: var(--color-primary);
        color: var(--color-on-primary);
    }

  .dark .wistore-admin .dark\:bg-slate-900 {
      background-color: var(--ui-surface) !important;
  }

  .dark .wistore-admin .dark\:bg-slate-850 {
      background-color: #2A2A2A !important;
  }

  .wistore-admin .ui-overlay {
      background-color: color-mix(in srgb, var(--ui-surface) 95%, transparent);
  }

  .dark .wistore-admin .dark\:border-slate-800,
  .dark .wistore-admin .dark\:border-slate-850 {
      border-color: var(--ui-border) !important;
  }

  .wistore-admin .ui-surface {
      background-color: var(--ui-surface);
      color: var(--ui-text);
  }

  .wistore-admin .ui-card {
      background-color: var(--ui-surface);
      color: var(--ui-text);
      border: 1px solid var(--ui-border);
  }

  .wistore-admin .ui-field {
      background-color: var(--ui-surface);
      color: var(--ui-text);
      border-color: var(--ui-border);
  }

  .wistore-admin .ui-field::placeholder {
      color: var(--ui-text-muted);
  }

  .wistore-admin .ui-inset {
      background-color: #ECEEF1;
      color: var(--ui-text);
      border-color: var(--ui-border);
  }

  .dark .wistore-admin .ui-inset {
      background-color: #161616;
  }

  /* Modo claro: tarjetas oscuras legacy → superficie off-white */
  html:not(.dark) .wistore-admin main .bg-slate-900 {
      background-color: var(--ui-surface) !important;
      border-color: var(--ui-border) !important;
  }

  html:not(.dark) .wistore-admin main .bg-slate-900 .text-white,
  html:not(.dark) .wistore-admin main .bg-slate-900 .text-slate-100 {
      color: var(--ui-text) !important;
  }

  html:not(.dark) .wistore-admin main .from-slate-900 {
      --tw-gradient-from: var(--ui-surface) var(--tw-gradient-from-position) !important;
      --tw-gradient-to: rgb(250 251 252 / 0) var(--tw-gradient-to-position) !important;
      --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
  }

  .dark .wistore-admin .dark\:bg-slate-950,
  .dark .wistore-admin .dark\:bg-slate-800,
  .dark .wistore-admin .dark\:bg-slate-800\/50,
  .dark .wistore-admin .dark\:bg-slate-800\/40 {
      background-color: var(--ui-inset, #161616) !important;
  }

  .dark .wistore-admin .bg-slate-900 {
      background-color: var(--ui-surface) !important;
  }

  .dark .wistore-admin .border-slate-800 {
      border-color: var(--ui-border) !important;
  }

  .dark .wistore-admin .dark\:text-slate-200,
  .dark .wistore-admin .dark\:text-slate-300 {
      color: var(--ui-text);
  }

  .dark .wistore-admin .dark\:text-slate-400,
  .dark .wistore-admin .dark\:text-slate-500 {
      color: var(--ui-text-muted);
  }

  .dark .wistore-admin .dark\:border-slate-750,
  .dark .wistore-admin .dark\:border-slate-700,
  .dark .wistore-admin .dark\:border-slate-800\/80,
  .dark .wistore-admin .dark\:border-slate-800\/50,
  .dark .wistore-admin .dark\:border-slate-850\/80 {
      border-color: var(--ui-border) !important;
  }

  /* Superficies con color de acento sólido (header, nav móvil) */
  .wistore-admin .accent-surface {
      background-color: var(--color-primary);
      color: var(--color-on-primary);
      border-color: rgba(var(--color-on-primary-rgb), 0.1);
  }

  .wistore-admin .accent-surface .accent-muted {
      color: rgba(var(--color-on-primary-rgb), 0.6);
  }

  .wistore-admin .accent-surface .accent-subtle-bg {
      background-color: rgba(var(--color-on-primary-rgb), 0.12);
  }

  .wistore-admin .accent-surface .accent-subtle-bg-active {
      background-color: rgba(var(--color-on-primary-rgb), 0.18);
  }

  .wistore-admin .accent-surface-input {
      background-color: rgba(var(--color-on-primary-rgb), 0.1);
      border-color: rgba(var(--color-on-primary-rgb), 0.12);
      color: var(--color-on-primary);
  }

  .wistore-admin .accent-surface-input::placeholder {
      color: rgba(var(--color-on-primary-rgb), 0.55);
  }

  .wistore-admin .accent-surface-input:focus {
      background-color: rgba(var(--color-on-primary-rgb), 0.16);
      border-color: rgba(var(--color-on-primary-rgb), 0.28);
      outline: none;
      box-shadow: 0 0 0 1px rgba(var(--color-on-primary-rgb), 0.2);
  }

  .wistore-admin .accent-icon-btn {
      color: var(--color-on-primary);
      opacity: 0.85;
  }

  .wistore-admin .accent-icon-btn:hover {
      opacity: 1;
      background-color: rgba(var(--color-on-primary-rgb), 0.12);
  }

  .wistore-admin .accent-nav-link {
      color: rgba(var(--color-on-primary-rgb), 0.65);
  }

  .wistore-admin .accent-nav-link:hover,
  .wistore-admin .accent-nav-link--active {
      color: var(--color-on-primary);
  }

  .wistore-admin .accent-nav-link--active {
      background-color: rgba(var(--color-on-primary-rgb), 0.18);
  }

  /* Avatar de perfil: borde según conexión a internet */
  .wistore-admin .admin-avatar-status {
      display: inline-flex;
      border-radius: 9999px;
      padding: 2px;
      transition: box-shadow 0.2s ease, outline-color 0.2s ease;
  }

  .wistore-admin .admin-avatar-status--online {
      outline: 2.5px solid #22c55e;
      outline-offset: 1px;
      box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.45);
  }

  .wistore-admin .admin-avatar-status--offline {
      outline: 2.5px solid #ef4444;
      outline-offset: 1px;
      box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.45);
  }

  /* Botones principales con contraste automático */
  .wistore-admin .btn-accent,
  .wistore-admin .settings-save-btn,
  .wistore-admin .tab-btn.active,
  .wistore-admin button.bg-primary:not([class*="bg-primary/"]),
  .wistore-admin a.bg-primary:not([class*="bg-primary/"]) {
      color: var(--color-on-primary) !important;
  }

  .wistore-admin .btn-accent {
      background-color: var(--color-primary);
      border-color: transparent;
  }

  .wistore-admin .btn-accent:hover {
      filter: brightness(0.95);
  }

  .wistore-admin .swal2-confirm {
      color: var(--color-on-primary) !important;
  }
