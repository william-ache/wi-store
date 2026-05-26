{{-- Scrollbar marketing WI-Store (solo landing y páginas públicas de marca) --}}
<style>
    html.wi-store-ui.wi-store-landing {
        scroll-behavior: smooth;
        scrollbar-width: thin;
        scrollbar-color: #d946ef transparent;
    }

    html.wi-store-ui.wi-store-landing ::-webkit-scrollbar,
    html.wi-store-ui.wi-store-landing .wi-store-scrollbar::-webkit-scrollbar,
    html.wi-store-ui.wi-store-landing .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    html.wi-store-ui.wi-store-landing ::-webkit-scrollbar-track,
    html.wi-store-ui.wi-store-landing .wi-store-scrollbar::-webkit-scrollbar-track,
    html.wi-store-ui.wi-store-landing .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(30, 36, 62, 0.4);
    }

    html.wi-store-ui.wi-store-landing ::-webkit-scrollbar-thumb,
    html.wi-store-ui.wi-store-landing .wi-store-scrollbar::-webkit-scrollbar-thumb,
    html.wi-store-ui.wi-store-landing .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #a855f7 0%, #d946ef 50%, #22d3ee 100%);
        border-radius: 9999px;
    }

    html.wi-store-ui.wi-store-landing ::-webkit-scrollbar-thumb:hover,
    html.wi-store-ui.wi-store-landing .wi-store-scrollbar::-webkit-scrollbar-thumb:hover,
    html.wi-store-ui.wi-store-landing .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #c084fc 0%, #e879f9 50%, #67e8f9 100%);
    }
</style>
