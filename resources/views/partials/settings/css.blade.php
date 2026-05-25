<style>
    /* Compact Select2 Custom overrides for settings view */
    .select2-container--default .select2-selection--single {
        height: 32px !important;
        padding: 0 0.4rem !important;
        border-radius: 0.75rem !important;
        background-color: #ffffff !important;
    }
    .dark .select2-container--default .select2-selection--single {
        background-color: #0f172a !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 11px !important;
        line-height: 30px !important;
        font-weight: 600 !important;
        padding-left: 0.25rem !important;
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .tab-btn.active { background-color: var(--color-primary); color: white; }

    .settings-save-bar {
        position: sticky;
        bottom: 0;
        z-index: 20;
        background: linear-gradient(to top, rgba(255,255,255,0.98) 70%, transparent);
    }
    .dark .settings-save-bar {
        background: linear-gradient(to top, rgba(15,23,42,0.98) 70%, transparent);
    }

    /* Escritorio: contenido de configuración un poco más grande */
    @media (min-width: 768px) {
        .settings-page .select2-container--default .select2-selection--single {
            height: 38px !important;
            padding: 0 0.5rem !important;
        }
        .settings-page .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 13px !important;
            line-height: 36px !important;
        }

        .settings-page label {
            font-size: 0.75rem !important;
        }

        .settings-page input:not([type="color"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="hidden"]),
        .settings-page select,
        .settings-page textarea {
            font-size: 0.8125rem !important;
        }

        .settings-page input:not([type="color"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="hidden"]),
        .settings-page select {
            min-height: 2.375rem;
        }

        .settings-page textarea {
            min-height: 3.5rem;
        }

        .settings-page .settings-help-text,
        .settings-page p.text-\[9px\],
        .settings-page span.text-\[9px\],
        .settings-page code {
            font-size: 0.6875rem !important;
        }

        .settings-page .settings-section-chip {
            font-size: 0.625rem !important;
        }
    }

    @media (min-width: 1024px) {
        .settings-page .select2-container--default .select2-selection--single {
            height: 42px !important;
        }
        .settings-page .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 14px !important;
            line-height: 40px !important;
        }

        .settings-page label {
            font-size: 0.8125rem !important;
        }

        .settings-page input:not([type="color"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="hidden"]),
        .settings-page select,
        .settings-page textarea {
            font-size: 0.875rem !important;
        }

        .settings-page input:not([type="color"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="hidden"]),
        .settings-page select {
            min-height: 2.5rem;
        }

        .settings-page .settings-help-text,
        .settings-page p.text-\[9px\],
        .settings-page span.text-\[9px\] {
            font-size: 0.75rem !important;
        }
    }
</style>
