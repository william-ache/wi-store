@props([
    'name' => 'allowed_modules',
    'selected' => [],
    'inputPrefix' => '',
])

@php
    use App\Support\AdminModules;
    $selected = array_values(array_intersect(AdminModules::keys(), (array) $selected));
@endphp

<div class="sa-module-grid">
    @foreach (AdminModules::CATALOG as $key => $meta)
        <label class="sa-module-chip">
            <input type="checkbox"
                   name="{{ $inputPrefix }}{{ $name }}[]"
                   value="{{ $key }}"
                   @checked(in_array($key, $selected, true))
                   class="sa-module-chip__input">
            <span class="sa-module-chip__box">
                <i class="fas {{ $meta['icon'] }}" aria-hidden="true"></i>
                <span>{{ $meta['label'] }}</span>
            </span>
        </label>
    @endforeach
</div>
