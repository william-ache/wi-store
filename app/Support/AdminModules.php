<?php

namespace App\Support;

final class AdminModules
{
    /** @var array<string, array{label: string, icon: string, group: string}> */
    public const CATALOG = [
        'categories' => ['label' => 'Categorías', 'icon' => 'fa-layer-group', 'group' => 'inventario'],
        'products' => ['label' => 'Productos', 'icon' => 'fa-burger', 'group' => 'inventario'],
        'orders' => ['label' => 'Pedidos', 'icon' => 'fa-clipboard-list', 'group' => 'ventas'],
        'clients' => ['label' => 'Clientes', 'icon' => 'fa-users', 'group' => 'contactos'],
        'invoices' => ['label' => 'Facturas', 'icon' => 'fa-file-invoice', 'group' => 'finanzas'],
        'delivery' => ['label' => 'Delivery', 'icon' => 'fa-motorcycle', 'group' => 'ventas'],
        'analytics' => ['label' => 'Analítica', 'icon' => 'fa-chart-line', 'group' => 'general'],
        'announcements' => ['label' => 'Marketing', 'icon' => 'fa-bullhorn', 'group' => 'marketing'],
        'referrals' => ['label' => 'Referidos', 'icon' => 'fa-link', 'group' => 'marketing'],
    ];

    /** Módulos que históricamente requerían plan Negocio / prueba. */
    public const BUSINESS_KEYS = [
        'orders',
        'clients',
        'invoices',
        'delivery',
    ];

    /** @return list<string> */
    public static function keys(): array
    {
        return array_keys(self::CATALOG);
    }

    public static function validationRule(): string
    {
        return 'string|in:' . implode(',', self::keys());
    }

    /** @return list<string> */
    public static function defaultAllowedForPlan(string $planKey): array
    {
        $all = self::keys();

        return match (PlatformPlanSettings::normalizePlanKey($planKey)) {
            'standard' => array_values(array_diff($all, self::BUSINESS_KEYS)),
            'free_trial', 'premium' => $all,
            default => array_values(array_diff($all, self::BUSINESS_KEYS)),
        };
    }

    /** @param  list<string>|null  $modules */
    public static function sanitize(?array $modules): array
    {
        $modules = array_values(array_unique(array_filter(
            $modules ?? [],
            fn ($key) => is_string($key) && isset(self::CATALOG[$key]),
        )));

        return $modules !== [] ? $modules : self::keys();
    }
}
