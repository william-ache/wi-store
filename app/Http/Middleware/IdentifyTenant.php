<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $shopSlug = $request->route('shop_slug');

        if ($shopSlug) {
            $shop = Shop::where('slug', $shopSlug)->first();

            if (!$shop) {
                abort(404, 'Tienda no encontrada.');
            }

            // Registrar en config para los global scopes
            config(['current_shop' => $shop]);
            config(['current_shop_id' => $shop->id]);

            // Compartir de forma global para las vistas Blade
            View::share('currentShop', $shop);

            // Mantener compatibilidad con las vistas existentes que usan el array $company
            View::share('company', [
                'name' => $shop->name,
                'slug' => $shop->slug,
                'whatsapp' => $shop->whatsapp_number,
                'logo' => $shop->logo_path ? (filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path)) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=1A1A1A&color=fff',
                'cover' => $shop->cover_path ? (filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path)) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200',
                'description' => $shop->description,
                'address' => $shop->address,
                'payment_methods' => $shop->payment_methods,
                'exchange_rate' => $shop->exchange_rate,
                'exchange_updated_at' => $shop->exchange_updated_at ?: date('d/m/Y h:i A'),
                'google_maps_link' => $shop->google_maps_link,
                'work_hours' => $shop->work_hours,
                'base_currency' => $shop->base_currency,
                'delivery_rate_per_km' => $shop->delivery_rate_per_km,
                'latitude' => $shop->latitude,
                'longitude' => $shop->longitude,
                'colors' => [
                    'primary' => $shop->color_primary,
                    'secondary' => $shop->color_secondary,
                    'bg_light' => $shop->color_background,
                    'bg_accent' => $shop->color_background, // fallback
                ]
            ]);

            // Limpiar parámetro de la ruta para los controladores
            $request->route()->forgetParameter('shop_slug');
        }

        return $next($request);
    }
}
