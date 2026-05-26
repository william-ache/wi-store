@props([
    'src',
    'webp' => null,
    'alt' => '',
    'width' => null,
    'height' => null,
    'class' => '',
    'loading' => 'lazy',
    'fetchpriority' => null,
    'sizes' => '100vw',
])

@php
    $w = $width ? (int) $width : null;
    $h = $height ? (int) $height : null;
@endphp

<div class="responsive-image-shell {{ $attributes->get('wrapperClass', '') }}" @if($w && $h) style="aspect-ratio: {{ $w }} / {{ $h }};" @endif>
    <picture>
        @if($webp)
            <source type="image/webp" srcset="{{ $webp }}">
        @endif
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            @if($w) width="{{ $w }}" @endif
            @if($h) height="{{ $h }}" @endif
            loading="{{ $loading }}"
            decoding="async"
            @if($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
            class="{{ $class }}"
        >
    </picture>
</div>
