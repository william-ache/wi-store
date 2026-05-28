@php
    $shareUrl = $shareUrl ?? url('/') . '#como-funciona';
    $shareTitle = $shareTitle ?? 'Tutorial WI-Store — Así de fácil funciona';
    $poster = $poster ?? null;
    $sources = collect($sources ?? [
        ['label' => '1080p', 'src' => ''],
        ['label' => '720p', 'src' => ''],
        ['label' => '480p', 'src' => ''],
    ])->filter(fn ($q) => ! empty($q['src']))->values();
    $hasVideo = $sources->isNotEmpty();
    if (! $hasVideo) {
        $sources = collect([['label' => 'Auto', 'src' => '']]);
    }
    $tutorialPlayerConfig = [
        'qualities' => $sources->values()->all(),
        'shareUrl' => $shareUrl,
        'shareTitle' => $shareTitle,
        'hasVideo' => $hasVideo,
    ];
@endphp

@include('partials.landing.tutorial-video-script')

<div
    class="landing-tutorial-player rounded-2xl border border-purple-200 overflow-hidden shadow-xl shadow-purple-500/10 bg-white"
    x-data="landingTutorialPlayer({{ \Illuminate\Support\Js::from($tutorialPlayerConfig) }})"
    @keydown.window.escape="closeMenus()">
    <div class="relative w-full aspect-video md:aspect-[21/9] min-h-[220px] md:min-h-[280px] bg-gradient-to-br from-[#1a1030] via-[#0e1228] to-[#0a1628] group">
        <video
            x-ref="video"
            class="w-full h-full object-contain bg-black"
            playsinline
            preload="metadata"
            @click="togglePlay()"
            @play="playing = true"
            @pause="playing = false"
            @volumechange="volume = $refs.video.volume"
            @loadedmetadata="onLoaded()"
            @ended="playing = false"
            @timeupdate="progress = $refs.video.duration ? ($refs.video.currentTime / $refs.video.duration) * 100 : 0"
            aria-label="Tutorial WI-Store"></video>

        {{-- Placeholder sin video --}}
        <div
            x-show="!hasVideo"
            class="absolute inset-0 flex flex-col items-center justify-center gap-2 px-6 text-center pointer-events-none"
            aria-hidden="true">
            <p class="text-2xl md:text-4xl font-black uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-purple-300 via-fuchsia-200 to-cyan-300">
                Próximamente
            </p>
            <p class="text-[11px] md:text-xs text-slate-500 font-semibold">Tutorial en video paso a paso</p>
        </div>

        {{-- Play central --}}
        <button
            type="button"
            x-show="hasVideo && !playing"
            @click.stop="togglePlay()"
            class="absolute inset-0 flex items-center justify-center bg-black/25 opacity-0 group-hover:opacity-100 focus:opacity-100 transition-opacity"
            aria-label="Reproducir tutorial">
            <span class="w-14 h-14 rounded-full bg-gradient-to-r from-purple-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-purple-500/30 border border-white/20">
                <i class="fas fa-play text-white text-lg ml-0.5" aria-hidden="true"></i>
            </span>
        </button>

        {{-- Barra de progreso fina --}}
        <div class="absolute bottom-12 left-0 right-0 h-0.5 bg-white/10" x-show="hasVideo" aria-hidden="true">
            <div class="h-full bg-gradient-to-r from-purple-500 to-cyan-400 transition-all duration-150" :style="'width:' + progress + '%'"></div>
        </div>

        {{-- Controles personalizados --}}
        <div class="absolute bottom-0 left-0 right-0 px-3 py-2.5 bg-gradient-to-t from-[#0a0f1f]/95 via-[#0e1228]/90 to-transparent border-t border-white/5">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <div class="flex items-center gap-1">
                    <button type="button" @click.stop="volumeDown()" :disabled="!hasVideo"
                        class="landing-tutorial-btn" title="Bajar volumen" aria-label="Bajar volumen">
                        <i class="fas fa-volume-down text-xs" aria-hidden="true"></i>
                    </button>
                    <span class="text-[10px] font-bold text-slate-300 tabular-nums w-8 text-center" x-text="Math.round(volume * 100)" aria-live="polite"></span>
                    <button type="button" @click.stop="volumeUp()" :disabled="!hasVideo"
                        class="landing-tutorial-btn" title="Subir volumen" aria-label="Subir volumen">
                        <i class="fas fa-volume-up text-xs" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="flex items-center gap-1.5">
                    {{-- Calidad --}}
                    <div class="relative" @click.outside="menuOpen === 'quality' && (menuOpen = null)">
                        <button type="button" @click.stop="toggleMenu('quality')" :disabled="!hasVideo || qualities.length < 2"
                            class="landing-tutorial-btn landing-tutorial-btn--label min-w-[4.5rem]"
                            :class="!hasVideo || qualities.length < 2 ? 'opacity-50 cursor-not-allowed' : ''"
                            aria-label="Calidad de video"
                            :aria-expanded="menuOpen === 'quality'">
                            <span x-text="qualities[currentQuality] ? qualities[currentQuality].label : 'Auto'"></span>
                            <i class="fas fa-chevron-up text-[8px] ml-1 opacity-60" aria-hidden="true"></i>
                        </button>
                        <div x-show="menuOpen === 'quality'" x-transition.opacity
                            class="absolute bottom-full right-0 mb-1 py-1 min-w-[5.5rem] rounded-xl border border-purple-500/30 bg-[#12182e]/98 shadow-xl backdrop-blur-md z-20"
                            role="menu">
                            <template x-for="(q, i) in qualities" :key="q.label">
                                <button type="button" @click.stop="setQuality(i)"
                                    class="w-full px-3 py-1.5 text-left text-[11px] font-bold transition-colors"
                                    :class="currentQuality === i ? 'text-cyan-300 bg-purple-500/20' : 'text-slate-300 hover:bg-white/5'"
                                    role="menuitem">
                                    <span x-text="q.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Velocidad (máx. 2x) --}}
                    <div class="relative" @click.outside="menuOpen === 'speed' && (menuOpen = null)">
                        <button type="button" @click.stop="toggleMenu('speed')" :disabled="!hasVideo"
                            class="landing-tutorial-btn landing-tutorial-btn--label min-w-[3rem]"
                            :class="!hasVideo ? 'opacity-50 cursor-not-allowed' : ''"
                            aria-label="Velocidad de reproducción"
                            :aria-expanded="menuOpen === 'speed'">
                            <span x-text="speedLabel()"></span>
                            <i class="fas fa-chevron-up text-[8px] ml-1 opacity-60" aria-hidden="true"></i>
                        </button>
                        <div x-show="menuOpen === 'speed'" x-transition.opacity
                            class="absolute bottom-full right-0 mb-1 py-1 min-w-[4.5rem] rounded-xl border border-purple-500/30 bg-[#12182e]/98 shadow-xl backdrop-blur-md z-20"
                            role="menu">
                            <template x-for="s in speeds" :key="s">
                                <button type="button" @click.stop="setSpeed(s)"
                                    class="w-full px-3 py-1.5 text-left text-[11px] font-bold transition-colors"
                                    :class="speed === s ? 'text-cyan-300 bg-purple-500/20' : 'text-slate-300 hover:bg-white/5'"
                                    role="menuitem"
                                    x-text="s === 1 ? '1×' : s + '×'"></button>
                            </template>
                        </div>
                    </div>

                    {{-- Compartir --}}
                    <button type="button" @click.stop="share()" class="landing-tutorial-btn landing-tutorial-btn--accent" title="Compartir" aria-label="Compartir tutorial">
                        <i class="fas fa-share-alt text-xs" aria-hidden="true"></i>
                        <span class="hidden sm:inline text-[10px] font-bold ml-1">Compartir</span>
                    </button>
                </div>
            </div>
            <p x-show="shareDone" x-transition class="text-[10px] text-cyan-300 font-semibold text-center mt-1.5" role="status">Enlace copiado</p>
        </div>
    </div>
</div>
