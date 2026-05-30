<style>
    .sa-page {
        font-family: 'Outfit', sans-serif;
        background: #f1f5f9;
        color: #1e293b;
    }

    .sa-navbar {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid #e2e8f0;
    }

    .sa-sidebar {
        width: 15.5rem;
        flex-shrink: 0;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        padding: 1.25rem 0.85rem;
        display: none;
    }

    @media (min-width: 1024px) {
        .sa-sidebar { display: flex; flex-direction: column; }
        .sa-sidebar-toggle { display: none; }
    }

    .sa-sidebar.is-open {
        display: flex;
        flex-direction: column;
        position: fixed;
        inset: 3.5rem 0 0 0;
        z-index: 40;
        max-width: 16rem;
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
</style>
