{{-- Scroll delgado WIStore (morado → fucsia → cian). No usar en store/index (menú digital). --}}
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
        scrollbar-color: #c084fc transparent;
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
        background: transparent;
    }

    html.wistore-ui ::-webkit-scrollbar-thumb,
    html.wistore-ui .wistore-scrollbar::-webkit-scrollbar-thumb,
    html.wistore-ui .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(
            180deg,
            #7c3aed 0%,
            #c026d3 18%,
            #ec4899 34%,
            #22d3ee 52%,
            #3b82f6 70%,
            #8b5cf6 100%
        );
        border-radius: 9999px;
    }

    html.wistore-ui ::-webkit-scrollbar-thumb:hover,
    html.wistore-ui .wistore-scrollbar::-webkit-scrollbar-thumb:hover,
    html.wistore-ui .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(
            180deg,
            #8b5cf6 0%,
            #d946ef 18%,
            #f472b6 34%,
            #67e8f9 52%,
            #60a5fa 70%,
            #a78bfa 100%
        );
    }

    html.wistore-ui.dark,
    .dark html.wistore-ui {
        scrollbar-color: #e879f9 transparent;
    }
</style>
