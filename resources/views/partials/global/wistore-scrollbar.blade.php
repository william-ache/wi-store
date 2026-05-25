{{-- Mismos colores que #landing-scroll-progress: purple-500 → fuchsia-500 → cyan-400 --}}
<style>
    .scrollbar-none::-webkit-scrollbar,
    .hide-scrollbar::-webkit-scrollbar {
        display: none !important;
    }
    .scrollbar-none,
    .hide-scrollbar {
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    html.wistore-ui {
        scroll-behavior: smooth;
        scrollbar-width: thin;
        /* purple-500 / fuchsia-500 (Firefox) */
        scrollbar-color: #d946ef transparent;
    }

    html.wistore-ui ::-webkit-scrollbar,
    html.wistore-ui .wistore-scrollbar::-webkit-scrollbar,
    html.wistore-ui .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    html.wistore-ui ::-webkit-scrollbar-track,
    html.wistore-ui .wistore-scrollbar::-webkit-scrollbar-track,
    html.wistore-ui .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(30, 36, 62, 0.4);
    }

    html.wistore-ui ::-webkit-scrollbar-thumb,
    html.wistore-ui .wistore-scrollbar::-webkit-scrollbar-thumb,
    html.wistore-ui .custom-scrollbar::-webkit-scrollbar-thumb {
        /* from-purple-500 via-fuchsia-500 to-cyan-400 (vertical) */
        background: linear-gradient(
            180deg,
            #a855f7 0%,
            #d946ef 50%,
            #22d3ee 100%
        );
        border-radius: 9999px;
    }

    html.wistore-ui ::-webkit-scrollbar-thumb:hover,
    html.wistore-ui .wistore-scrollbar::-webkit-scrollbar-thumb:hover,
    html.wistore-ui .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(
            180deg,
            #c084fc 0%,
            #e879f9 50%,
            #67e8f9 100%
        );
    }

    html.wistore-ui.dark,
    .dark html.wistore-ui {
        scrollbar-color: #d946ef transparent;
    }
</style>
