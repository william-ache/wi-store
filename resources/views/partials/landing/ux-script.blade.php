<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingPage', () => ({
            isMobileMenuOpen: false,
            activeSection: 'inicio',
            showCarousel: true,
            heroDemoStep: 1,
            heroDemoPaused: false,
            heroDemoTimer: null,
            activeHowStep: 1,
            searchQuery: @json(request('search', '')),
            activeCategory: 'Todos',
            allShops: @json($shopsWithCategories ?? []),

            motion: {
                enter: 'landing-motion-enter',
                enterStart: 'opacity-0 translate-y-2 scale-[0.99]',
                enterEnd: 'opacity-100 translate-y-0 scale-100',
                leave: 'landing-motion-leave',
                leaveStart: 'opacity-100 translate-y-0 scale-100',
                leaveEnd: 'opacity-0 -translate-y-1 scale-[0.99]',
            },

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
                const sections = [
                    { id: 'inicio', el: document.getElementById('inicio') },
                    // { id: 'explorar', el: document.getElementById('explorar') },
                    { id: 'por-que', el: document.getElementById('por-que') },
                    { id: 'como-funciona', el: document.getElementById('como-funciona') },
                    { id: 'precios', el: document.getElementById('precios') },
                    { id: 'testimonios', el: document.getElementById('testimonios') },
                ].filter(s => s.el);

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeSection = entry.target.id;
                        }
                    });
                }, { rootMargin: '-30% 0px -60% 0px', threshold: 0 });

                sections.forEach(s => observer.observe(s.el));

                this.initScrollProgress();
                this.startHeroDemoCycle();
            },

            initScrollProgress() {
                const progress = document.getElementById('landing-scroll-progress');
                if (!progress) return;

                let target = 0;
                let current = 0;
                let ticking = false;

                const update = () => {
                    const h = document.documentElement.scrollHeight - window.innerHeight;
                    target = h > 0 ? window.scrollY / h : 0;
                    current += (target - current) * 0.14;
                    if (Math.abs(target - current) < 0.0005) current = target;
                    const ratio = Math.min(1, Math.max(0, current));
                    progress.style.width = (ratio * 100) + '%';
                    progress.style.transform = 'none';
                    ticking = false;
                };

                const onScroll = () => {
                    if (!ticking) {
                        ticking = true;
                        requestAnimationFrame(update);
                    }
                };

                window.addEventListener('scroll', onScroll, { passive: true });
                update();
            },

            scrollOffset() {
                const header = document.getElementById('landing-header');
                return header ? header.offsetHeight + 16 : 72;
            },

            scrollTo(id) {
                const el = document.getElementById(id);
                if (!el) return;

                const top = Math.max(0, el.getBoundingClientRect().top + window.scrollY - this.scrollOffset());

                window.scrollTo({
                    top,
                    behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
                });

                this.isMobileMenuOpen = false;
            },

            setHeroDemoStep(step) {
                this.heroDemoStep = step;
                this.restartHeroDemoCycle();
            },

            startHeroDemoCycle() {
                this.restartHeroDemoCycle();
            },

            restartHeroDemoCycle() {
                if (this.heroDemoTimer) clearInterval(this.heroDemoTimer);
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

                this.heroDemoTimer = setInterval(() => {
                    if (this.heroDemoPaused || this.isMobileMenuOpen) return;
                    this.heroDemoStep = this.heroDemoStep >= 3 ? 1 : this.heroDemoStep + 1;
                }, 5500);
            },

            setCategory(cat) {
                this.activeCategory = cat;
            },
            clearFilters() {
                this.searchQuery = '';
                this.activeCategory = 'Todos';
            },

            destroy() {
                if (this.heroDemoTimer) clearInterval(this.heroDemoTimer);
            },
        }));
    });
</script>
