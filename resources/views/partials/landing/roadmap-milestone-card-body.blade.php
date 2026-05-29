<div class="roadmap-card roadmap-card--{{ $m['tone'] }}">
    <div class="roadmap-card__inner">
        <div class="roadmap-card__badge-icon" aria-hidden="true">
            <i class="fas {{ $m['icon'] }}"></i>
        </div>
        <div class="roadmap-card__meta">
            <span class="roadmap-tag {{ $m['tag_bg'] }}">{{ $m['quarter'] }}</span>
            <span class="roadmap-status {{ $m['status_class'] }}">{{ $m['status'] }}</span>
        </div>
        <h3 class="roadmap-title">{{ $m['title'] }}</h3>
        <p class="roadmap-desc">{{ $m['desc'] }}</p>
        @if (!empty($m['extra']))
            <div class="roadmap-card__extras">
                <span class="roadmap-extra-tag text-emerald-300 bg-emerald-500/10 border-emerald-500/25">
                    <span class="w-1 h-1 rounded-full bg-emerald-400"></span> Venezuela · Activo
                </span>
                <span class="roadmap-extra-tag text-yellow-200 bg-yellow-400/10 border-yellow-400/25">
                    <span class="w-1 h-1 rounded-full bg-yellow-400"></span> Colombia · 2026
                </span>
            </div>
        @endif
    </div>
</div>
