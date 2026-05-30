<?php

namespace App\Support;

/**
 * Textos y datos de planes para vistas (landing, registro, billing).
 * Siempre lee la configuración guardada en super admin.
 */
final class PlanCatalog
{
    /** Plan de pago sugerido al terminar la prueba. */
    public const POST_TRIAL_PLAN = 'premium';

    /** @return array{max_products: int|null, max_categories: int|null, name: string} */
    public static function trialLimits(): array
    {
        $all = PlatformPlanSettings::all();
        $trial = is_array($all['free_trial'] ?? null) ? $all['free_trial'] : [];
        $premium = PlatformPlanSettings::limits('premium');

        $maxProducts = $trial['max_products'] ?? $premium['max_products'] ?? null;
        $maxCategories = $trial['max_categories'] ?? $premium['max_categories'] ?? null;

        if ($maxProducts === '' || $maxProducts === null) {
            $maxProducts = $premium['max_products'];
        }

        if ($maxCategories === '' || $maxCategories === null) {
            $maxCategories = $premium['max_categories'];
        }

        return [
            'max_products' => $maxProducts !== null && $maxProducts !== '' ? (int) $maxProducts : null,
            'max_categories' => $maxCategories !== null && $maxCategories !== '' ? (int) $maxCategories : null,
            'name' => 'Prueba gratis',
        ];
    }

    public static function formatLimit(?int $max, string $singular, string $plural): string
    {
        if ($max === null) {
            return ucfirst($plural) . ' ilimitados';
        }

        if ($max === 1) {
            return 'Hasta 1 ' . $singular;
        }

        return 'Hasta ' . $max . ' ' . $plural;
    }

    public static function formatLimitShort(?int $max, string $singular, string $plural): string
    {
        if ($max === null) {
            return $plural . ' ilimitados';
        }

        return $max . ' ' . ($max === 1 ? $singular : $plural);
    }

    /** @return array<string, array<string, mixed>> */
    public static function pricing(): array
    {
        return PlanPricing::plans();
    }

    /** @return array<string, mixed>|null */
    public static function pricingFor(string $planKey): ?array
    {
        return PlanPricing::for($planKey) ?? PlanPricing::PLANS[$planKey] ?? null;
    }

    public static function monthlyPrice(string $planKey): float
    {
        return (float) (self::pricingFor($planKey)['monthly'] ?? 0);
    }

    public static function marketingName(string $planKey): string
    {
        return (string) (PlatformPlanSettings::limits($planKey)['name']
            ?? self::pricingFor($planKey)['name']
            ?? 'Plan');
    }

    /**
     * Filas de comparativa técnica (límites y precios dinámicos).
     *
     * @return array<int, array{feature: string, standard: string, premium: string}>
     */
    public static function comparisonRows(): array
    {
        $standard = PlatformPlanSettings::limits('standard');
        $premium = PlatformPlanSettings::limits('premium');
        $stdPrice = self::pricingFor('standard');
        $prePrice = self::pricingFor('premium');

        return [
            [
                'feature' => 'Límite de Productos',
                'standard' => self::formatLimit($standard['max_products'], 'producto', 'productos'),
                'premium' => self::formatLimit($premium['max_products'], 'producto', 'productos'),
            ],
            [
                'feature' => 'Límite de Categorías',
                'standard' => self::formatLimit($standard['max_categories'], 'categoría', 'categorías'),
                'premium' => self::formatLimit($premium['max_categories'], 'categoría', 'categorías'),
            ],
            [
                'feature' => 'Precio mensual',
                'standard' => PlanPricing::formatUsd((float) ($stdPrice['monthly'] ?? 0)) . ' / mes',
                'premium' => PlanPricing::formatUsd((float) ($prePrice['monthly'] ?? 0)) . ' / mes',
            ],
            [
                'feature' => 'Visualización de Fotos',
                'standard' => 'Solo ventana Modal (Show)',
                'premium' => 'Menú, Carrito y Modal',
            ],
            [
                'feature' => 'Personalización de Diseño',
                'standard' => 'No (Paleta Base)',
                'premium' => 'Sí (Colores de Marca)',
            ],
            [
                'feature' => 'Sedes / Sucursales',
                'standard' => '1 Sede',
                'premium' => 'Hasta 3 Sedes',
            ],
            [
                'feature' => 'Números de Contacto',
                'standard' => '1 Número',
                'premium' => 'Hasta 3 Números',
            ],
            [
                'feature' => 'Métodos de Pago',
                'standard' => '1 Método único',
                'premium' => 'Múltiples (Inteligentes)',
            ],
            [
                'feature' => 'Opciones y Extras',
                'standard' => 'No disponible',
                'premium' => 'Sí (Variantes y Atributos)',
            ],
            [
                'feature' => 'Módulo de Servicios',
                'standard' => 'No disponible',
                'premium' => 'Disponible',
            ],
            [
                'feature' => 'Carrusel de Tiendas',
                'standard' => 'No aparece',
                'premium' => 'Destacado Regular',
            ],
            [
                'feature' => 'Panel Administrativo',
                'standard' => 'No disponible',
                'premium' => 'Sí (Clientes, Órdenes, Pagos)',
            ],
            [
                'feature' => 'Nivel de Soporte',
                'standard' => 'Estándar vía WhatsApp',
                'premium' => 'Corporativo dedicado 24/7',
            ],
        ];
    }

    /** @return array<int, array{feature: string, standard: string, premium: string}> */
    public static function comparisonRowsPreview(): array
    {
        $rows = [];

        foreach (self::comparisonRows() as $row) {
            if ($row['feature'] === 'Visualización de Fotos') {
                continue;
            }

            $rows[] = $row;

            if ($row['feature'] === 'Métodos de Pago') {
                break;
            }
        }

        return $rows;
    }

    /**
     * Beneficios compactos para el modal de registro (prueba).
     *
     * @return list<array{0: string, 1: string, 2?: string}>
     */
    public static function trialRegisterFeatures(): array
    {
        $trial = self::trialLimits();

        return [
            ['fa-box', self::formatLimitShort($trial['max_products'], 'producto', 'productos')],
            ['fa-tags', self::formatLimitShort($trial['max_categories'], 'categoría', 'categorías')],
            ['fa-whatsapp', 'Pedidos WA', 'fab'],
            ['fa-palette', 'Tu branding'],
            ['fa-chart-line', 'Panel pedidos'],
            ['fa-percent', '0% comisión'],
        ];
    }

    public static function postTrialMonthlyFormatted(): string
    {
        return PlanPricing::formatUsd(self::monthlyPrice(self::POST_TRIAL_PLAN));
    }

    public static function postTrialMarketingName(): string
    {
        return self::marketingName(self::POST_TRIAL_PLAN);
    }
}
