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
}
