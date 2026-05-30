@props(['mode' => 'edit'])

@php
    use App\Support\AdminModules;
    $isEdit = $mode === 'edit';
@endphp

<div class="sa-form-group sa-company-modules">
    <label class="sa-form-label">Módulos del panel</label>
    <p class="sa-form-hint">
        Solo puedes activar módulos permitidos por el plan. La tienda verá en su menú lateral únicamente los marcados aquí.
    </p>

    <div class="sa-module-grid sa-module-grid--company">
        @foreach (AdminModules::CATALOG as $key => $meta)
            <label class="sa-module-chip"
                   @if ($isEdit)
                       x-show="planAllowsModule('{{ $key }}', editingShop.plan)"
                   @else
                       x-show="planAllowsModule('{{ $key }}', createPlan)"
                   @endif
                   x-cloak>
                <input type="checkbox"
                       value="{{ $key }}"
                       @if ($isEdit)
                           :checked="shopModuleChecked('{{ $key }}')"
                           @change="toggleShopModule('{{ $key }}', $event.target.checked)"
                       @else
                           name="enabled_modules[]"
                           @checked(in_array($key, old('enabled_modules', AdminModules::defaultAllowedForPlan('standard')), true))
                       @endif
                       class="sa-module-chip__input">
                <span class="sa-module-chip__box">
                    <i class="fas {{ $meta['icon'] }}" aria-hidden="true"></i>
                    <span>{{ $meta['label'] }}</span>
                </span>
            </label>
        @endforeach
    </div>

    @if ($isEdit)
        <template x-for="key in editingShop.enabled_modules" :key="'mod-' + key">
            <input type="hidden" name="enabled_modules[]" :value="key">
        </template>
    @endif
</div>
