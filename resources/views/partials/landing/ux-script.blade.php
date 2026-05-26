<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingPage', () => ({
            isMobileMenuOpen: false,
            activeSection: 'inicio',
            showCarousel: true,
            heroDemoStep: 1,
            activeHowStep: 1,
            searchQuery: @json(request('search', '')),
            activeCategory: 'Todos',
            allShops: @json($shopsWithCategories ?? []),
            matchesFilter(name, description, category) {
                const q = this.searchQuery.toLowerCase().trim();
                const matchesSearch = q === '' ||
                    name.toLowerCase().includes(q) ||
                    (description && description.toLowerCase().includes(q));
                const matchesCategory = this.activeCategory === 'Todos' || category === this.activeCategory;
                return matchesSearch && matchesCategory;
            },
            get hasResults() {
                return this.allShops.some(shop => this.matchesFilter(shop.name, shop.description, shop.category));
            },
            get isFiltering() {
                return this.searchQuery.trim() !== '' || this.activeCategory !== 'Todos';
            },
            get filteredCount() {
                return this.allShops.filter(shop => this.matchesFilter(shop.name, shop.description, shop.category)).length;
            },
            get marketplaceUrl() {
                const params = new URLSearchParams();
                const q = this.searchQuery.trim();
                if (q) params.set('q', q);
                if (this.activeCategory !== 'Todos') params.set('categoria', this.activeCategory);
                const qs = params.toString();
                return @json(route('tiendas.index')) + (qs ? '?' + qs : '');
            },
            init() {
                const map = [
                    { id: 'explorar', el: document.getElementById('explorar') },
                    { id: 'como-funciona', el: document.getElementById('como-funciona') },
                    { id: 'precios', el: document.getElementById('precios') },
                ].filter(s => s.el);

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeSection = entry.target.id;
                        }
                    });
                }, { rootMargin: '-35% 0px -55% 0px', threshold: 0 });

                map.forEach(s => observer.observe(s.el));

                const progress = document.getElementById('landing-scroll-progress');
                if (progress) {
                    window.addEventListener('scroll', () => {
                        const h = document.documentElement.scrollHeight - window.innerHeight;
                        const p = h > 0 ? window.scrollY / h : 0;
                        progress.style.transform = 'scaleX(' + Math.min(1, p) + ')';
                    }, { passive: true });
                }
            },
            scrollTo(id) {
                const el = document.getElementById(id);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                this.isMobileMenuOpen = false;
            },
            setCategory(cat) {
                this.activeCategory = cat;
            },
            clearFilters() {
                this.searchQuery = '';
                this.activeCategory = 'Todos';
            },
        }));

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
                    if (this.hasVideo && this.qualities[0]?.src) {
                        v.src = this.qualities[0].src;
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
                if (!next?.src) return;
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
                        if (e?.name === 'AbortError') return;
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
