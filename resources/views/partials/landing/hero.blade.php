<section id="inicio" class="landing-hero-surface relative z-10">
  <div class="landing-hero-grid absolute pointer-events-none z-0" aria-hidden="true"></div>
  <div class="landing-hero-glow absolute pointer-events-none z-0" aria-hidden="true"></div>
  <div class="landing-section-glow top-[8%] -left-24 w-[26rem] h-[26rem] bg-purple-400/20 z-0" aria-hidden="true"></div>
  <div class="landing-section-glow top-[4%] -right-24 w-[28rem] h-[28rem] bg-cyan-400/22 z-0" aria-hidden="true"></div>
  <div class="landing-section-glow bottom-[10%] left-[12%] w-[20rem] h-[20rem] bg-fuchsia-400/14 z-0" aria-hidden="true"></div>

  <div class="landing-hero-inner landing-container relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-center">

      {{-- Columna izquierda --}}
      <div class="text-left max-w-2xl">
        <p class="inline-flex items-center gap-2.5 text-xs md:text-[13px] font-bold uppercase tracking-[0.18em] text-slate-500 mb-6 md:mb-7">
          <span class="w-2 h-2 rounded-full bg-gradient-to-r from-purple-500 to-cyan-500 shrink-0" aria-hidden="true"></span>
          Menú digital comercial
        </p>

        <h1 class="text-[2.35rem] sm:text-[2.9rem] lg:text-[3.25rem] xl:text-[3.65rem] font-black tracking-tight text-slate-900 leading-[1.05]">
          Tu negocio vende solo con un menú por
          <span class="text-purple-700">WhatsApp</span>
        </h1>

        <p class="landing-hero-lead mt-5 md:mt-6 text-base md:text-lg xl:text-xl leading-relaxed max-w-xl">
          Arma tu catálogo con fotos y precios. Tus clientes eligen y los pedidos te llegan ordenados al WhatsApp o Telegram.
          <span class="text-slate-800 font-semibold">Listo en minutos</span>, sin saber de páginas web.
        </p>

        <div class="mt-7 md:mt-8 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3.5 sm:gap-4.5">
          <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
            <a href="/register"
               class="inline-flex items-center gap-2 pl-5 pr-2 py-2 rounded-full bg-gradient-to-r from-purple-600 to-cyan-500 hover:brightness-105 text-white font-bold text-sm shadow-md shadow-purple-500/20 active:scale-[0.98] transition-all shrink-0">
              <span class="leading-none">Probar gratis {{ $wiStoreTrialDays }} días</span>
              <span class="w-7 h-7 shrink-0 rounded-full bg-slate-900 inline-flex items-center justify-center" aria-hidden="true">
                <i class="fas fa-arrow-right text-white text-[10px] leading-none"></i>
              </span>
            </a>

            <a href="https://www.trustpilot.com/review/wi-store.com?utm_medium=trustbox&utm_source=TrustBoxReviewCollector"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center"
               aria-label="Ver reseñas de WI-Store en Trustpilot">
              <img src="{{ asset('images/trustpilot-stars.png') }}"
                   alt="Trustpilot 5 estrellas"
                   width="80"
                   height="44"
                   loading="lazy"
                   decoding="async"
                   class="h-20 w-full rounded-md">
            </a>
          </div>

          <div class="landing-hero-social flex items-center gap-3 min-w-0">
            <div class="landing-hero-social__stack flex items-center shrink-0" aria-hidden="true">
              @foreach ([
                ['sabores-yb.png', 'Sabores Y&B'],
                ['ys-detallitos.png', 'YS Detallitos'],
                ['dulces-antojitos.png', 'Dulces Antojitos'],
                ['rey-david.png', 'Rey David Cakes'],
              ] as [$proofFile, $proofName])
                <span class="landing-hero-social__avatar">
                  <img src="{{ asset('images/landing/social-proof/' . $proofFile) }}"
                       alt="{{ $proofName }}"
                       width="36"
                       height="36"
                       loading="lazy"
                       decoding="async"
                       class="w-full h-full object-cover">
                </span>
              @endforeach
              <span class="landing-hero-social__avatar landing-hero-social__avatar--count">+50</span>
            </div>
            <p class="text-sm text-slate-600 leading-snug min-w-0">
              <span class="font-bold text-slate-800">+50</span>
              negocios y emprendedores usan
              <span class="landing-hero-social__brand" aria-label="WI-Store">WI-Store</span>
            </p>
          </div>
        </div>

        <p class="mt-9 md:mt-10 lg:mt-12 text-[11px] md:text-xs font-bold uppercase tracking-[0.14em] text-slate-500">
          {{ $wiStoreTrialLabel }} · Activo en minutos · Cancelas cuando quieras
        </p>
      </div>

      {{-- Columna derecha: cards flotantes (estilo dashboard) --}}
      <div class="relative flex justify-center lg:justify-end min-h-[19rem] md:min-h-[22rem] xl:min-h-[26rem] overflow-x-clip px-1 sm:px-0">
        {{-- Card principal: pedido en vivo --}}
        <div class="landing-float-card relative w-full max-w-[300px] sm:max-w-[320px] xl:max-w-[340px] bg-white rounded-2xl border border-slate-200/90 shadow-xl shadow-slate-300/40 p-4 sm:p-5 xl:p-6 z-10">
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
        <div class="landing-float-card landing-float-card--delay relative mt-3 ml-auto w-[min(100%,180px)] sm:absolute sm:mt-0 sm:-bottom-1 sm:right-1 lg:right-2 sm:w-[195px] xl:w-[210px] bg-white rounded-2xl border border-slate-200/90 shadow-lg shadow-slate-300/30 p-3.5 sm:p-4 z-20">
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
        <div class="absolute -top-8 -left-12 w-48 h-48 md:w-56 md:h-56 rounded-full bg-purple-400/20 blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute bottom-8 left-0 w-36 h-36 rounded-full bg-cyan-400/22 blur-2xl pointer-events-none" aria-hidden="true"></div>
      </div>
    </div>
  </div>

  <div class="landing-hero-scroll-wrap shrink-0 flex justify-center pt-2 pb-1">
    <button type="button"
            @click="scrollTo('por-que')"
            class="landing-hero-scroll-hint group"
            aria-label="Ver la siguiente sección">
      <span class="landing-hero-scroll-hint__ring" aria-hidden="true"></span>
      <i class="fas fa-chevron-down" aria-hidden="true"></i>
    </button>
  </div>
</section>
