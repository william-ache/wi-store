@props([
    'code' => 'VE',
    'title' => '',
    'size' => 'md',
    'highlight' => false,
])

@php
    $sizes = [
        'sm' => 'w-8 h-8 text-[9px]',
        'md' => 'w-10 h-10 text-[11px]',
        'lg' => 'w-12 h-12 text-xs',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $code = strtoupper($code);

    $gradient = match ($code) {
        'CO' => 'linear-gradient(to bottom, #ffe066 0%, #fcd116 0%, #fcd116 58%, #f5c518 58%, #003893 58%, #003893 82%, #ce1126 82%, #ce1126 100%)',
        'VE' => 'linear-gradient(to bottom, #ffcc00 0%, #ffcc00 33.33%, #1d4ed8 33.33%, #1d4ed8 66.66%, #cf142b 66.66%, #cf142b 100%)',
        default => 'linear-gradient(to bottom, #94a3b8, #64748b)',
    };

    $highlightRing = ($highlight || $code === 'CO')
        ? 'ring-2 ring-yellow-300/90 ring-offset-1 ring-offset-[#0d1127] shadow-[0_0_14px_rgba(252,211,77,0.45)]'
        : '';
@endphp

<span
    class="inline-flex items-center justify-center rounded-full border-2 border-[#0d1127] font-black text-white tracking-tight shadow-lg shrink-0 {{ $sizeClass }} {{ $highlightRing }}"
    style="background: {{ $gradient }};"
    @if($title) title="{{ $title }}" @endif
>{{ $code }}</span>
