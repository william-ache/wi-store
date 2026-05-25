    html.wistore-ui.wistore-admin {
        scrollbar-width: thin;
        scrollbar-color: var(--color-primary) transparent;
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar-track,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar-track,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(var(--color-primary-rgb), 0.08);
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar-thumb,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar-thumb,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 9999px;
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar-thumb:hover,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar-thumb:hover,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        filter: brightness(1.12);
    }

    html.wistore-ui.wistore-admin.dark,
    .dark html.wistore-ui.wistore-admin {
        scrollbar-color: var(--color-primary) transparent;
    }
