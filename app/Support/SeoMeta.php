<?php

namespace App\Support;

use App\Models\Shop;
use Illuminate\Support\Str;

final class SeoMeta
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public ?string $ogImage = null,
        public string $ogType = 'website',
        public bool $noindex = false,
        public ?array $jsonLd = null,
    ) {}

    public static function forShop(Shop $shop, ?string $pageTitle = null, ?string $description = null): self
    {
        $title = $pageTitle
            ? Str::limit("{$pageTitle} | {$shop->name}", 60, '')
            : Str::limit("{$shop->name} — Menú digital", 60, '');

        $desc = $description
            ?? $shop->description
            ?? "Explora el catálogo de {$shop->name}. Pide por WhatsApp o visita nuestra tienda online.";

        $ogImage = $shop->logoUrl() ?? $shop->coverUrl();

        $canonical = url()->current();

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => $canonical . '#website',
                    'url' => $canonical,
                    'name' => $shop->name,
                ],
                [
                    '@type' => 'Store',
                    '@id' => $canonical . '#store',
                    'name' => $shop->name,
                    'url' => $canonical,
                    'image' => $ogImage,
                    'telephone' => $shop->contact_phone ?: $shop->whatsapp_number,
                ],
            ],
        ];

        return new self(
            title: $title,
            description: Str::limit(strip_tags($desc), 155, ''),
            canonical: $canonical,
            ogImage: $ogImage,
            ogType: 'website',
            noindex: false,
            jsonLd: $jsonLd,
        );
    }

    public static function forMarketplace(): self
    {
        $canonical = route('tiendas.index');

        return new self(
            title: 'Marketplace de tiendas — WI-Store',
            description: 'Explora menús digitales por categoría y zona. Filtra comercios en WI-Store y entra al catálogo en un clic.',
            canonical: $canonical,
            ogType: 'website',
            noindex: false,
            jsonLd: [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'WebPage',
                        '@id' => $canonical . '#webpage',
                        'url' => $canonical,
                        'name' => 'Marketplace de tiendas — WI-Store',
                        'description' => 'Directorio de tiendas con menús digitales y pedidos por WhatsApp.',
                        'isPartOf' => [
                            '@type' => 'WebSite',
                            'name' => 'WI-Store',
                            'url' => url('/'),
                        ],
                    ],
                ],
            ],
        );
    }

    public static function forContacto(): self
    {
        $canonical = route('contacto');

        return new self(
            title: 'Contacto y soporte — WI-Store',
            description: 'Escríbenos por WhatsApp o correo. Te ayudamos con planes, demos y el plan personalizado de WI-Store.',
            canonical: $canonical,
            ogType: 'website',
            noindex: false,
            jsonLd: [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'ContactPage',
                        '@id' => $canonical . '#webpage',
                        'url' => $canonical,
                        'name' => 'Contacto — WI-Store',
                        'description' => 'Canales de atención y soporte para comercios WI-Store.',
                    ],
                ],
            ],
        );
    }

    public static function forLanding(): self
    {
        return new self(
            title: 'WI-Store — Catálogos digitales para WhatsApp y Telegram',
            description: 'Crea tu menú digital, recibe pedidos por WhatsApp o Telegram. Prueba gratis 7 días. Sin comisiones por cada venta.',
            canonical: url('/'),
            ogImage: null,
            ogType: 'website',
            noindex: false,
            jsonLd: [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'Organization',
                        '@id' => url('/') . '#organization',
                        'name' => 'WI-Store',
                        'url' => url('/'),
                    ],
                    [
                        '@type' => 'WebSite',
                        '@id' => url('/') . '#website',
                        'name' => 'WI-Store',
                        'url' => url('/'),
                        'description' => 'Catálogos digitales y pedidos por WhatsApp o Telegram para comercios en Venezuela.',
                        'publisher' => ['@id' => url('/') . '#organization'],
                    ],
                    [
                        '@type' => 'WebPage',
                        '@id' => url('/') . '#webpage',
                        'url' => url('/'),
                        'name' => 'WI-Store — Catálogos digitales para WhatsApp y Telegram',
                        'description' => 'Crea tu menú digital, recibe pedidos por WhatsApp o Telegram. Prueba gratis 7 días.',
                        'isPartOf' => ['@id' => url('/') . '#website'],
                    ],
                ],
            ],
        );
    }

    public static function admin(): self
    {
        $shop = config('current_shop');

        return new self(
            title: 'Panel de administración' . ($shop ? " | {$shop->name}" : ''),
            description: 'Panel administrativo WI-Store.',
            canonical: url()->current(),
            noindex: true,
        );
    }
}
