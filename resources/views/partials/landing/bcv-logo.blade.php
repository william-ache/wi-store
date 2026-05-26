@props([
    'class' => 'w-10 h-10',
    'color' => 'currentColor',
])
@php $uid = 'bcv-seal-' . substr(md5($class . $color), 0, 8); @endphp

<svg viewBox="0 0 100 100" class="{{ $class }}" fill="{{ $color }}" aria-hidden="true" role="img">
    <title>Banco Central de Venezuela</title>
    <defs>
        <g id="{{ $uid }}-segment">
            <path d="M 50,5.5 L 47.8,10.2 L 52.2,10.2 Z" fill="currentColor" />
            <path d="M 50,11.5 L 44,17.2 L 46.2,19.2 L 50,15.6 L 53.8,19.2 L 56,17.2 Z" fill="currentColor" />
            <path d="M 49.3,10 L 50.7,10 L 50.7,24.5 L 49.3,24.5 Z" fill="currentColor" />
            <path d="M 50,16.5 L 45.2,21.3 L 47,23.1 L 50,20.1 L 53,23.1 L 54.8,21.3 Z" fill="currentColor" />
            <path d="M 50,21.5 L 48.2,24.2 L 51.8,24.2 Z" fill="currentColor" />
        </g>
    </defs>
    <circle cx="50" cy="50" r="48" fill="none" stroke="currentColor" stroke-width="1.8" />
    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="0.8" />
    @for ($i = 0; $i < 32; $i++)
        <use href="#{{ $uid }}-segment" transform="rotate({{ $i * 11.25 }} 50 50)" />
    @endfor
    <circle cx="50" cy="50" r="25.5" fill="currentColor" stroke="white" stroke-width="0.8" />
    <rect x="23" y="38" width="54" height="24" fill="currentColor" stroke="white" stroke-width="1.5" rx="1.5" />
    <text x="50" y="55.5" font-family="Georgia, 'Times New Roman', serif" font-weight="900" font-size="16"
        fill="white" text-anchor="middle" letter-spacing="1">BCV</text>
</svg>
