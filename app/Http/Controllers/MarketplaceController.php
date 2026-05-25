<?php

namespace App\Http\Controllers;

use App\Support\ShopCatalog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        $shops = ShopCatalog::activeShopsQuery()->get();
        $catalog = ShopCatalog::mapForDisplay($shops);

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
