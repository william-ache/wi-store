{{-- Scrollbar marketing WIStore (solo landing y páginas públicas de marca) --}}
<style>
    html.wistore-ui.wistore-landing {
        scroll-behavior: smooth;
        scrollbar-width: thin;
        scrollbar-color: #d946ef transparent;
    }

    html.wistore-ui.wistore-landing ::-webkit-scrollbar,
    html.wistore-ui.wistore-landing .wistore-scrollbar::-webkit-scrollbar,
    html.wistore-ui.wistore-landing .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    html.wistore-ui.wistore-landing ::-webkit-scrollbar-track,
    html.wistore-ui.wistore-landing .wistore-scrollbar::-webkit-scrollbar-track,
    html.wistore-ui.wistore-landing .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(30, 36, 62, 0.4);
    }

    html.wistore-ui.wistore-landing ::-webkit-scrollbar-thumb,
    html.wistore-ui.wistore-landing .wistore-scrollbar::-webkit-scrollbar-thumb,
    html.wistore-ui.wistore-landing .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #a855f7 0%, #d946ef 50%, #22d3ee 100%);
        border-radius: 9999px;
    }

    html.wistore-ui.wistore-landing ::-webkit-scrollbar-thumb:hover,
    html.wistore-ui.wistore-landing .wistore-scrollbar::-webkit-scrollbar-thumb:hover,
    html.wistore-ui.wistore-landing .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #c084fc 0%, #e879f9 50%, #67e8f9 100%);
    }
</style>
