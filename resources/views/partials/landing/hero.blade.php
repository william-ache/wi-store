<section id="inicio" class="relative z-10">
  <div class="landing-hero-grid absolute pointer-events-none z-0" aria-hidden="true"></div>
  <div class="landing-hero-glow absolute pointer-events-none z-0" aria-hidden="true"></div>

  <div class="landing-hero-inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

      {{-- Columna izquierda --}}
      <div class="text-left max-w-2xl">
        <p class="inline-flex items-center gap-2.5 text-xs md:text-[13px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-6 md:mb-7">
          <span class="w-2 h-2 rounded-full bg-gradient-to-r from-purple-500 to-cyan-500 shrink-0" aria-hidden="true"></span>
          Menú digital comercial
        </p>

        <h1 class="text-[2.6rem] sm:text-[3.15rem] lg:text-[3.65rem] font-black tracking-tight text-slate-900 leading-[1.05]">
          Tu negocio vende solo con un menú por
          <span class="text-purple-700">WhatsApp</span>
        </h1>

        <p class="mt-6 md:mt-7 text-lg md:text-xl text-slate-500 leading-relaxed max-w-xl">
          Arma tu catálogo con fotos y precios. Tus clientes eligen y los pedidos te llegan ordenados al WhatsApp o Telegram.
          <span class="text-slate-700 font-medium">Listo en minutos</span>, sin saber de páginas web.
        </p>

        <div class="mt-8 md:mt-10 flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2.5 sm:gap-3">
          <a href="/register"
             class="inline-flex items-center justify-between sm:justify-start gap-2.5 pl-5 pr-1.5 py-2 rounded-full bg-gradient-to-r from-purple-600 to-cyan-500 hover:brightness-105 text-white font-bold text-sm shadow-md shadow-purple-500/20 active:scale-[0.98] transition-all min-h-[2.75rem]">
            <span>Probar gratis {{ $wiStoreTrialDays }} días</span>
            <span class="w-7 h-7 shrink-0 rounded-full bg-slate-900 flex items-center justify-center" aria-hidden="true">
              <i class="fas fa-arrow-right text-white text-[10px]"></i>
            </span>
          </a>
          <button type="button" @click="scrollTo('por-que')"
                  class="inline-flex items-center justify-center gap-1.5 px-5 py-2 rounded-full border-2 border-slate-900 bg-white hover:bg-slate-50 text-slate-900 font-bold text-sm active:scale-[0.98] transition-all min-h-[2.75rem]">
            Saber más
            <i class="fas fa-chevron-down text-xs opacity-70" aria-hidden="true"></i>
          </button>
        </div>

        <p class="mt-14 md:mt-16 text-[11px] md:text-xs font-bold uppercase tracking-[0.14em] text-slate-400">
          {{ $wiStoreTrialLabel }} · Activo en minutos · Cancelas cuando quieras
        </p>
      </div>

      {{-- Columna derecha: cards flotantes (estilo dashboard) --}}
      <div class="relative flex justify-center lg:justify-end min-h-[22rem] md:min-h-[26rem]">
        {{-- Card principal: pedido en vivo --}}
        <div class="landing-float-card relative w-full max-w-[340px] bg-white rounded-2xl border border-slate-200/90 shadow-xl shadow-slate-300/40 p-5 md:p-6 z-10">
          <div class="flex items-start justify-between gap-3 mb-5">
            <div>
              <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pedido</p>
              <p class="text-lg font-black text-slate-900 tabular-nums">#4281</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wide px-2.5 py-1 rounded-full bg-cyan-100 text-cyan-800 border border-cyan-200">
              <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse" aria-hidden="true"></span>
              En vivo
            </span>
          </div>

          <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Estado</p>
          <p class="text-sm font-bold text-slate-800 mb-4">Listo para entregar</p>

          <div class="flex items-start justify-between gap-0.5 mb-6" role="list" aria-label="Progreso del pedido">
            @foreach (['Recibido', 'Preparando', 'Listo', 'Entregado'] as $i => $step)
              <div class="flex flex-col items-center gap-1.5 flex-1 min-w-0" role="listitem">
                <span class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black
                    {{ $i < 3 ? 'bg-gradient-to-br from-purple-500 to-cyan-500 text-white shadow-md shadow-purple-500/20' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                  @if ($i < 3)
                    <i class="fas fa-check text-[9px]" aria-hidden="true"></i>
                  @else
                    <span class="w-2 h-2 rounded-full bg-slate-300" aria-hidden="true"></span>
                  @endif
                </span>
                <span class="text-[8px] md:text-[9px] font-bold text-slate-500 text-center leading-tight truncate w-full px-0.5">{{ $step }}</span>
              </div>
              @if (!$loop->last)
                <div class="w-full max-w-3 h-0.5 mt-4 rounded-full flex-shrink {{ $i < 2 ? 'bg-gradient-to-r from-purple-300 to-cyan-300' : 'bg-slate-200' }}" aria-hidden="true"></div>
              @endif
            @endforeach
          </div>

          <div class="flex items-end justify-between pt-4 border-t border-slate-100">
            <div>
              <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total · 3 items</p>
            </div>
            <p class="text-2xl font-black text-slate-900 tabular-nums">$24.50</p>
          </div>
        </div>

        {{-- Card secundaria: ventas --}}
        <div class="landing-float-card landing-float-card--delay absolute -bottom-2 -right-2 sm:right-0 lg:-right-4 w-[min(100%,200px)] sm:w-[210px] bg-white rounded-2xl border border-slate-200/90 shadow-lg shadow-slate-300/30 p-4 z-20">
          <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Ventas hoy</p>
          <div class="flex items-end justify-between gap-2 mt-1">
            <p class="text-xl font-black text-slate-900 tabular-nums">$487</p>
            <span class="text-[11px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md border border-emerald-100">+12%</span>
          </div>
          <div class="flex items-end justify-between gap-1 h-12 mt-3" aria-hidden="true">
            @foreach ([28, 42, 35, 58, 48, 72, 65] as $h)
              <span class="flex-1 rounded-sm bg-gradient-to-t from-purple-500 to-cyan-400 opacity-90"
                    style="height: {{ $h }}%"></span>
            @endforeach
          </div>
        </div>

        {{-- Acento decorativo --}}
        <div class="absolute -top-6 -left-4 w-28 h-28 rounded-full bg-purple-400/25 blur-2xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute bottom-8 left-0 w-36 h-36 rounded-full bg-cyan-400/22 blur-2xl pointer-events-none" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</section>
