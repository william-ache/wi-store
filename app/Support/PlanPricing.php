<?php

namespace App\Support;

final class PlanPricing
{
    /** @var array<string, array<string, mixed>> */
    public const PLANS = [
        'standard' => [
            'key' => 'standard',
            'name' => 'Emprendedor',
            'monthly' => 8.99,
            'annual_discount_percent' => 15,
            'annual_monthly_equivalent' => 7.64,
            'annual_total' => 91.70,
            'annual_savings_label' => '1.8 Meses (~54 Días)',
        ],
        'premium' => [
            'key' => 'premium',
            'name' => 'Negocio',
            'monthly' => 14.99,
            'annual_discount_percent' => 25,
            'annual_monthly_equivalent' => 11.24,
            'annual_total' => 134.91,
            'annual_savings_label' => '3.0 Meses (90 Días)',
        ],
    ];

    public static function for(?string $plan): ?array
    {
        if (!$plan || !isset(self::PLANS[$plan])) {
            return null;
        }

        return self::PLANS[$plan];
    }

    public static function displayName(?string $plan): string
    {
        return self::for($plan)['name'] ?? 'Plan';
    }

    public static function amount(string $plan, string $cycle = 'mensual'): float
    {
        $config = self::for($plan);
        if (!$config) {
            return 0.0;
        }

        return $cycle === 'anual'
            ? (float) $config['annual_total']
            : (float) $config['monthly'];
    }

    public static function formatUsd(float $amount): string
    {
        return '$' . number_format($amount, 2, '.', '');
    }
}
