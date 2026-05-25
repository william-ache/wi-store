<style>
    @php
        $primaryColor = config('current_shop')->color_primary ?? '#E60067';
        $primaryColor = ltrim($primaryColor, '#');
        if (strlen($primaryColor) === 3) {
            $r = hexdec(substr($primaryColor, 0, 1) . substr($primaryColor, 0, 1));
            $g = hexdec(substr($primaryColor, 1, 1) . substr($primaryColor, 1, 1));
            $b = hexdec(substr($primaryColor, 2, 1) . substr($primaryColor, 2, 1));
        } elseif (strlen($primaryColor) === 6) {
            $r = hexdec(substr($primaryColor, 0, 2));
            $g = hexdec(substr($primaryColor, 2, 2));
            $b = hexdec(substr($primaryColor, 4, 2));
        } else {
            $r = 230;
            $g = 0;
            $b = 103;
        }
    @endphp
    :root {
        --color-primary: {{ config('current_shop')->color_primary ?? '#E60067' }};
        --color-primary-rgb: {{ $r }}, {{ $g }}, {{ $b }};
        --color-secondary: {{ config('current_shop')->color_secondary ?? '#C6A100' }};
    }
    html {
        scroll-behavior: smooth;
    }
    body {
        font-family: 'Outfit', sans-serif;
        background-color: #f8fafc;
        -webkit-tap-highlight-color: transparent;
    }
    [x-cloak] { display: none !important; }
    
    /* Scrollbar: ver partials/global/wistore-scrollbar.blade.php (html.wistore-ui) */

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .overflow-x-auto {
        padding: 0.25rem 0.25rem 1.25rem 0.25rem;
    }

    /* DataTables custom premium styling */
    .dataTables_wrapper {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 0 !important;
    }
    .dataTables_wrapper .dataTables_length select {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.45rem 1.75rem 0.45rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
        outline: none;
        color: #475569;
    }
    .dark .dataTables_wrapper .dataTables_length select {
        background-color: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 0 !important;
    }
    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        margin-bottom: 0 !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        padding: 0.45rem 1rem 0.45rem 2.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s;
        color: #334155;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.03);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 0.875rem center;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.15);
    }
    .dark .dataTables_wrapper .dataTables_filter input:focus {
        box-shadow: 0 0 0 3px rgba(51, 65, 85, 0.4);
    }
    .dark .dataTables_wrapper .dataTables_filter input {
        background-color: #1e293b;
        border-color: #334155;
        color: #f1f5f9;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E");
    }
    table.dataTable {
        border-collapse: collapse !important;
        width: 100% !important;
        border-radius: 1.25rem !important;
        overflow: hidden;
        border: 1px solid #f1f5f9 !important;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 8px 15px -6px rgba(0, 0, 0, 0.04), 0 0 1px 0 rgba(0, 0, 0, 0.1) !important;
    }
    .dark table.dataTable {
        border: 1px solid #1e293b !important;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.02) !important;
    }
    table.dataTable thead th {
        background-color: var(--color-primary, #E60067) !important;
        color: white !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em !important;
        padding: 1rem 1.25rem !important;
        border-bottom: none !important;
    }
    table.dataTable tbody td {
        padding: 1rem 1.25rem !important;
        font-size: 0.8125rem !important;
        border-bottom: 1px solid #f1f5f9 !important;
        background-color: #fafbfc !important;
    }
    table.dataTable tbody tr:nth-child(even) td {
        background-color: rgba(var(--color-primary-rgb), 0.015) !important;
    }
    .dark table.dataTable tbody td {
        border-bottom-color: #1e293b !important;
        color: #e2e8f0 !important;
        background-color: #0f172a !important;
    }
    .dark table.dataTable tbody tr:nth-child(even) td {
        background-color: rgba(var(--color-primary-rgb), 0.03) !important;
    }
    table.dataTable tbody tr:hover td {
        background-color: rgba(var(--color-primary-rgb), 0.05) !important;
    }
    .dark table.dataTable tbody tr:hover td {
        background-color: rgba(var(--color-primary-rgb), 0.12) !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 1rem !important;
        display: flex;
        gap: 0.25rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        padding: 0.375rem 0.75rem !important;
        transition: all 0.2s !important;
        background: white !important;
        color: #475569 !important;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-color: #334155 !important;
        background: #1e293b !important;
        color: #cbd5e1 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        color: #1e293b !important;
        border-color: #cbd5e1 !important;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #334155 !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--color-primary, #E60067) !important;
        color: white !important;
        border-color: var(--color-primary, #E60067) !important;
        box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.25) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f8fafc !important;
        color: #94a3b8 !important;
        border-color: #e2e8f0 !important;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        background: #0f172a !important;
        color: #475569 !important;
        border-color: #1e293b !important;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.75rem !important;
        color: #64748b !important;
        font-weight: 700 !important;
        padding-top: 1.25rem !important;
    }
    .dark .dataTables_wrapper .dataTables_info {
        color: #94a3b8 !important;
    }

    /* SweetAlert2 Premium Customizations */
    .swal2-popup {
        border-radius: 1.5rem !important;
        font-family: 'Outfit', sans-serif !important;
        padding: 2rem !important;
    }

    /* Toasts compactos (no heredan el padding de modales) */
    .swal2-popup.swal2-toast {
        padding: 0.625rem 0.875rem !important;
        border-radius: 0.875rem !important;
        max-width: min(22rem, calc(100vw - 2rem)) !important;
        min-height: auto !important;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12), 0 2px 6px rgba(15, 23, 42, 0.06) !important;
    }

    .swal2-popup.swal2-toast .swal2-title {
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        line-height: 1.35 !important;
        margin: 0 0 0 0.5rem !important;
        padding: 0 !important;
    }

    .swal2-popup.swal2-toast .swal2-icon {
        width: 1.5rem !important;
        height: 1.5rem !important;
        min-width: 1.5rem !important;
        margin: 0 0.5rem 0 0 !important;
        transform: scale(0.85);
    }

    .swal2-popup.swal2-toast .swal2-icon-content {
        font-size: 0.75rem !important;
    }

    .swal2-popup.swal2-toast .swal2-timer-progress-bar {
        height: 2px !important;
    }

    @media (min-width: 768px) {
        .swal2-container.swal2-top-end {
            top: 1rem !important;
            right: 1rem !important;
        }

        .swal2-popup.swal2-toast {
            max-width: 20rem !important;
        }

        .swal2-popup.swal2-toast .swal2-title {
            font-size: 0.75rem !important;
        }
    }
    .dark .swal2-popup {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        border: 1px solid #1e293b !important;
    }
    .swal2-title {
        font-weight: 800 !important;
        font-size: 1.25rem !important;
        color: #1e293b !important;
    }
    .dark .swal2-title {
        color: #f1f5f9 !important;
    }
    .swal2-html-container {
        font-size: 0.875rem !important;
        color: #64748b !important;
    }
    .dark .swal2-html-container {
        color: #94a3b8 !important;
    }
    .swal2-confirm {
        background-color: var(--color-primary) !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.8125rem !important;
        padding: 0.625rem 1.5rem !important;
        box-shadow: 0 4px 12px rgba(var(--color-primary-rgb), 0.2) !important;
    }
    .swal2-cancel {
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.8125rem !important;
        padding: 0.625rem 1.5rem !important;
    }

    /* Premium DataTables Export Buttons */
    .dt-buttons {
        display: inline-flex !important;
        gap: 0.5rem !important;
        margin-bottom: 0 !important;
    }
    .dt-button {
        border-radius: 0.75rem !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        padding: 0.5rem 1rem !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02) !important;
    }
    
    /* Excel default styles */
    .btn-export-excel {
        border: 1px solid #bbf7d0 !important; /* emerald-200 */
        color: #15803d !important; /* emerald-700 */
        background-color: #f0fdf4 !important; /* emerald-50 */
    }
    .dark .btn-export-excel {
        border: 1px solid rgba(34, 197, 94, 0.3) !important;
        color: #4ade80 !important; /* emerald-400 */
        background-color: rgba(20, 83, 45, 0.25) !important;
    }
    .btn-export-excel:hover {
        border-color: #22c55e !important; /* emerald-500 */
        color: white !important;
        background-color: #22c55e !important;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2) !important;
    }
    .dark .btn-export-excel:hover {
        border-color: #22c55e !important;
        color: white !important;
        background-color: #15803d !important;
    }

    /* PDF default styles */
    .btn-export-pdf {
        border: 1px solid #fecaca !important; /* red-200 */
        color: #b91c1c !important; /* red-700 */
        background-color: #fef2f2 !important; /* red-50 */
    }
    .dark .btn-export-pdf {
        border: 1px solid rgba(239, 68, 68, 0.3) !important;
        color: #f87171 !important; /* red-400 */
        background-color: rgba(127, 29, 29, 0.25) !important;
    }
    .btn-export-pdf:hover {
        border-color: #ef4444 !important; /* red-500 */
        color: white !important;
        background-color: #ef4444 !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2) !important;
    }
    .dark .btn-export-pdf:hover {
        border-color: #ef4444 !important;
        color: white !important;
        background-color: #b91c1c !important;
    }

    /* Print Media Styles */
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        body > *:not(#print-preview-modal) {
            display: none !important;
        }
        #print-preview-modal {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            height: auto !important;
            overflow: visible !important;
            background: white !important;
            display: flex !important;
        }
        #print-preview-modal > div:first-child {
            display: none !important; /* Ocultar barra superior en impresión */
        }
        #print-preview-modal > div:last-child {
            background: white !important;
            padding: 0 !important;
        }
        #print-preview-paper {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    /* Custom Select2 Premium styling matching dark mode and outfit font */
    .select2-container .select2-selection--single {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.75rem !important;
        height: 44px !important;
        transition: all 0.2s ease-in-out !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 0.5rem !important;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.02) !important;
    }
    .dark .select2-container .select2-selection--single {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.15) !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--color-primary, #E60067) !important;
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.15) !important;
        outline: none !important;
    }
    .dark .select2-container--default.select2-container--focus .select2-selection--single,
    .dark .select2-container--default.select2-container--open .select2-selection--single {
        box-shadow: 0 0 0 3px rgba(51, 65, 85, 0.4) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155 !important;
        font-family: 'Outfit', sans-serif !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        line-height: normal !important;
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
        display: flex !important;
        align-items: center !important;
        height: 100% !important;
        width: 100% !important;
    }
    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #cbd5e1 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
    .dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #64748b !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 0.75rem !important;
        top: 0 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        width: 20px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #94a3b8 transparent transparent transparent !important;
        border-width: 5px 4px 0 4px !important;
        border-style: solid !important;
        margin-left: 0 !important;
        margin-top: 0 !important;
        left: auto !important;
        top: auto !important;
        position: relative !important;
        transition: transform 0.2s ease-in-out !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        transform: rotate(180deg) !important;
        border-color: var(--color-primary, #E60067) transparent transparent transparent !important;
    }
    .dark .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #64748b transparent transparent transparent !important;
    }
    .select2-dropdown {
        background-color: white !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        z-index: 99999 !important;
        overflow: hidden !important;
        font-family: 'Outfit', sans-serif !important;
        margin-top: 4px !important;
    }
    .dark .select2-dropdown {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3) !important;
    }
    .select2-container--default .select2-search--dropdown {
        padding: 0.75rem !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .dark .select2-container--default .select2-search--dropdown {
        border-bottom-color: #334155 !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 0.75rem !important;
        font-family: 'Outfit', sans-serif !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        outline: none !important;
        color: #334155 !important;
        width: 100% !important;
    }
    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--color-primary, #E60067) !important;
        box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.15) !important;
    }
    .dark .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        box-shadow: 0 0 0 2px rgba(51, 65, 85, 0.4) !important;
    }
    .select2-container--default .select2-results__option {
        font-family: 'Outfit', sans-serif !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        padding: 0.625rem 1rem !important;
        color: #475569 !important;
        transition: background-color 0.15s, color 0.15s !important;
    }
    .dark .select2-container--default .select2-results__option {
        color: #cbd5e1 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: var(--color-primary, #E60067) !important;
        color: white !important;
    }
    .select2-container--default .select2-results__options {
        max-height: 200px !important;
        overflow-y: auto !important;
    }
</style>
