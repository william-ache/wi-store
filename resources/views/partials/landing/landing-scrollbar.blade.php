{{-- Scrollbar marketing WI-Store (solo landing y páginas públicas de marca) --}}
<style>
    html.wi-store-ui.wi-store-landing {
        scrollbar-width: thin;
        scrollbar-color: #a855f7 #f1f5f9;
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
        background: #f1f5f9;
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
        background: linear-gradient(180deg, #9333ea 0%, #c026d3 50%, #06b6d4 100%);
    }
</style>
