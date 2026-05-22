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
        $shop = \App\Models\Shop::first();
        $categories = Category::where('status', true)
            ->with(['products' => function ($query) {
                $query->where('is_available', true);
            }])
            ->get();

        $reviews = Review::where('is_approved', true)->latest()->get();
        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 5.0;
        $branches = \App\Models\Shop::select('name', 'slug', 'address', 'google_maps_link')->get();

        // Preparar datos de la tienda para la vista
        $company = [
            'name' => $shop->name,
            'slug' => $shop->slug,
            'whatsapp' => $shop->whatsapp_number,
            'whatsapp_number' => $shop->whatsapp_number,
            'description' => $shop->description,
            'address' => $shop->address,
            'google_maps_link' => $shop->google_maps_link,
            'latitude' => $shop->latitude,
            'longitude' => $shop->longitude,
            'delivery_rate_per_km' => $shop->delivery_rate_per_km,
            'work_hours' => $shop->work_hours,
            'base_currency' => $shop->base_currency,
            'exchange_rate' => $shop->exchange_rate,
            'exchange_updated_at' => $shop->exchange_updated_at ?: date('d/m/Y h:i A'),
            'amenities' => $shop->amenities,
            'colors' => [
                'primary' => $shop->color_primary ?? '#E60067',
                'secondary' => $shop->color_secondary ?? '#0B132B',
                'bg_light' => $shop->color_background ?? '#FFFFFF',
            ],
            'logo' => $shop->logo_path ? (filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path)) : null,
            'cover' => $shop->cover_path ? (filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path)) : null,
            'facebook' => $shop->facebook,
            'instagram' => $shop->instagram,
            'tiktok' => $shop->tiktok,
            'x_twitter' => $shop->x_twitter,
            'contact_phone' => $shop->contact_phone,
            'contact_sms' => $shop->contact_sms,
            'telegram' => $shop->telegram,
            'payment_methods' => $shop->payment_methods,
            'plan' => $shop->plan ?? 'standard',
            'subscription_plan' => $shop->plan ?? 'standard',
        ];

        return view('store.index', compact('categories', 'reviews', 'averageRating', 'branches', 'company'));
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
            'delivery_type' => 'required|string',
            'payment_method' => 'nullable|string'
        ]);

        $pmText = $request->payment_method ? ' - Pago: ' . $request->payment_method : '';

        \App\Models\Notification::create([
            'title' => 'Nueva orden recibida',
            'content' => 'Has recibido una nueva orden de ' . $request->customer_name . ' (' . $request->customer_phone . ') por un monto de $' . number_format($request->total, 2) . '. Tipo: ' . ($request->delivery_type === 'delivery' ? 'Delivery' : 'Retiro en local') . $pmText . '.',
            'type' => 'new_order',
            'is_read' => false
        ]);

        return response()->json(['success' => true]);
    }
}
