<?php

namespace App\Support;

use App\Models\Shop;

final class PlanFeatures
{
    public const EMPRENDEDOR_PLAN = 'standard';

    public const BRAND_PRIMARY = '#E60067';

    public const BRAND_SECONDARY = '#C6A100';

    public const BRAND_BACKGROUND = '#0b0f19';

    /** @deprecated Use AdminModules::BUSINESS_KEYS */
    public const BUSINESS_ONLY_MODULES = AdminModules::BUSINESS_KEYS;

    public static function resolvePlan(?Shop $shop): string
    {
        if (!$shop) {
            return self::EMPRENDEDOR_PLAN;
        }

        return PlatformPlanSettings::normalizePlanKey((string) ($shop->plan ?? ''));
    }

    /** Módulos que el plan de la tienda permite (configurable en super admin). */
    public static function allowedModulesForShop(?Shop $shop = null): array
    {
        $shop = $shop ?? config('current_shop');

        if (!$shop) {
            return AdminModules::keys();
        }

        return PlatformPlanSettings::allowedModules(self::resolvePlan($shop));
    }

    /** Módulos activos en el panel = selección de la tienda ∩ permitidos por el plan. */
    public static function effectiveModulesForShop(?Shop $shop = null): array
    {
        $shop = $shop ?? config('current_shop');
        $allowed = self::allowedModulesForShop($shop);
        $selected = AdminModules::sanitize($shop?->enabled_modules);

        return array_values(array_intersect($selected, $allowed));
    }

    public static function shopHasModule(?Shop $shop, string $module): bool
    {
        return in_array($module, self::effectiveModulesForShop($shop), true);
    }

    /**
     * Ventas, contactos y finanzas: si el plan permite algún módulo de negocio.
     */
    public static function hasBusinessPanel(?Shop $shop = null): bool
    {
        $allowed = self::allowedModulesForShop($shop);

        return count(array_intersect($allowed, AdminModules::BUSINESS_KEYS)) > 0;
    }

    /** Colores de marca personalizables (plan Negocio y prueba por defecto). */
    public static function canCustomizeBrandColors(?Shop $shop = null): bool
    {
        return self::hasBusinessPanel($shop);
    }

    public static function brandColor(?Shop $shop, string $which): string
    {
        if ($shop && self::canCustomizeBrandColors($shop)) {
            return match ($which) {
                'primary' => $shop->color_primary ?: self::BRAND_PRIMARY,
                'secondary' => $shop->color_secondary ?: self::BRAND_SECONDARY,
                'background' => $shop->color_background ?: self::BRAND_BACKGROUND,
                default => self::BRAND_PRIMARY,
            };
        }

        return match ($which) {
            'primary' => self::BRAND_PRIMARY,
            'secondary' => self::BRAND_SECONDARY,
            'background' => self::BRAND_BACKGROUND,
            default => self::BRAND_PRIMARY,
        };
    }

    public static function textOnPrimaryMode(?Shop $shop): string
    {
        $mode = $shop?->text_on_primary ?? 'white';

        return in_array($mode, ['auto', 'white', 'black'], true) ? $mode : 'white';
    }

    public static function onPrimaryColor(?Shop $shop): string
    {
        return BrandColor::onPrimary(
            BrandColor::normalizeHex(self::brandColor($shop, 'primary')),
            self::textOnPrimaryMode($shop),
        );
    }

    /**
     * @return array{r: int, g: int, b: int}
     */
    public static function onPrimaryColorRgb(?Shop $shop): array
    {
        return BrandColor::rgb(self::onPrimaryColor($shop));
    }

    /** Marca la tienda lista para el panel (módulos según plan / super admin). */
    public static function bootstrapShopModules(Shop $shop): void
    {
        $shop->update([
            'has_setup_modules' => true,
            'enabled_modules' => self::filterEnabledModules(
                $shop->enabled_modules ?: self::allowedModulesForShop($shop),
                $shop,
            ),
        ]);
    }

    /** Recorta módulos y paleta al cambiar de plan. */
    public static function syncShopModulesForPlan(Shop $shop): void
    {
        $shop->refresh();

        $filtered = self::filterEnabledModules($shop->enabled_modules, $shop);

        if ($filtered === []) {
            $filtered = self::allowedModulesForShop($shop);
        }

        $updates = [];

        if ($filtered !== ($shop->enabled_modules ?? [])) {
            $updates['enabled_modules'] = $filtered;
        }

        if (! self::canCustomizeBrandColors($shop)) {
            $updates['color_primary'] = self::BRAND_PRIMARY;
            $updates['color_secondary'] = self::BRAND_SECONDARY;
            $updates['color_background'] = self::BRAND_BACKGROUND;
        }

        if ($updates !== []) {
            $shop->update($updates);
        }
    }

    /**
     * @param  list<string>|null  $modules
     * @return list<string>
     */
    public static function filterEnabledModules(?array $modules, ?Shop $shop = null): array
    {
        $shop = $shop ?? config('current_shop');
        $allowed = self::allowedModulesForShop($shop);
        $modules = AdminModules::sanitize($modules ?? $shop?->enabled_modules);

        return array_values(array_intersect($modules, $allowed));
    }

    public static function routeRequiredModule(?string $routeName): ?string
    {
        if (!$routeName) {
            return null;
        }

        $map = [
            'admin.orders.' => 'orders',
            'admin.clients.' => 'clients',
            'admin.bookings.' => 'clients',
            'admin.abandoned-carts.' => 'orders',
        ];

        foreach ($map as $prefix => $module) {
            if (str_starts_with($routeName, $prefix)) {
                return $module;
            }
        }

        if (str_starts_with($routeName, 'admin.excel.')) {
            $entity = request()->route('entity');

            return match ($entity) {
                'orders', 'abandoned-carts' => 'orders',
                'clients', 'bookings' => 'clients',
                default => null,
            };
        }

        if (str_starts_with($routeName, 'admin.analytics')) {
            return 'analytics';
        }

        if (str_starts_with($routeName, 'admin.announcements') || str_starts_with($routeName, 'admin.coupons')) {
            return 'announcements';
        }

        return null;
    }

    public static function routeRequiresBusinessPanel(?string $routeName): bool
    {
        $module = self::routeRequiredModule($routeName);

        return $module !== null && in_array($module, AdminModules::BUSINESS_KEYS, true);
    }

    public static function routeBlockedForShop(?Shop $shop, ?string $routeName): bool
    {
        $module = self::routeRequiredModule($routeName);

        if ($module === null) {
            return false;
        }

        return ! self::shopHasModule($shop, $module);
    }
}
