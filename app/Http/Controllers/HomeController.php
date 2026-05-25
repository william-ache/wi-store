<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::where('is_active', true)->latest()->get();

        $categoryLabels = [
            'gastronomia' => 'Gastronomía',
            'moda_estilo' => 'Moda y Estilo',
            'detalles_regalos' => 'Detalles y Regalos',
            'servicios' => 'Servicios',
            'otros' => 'Otros',
        ];

        $shopsWithCategories = $shops->map(function ($shop) use ($categoryLabels) {
            $categoryKey = $shop->shop_category ?: 'otros';
            $shop->category = $categoryLabels[$categoryKey] ?? 'Otros';

            return $shop;
        });

        return view('home', compact('shops', 'shopsWithCategories'));
    }
}
