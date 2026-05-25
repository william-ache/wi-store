@php
    $size = $size ?? 'md';
    $extraClass = $class ?? 'text-white';
    $sizes = [
        'xs' => 'w-4 h-4',
        'sm' => 'w-6 h-6',
        'md' => 'w-9 h-9',
    ];
    $dim = $sizes[$size] ?? $sizes['md'];
@endphp

<svg class="{{ $dim }} {{ $extraClass }} drop-shadow-sm" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <!-- Antena -->
    <rect x="14" y="2" width="4" height="4" rx="2" fill="currentColor" opacity="0.9"/>
    <circle cx="16" cy="2" r="1.5" fill="#a5f3fc" class="animate-pulse"/>
    <!-- Cabeza -->
    <rect x="5" y="7" width="22" height="18" rx="8" fill="currentColor"/>
    <!-- Brillo -->
    <ellipse cx="11" cy="11" rx="3" ry="2" fill="white" opacity="0.2"/>
    <!-- Ojos -->
    <circle cx="11.5" cy="15" r="2.8" fill="#312e81"/>
    <circle cx="20.5" cy="15" r="2.8" fill="#312e81"/>
    <circle cx="12.2" cy="14.2" r="1" fill="white"/>
    <circle cx="21.2" cy="14.2" r="1" fill="white"/>
    <!-- Sonrisa -->
    <path d="M10.5 19.5c1.4 2 3.2 2.8 5.5 2.8s4.1-.8 5.5-2.8" stroke="#312e81" stroke-width="1.5" stroke-linecap="round" fill="none"/>
    <!-- Mejillas -->
    <circle cx="8" cy="18" r="1.5" fill="#f9a8d4" opacity="0.7"/>
    <circle cx="24" cy="18" r="1.5" fill="#f9a8d4" opacity="0.7"/>
</svg>
