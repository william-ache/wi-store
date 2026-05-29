<?php

namespace App\Support;

use App\Models\Shop;

final class PlanFeatures
{
    public const EMPRENDEDOR_PLAN = 'standard';

    /** Módulos del panel solo disponibles en Plan Negocio (y prueba premium). */
    public const BUSINESS_ONLY_MODULES = [
        'orders',
        'clients',
        'invoices',
        'delivery',
    ];

    public static function resolvePlan(?Shop $shop): string
    {
        if (!$shop) {
            return self::EMPRENDEDOR_PLAN;
        }

        $plan = strtolower(trim((string) ($shop->plan ?? '')));

        return match ($plan) {
            'premium', 'negocio', 'business' => 'premium',
            'free_trial', 'trial' => 'free_trial',
            'standard', 'emprendedor', 'basic' => self::EMPRENDEDOR_PLAN,
            default => self::EMPRENDEDOR_PLAN,
        };
    }

    /**
     * Ventas, contactos, finanzas y sus submenús (plan Negocio / prueba).
     */
    public static function hasBusinessPanel(?Shop $shop = null): bool
    {
        $shop = $shop ?? config('current_shop');

        if (!$shop) {
            return true;
        }

        return self::resolvePlan($shop) !== self::EMPRENDEDOR_PLAN;
    }

    /** Ajusta módulos habilitados cuando la tienda pasa a plan Emprendedor. */
    public static function syncShopModulesForPlan(Shop $shop): void
    {
        $shop->refresh();

        if (self::hasBusinessPanel($shop)) {
            return;
        }

        $filtered = self::filterEnabledModules($shop->enabled_modules, $shop);

        if ($filtered !== ($shop->enabled_modules ?? [])) {
            $shop->update(['enabled_modules' => $filtered]);
        }
    }

    /**
     * @param  list<string>|null  $modules
     * @return list<string>
     */
    public static function filterEnabledModules(?array $modules, ?Shop $shop = null): array
    {
        $shop = $shop ?? config('current_shop');
        $defaults = [
            'categories',
            'products',
            'orders',
            'clients',
            'invoices',
            'delivery',
            'analytics',
            'announcements',
            'referrals',
        ];

        $modules = array_values($modules ?? $shop?->enabled_modules ?? $defaults);

        if (self::hasBusinessPanel($shop)) {
            return $modules;
        }

        return array_values(array_diff($modules, self::BUSINESS_ONLY_MODULES));
    }

    public static function routeRequiresBusinessPanel(?string $routeName): bool
    {
        if (!$routeName) {
            return false;
        }

        $prefixes = [
            'admin.orders.',
            'admin.clients.',
            'admin.bookings.',
            'admin.abandoned-carts.',
            'admin.excel.export',
            'admin.excel.template',
            'admin.excel.import',
        ];

        foreach ($prefixes as $prefix) {
            if (!str_starts_with($routeName, $prefix)) {
                continue;
            }

            if (str_starts_with($routeName, 'admin.excel.')) {
                $entity = request()->route('entity');

                return in_array($entity, ['orders', 'clients', 'bookings', 'abandoned-carts'], true);
            }

            return true;
        }

        return false;
    }
}
