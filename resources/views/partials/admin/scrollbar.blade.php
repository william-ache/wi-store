    html.wi-store-ui.wi-store-admin {
        scrollbar-width: thin;
        scrollbar-color: var(--color-primary) transparent;
        overflow-y: auto;
        overflow-x: hidden;
    }

    html.wi-store-ui.wi-store-admin ::-webkit-scrollbar,
    html.wi-store-ui.wi-store-admin .wi-store-scrollbar::-webkit-scrollbar,
    html.wi-store-ui.wi-store-admin .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 0;
    }

    html.wi-store-ui.wi-store-admin ::-webkit-scrollbar:horizontal,
    html.wi-store-ui.wi-store-admin .wi-store-scrollbar::-webkit-scrollbar:horizontal,
    html.wi-store-ui.wi-store-admin .custom-scrollbar::-webkit-scrollbar:horizontal {
        height: 0;
        display: none;
    }

    html.wi-store-ui.wi-store-admin ::-webkit-scrollbar-track,
    html.wi-store-ui.wi-store-admin .wi-store-scrollbar::-webkit-scrollbar-track,
    html.wi-store-ui.wi-store-admin .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    html.wi-store-ui.wi-store-admin ::-webkit-scrollbar-thumb,
    html.wi-store-ui.wi-store-admin .wi-store-scrollbar::-webkit-scrollbar-thumb,
    html.wi-store-ui.wi-store-admin .custom-scrollbar::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 9999px;
    }

    html.wi-store-ui.wi-store-admin ::-webkit-scrollbar-thumb:hover,
    html.wi-store-ui.wi-store-admin .wi-store-scrollbar::-webkit-scrollbar-thumb:hover,
    html.wi-store-ui.wi-store-admin .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        filter: brightness(1.12);
    }

    html.wi-store-ui.wi-store-admin.dark,
    .dark html.wi-store-ui.wi-store-admin {
        scrollbar-color: var(--color-primary) transparent;
    }
