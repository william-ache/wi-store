<?php

namespace App\Http\Controllers;

use App\Support\ShopCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        /** @var array<int, array<string, mixed>> $shopsData */
        $shopsData = Cache::remember('marketplace.catalog.v2', 600, function () {
            $shops = ShopCatalog::activeShopsQuery()->get();

            return ShopCatalog::mapForDisplay($shops)->values()->all();
        });

        $catalog = collect($shopsData);

        return view('marketplace.index', [
            'shopsJson' => $catalog->values(),
            'zones' => ShopCatalog::zonesFromCatalog($catalog),
            'shopsCount' => $catalog->count(),
            'initialQuery' => (string) $request->query('q', ''),
            'initialCategory' => (string) $request->query('categoria', 'Todos'),
            'initialZone' => (string) $request->query('zona', 'Todas'),
            'initialService' => (string) $request->query('servicio', 'Todos'),
            'initialSort' => (string) $request->query('orden', 'recientes'),
        ]);
    }
}
