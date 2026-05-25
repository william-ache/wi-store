{{-- Enlace mailto al correo de soporte de la plataforma (config/wistore.php) --}}
@props([
    'class' => 'inline-flex items-center gap-2 text-sm font-bold text-cyan-300/90 hover:text-cyan-200 transition-colors break-all',
    'icon' => true,
])
<a href="mailto:{{ $wistoreSupportEmail }}" {{ $attributes->merge(['class' => $class]) }}>
    @if($icon)
        <i class="fas fa-envelope text-xs opacity-80 shrink-0"></i>
    @endif
    <span>{{ $wistoreSupportEmail }}</span>
</a>
