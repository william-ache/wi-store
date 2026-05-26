    html.wistore-ui.wistore-admin {
        scrollbar-width: thin;
        scrollbar-color: var(--color-primary) transparent;
        overflow-y: auto;
        overflow-x: hidden;
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 0;
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar:horizontal,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar:horizontal,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar:horizontal {
        height: 0;
        display: none;
    }

    html.wistore-ui.wistore-admin ::-webkit-scrollbar-track,
    html.wistore-ui.wistore-admin .wistore-scrollbar::-webkit-scrollbar-track,
    html.wistore-ui.wistore-admin .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
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
