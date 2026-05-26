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

    public static function admin(): self
    {
        $shop = config('current_shop');

        return new self(
            title: 'Panel de administración' . ($shop ? " | {$shop->name}" : ''),
            description: 'Panel administrativo WIStore.',
            canonical: url()->current(),
            noindex: true,
        );
    }
}
