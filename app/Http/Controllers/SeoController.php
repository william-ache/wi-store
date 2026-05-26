<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $shop = config('current_shop');

        if ($shop) {
            $lines = [
                'User-agent: *',
                'Allow: /',
                'Disallow: /admin/',
                'Disallow: /api/',
                '',
                'Sitemap: ' . url('/sitemap.xml'),
            ];
        } else {
            $lines = [
                'User-agent: *',
                'Allow: /',
                'Disallow: /wydex-super-admin/',
                '',
                'Sitemap: ' . url('/sitemap.xml'),
            ];
        }

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    public function sitemap(): Response
    {
        $shop = config('current_shop');

        if (!$shop) {
            return $this->platformSitemap();
        }

        $xml = Cache::remember("sitemap.shop.{$shop->id}", 3600, function () use ($shop) {
            $urls = collect([
                [
                    'loc' => url('/'),
                    'changefreq' => 'daily',
                    'priority' => '1.0',
                ],
            ]);

            Product::where('is_available', true)->orderBy('updated_at', 'desc')->each(function (Product $product) use ($urls) {
                $urls->push([
                    'loc' => url('/?producto=' . $product->id),
                    'lastmod' => $product->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ]);
            });

            return view('seo.sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    private function platformSitemap(): Response
    {
        $xml = Cache::remember('sitemap.platform', 3600, function () {
            $urls = collect([
                ['loc' => url('/'), 'changefreq' => 'weekly', 'priority' => '1.0'],
                ['loc' => route('tiendas.index'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ]);

            Shop::where('is_active', true)->each(function (Shop $shop) use ($urls) {
                $urls->push([
                    'loc' => url('/' . $shop->slug),
                    'changefreq' => 'daily',
                    'priority' => '0.7',
                ]);
            });

            return view('seo.sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
