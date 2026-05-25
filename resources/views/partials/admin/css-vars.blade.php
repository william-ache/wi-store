@php
    $shopForVars = $shop ?? config('current_shop');
    $primaryHex = $shopForVars?->color_primary ?? '#E60067';
    $secondaryHex = $shopForVars?->color_secondary ?? '#C6A100';
    $primaryColor = ltrim($primaryHex, '#');
    if (strlen($primaryColor) === 3) {
        $r = hexdec(substr($primaryColor, 0, 1) . substr($primaryColor, 0, 1));
        $g = hexdec(substr($primaryColor, 1, 1) . substr($primaryColor, 1, 1));
        $b = hexdec(substr($primaryColor, 2, 1) . substr($primaryColor, 2, 1));
    } elseif (strlen($primaryColor) === 6) {
        $r = hexdec(substr($primaryColor, 0, 2));
        $g = hexdec(substr($primaryColor, 2, 2));
        $b = hexdec(substr($primaryColor, 4, 2));
    } else {
        $r = 230;
        $g = 0;
        $b = 103;
    }
@endphp
    :root {
        --color-primary: {{ $primaryHex }};
        --color-primary-rgb: {{ $r }}, {{ $g }}, {{ $b }};
        --color-secondary: {{ $secondaryHex }};
    }
