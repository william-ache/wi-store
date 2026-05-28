<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingPage', () => ({
            isMobileMenuOpen: false,
            activeSection: 'inicio',
            showCarousel: true,
            heroDemoStep: 1,
            heroDemoPaused: false,
            heroDemoTimer: null,
            activeFaq: 1,
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
                    { id: 'faq', el: document.getElementById('faq') },
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
                this.initScrollReveal();
                this.initRegisterFormDemo();
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

            initScrollReveal() {
                const selectors = [
                    '#por-que',
                    '#como-funciona',
                    '#precios',
                    '#testimonios',
                    '#faq',
                    '.landing-how-step',
                    '.landing-why-card',
                    '.landing-plan-card',
                    '.landing-faq-item',
                    '.landing-final-cta__panel',
                    '.landing-footer',
                ];

                const targets = Array.from(document.querySelectorAll(selectors.join(',')));
                if (!targets.length) return;

                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (reduceMotion || !('IntersectionObserver' in window)) {
                    targets.forEach(el => el.classList.add('is-visible'));
                    return;
                }

                targets.forEach(el => el.classList.add('landing-reveal'));

                const revealObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -8% 0px',
                });

                targets.forEach(el => revealObserver.observe(el));
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

            initRegisterFormDemo() {
                const demo = document.querySelector('.landing-how-form-demo--js');
                if (!demo) return;

                const cursor = demo.querySelector('.landing-how-demo-cursor');
                if (!cursor) return;

                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    cursor.style.display = 'none';
                    return;
                }

                const targets = {
                    name: demo.querySelector('.landing-how-form-field--name'),
                    category: demo.querySelector('.landing-how-category-chip--selected'),
                    color: demo.querySelector('.landing-how-color-swatch--selected'),
                    submit: demo.querySelector('.landing-how-form-submit'),
                };

                const duration = 8000;
                let start = performance.now();
                let rafId = null;

                const place = (el, clicking = false) => {
                    if (!el) return;
                    const demoRect = demo.getBoundingClientRect();
                    const rect = el.getBoundingClientRect();
                    const cursorRect = cursor.getBoundingClientRect();
                    const hotspotX = cursorRect.width * 0.1;
                    const hotspotY = cursorRect.height * 0.2;
                    const x = rect.left - demoRect.left + rect.width / 2.25 - hotspotX;
                    const y = rect.top - demoRect.top + rect.height / 2.25 - hotspotY;
                    cursor.style.transform = `translate(${x}px, ${y}px)`;
                    cursor.classList.toggle('is-clicking', clicking);
                };

                const tick = (now) => {
                    const elapsed = (now - start) % duration;

                    if (elapsed < 1200) {
                        place(targets.name, false);
                    } else if (elapsed < 2200) {
                        place(targets.name, true);
                    } else if (elapsed < 3200) {
                        place(targets.category, false);
                    } else if (elapsed < 4000) {
                        place(targets.category, true);
                    } else if (elapsed < 5000) {
                        place(targets.color, false);
                    } else if (elapsed < 5800) {
                        place(targets.color, true);
                    } else if (elapsed < 6600) {
                        place(targets.submit, false);
                    } else if (elapsed < 7400) {
                        place(targets.submit, true);
                    } else {
                        // Keep a stable 8s timeline so cursor stays in sync
                        // with CSS animations and doesn't jump ahead per loop.
                        place(targets.name, false);
                    }

                    rafId = requestAnimationFrame(tick);
                };

                rafId = requestAnimationFrame(tick);
                this._registerDemoRaf = rafId;
            },

            destroy() {
                if (this.heroDemoTimer) clearInterval(this.heroDemoTimer);
                if (this._registerDemoRaf) cancelAnimationFrame(this._registerDemoRaf);
            },
        }));
    });
</script>
