<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todas las tiendas activas para el filtrado en tiempo real
        $shops = Shop::where('is_active', true)->latest()->get();

        return view('home', compact('shops'));
    }
}
