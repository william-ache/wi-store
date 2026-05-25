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
    });
</script>
