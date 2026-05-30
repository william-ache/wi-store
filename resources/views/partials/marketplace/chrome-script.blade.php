<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('marketplaceChrome', () => ({
            isMobileMenuOpen: false,
            scrollY: 0,

            get isHeaderScrolled() {
                return this.scrollY > 24;
            },

            init() {
                const syncScroll = () => {
                    this.scrollY = window.scrollY || 0;
                };
                window.addEventListener('scroll', syncScroll, { passive: true });
                syncScroll();

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
                    progress.style.width = (Math.min(1, Math.max(0, current)) * 100) + '%';
                    ticking = false;
                };

                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        ticking = true;
                        requestAnimationFrame(update);
                    }
                }, { passive: true });
                update();
            },
        }));
    });
</script>
