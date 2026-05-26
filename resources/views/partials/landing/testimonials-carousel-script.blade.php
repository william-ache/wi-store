@once
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingTestimonialsCarousel', (items = []) => ({
            items,
            starFilter: 'all',
            slide: 0,
            get filtered() {
                if (this.starFilter === 'all') return this.items;
                const stars = parseInt(this.starFilter, 10);
                return this.items.filter(i => i.rating === stars);
            },
            get maxSlide() {
                return Math.max(0, this.filtered.length - 1);
            },
            prev() {
                this.slide = this.slide <= 0 ? this.maxSlide : this.slide - 1;
            },
            next() {
                this.slide = this.slide >= this.maxSlide ? 0 : this.slide + 1;
            },
            setFilter(value) {
                this.starFilter = value;
                this.slide = 0;
            },
        }));
    });
</script>
@endonce
