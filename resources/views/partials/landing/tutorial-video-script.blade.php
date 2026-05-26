@once
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingTutorialPlayer', (config = {}) => ({
            qualities: config.qualities || [{ label: 'Auto', src: '' }],
            shareUrl: config.shareUrl || window.location.href,
            shareTitle: config.shareTitle || 'Tutorial WIStore',
            hasVideo: config.hasVideo === true,
            playing: false,
            volume: 0.85,
            speed: 1,
            speeds: [1, 1.25, 1.5, 2],
            currentQuality: 0,
            menuOpen: null,
            progress: 0,
            shareDone: false,
            init() {
                this.$nextTick(() => {
                    const v = this.$refs.video;
                    if (!v) return;
                    v.volume = this.volume;
                    v.playbackRate = this.speed;
                    const first = this.qualities[0];
                    if (this.hasVideo && first && first.src) {
                        v.src = first.src;
                    }
                });
            },
            onLoaded() {
                const v = this.$refs.video;
                if (v) {
                    v.volume = this.volume;
                    v.playbackRate = this.speed;
                }
            },
            togglePlay() {
                if (!this.hasVideo) return;
                const v = this.$refs.video;
                if (v.paused) {
                    v.play().catch(() => {});
                } else {
                    v.pause();
                }
            },
            volumeUp() {
                if (!this.hasVideo) return;
                this.volume = Math.min(1, Math.round((this.volume + 0.1) * 10) / 10);
                this.$refs.video.volume = this.volume;
            },
            volumeDown() {
                if (!this.hasVideo) return;
                this.volume = Math.max(0, Math.round((this.volume - 0.1) * 10) / 10);
                this.$refs.video.volume = this.volume;
            },
            speedLabel() {
                return this.speed === 1 ? '1×' : this.speed + '×';
            },
            setSpeed(value) {
                if (!this.hasVideo) return;
                this.speed = value;
                this.$refs.video.playbackRate = value;
                this.menuOpen = null;
            },
            setQuality(index) {
                if (!this.hasVideo) return;
                const v = this.$refs.video;
                const next = this.qualities[index];
                if (!next || !next.src) return;
                const time = v.currentTime;
                const wasPlaying = !v.paused;
                this.currentQuality = index;
                v.src = next.src;
                v.load();
                v.addEventListener('loadedmetadata', () => {
                    v.currentTime = time;
                    if (wasPlaying) v.play().catch(() => {});
                }, { once: true });
                this.menuOpen = null;
            },
            toggleMenu(name) {
                if (!this.hasVideo) return;
                if (name === 'quality' && this.qualities.length < 2) return;
                this.menuOpen = this.menuOpen === name ? null : name;
            },
            closeMenus() {
                this.menuOpen = null;
            },
            async share() {
                const url = this.shareUrl;
                const title = this.shareTitle;
                if (navigator.share) {
                    try {
                        await navigator.share({ title, url });
                        return;
                    } catch (e) {
                        if (e && e.name === 'AbortError') return;
                    }
                }
                try {
                    await navigator.clipboard.writeText(url);
                    this.shareDone = true;
                    setTimeout(() => { this.shareDone = false; }, 2200);
                } catch (e) {
                    window.prompt('Copia este enlace:', url);
                }
            },
        }));
    });
</script>
@endonce
