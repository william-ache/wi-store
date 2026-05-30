<style>
    .sa-page {
        font-family: 'Outfit', sans-serif;
        background: #f1f5f9;
        color: #1e293b;
        --sa-nav-h: 3.5rem;
        --sa-sidebar-w: 15.5rem;
    }

    @media (min-width: 768px) {
        .sa-page {
            --sa-nav-h: 4rem;
        }
    }

    .sa-navbar {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid #e2e8f0;
    }

    .sa-shell {
        flex: 1;
        width: 100%;
        min-width: 0;
    }

    .sa-main {
        flex: 1;
        min-width: 0;
    }

    .sa-sidebar {
        width: var(--sa-sidebar-w);
        flex-shrink: 0;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        padding: 1.25rem 0.85rem;
        display: none;
    }

    @media (min-width: 1024px) {
        .sa-sidebar {
            display: flex;
            flex-direction: column;
            position: fixed;
            top: var(--sa-nav-h);
            left: 0;
            bottom: 0;
            z-index: 40;
            height: calc(100dvh - var(--sa-nav-h));
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .sa-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sa-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        .sa-sidebar-toggle {
            display: none;
        }

        .sa-main {
            margin-left: var(--sa-sidebar-w);
            width: calc(100% - var(--sa-sidebar-w));
        }
    }

    .sa-sidebar.is-open {
        display: flex;
        flex-direction: column;
        position: fixed;
        top: var(--sa-nav-h);
        left: 0;
        bottom: 0;
        z-index: 40;
        max-width: 16rem;
        height: calc(100dvh - var(--sa-nav-h));
        overflow-y: auto;
        box-shadow: 8px 0 32px rgba(15, 23, 42, 0.12);
    }

    .sa-nav-link {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.65rem 0.85rem;
        border-radius: 0.75rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #64748b;
        transition: background 0.15s, color 0.15s;
    }

    .sa-nav-link:hover {
        background: #f8fafc;
        color: #334155;
    }

    .sa-nav-link.is-active {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.1), rgba(8, 145, 178, 0.08));
        color: #6b21a8;
        border: 1px solid rgba(147, 51, 234, 0.15);
    }

    .sa-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.04);
    }

    .sa-btn-primary {
        background: linear-gradient(135deg, #9333ea 0%, #0891b2 100%);
        color: #fff;
        font-weight: 800;
        border-radius: 0.75rem;
        box-shadow: 0 4px 14px rgba(147, 51, 234, 0.22);
        transition: filter 0.15s, transform 0.1s;
    }

    .sa-btn-primary:hover { filter: brightness(1.05); }
    .sa-btn-primary:active { transform: scale(0.98); }

    .sa-btn-ghost {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 700;
        border-radius: 0.75rem;
    }

    .sa-btn-ghost:hover {
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .sa-btn-danger {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #be123c;
        font-weight: 800;
        border-radius: 0.75rem;
    }

    .sa-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem 1.15rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .sa-alert--success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
    }

    .sa-alert--error {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #be123c;
    }

    .sa-field {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        border-radius: 0.75rem;
    }

    .sa-field:focus {
        outline: none;
        border-color: rgba(147, 51, 234, 0.45);
        box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
        background: #fff;
    }

    /* DataTables light */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: #64748b !important;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.5rem !important;
        color: #0f172a !important;
        padding: 4px 10px !important;
        font-family: 'Outfit', sans-serif;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #9333ea, #0891b2) !important;
        border-color: transparent !important;
        color: #fff !important;
        border-radius: 0.5rem !important;
    }

    table.dataTable thead th {
        border-bottom: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    table.dataTable tbody td {
        border-top: 1px solid #f1f5f9 !important;
        vertical-align: middle;
    }

    table.dataTable tbody tr:hover {
        background: #f8fafc !important;
    }

    /* ——— Tabla empresas ——— */
    .sa-companies-table__head {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .sa-companies-table__title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.125rem;
        font-weight: 800;
        color: #0f172a;
    }

    .sa-companies-table__desc {
        font-size: 0.8125rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .sa-companies-table__actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.65rem;
    }

    .sa-count-badge {
        font-size: 0.6875rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.4rem 0.75rem;
        border-radius: 9999px;
        background: #f5f3ff;
        border: 1px solid #e9d5ff;
        color: #6b21a8;
    }

    .sa-table-wrap {
        overflow-x: auto;
        margin: 0 -0.25rem;
        padding: 0 0.25rem;
    }

    .sa-table-wrap::-webkit-scrollbar {
        height: 6px;
    }

    .sa-table-wrap::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }

    .sa-table {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sa-table__th {
        padding: 0.75rem 1rem;
        font-size: 0.625rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .sa-table__th:first-child { border-radius: 0.75rem 0 0 0; }
    .sa-table__th:last-child { border-radius: 0 0.75rem 0 0; }

    .sa-table__th--center { text-align: center; }
    .sa-table__th--actions { text-align: right; min-width: 11rem; }

    .sa-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.8125rem;
    }

    .sa-table tbody tr:last-child td { border-bottom: none; }
    .sa-table tbody tr:hover td { background: #fafbfc; }

    .sa-shop-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 10rem;
    }

    .sa-shop-cell__logo {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.65rem;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sa-shop-cell__name {
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
    }

    .sa-shop-cell__slug {
        font-size: 0.6875rem;
        font-weight: 600;
        color: #7c3aed;
    }

    .sa-shop-cell__slug:hover { text-decoration: underline; }

    .sa-cell-email {
        display: block;
        max-width: 11rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #475569;
        font-weight: 600;
    }

    .sa-cell-muted {
        font-size: 0.75rem;
        color: #94a3b8;
        font-style: italic;
    }

    .sa-payment-cell {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        align-items: flex-start;
    }

    .sa-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.55rem;
        border-radius: 0.5rem;
        font-size: 0.6875rem;
        font-weight: 700;
        line-height: 1.3;
        white-space: nowrap;
    }

    .sa-pill--neutral {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .sa-pill--success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
    }

    .sa-pill--warning {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #b45309;
    }

    .sa-pill--danger {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #be123c;
    }

    .sa-pill--dot::before {
        content: '';
        width: 0.4rem;
        height: 0.4rem;
        border-radius: 9999px;
        background: currentColor;
    }

    .sa-plan-form {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        min-width: 8.5rem;
    }

    .sa-select {
        width: 100%;
        appearance: none;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.4rem center;
        background-size: 1.1em;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #0f172a;
        font-weight: 600;
        cursor: pointer;
    }

    .sa-select:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.15);
    }

    .sa-select--sm {
        font-size: 0.75rem;
        padding: 0.4rem 1.75rem 0.4rem 0.5rem;
    }

    .sa-select--xs {
        font-size: 0.6875rem;
        padding: 0.3rem 1.5rem 0.3rem 0.45rem;
        color: #64748b;
    }

    .sa-row-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.4rem;
        min-width: 10.5rem;
    }

    .sa-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.65rem;
        border-radius: 0.5rem;
        font-size: 0.6875rem;
        font-weight: 800;
        border: 1px solid transparent;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
    }

    .sa-action-btn--primary {
        background: #f5f3ff;
        border-color: #e9d5ff;
        color: #6b21a8;
    }

    .sa-action-btn--primary:hover {
        background: #7c3aed;
        color: #fff;
    }

    .sa-action-btn--danger {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #be123c;
    }

    .sa-action-btn--danger:hover {
        background: #e11d48;
        color: #fff;
    }

    .sa-action-btn--success {
        background: #ecfdf5;
        border-color: #a7f3d0;
        color: #047857;
    }

    .sa-action-btn--success:hover {
        background: #059669;
        color: #fff;
    }

    .sa-table-empty {
        text-align: center;
        padding: 3rem 1rem !important;
        color: #64748b;
    }

    /* DataTables toolbar / footer */
    .sa-dt-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .sa-dt-toolbar .dataTables_length label,
    .sa-dt-toolbar .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
    }

    .sa-dt-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .dataTables_wrapper .dataTables_filter input {
        min-width: 14rem;
        padding: 0.5rem 0.75rem !important;
        border-radius: 0.65rem !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        gap: 0.25rem;
        margin: 0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        min-width: 2rem;
        text-align: center;
        border: 1px solid #e2e8f0 !important;
        background: #fff !important;
        color: #475569 !important;
        border-radius: 0.5rem !important;
        margin: 0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
        background: #f8fafc !important;
        color: #0f172a !important;
    }

    .dataTables_wrapper .dataTables_scroll,
    .dataTables_wrapper .dataTables_scrollHead,
    .dataTables_wrapper .dataTables_scrollBody {
        overflow: visible !important;
        width: 100% !important;
    }

    table.dataTable { margin-top: 0 !important; margin-bottom: 0 !important; }
    table.dataTable.no-footer { border-bottom: none !important; }

    .dataTables_wrapper .dataTables_processing {
        background: rgba(255, 255, 255, 0.9) !important;
        color: #64748b !important;
    }

    /* ——— Modales crear / editar empresa ——— */
    .sa-modal-scroll {
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }

    .sa-modal-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .sa-modal-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }

    .sa-modal-field {
        width: 100%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        color: #0f172a;
        font-size: 0.8125rem;
        font-weight: 600;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .sa-modal-field::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .sa-modal-field:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.12);
    }

    .sa-modal-field--icon {
        padding: 0.5rem 0.75rem 0.5rem 2.25rem;
    }

    .sa-modal-field--select {
        padding-right: 2.25rem;
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.55rem center;
        background-size: 1.15em;
        background-color: #ffffff;
    }

    .sa-modal-field--select option {
        color: #0f172a;
        background: #ffffff;
        font-weight: 600;
        padding: 0.35rem 0.5rem;
    }

    .sa-modal-field[type="date"],
    .sa-modal-field[type="number"],
    .sa-modal-field[type="email"] {
        color-scheme: light;
    }

    .sa-field-wrap {
        position: relative;
    }

    .sa-field-wrap__icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.75rem;
        pointer-events: none;
        z-index: 1;
    }

    .sa-modal-file {
        width: 100%;
        font-size: 0.75rem;
        color: #64748b;
        cursor: pointer;
    }

    .sa-modal-file::file-selector-button {
        margin-right: 0.65rem;
        padding: 0.45rem 0.85rem;
        border: 1px solid #e9d5ff;
        border-radius: 0.5rem;
        background: #f5f3ff;
        color: #6b21a8;
        font-weight: 700;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }

    .sa-modal-file::file-selector-button:hover {
        background: #ede9fe;
        border-color: #c4b5fd;
    }

    .sa-file-label {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        padding: 0.55rem 0.65rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        background: #fff;
        cursor: pointer;
        transition: border-color 0.15s;
    }

    .sa-file-label:hover {
        border-color: #c4b5fd;
    }

    .sa-file-label__text {
        font-size: 0.6875rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .sa-temp-password {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.55rem;
        border-radius: 0.5rem;
        background: #f5f3ff;
        border: 1px solid #e9d5ff;
        color: #6b21a8;
        font-family: ui-monospace, monospace;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .sa-temp-password__toggle {
        padding: 0.15rem;
        color: #7c3aed;
        border: none;
        background: transparent;
        cursor: pointer;
        line-height: 1;
    }

    .sa-temp-password__toggle:hover {
        color: #5b21b6;
    }

    /* Formulario modal empresa */
    .sa-form-col {
        display: flex;
        flex-direction: column;
        gap: 1.15rem;
    }

    .sa-form-section-title {
        font-size: 0.8125rem;
        font-weight: 800;
        color: #6b21a8;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        margin: 0;
    }

    .sa-form-subtitle {
        font-size: 0.6875rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #7c3aed;
        margin: 0 0 0.75rem;
    }

    .sa-form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .sa-form-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #334155;
        line-height: 1.3;
    }

    .sa-form-hint {
        font-size: 0.6875rem;
        color: #94a3b8;
        line-height: 1.4;
        margin: 0;
    }

    .sa-form-hint--inline {
        margin-top: 0.15rem;
    }

    .sa-modal-field--date {
        padding-right: 0.5rem;
    }

    .sa-form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    @media (max-width: 480px) {
        .sa-form-row-2 {
            grid-template-columns: 1fr;
        }
    }

    .sa-modal-subsection {
        padding: 1rem 1.1rem;
        border-radius: 0.85rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .sa-modal-field {
        min-height: 2.625rem;
    }

    .sa-modal-field--textarea {
        min-height: 4.25rem;
        padding: 0.65rem 0.75rem;
        line-height: 1.45;
        resize: vertical;
    }

    .sa-password-panel {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        padding-top: 0.25rem;
        border-top: 1px dashed #e2e8f0;
    }

    .sa-password-panel__current {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .sa-color-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.65rem;
    }

    .sa-color-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 0.5rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        cursor: pointer;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .sa-color-card:hover {
        border-color: #c4b5fd;
    }

    .sa-color-card__label {
        font-size: 0.6875rem;
        font-weight: 700;
        color: #64748b;
    }

    .sa-color-card__input {
        width: 2.75rem;
        height: 2.75rem;
        padding: 0;
        border: 2px solid #e2e8f0;
        border-radius: 0.65rem;
        cursor: pointer;
        background: transparent;
    }

    .sa-media-stack {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .sa-media-block {
        padding: 0.85rem 1rem;
        border-radius: 0.75rem;
        border: 1px dashed #cbd5e1;
        background: #fafbfc;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .sa-media-block__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .sa-media-block__title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .sa-media-block__preview {
        flex-shrink: 0;
    }

    .sa-media-block__thumb {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.5rem;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    .sa-media-block__thumb--wide {
        width: 3.5rem;
        height: 2.25rem;
    }

    .sa-form-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.65rem;
        padding-top: 1.25rem;
        margin-top: 0.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .sa-btn-secondary {
        padding: 0.5rem 1.15rem;
        border-radius: 0.75rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #475569;
        background: #fff;
        border: 1px solid #e2e8f0;
        transition: background 0.15s, border-color 0.15s;
    }

    .sa-btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }
</style>
