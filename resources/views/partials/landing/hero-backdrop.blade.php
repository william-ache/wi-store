{{-- Misma capa visual que el hero: cuadrícula + degradados morado/cian (+ fade opcional) --}}
<div class="landing-hero-backdrop pointer-events-none" aria-hidden="true">
    <div class="landing-hero-grid"></div>
    <div class="landing-hero-glow"></div>
    @if (!empty($withFade))
        <div class="landing-hero-fade"></div>
    @endif
</div>
