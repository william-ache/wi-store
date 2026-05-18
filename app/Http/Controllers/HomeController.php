<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::query();

        // Si hay una búsqueda de tienda
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Obtener las tiendas activas paginadas o limitadas a 8
        $shops = $query->latest()->paginate(8);

        return view('home', compact('shops'));
    }
}
