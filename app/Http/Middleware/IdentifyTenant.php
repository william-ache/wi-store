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

            // Si la tienda está inactiva
            if (!$shop->is_active) {
                // Determinar si es una ruta administrativa
                $isAdminRoute = $request->is('*/admin*') || $request->routeIs('admin.*');

                if (!$isAdminRoute) {
                    // Es una ruta pública del menú
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'error' => 'Esta tienda se encuentra temporalmente desactivada.'
                        ], 403);
                    }

                    // Compartir las variables de la tienda básicas necesarias para la vista de tienda cerrada
                    $facebook = $shop->facebook;
                    $instagram = $shop->instagram;
                    $tiktok = $shop->tiktok;
                    $x_twitter = $shop->x_twitter;
                    $telegram = $shop->telegram;
                    $whatsapp = $shop->whatsapp_number;

                    $companyData = [
                        'name' => $shop->name,
                        'slug' => $shop->slug,
                        'whatsapp' => $whatsapp,
                        'logo' => $shop->logo_path ? (filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path)) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=1A1A1A&color=fff',
                        'facebook' => $facebook,
                        'instagram' => $instagram,
                        'tiktok' => $tiktok,
                        'x_twitter' => $x_twitter,
                        'telegram' => $telegram,
                        'colors' => [
                            'primary' => $shop->color_primary ?? '#8B5CF6',
                            'secondary' => $shop->color_secondary ?? '#0a051d',
                            'bg_light' => $shop->color_background ?? '#0b0f19',
                        ]
                    ];

                    return response()->view('store.closed', ['company' => $companyData]);
                } else {
                    // Es una ruta del panel administrativo
                    // Compartir la variable global de desactivación
                    \Illuminate\Support\Facades\View::share('shopIsInactive', true);

                    // Si es una petición de modificación (POST, PUT, DELETE, PATCH), bloquearla!
                    if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                        return redirect()->back()->with('error', 'Esta tienda está temporalmente desactivada. No se permite realizar modificaciones en el sistema.');
                    }
                }
            }



            // Control de acceso multi-tenant para el panel administrativo
            if (\Illuminate\Support\Facades\Auth::check() && ($request->is('*/admin*') || $request->routeIs('admin.*'))) {
                $user = \Illuminate\Support\Facades\Auth::user();
                if ($user->shop_id !== $shop->id) {
                    // Obtener la tienda del usuario logueado
                    $userShop = Shop::find($user->shop_id);
                    if ($userShop) {
                        return redirect()->route('admin.dashboard', ['shop_slug' => $userShop->slug])
                            ->with('error', 'No tienes permiso para acceder al panel administrativo de otra tienda.');
                    } else {
                        \Illuminate\Support\Facades\Auth::logout();
                        return redirect()->route('login')->withErrors([
                            'email' => 'Tu usuario no está asociado a una tienda válida.',
                        ]);
                    }
                }
            }

            // Compartir de forma global para las vistas Blade
            View::share('currentShop', $shop);

            $facebook = $shop->facebook;
            $instagram = $shop->instagram;
            $tiktok = $shop->tiktok;
            $x_twitter = $shop->x_twitter;
            $telegram = $shop->telegram;
            $whatsapp = $shop->whatsapp_number;
            $contactPhone = $shop->contact_phone;
            $contactSms = $shop->contact_sms;

            // Mantener compatibilidad con las vistas existentes que usan el array $company
            View::share('company', [
                'name' => $shop->name,
                'slug' => $shop->slug,
                'whatsapp' => $whatsapp,
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
                'has_dine_in' => $shop->has_dine_in,
                'has_pickup' => $shop->has_pickup,
                'has_delivery' => $shop->has_delivery,
                'amenities' => $shop->amenities ?? [],
                'delivery_rate_per_km' => $shop->delivery_rate_per_km,
                'latitude' => $shop->latitude,
                'longitude' => $shop->longitude,
                'facebook' => $facebook,
                'instagram' => $instagram,
                'tiktok' => $tiktok,
                'x_twitter' => $x_twitter,
                'contact_phone' => $contactPhone,
                'contact_sms' => $contactSms,
                'telegram' => $telegram,
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
