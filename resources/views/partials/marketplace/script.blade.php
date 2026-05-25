<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('marketplacePage', () => ({
            searchQuery: @json($initialQuery),
            activeCategory: @json($initialCategory),
            activeZone: @json($initialZone),
            activeService: @json($initialService),
            sortBy: @json($initialSort),
            allShops: @json($shopsJson),

            matchesFilter(shop) {
                const q = this.searchQuery.toLowerCase().trim();
                const haystack = [shop.name, shop.description, shop.address, shop.zone, shop.category]
                    .filter(Boolean)
                    .join(' ')
                    .toLowerCase();

                const matchesSearch = q === '' || haystack.includes(q);
                const matchesCategory = this.activeCategory === 'Todos' || shop.category === this.activeCategory;
                const matchesZone = this.activeZone === 'Todas' || shop.zone === this.activeZone;

                let matchesService = true;
                if (this.activeService === 'delivery') matchesService = shop.has_delivery;
                if (this.activeService === 'pickup') matchesService = shop.has_pickup;
                if (this.activeService === 'dine_in') matchesService = shop.has_dine_in;

                return matchesSearch && matchesCategory && matchesZone && matchesService;
            },

            get filteredShops() {
                let list = this.allShops.filter(shop => this.matchesFilter(shop));

                if (this.sortBy === 'nombre') {
                    list = [...list].sort((a, b) => a.name.localeCompare(b.name, 'es'));
                } else if (this.sortBy === 'zona') {
                    list = [...list].sort((a, b) => (a.zone || '').localeCompare(b.zone || '', 'es'));
                }

                return list;
            },

            get isFiltering() {
                return this.searchQuery.trim() !== ''
                    || this.activeCategory !== 'Todos'
                    || this.activeZone !== 'Todas'
                    || this.activeService !== 'Todos';
            },

            clearFilters() {
                this.searchQuery = '';
                this.activeCategory = 'Todos';
                this.activeZone = 'Todas';
                this.activeService = 'Todos';
                this.sortBy = 'recientes';
            },

            setCategory(cat) {
                this.activeCategory = cat;
            },

            setZone(zone) {
                this.activeZone = zone;
            },

            setService(service) {
                this.activeService = service;
            },
        }));
    });
</script>
