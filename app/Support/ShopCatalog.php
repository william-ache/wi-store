<?php

namespace App\Support;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ShopCatalog
{
    public const CATEGORY_LABELS = [
        'gastronomia' => 'Gastronomía',
        'moda_estilo' => 'Moda y Estilo',
        'detalles_regalos' => 'Detalles y Regalos',
        'servicios' => 'Servicios',
        'otros' => 'Otros',
    ];

    /** @var array<string, string> needle (lowercase) => zone label */
    private const ZONE_ALIASES = [
        'distrito capital' => 'Distrito Capital',
        'caracas' => 'Distrito Capital',
        'miranda' => 'Miranda',
        'los teques' => 'Miranda',
        'guarenas' => 'Miranda',
        'guatire' => 'Miranda',
        'aragua' => 'Aragua',
        'maracay' => 'Aragua',
        'la victoria' => 'Aragua',
        'carabobo' => 'Carabobo',
        'valencia' => 'Carabobo',
        'zulia' => 'Zulia',
        'maracaibo' => 'Zulia',
        'lara' => 'Lara',
        'barquisimeto' => 'Lara',
        'bolívar' => 'Bolívar',
        'bolivar' => 'Bolívar',
        'ciudad bolívar' => 'Bolívar',
        'táchira' => 'Táchira',
        'tachira' => 'Táchira',
        'merida' => 'Mérida',
        'mérida' => 'Mérida',
        'anzoátegui' => 'Anzoátegui',
        'anzoategui' => 'Anzoátegui',
        'barcelona' => 'Anzoátegui',
        'puerto la cruz' => 'Anzoátegui',
        'falcón' => 'Falcón',
        'falcon' => 'Falcón',
        'coro' => 'Falcón',
        'portuguesa' => 'Portuguesa',
        'acarigua' => 'Portuguesa',
        'yaracuy' => 'Yaracuy',
        'sucre' => 'Sucre',
        'cumana' => 'Sucre',
        'cumaná' => 'Sucre',
        'monagas' => 'Monagas',
        'maturin' => 'Monagas',
        'maturín' => 'Monagas',
        'guárico' => 'Guárico',
        'guarico' => 'Guárico',
        'san juan de los morros' => 'Guárico',
        'cojedes' => 'Cojedes',
        'trujillo' => 'Trujillo',
        'barinas' => 'Barinas',
        'apure' => 'Apure',
        'amazonas' => 'Amazonas',
        'delta amacuro' => 'Delta Amacuro',
        'nueva esparta' => 'Nueva Esparta',
        'margarita' => 'Nueva Esparta',
        'vargas' => 'La Guaira',
        'la guaira' => 'La Guaira',
    ];

    public static function activeShopsQuery(): Builder
    {
        return Shop::query()->where('is_active', true)->latest();
    }

    public static function enrich(Shop $shop): Shop
    {
        $categoryKey = $shop->shop_category ?: 'otros';
        $shop->category = self::CATEGORY_LABELS[$categoryKey] ?? 'Otros';
        $shop->zone = self::extractZone($shop->address);
        $shop->has_cashea = $shop->hasCasheaAvailable();
        $shop->has_krece = $shop->hasKreceAvailable();

        return $shop;
    }

    public static function mapForDisplay(Collection $shops): Collection
    {
        return $shops->map(fn (Shop $shop) => self::toArray(self::enrich($shop)));
    }

    public static function toArray(Shop $shop): array
    {
        $categoryKey = $shop->shop_category ?: 'otros';

        return [
            'id' => $shop->id,
            'name' => $shop->name,
            'slug' => $shop->slug,
            'description' => $shop->description ?: 'Menú digital con pedidos por WhatsApp.',
            'category' => $shop->category ?? (self::CATEGORY_LABELS[$categoryKey] ?? 'Otros'),
            'category_key' => $categoryKey,
            'zone' => $shop->zone ?? self::extractZone($shop->address),
            'address' => $shop->address,
            'logo_url' => self::mediaUrl($shop->logo_path, $shop->name),
            'cover_url' => self::mediaUrl($shop->cover_path),
            'has_delivery' => (bool) $shop->has_delivery,
            'has_pickup' => (bool) $shop->has_pickup,
            'has_dine_in' => (bool) $shop->has_dine_in,
            'plan' => $shop->plan,
            'has_cashea' => $shop->hasCasheaAvailable(),
            'has_krece' => $shop->hasKreceAvailable(),
            'url' => '/' . $shop->slug,
        ];
    }

    public static function extractZone(?string $address): string
    {
        $address = trim((string) $address);
        if ($address === '') {
            return 'Sin ubicación';
        }

        $normalized = mb_strtolower($address);
        foreach (self::ZONE_ALIASES as $needle => $label) {
            if (str_contains($normalized, $needle)) {
                return $label;
            }
        }

        $segment = trim(explode(',', $address)[0]);
        if ($segment === '' || mb_strlen($segment) > 48) {
            return 'Sin ubicación';
        }

        return $segment;
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $catalog
     * @return array<int, string>
     */
    public static function zonesFromCatalog(Collection $catalog): array
    {
        return $catalog->pluck('zone')
            ->filter()
            ->unique()
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();
    }

    private static function mediaUrl(?string $path, ?string $name = null): ?string
    {
        if (! $path) {
            if ($name) {
                return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=a855f7&color=fff';
            }

            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}
