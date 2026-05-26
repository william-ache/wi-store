<!-- PRINT PREVIEW OVERLAY -->
<div id="print-preview-modal" class="fixed inset-0 z-[100] overflow-y-auto bg-slate-900/60 backdrop-blur-sm hidden flex-col select-text">
    <!-- Top Bar -->
    <div class="px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-md" style="background-color: var(--color-primary, #E60067) !important; color: var(--color-on-primary) !important;">
        <div class="flex items-center gap-2.5 font-bold">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span class="text-sm tracking-wide">Vista Previa de Impresión</span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="triggerPrint()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Guardar como PDF / Imprimir</span>
            </button>
            <button onclick="closePrintPreview()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-bold text-xs px-4 py-2 rounded-lg transition">
                ✕ Cerrar Vista Previa
            </button>
        </div>
    </div>
    
    <!-- Document Container -->
    <div class="flex-grow overflow-y-auto px-4 md:px-8 py-8 flex justify-center bg-slate-100 dark:bg-slate-900/40">
        <!-- The Paper (A4 / Letter Styled) -->
        <div id="print-preview-paper" class="bg-white text-slate-800 w-full max-w-4xl p-12 my-4 shadow-2xl rounded-sm border border-slate-200 flex flex-col justify-between" style="min-height: 297mm; font-family: 'Outfit', sans-serif;">
            <div>
                <!-- Header Section -->
                <div class="border-b-2 border-slate-800 pb-6 mb-8 flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase leading-none">{{ config('current_shop')->name ?? 'Mi Tienda' }}</h2>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1.5">Sistema Integrado de Control Administrativo (SICA)</p>
                    </div>
                    <div class="text-right text-xs text-slate-600">
                        <p class="font-bold text-slate-800" id="preview-report-title">Reporte de Inventario</p>
                        <p class="mt-1">Fecha Emisión: <span class="font-bold text-slate-800">{{ date('d/m/Y') }}</span></p>
                        <p class="mt-0.5">Registros: <span class="font-bold text-slate-800" id="preview-record-count">0</span></p>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse text-xs border border-slate-300" id="preview-table">
                        <!-- Dynamic columns & rows will be injected here -->
                    </table>
                </div>
            </div>
            
            <!-- Footer Section -->
            <div class="border-t border-slate-200 pt-6 mt-12 flex justify-between items-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                <span>© {{ date('Y') }} {{ config('current_shop')->name }}. Todos los derechos reservados.</span>
                <span>Reporte Autogenerado por WIStore SICA</span>
            </div>
        </div>
    </div>
</div>
