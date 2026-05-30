<section class="marketplace-soon" aria-labelledby="marketplace-soon-heading">
    <div class="marketplace-soon__card rounded-[2rem] border border-slate-200/90 bg-white/90 backdrop-blur-sm shadow-xl shadow-slate-200/50 px-8 py-12 sm:px-10 md:px-14 md:py-16 text-center">
        <div class="marketplace-soon__icon mx-auto mb-6" aria-hidden="true">
            <span class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gradient-to-br from-purple-100 to-cyan-100 border border-purple-200/60 text-3xl md:text-4xl">
                🏪
            </span>
        </div>

        <span class="landing-plan-badge landing-plan-badge--emprendedor text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-full">
            Próximamente
        </span>

        <h1 id="marketplace-soon-heading" class="text-2xl md:text-4xl font-black text-slate-900 mt-5 tracking-tight">
            Marketplace de tiendas afiliadas
        </h1>

        <p class="text-sm md:text-base text-slate-600 mt-4 max-w-xl mx-auto leading-relaxed">
            Muy pronto podrás explorar las tiendas afiliadas a WI-Store, buscar por categoría y zona, y encontrar en un solo lugar lo que necesitas, donde lo necesites.
        </p>

        <ul class="marketplace-soon__features mt-8 md:mt-10 text-left max-w-md mx-auto space-y-3 px-1 sm:px-2" aria-label="Funciones que llegarán">
            <li class="marketplace-soon__feature flex items-start gap-3 rounded-xl border border-slate-200/80 bg-slate-50/80 px-5 py-3.5">
                <span class="marketplace-soon__feature-icon shrink-0 w-9 h-9 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center" aria-hidden="true">
                    <i class="fas fa-store text-sm"></i>
                </span>
                <span class="text-sm text-slate-600 leading-snug pt-1">
                    <strong class="text-slate-800 font-bold block text-xs uppercase tracking-wide mb-0.5">Directorio</strong>
                    Tiendas afiliadas verificadas en un solo espacio.
                </span>
            </li>
            <li class="marketplace-soon__feature flex items-start gap-3 rounded-xl border border-slate-200/80 bg-slate-50/80 px-5 py-3.5">
                <span class="marketplace-soon__feature-icon shrink-0 w-9 h-9 rounded-lg bg-cyan-100 text-cyan-700 flex items-center justify-center" aria-hidden="true">
                    <i class="fas fa-magnifying-glass text-sm"></i>
                </span>
                <span class="text-sm text-slate-600 leading-snug pt-1">
                    <strong class="text-slate-800 font-bold block text-xs uppercase tracking-wide mb-0.5">Búsqueda inteligente</strong>
                    Filtra por nombre, categoría, zona y tipo de servicio.
                </span>
            </li>
            <li class="marketplace-soon__feature flex items-start gap-3 rounded-xl border border-slate-200/80 bg-slate-50/80 px-5 py-3.5">
                <span class="marketplace-soon__feature-icon shrink-0 w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center" aria-hidden="true">
                    <i class="fas fa-location-dot text-sm"></i>
                </span>
                <span class="text-sm text-slate-600 leading-snug pt-1">
                    <strong class="text-slate-800 font-bold block text-xs uppercase tracking-wide mb-0.5">Cerca de ti</strong>
                    Encuentra comercios y entra a su canal de venta en un clic.
                </span>
            </li>
        </ul>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-8 md:mt-10">
            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 rounded-full border border-slate-200 bg-white text-slate-800 font-bold text-sm hover:border-purple-300 hover:text-purple-800 transition-colors">
                <i class="fas fa-arrow-left text-[10px]" aria-hidden="true"></i>
                Volver al inicio
            </a>
            <a href="/register"
               class="landing-plan-btn landing-plan-btn--negocio inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 rounded-full text-white font-extrabold text-sm">
                Crear mi tienda
            </a>
        </div>

        <p class="text-[11px] text-slate-400 mt-6 max-w-sm mx-auto leading-relaxed">
            ¿Tienes un negocio? Regístrate ahora y prepárate para aparecer en el directorio cuando abramos el marketplace.
        </p>
    </div>
</section>
