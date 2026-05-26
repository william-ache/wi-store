<?php

namespace App\Http\Controllers;

use App\Models\PlatformTestimonial;
use App\Support\ShopCatalog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $shops = ShopCatalog::activeShopsQuery()->get();
        $shopsWithCategories = $shops->map(fn ($shop) => ShopCatalog::enrich($shop));
        $featuredCarouselShops = ShopCatalog::featuredPremiumCarousel(10)
            ->map(fn ($shop) => ShopCatalog::enrich($shop));
        $testimonials = PlatformTestimonial::forLanding();

        return view('home', compact('shops', 'shopsWithCategories', 'featuredCarouselShops', 'testimonials'));
    }
}
