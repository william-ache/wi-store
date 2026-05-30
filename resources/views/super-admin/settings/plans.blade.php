@extends('layouts.super-admin')

@section('title', 'Ajustes de planes — Super Admin')

@section('page-header')
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Ajustes · Planes</h1>
    <p class="text-sm text-slate-500 mt-1">Personaliza precios, límites y textos que se muestran en la landing y registro.</p>
@endsection

@section('content')
    @php
        $plans = $settings['plans'] ?? [];
        $standard = $plans['standard'] ?? [];
        $premium = $plans['premium'] ?? [];
        $highlightsText = static function (array $plan): string {
            $lines = $plan['highlights'] ?? [];
            return is_array($lines) ? implode("\n", $lines) : '';
        };
    @endphp

    <form action="{{ route('super-admin.settings.plans.update') }}" method="POST" class="space-y-6 max-w-4xl">
        @csrf

        <section class="sa-panel p-5 md:p-6">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-500 mb-4">Prueba gratuita</h2>
            <div class="max-w-xs mb-6">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Días de prueba</label>
                <input type="number" name="trial_days" min="1" max="90" required
                       value="{{ old('trial_days', $settings['trial_days'] ?? 14) }}"
                       class="sa-field w-full px-3 py-2.5 text-sm mt-1">
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-1">Módulos disponibles en prueba</h3>
                <p class="text-xs text-slate-500 mb-3">Define qué secciones del panel puede usar una tienda en periodo de prueba.</p>
                @include('partials.super-admin.module-checkboxes', [
                    'name' => 'allowed_modules',
                    'inputPrefix' => 'free_trial.',
                    'selected' => old('free_trial.allowed_modules', $settings['free_trial']['allowed_modules'] ?? []),
                ])
            </div>
        </section>

        @foreach (['standard' => 'Emprendedor', 'premium' => 'Negocio'] as $key => $label)
            @php $plan = $key === 'standard' ? $standard : $premium; @endphp
            <section class="sa-panel p-5 md:p-6">
                <h2 class="text-lg font-black text-slate-900 mb-1">Plan {{ $label }}</h2>
                <p class="text-xs text-slate-500 mb-5">Clave interna: <code class="text-purple-700">{{ $key }}</code>
                    @if (isset($pricingPreview[$key]))
                        · Vista previa: {{ \App\Support\PlanPricing::formatUsd($pricingPreview[$key]['monthly']) }}/mes
                        · Anual {{ \App\Support\PlanPricing::formatUsd($pricingPreview[$key]['annual_total']) }}
                    @endif
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Nombre comercial</label>
                        <input type="text" name="plans[{{ $key }}][marketing_name]" required
                               value="{{ old("plans.{$key}.marketing_name", $plan['marketing_name'] ?? '') }}"
                               class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Precio mensual (USD)</label>
                        <input type="number" step="0.01" min="0" name="plans[{{ $key }}][monthly]" required
                               value="{{ old("plans.{$key}.monthly", $plan['monthly'] ?? 0) }}"
                               class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Descuento anual (%)</label>
                        <input type="number" min="0" max="90" name="plans[{{ $key }}][annual_discount_percent]" required
                               value="{{ old("plans.{$key}.annual_discount_percent", $plan['annual_discount_percent'] ?? 0) }}"
                               class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Máx. productos (vacío = ilimitado)</label>
                        <input type="number" min="0" name="plans[{{ $key }}][max_products]"
                               value="{{ old("plans.{$key}.max_products", $plan['max_products'] ?? '') }}"
                               class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Máx. categorías</label>
                        <input type="number" min="0" name="plans[{{ $key }}][max_categories]"
                               value="{{ old("plans.{$key}.max_categories", $plan['max_categories'] ?? '') }}"
                               class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Texto bajo el plan (landing)</label>
                    <textarea name="plans[{{ $key }}][purpose]" rows="2"
                              class="sa-field w-full px-3 py-2.5 text-sm mt-1">{{ old("plans.{$key}.purpose", $plan['purpose'] ?? '') }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Beneficios (uno por línea)</label>
                    <textarea name="plans[{{ $key }}][highlights_text]" rows="6"
                              class="sa-field w-full px-3 py-2.5 text-sm mt-1 font-mono text-xs leading-relaxed">{{ old("plans.{$key}.highlights_text", $highlightsText($plan)) }}</textarea>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800 mb-1">Módulos del panel (plan {{ $label }})</h3>
                    <p class="text-xs text-slate-500 mb-3">Máximo que podrán activar las tiendas con este plan. El super admin puede restringir más por empresa.</p>
                    @include('partials.super-admin.module-checkboxes', [
                        'name' => 'allowed_modules',
                        'inputPrefix' => "plans[{$key}].",
                        'selected' => old("plans.{$key}.allowed_modules", $plan['allowed_modules'] ?? []),
                    ])
                </div>
            </section>
        @endforeach

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="sa-btn-primary px-6 py-3 rounded-xl text-sm font-extrabold inline-flex items-center gap-2">
                <i class="fas fa-save" aria-hidden="true"></i>
                Guardar configuración
            </button>
            <a href="{{ route('home') }}#precios" target="_blank" rel="noopener"
               class="sa-btn-ghost px-5 py-3 rounded-xl text-sm inline-flex items-center gap-2">
                <i class="fas fa-external-link-alt text-xs" aria-hidden="true"></i>
                Ver en landing
            </a>
        </div>
    </form>
@endsection
