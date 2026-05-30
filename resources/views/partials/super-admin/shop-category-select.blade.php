@props([
    'name' => 'shop_category',
    'required' => true,
    'model' => null,
    'selected' => null,
])

@php
    $current = $model ? null : old($name, $selected ?? 'otros');
@endphp

<div class="sa-field-wrap">
    <i class="fas fa-tags sa-field-wrap__icon" aria-hidden="true"></i>
    <select
        name="{{ $name }}"
        @if ($required) required @endif
        @if ($model) x-model="{{ $model }}" @endif
        {{ $attributes->merge(['class' => 'sa-modal-field sa-modal-field--icon sa-modal-field--select']) }}
    >
        @foreach ([
            'gastronomia' => 'Gastronomía',
            'moda_estilo' => 'Moda y estilo',
            'detalles_regalos' => 'Detalles y regalos',
            'servicios' => 'Servicios',
            'otros' => 'Otros',
        ] as $value => $label)
            <option value="{{ $value }}" @if (!$model && $current === $value) selected @endif>{{ $label }}</option>
        @endforeach
    </select>
</div>
