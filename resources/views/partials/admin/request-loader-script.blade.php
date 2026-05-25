<script>
(function () {
    const LOADER_ID = 'admin-request-loader';
    const SHOW_DELAY_MS = 120;
    const HIDE_FADE_MS = 280;

    const WiStoreLoader = {
        count: 0,
        showTimer: null,
        hideTimer: null,
        visible: false,

        getEl() {
            return document.getElementById(LOADER_ID);
        },

        shouldSkip(url, method) {
            if (!url) return true;
            const u = String(url);
            const m = (method || 'GET').toUpperCase();

            if (u.startsWith('blob:') || u.startsWith('data:')) return true;
            if (/\.(png|jpe?g|gif|webp|svg|ico|css|js|woff2?)(\?|$)/i.test(u)) return true;

            // Polling de notificaciones (evita parpadeo constante)
            if (u.includes('/admin/notifications') && m === 'GET') return true;

            return false;
        },

        show() {
            this.count++;
            clearTimeout(this.hideTimer);

            if (this.visible || this.showTimer) return;

            this.showTimer = setTimeout(() => {
                this.showTimer = null;
                if (this.count <= 0) return;
                const el = this.getEl();
                if (!el) return;
                el.classList.remove('hidden');
                el.setAttribute('aria-hidden', 'false');
                requestAnimationFrame(() => {
                    el.classList.remove('opacity-0');
                    this.visible = true;
                });
            }, SHOW_DELAY_MS);
        },

        hide() {
            this.count = Math.max(0, this.count - 1);
            if (this.count > 0) return;

            clearTimeout(this.showTimer);
            this.showTimer = null;

            if (!this.visible) return;

            const el = this.getEl();
            if (!el) return;

            this.hideTimer = setTimeout(() => {
                el.classList.add('opacity-0');
                el.setAttribute('aria-hidden', 'true');
                setTimeout(() => {
                    if (this.count === 0) {
                        el.classList.add('hidden');
                        this.visible = false;
                    }
                }, HIDE_FADE_MS);
            }, 60);
        },
    };

    window.WiStoreLoader = WiStoreLoader;

    const nativeFetch = window.fetch.bind(window);
    window.fetch = function (input, init) {
        const url = typeof input === 'string' ? input : (input && input.url) || '';
        const method = (init && init.method) || (input && input.method) || 'GET';
        if (WiStoreLoader.shouldSkip(url, method)) {
            return nativeFetch(input, init);
        }
        WiStoreLoader.show();
        return nativeFetch(input, init)
            .finally(() => WiStoreLoader.hide());
    };

    if (window.jQuery) {
        jQuery(document).ajaxSend(function (_event, _xhr, settings) {
            if (!WiStoreLoader.shouldSkip(settings.url, settings.type)) {
                WiStoreLoader.show();
            }
        });
        jQuery(document).ajaxComplete(function (_event, _xhr, settings) {
            if (!WiStoreLoader.shouldSkip(settings.url, settings.type)) {
                WiStoreLoader.hide();
            }
        });
    }

    document.addEventListener('submit', function (event) {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (form.dataset.noLoader !== undefined) return;
        if (form.getAttribute('target') === '_blank') return;
        WiStoreLoader.show();
    }, true);

    window.addEventListener('pageshow', function () {
        WiStoreLoader.count = 0;
        const el = WiStoreLoader.getEl();
        if (el) {
            el.classList.add('hidden', 'opacity-0');
            el.setAttribute('aria-hidden', 'true');
            WiStoreLoader.visible = false;
        }
    });
})();
</script>
