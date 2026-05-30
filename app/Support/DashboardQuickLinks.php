<?php

namespace App\Support;

use App\Models\Shop;

final class DashboardQuickLinks
{
    public const MIN = 1;

    public const MAX = 6;

    /** @var array<string, array{label: string, path: string, icon: string, icon_bg: string, module?: string, requires_business?: bool}> */
    public const CATALOG = [
        'products' => [
            'label' => 'Cargar Productos',
            'path' => '/admin/products',
            'icon' => '📦',
            'icon_bg' => 'bg-amber-500/15',
            'module' => 'products',
        ],
        'categories' => [
            'label' => 'Categorías',
            'path' => '/admin/categories',
            'icon' => '🗂️',
            'icon_bg' => 'bg-orange-500/15',
            'module' => 'categories',
        ],
        'settings' => [
            'label' => 'Personalizar Tienda',
            'path' => '/admin/settings',
            'icon' => '🎨',
            'icon_bg' => 'bg-violet-500/15',
        ],
        'analytics' => [
            'label' => 'Ver Rendimiento',
            'path' => '/admin/analytics',
            'icon' => '📊',
            'icon_bg' => 'bg-sky-500/15',
            'module' => 'analytics',
        ],
        'orders' => [
            'label' => 'Gestionar Pedidos',
            'path' => '/admin/orders',
            'icon' => '📋',
            'icon_bg' => 'bg-emerald-500/15',
            'module' => 'orders',
            'requires_business' => true,
        ],
        'clients' => [
            'label' => 'Clientes',
            'path' => '/admin/clients',
            'icon' => '👥',
            'icon_bg' => 'bg-blue-500/15',
            'module' => 'clients',
            'requires_business' => true,
        ],
        'announcements' => [
            'label' => 'Campañas',
            'path' => '/admin/announcements',
            'icon' => '📣',
            'icon_bg' => 'bg-pink-500/15',
            'module' => 'announcements',
        ],
        'coupons' => [
            'label' => 'Cupones',
            'path' => '/admin/coupons',
            'icon' => '🏷️',
            'icon_bg' => 'bg-rose-500/15',
            'module' => 'announcements',
        ],
        'bookings' => [
            'label' => 'Reservas',
            'path' => '/admin/bookings',
            'icon' => '📅',
            'icon_bg' => 'bg-indigo-500/15',
            'requires_business' => true,
        ],
        'abandoned-carts' => [
            'label' => 'Carritos Abandonados',
            'path' => '/admin/abandoned-carts',
            'icon' => '🛒',
            'icon_bg' => 'bg-teal-500/15',
            'requires_business' => true,
        ],
        'subscription' => [
            'label' => 'Mi Suscripción',
            'path' => '/admin/subscription',
            'icon' => '💳',
            'icon_bg' => 'bg-yellow-500/15',
        ],
        'tutorials' => [
            'label' => 'Tutoriales',
            'path' => '/admin/tutorials',
            'icon' => '🎓',
            'icon_bg' => 'bg-cyan-500/15',
            'coming_soon' => true,
        ],
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
    public static function defaultsForShop(?Shop $shop): array
    {
        $defaults = ['products', 'settings', 'analytics'];

        if (self::isAvailable('orders', $shop)) {
            $defaults[] = 'orders';
        }

        return $defaults;
    }

    /** @param  list<string>|null  $keys */
    public static function sanitize(?array $keys, ?Shop $shop): array
    {
        $keys = array_values(array_unique(array_filter(
            $keys ?? [],
            fn ($key) => is_string($key) && isset(self::CATALOG[$key]),
        )));

        $keys = array_values(array_filter($keys, fn ($key) => self::isAvailable($key, $shop)));

        if ($keys === []) {
            return self::defaultsForShop($shop);
        }

        return array_slice($keys, 0, self::MAX);
    }

    /** @return list<string> */
    public static function selectedKeysForShop(?Shop $shop): array
    {
        if (! $shop) {
            return self::defaultsForShop(null);
        }

        return self::sanitize($shop->dashboard_quick_links, $shop);
    }

    /** @return list<array{key: string, href: string, icon: string, title: string, iconBg: string}> */
    public static function resolveForShop(?Shop $shop): array
    {
        if (! $shop) {
            return [];
        }

        $slug = $shop->slug;
        $keys = self::selectedKeysForShop($shop);

        return array_map(function (string $key) use ($slug) {
            $item = self::CATALOG[$key];

            return [
                'key' => $key,
                'href' => '/' . $slug . $item['path'],
                'icon' => $item['icon'],
                'title' => $item['label'],
                'iconBg' => $item['icon_bg'],
            ];
        }, $keys);
    }

    /** @return list<array{key: string, label: string, icon: string, icon_bg: string}> */
    public static function catalogForShop(?Shop $shop): array
    {
        $options = [];

        foreach (self::CATALOG as $key => $item) {
            if (! self::isAvailable($key, $shop)) {
                continue;
            }

            $options[] = [
                'key' => $key,
                'label' => $item['label'],
                'icon' => $item['icon'],
                'icon_bg' => $item['icon_bg'],
            ];
        }

        return $options;
    }

    public static function isAvailable(string $key, ?Shop $shop): bool
    {
        $item = self::CATALOG[$key] ?? null;

        if (! $item) {
            return false;
        }

        if (($item['coming_soon'] ?? false)) {
            return false;
        }

        if (($item['requires_business'] ?? false) && ! PlanFeatures::hasBusinessPanel($shop)) {
            return false;
        }

        if (isset($item['module']) && ! PlanFeatures::shopHasModule($shop, $item['module'])) {
            return false;
        }

        return true;
    }
}
