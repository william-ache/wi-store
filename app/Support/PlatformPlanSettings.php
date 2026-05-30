<?php

namespace App\Support;

use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Cache;

final class PlatformPlanSettings
{
    private const CACHE_KEY = 'platform.plan_settings.v1';

    private const SETTING_KEY = 'plans';

    public static function normalizePlanKey(string $plan): string
    {
        $plan = strtolower(trim($plan));

        return match ($plan) {
            'premium', 'negocio', 'business' => 'premium',
            'free_trial', 'trial' => 'free_trial',
            'standard', 'emprendedor', 'basic' => 'standard',
            default => 'standard',
        };
    }

    /** @return list<string> */
    public static function allowedModules(string $planKey): array
    {
        $key = self::normalizePlanKey($planKey);

        if ($key === 'free_trial') {
            $trial = self::all()['free_trial']['allowed_modules'] ?? null;

            return AdminModules::sanitize(is_array($trial) ? $trial : null);
        }

        $plan = self::plan($key);
        $modules = $plan['allowed_modules'] ?? null;

        return AdminModules::sanitize(is_array($modules) ? $modules : AdminModules::defaultAllowedForPlan($key));
    }

    /** @return array<string, mixed> */
    public static function defaults(): array
    {
        $allModules = AdminModules::keys();

        return [
            'trial_days' => (int) config('wi-store.trial_days', 14),
            'free_trial' => [
                'allowed_modules' => $allModules,
                'max_products' => 40,
                'max_categories' => 8,
            ],
            'plans' => [
                'standard' => [
                    'key' => 'standard',
                    'allowed_modules' => AdminModules::defaultAllowedForPlan('standard'),
                    'marketing_name' => 'Emprendedor',
                    'purpose' => 'Para PYMES que inician su gestión digital: pedidos, inventario y operación en un solo panel.',
                    'monthly' => 8.99,
                    'annual_discount_percent' => 15,
                    'max_products' => 15,
                    'max_categories' => 3,
                    'highlights' => [
                        'Pedidos centralizados · WhatsApp o Telegram · 0% comisión',
                        'Analítica básica en tu panel administrativo',
                        'Gestión de productos, categorías, pedidos y marketing',
                        'Hasta 15 productos · 3 categorías',
                        '1 sede · 1 teléfono · 1 método de pago',
                        'Catálogo digital integrado sin variantes ni extras',
                        'Identidad visual con paleta base de WI-Store',
                        'Soporte estándar de 8am a 3pm de lunes a viernes',
                    ],
                ],
                'premium' => [
                    'key' => 'premium',
                    'allowed_modules' => $allModules,
                    'marketing_name' => 'Negocio',
                    'purpose' => 'Para negocios que escalan: panel administrativo completo, más capacidad y control operativo.',
                    'monthly' => 14.99,
                    'annual_discount_percent' => 25,
                    'max_products' => 40,
                    'max_categories' => 8,
                    'highlights' => [
                        'Panel admin: pedidos, clientes, pagos y reportes',
                        'Hasta 40 productos · 8 categorías',
                        '3 sedes · 3 teléfonos · pagos múltiples',
                        'Variantes y extras (máx. 3 variantes)',
                        'Módulo de servicios comerciales',
                        'Venta online con fotos en catálogo, carrito y modal',
                        'Colores y marca personalizables',
                        'Soporte prioritario 24/7',
                    ],
                ],
            ],
        ];
    }

