@php
    use App\Support\BrandColor;

    $shopForVars = $shop ?? config('current_shop');
    $primaryHex = BrandColor::normalizeHex($shopForVars?->color_primary ?? '#E60067');
    $secondaryHex = BrandColor::normalizeHex($shopForVars?->color_secondary ?? '#C6A100');
    $onPrimary = BrandColor::onPrimary($primaryHex);
    $primaryRgb = BrandColor::rgb($primaryHex);
    $onPrimaryRgb = BrandColor::onPrimaryRgb($primaryHex);
@endphp
    :root {
        /* Tema claro — fondos neutros */
        --ui-bg: #F3F4F6;
        --ui-surface: #FAFBFC;
        --ui-text: #1F2937;
        --ui-text-muted: #6B7280;
        --ui-border: #E5E7EB;

        /* Acento de marca (inyectable desde BD) */
        --color-primary: {{ $primaryHex }};
        --color-primary-rgb: {{ $primaryRgb['r'] }}, {{ $primaryRgb['g'] }}, {{ $primaryRgb['b'] }};
        --color-on-primary: {{ $onPrimary }};
        --color-on-primary-rgb: {{ $onPrimaryRgb['r'] }}, {{ $onPrimaryRgb['g'] }}, {{ $onPrimaryRgb['b'] }};
        --color-secondary: {{ $secondaryHex }};
    }

    .dark {
        /* Tema oscuro — fondos neutros sin tinte azul/morado */
        --ui-bg: #121212;
        --ui-surface: #1E1E1E;
        --ui-text: #E5E7EB;
        --ui-text-muted: #9CA3AF;
        --ui-border: #2D2D2D;
    }
