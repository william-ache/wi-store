<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        // Las consultas a continuación aplican automáticamente el TenantScope 
        // gracias al Trait 'BelongsToTenant', por lo que ya están aisladas por tienda
        $categories = Category::where('status', true)
            ->with(['products' => function ($query) {
                $query->where('is_available', true);
            }])
            ->get();
            
        $reviews = Review::where('is_approved', true)->latest()->get();
        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 5.0;

        return view('store.index', compact('categories', 'reviews', 'averageRating'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        // El trait BelongsToTenant inyectará automáticamente el shop_id activo
        Review::create($request->all());

        return response()->json(['success' => true]);
    }

    public function registerClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255'
        ]);

        $client = \App\Models\Client::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => $request->name, 'status' => 'Activo']
        );

        return response()->json(['success' => true, 'client' => $client]);
    }

    public function notifyOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'delivery_type' => 'required|string'
        ]);

        \App\Models\Notification::create([
            'title' => 'Nueva orden recibida',
            'content' => 'Has recibido una nueva orden de ' . $request->customer_name . ' (' . $request->customer_phone . ') por un monto de $' . number_format($request->total, 2) . '. Tipo: ' . ($request->delivery_type === 'delivery' ? 'Delivery' : 'Retiro en local') . '.',
            'type' => 'new_order',
            'is_read' => false
        ]);

        return response()->json(['success' => true]);
    }
}
