{{-- CSS crítico above-the-fold: hero + shell (≈1–2 KB). El resto va en build/landing.css --}}
<style>
    html { background: #0e1228; }
    body {
        margin: 0;
        min-height: 100vh;
        background: #0e1228;
        color: #f1f5f9;
        font-family: 'Outfit', ui-sans-serif, system-ui, -apple-system, sans-serif;
        -webkit-font-smoothing: antialiased;
        -webkit-tap-highlight-color: transparent;
    }
    [x-cloak] { display: none !important; }
    .hero-gradient {
        background:
            radial-gradient(circle at 50% 10%, rgba(99, 102, 241, 0.18) 0%, transparent 50%),
            radial-gradient(circle at 10% 80%, rgba(79, 70, 229, 0.08) 0%, transparent 40%);
    }
    .gpu-accelerated {
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
    }
</style>