    /** @return array<string, mixed> */
    public static function all(): array
    {
        return Cache::remember(self::CACHE_KEY, 300, function () {
            $stored = PlatformSetting::query()
                ->where('key', self::SETTING_KEY)
                ->value('value');

            if (!is_array($stored)) {
                return self::defaults();
            }

            return self::merge(self::defaults(), $stored);
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function trialDays(): int
    {
        return max(1, (int) (self::all()['trial_days'] ?? 14));
    }

    /** @return array<string, array<string, mixed>> */
    public static function pricingPlans(): array
    {
        $plans = [];

        foreach (['standard', 'premium'] as $key) {
            $plan = self::plan($key);
            if (!$plan) {
                continue;
            }

            $monthly = (float) $plan['monthly'];
            $discount = (int) $plan['annual_discount_percent'];
            $annualTotal = round($monthly * 12 * (1 - ($discount / 100)), 2);
            $annualMonthly = $annualTotal > 0 ? round($annualTotal / 12, 2) : $monthly;

            $plans[$key] = [
                'key' => $key,
                'name' => $plan['marketing_name'],
                'monthly' => $monthly,
                'annual_discount_percent' => $discount,
                'annual_monthly_equivalent' => $annualMonthly,
                'annual_total' => $annualTotal,
                'annual_savings_label' => self::annualSavingsLabel($discount),
            ];
        }

        return $plans;
    }

    /** @return array<string, mixed>|null */
    public static function plan(string $key): ?array
    {
        $plans = self::all()['plans'] ?? [];

        return is_array($plans[$key] ?? null) ? $plans[$key] : null;
    }

    /** @return list<string> */
    public static function highlights(string $key): array
    {
        $plan = self::plan($key);
        $highlights = $plan['highlights'] ?? [];

        return is_array($highlights) ? array_values(array_filter($highlights, fn ($line) => is_string($line) && trim($line) !== '')) : [];
    }

    public static function purpose(string $key): string
    {
        return (string) (self::plan($key)['purpose'] ?? '');
    }

    /** @return array{max_products: int|null, max_categories: int|null, name: string} */
    public static function limits(string $key): array
    {
        $plan = self::plan($key);

        if (!$plan) {
            return ['max_products' => null, 'max_categories' => null, 'name' => 'Plan'];
        }

        return [
            'max_products' => isset($plan['max_products']) && $plan['max_products'] !== '' ? (int) $plan['max_products'] : null,
            'max_categories' => isset($plan['max_categories']) && $plan['max_categories'] !== '' ? (int) $plan['max_categories'] : null,
            'name' => (string) ($plan['marketing_name'] ?? 'Plan'),
        ];
    }

    /** @param array<string, mixed> $payload */
    public static function save(array $payload): void
    {
        $normalized = self::normalizeInput($payload);

        PlatformSetting::query()->updateOrCreate(
            ['key' => self::SETTING_KEY],
            ['value' => $normalized],
        );

        self::forgetCache();
    }

    /** @param array<string, mixed> $input */
    private static function normalizeInput(array $input): array
    {
        $defaults = self::defaults();
        $trialDays = max(1, (int) ($input['trial_days'] ?? $defaults['trial_days']));

        $plans = [];

        foreach (['standard', 'premium'] as $key) {
            $source = $input['plans'][$key] ?? [];
            $base = $defaults['plans'][$key];

            $highlightsRaw = $source['highlights_text'] ?? $source['highlights'] ?? $base['highlights'];
            if (is_string($highlightsRaw)) {
                $highlights = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $highlightsRaw) ?: [])));
            } elseif (is_array($highlightsRaw)) {
                $highlights = array_values(array_filter(array_map('strval', $highlightsRaw)));
            } else {
                $highlights = $base['highlights'];
            }

            $allowedRaw = $source['allowed_modules'] ?? $base['allowed_modules'] ?? [];
            $allowed = is_array($allowedRaw)
                ? AdminModules::sanitize(array_values($allowedRaw))
                : AdminModules::defaultAllowedForPlan($key);

            $plans[$key] = [
                'key' => $key,
                'marketing_name' => trim((string) ($source['marketing_name'] ?? $base['marketing_name'])),
                'purpose' => trim((string) ($source['purpose'] ?? $base['purpose'])),
                'monthly' => round(max(0, (float) ($source['monthly'] ?? $base['monthly'])), 2),
                'annual_discount_percent' => min(90, max(0, (int) ($source['annual_discount_percent'] ?? $base['annual_discount_percent']))),
                'max_products' => ($source['max_products'] ?? $base['max_products']) === '' || ($source['max_products'] ?? null) === null
                    ? null
                    : max(0, (int) ($source['max_products'] ?? $base['max_products'])),
                'max_categories' => ($source['max_categories'] ?? $base['max_categories']) === '' || ($source['max_categories'] ?? null) === null
                    ? null
                    : max(0, (int) ($source['max_categories'] ?? $base['max_categories'])),
                'highlights' => $highlights,
                'allowed_modules' => $allowed,
            ];
        }

        $trialSource = is_array($input['free_trial'] ?? null) ? $input['free_trial'] : [];
        $trialBase = $defaults['free_trial'];
        $trialModules = $trialSource['allowed_modules'] ?? $trialBase['allowed_modules'] ?? AdminModules::keys();

        return [
            'trial_days' => $trialDays,
            'free_trial' => [
                'allowed_modules' => AdminModules::sanitize(is_array($trialModules) ? array_values($trialModules) : null),
                'max_products' => ($trialSource['max_products'] ?? $trialBase['max_products']) === '' || ($trialSource['max_products'] ?? null) === null
                    ? null
                    : max(0, (int) ($trialSource['max_products'] ?? $trialBase['max_products'])),
                'max_categories' => ($trialSource['max_categories'] ?? $trialBase['max_categories']) === '' || ($trialSource['max_categories'] ?? null) === null
                    ? null
                    : max(0, (int) ($trialSource['max_categories'] ?? $trialBase['max_categories'])),
            ],
            'plans' => $plans,
        ];
    }

    /** @param array<string, mixed> $defaults @param array<string, mixed> $stored */
    private static function merge(array $defaults, array $stored): array
    {
        $merged = $defaults;
        $merged['trial_days'] = (int) ($stored['trial_days'] ?? $defaults['trial_days']);

        if (isset($stored['free_trial']) && is_array($stored['free_trial'])) {
            $merged['free_trial'] = array_replace_recursive($defaults['free_trial'], $stored['free_trial']);
            $merged['free_trial']['allowed_modules'] = AdminModules::sanitize(
                $merged['free_trial']['allowed_modules'] ?? $defaults['free_trial']['allowed_modules'],
            );
            foreach (['max_products', 'max_categories'] as $field) {
                if (array_key_exists($field, $merged['free_trial'])) {
                    $value = $merged['free_trial'][$field];
                    $merged['free_trial'][$field] = $value === '' || $value === null ? null : (int) $value;
                }
            }
        }

        foreach (['standard', 'premium'] as $key) {
            if (!isset($stored['plans'][$key]) || !is_array($stored['plans'][$key])) {
                continue;
            }

            $merged['plans'][$key] = array_replace_recursive($defaults['plans'][$key], $stored['plans'][$key]);
            $merged['plans'][$key]['allowed_modules'] = AdminModules::sanitize(
                $merged['plans'][$key]['allowed_modules'] ?? $defaults['plans'][$key]['allowed_modules'],
            );
        }

        return $merged;
    }

    private static function annualSavingsLabel(int $discountPercent): string
    {
        $months = round(($discountPercent / 100) * 12, 1);

        if ($months >= 1) {
            return sprintf('%.1f Meses (~%d Días)', $months, (int) round($months * 30));
        }

        return 'Sin ahorro anual';
    }
}
