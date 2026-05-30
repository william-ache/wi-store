<header class="sa-navbar h-14 md:h-16 px-4 md:px-6 flex items-center justify-between gap-4">
    <div class="flex items-center gap-3 min-w-0">
        <button type="button"
                class="sa-sidebar-toggle lg:hidden w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 flex items-center justify-center shrink-0"
                onclick="document.querySelector('.sa-sidebar')?.classList.toggle('is-open')"
                aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>
        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-cyan-500 flex items-center justify-center shrink-0 shadow-md shadow-purple-500/20">
            <i class="fas fa-cubes text-white text-sm" aria-hidden="true"></i>
        </div>
        <div class="min-w-0">
            <p class="text-sm font-black text-slate-900 truncate">WYDEX SaaS</p>
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Panel administrativo</p>
        </div>
        @if (($pendingCount ?? 0) > 0)
            <span class="hidden sm:inline-flex items-center gap-1.5 bg-rose-50 border border-rose-200 text-rose-700 px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse" aria-hidden="true"></span>
                {{ $pendingCount }} pago(s)
            </span>
        @endif
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('home') }}" class="sa-btn-ghost text-xs px-3 py-2 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left text-[10px]" aria-hidden="true"></i>
            <span class="hidden sm:inline">Web</span>
        </a>
        <form action="{{ route('super-admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="sa-btn-danger text-xs px-3 py-2 inline-flex items-center gap-2">
                <i class="fas fa-sign-out-alt text-[10px]" aria-hidden="true"></i>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </form>
    </div>
</header>
