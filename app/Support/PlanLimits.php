<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;

class PlanLimits
{
    public static function config(?string $plan): array
    {
        return match ($plan ?? 'free_trial') {
            'standard' => self::buildPaidPlanConfig('standard'),
            'premium' => self::buildPaidPlanConfig('premium'),
            default => [
                'key' => 'free_trial',
                'name' => 'Básico',
                'max_products' => 25,
                'max_categories' => 5,
                'price' => 'Bs 0/mes',
            ],
        };
    }

    public static function forShop(?Shop $shop): array
    {
        return self::config($shop?->plan);
    }

    private static function buildPaidPlanConfig(string $key): array
    {
        $limits = PlatformPlanSettings::limits($key);
        $pricing = PlanPricing::for($key);
        $monthly = (float) ($pricing['monthly'] ?? 0);

        return [
            'key' => $key,
            'name' => $limits['name'],
            'max_products' => $limits['max_products'],
            'max_categories' => $limits['max_categories'],
            'price' => PlanPricing::formatUsd($monthly) . '/mes',
        ];
    }

    public static function productsUsage(?Shop $shop = null): array
    {
        $plan = self::forShop($shop ?? config('current_shop'));
        $count = Product::count();

        return self::buildUsage('products', $count, $plan['max_products'], $plan);
    }

    public static function categoriesUsage(?Shop $shop = null): array
    {
        $plan = self::forShop($shop ?? config('current_shop'));
        $count = Category::count();

        return self::buildUsage('categories', $count, $plan['max_categories'], $plan);
    }

    private static function buildUsage(string $type, int $count, ?int $limit, array $plan): array
    {
        $percent = $limit !== null && $limit > 0
            ? min(100, (int) round(($count / $limit) * 100))
            : 0;

        return [
            'type' => $type,
            'current' => $count,
            'limit' => $limit,
            'limit_label' => $limit !== null ? (string) $limit : 'Ilimitados',
            'percent' => $percent,
            'at_limit' => $limit !== null && $count >= $limit,
            'plan_name' => $plan['name'],
            'resource_label' => $type === 'products' ? 'Productos' : 'Categorías',
        ];
    }
}
