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
        $host = $request->getHost();
        $shop = Shop::where('custom_domain', $host)->first();

        if (!$shop) {
            $shopSlug = $request->route('shop_slug');
            if ($shopSlug) {
                $shop = Shop::where('slug', $shopSlug)->first();
            }
        }

        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        // Registrar en config para los global scopes (siempre datos frescos de BD)
        $shop = $shop->fresh() ?? $shop;
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
                    'logo' => $shop->logoUrl() ?? 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=1A1A1A&color=fff',
                    'facebook' => $facebook,
                    'instagram' => $instagram,
                    'tiktok' => $tiktok,
                    'x_twitter' => $x_twitter,
                    'telegram' => $telegram,
                    'colors' => [
                        'primary' => \App\Support\PlanFeatures::brandColor($shop, 'primary'),
                        'secondary' => \App\Support\PlanFeatures::brandColor($shop, 'secondary'),
                        'bg_light' => \App\Support\PlanFeatures::brandColor($shop, 'background'),
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

                if ($shop->plan === 'standard' && $shop->active_session_id && $shop->active_session_id !== $request->session()->getId()) {
                    \Illuminate\Support\Facades\Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->withErrors([
                        'email' => 'Tu sesión fue cerrada porque se inició una nueva sesión en este plan estándar.',
                    ]);
                }

                if (!$shop->has_setup_modules) {
                    \App\Support\PlanFeatures::bootstrapShopModules($shop);
                    $shop->refresh();
                }

                // --- CONTROL DE VENCIMIENTO DE PLAN / PRUEBA GRATIS ---
                $isExpired = $shop->plan_expires_at && $shop->plan_expires_at->isPast();
                $isPendingPayment = $shop->payment_status === 'pending';
                $isRejectedPayment = $shop->payment_status === 'rejected';

                if ($isExpired || $isPendingPayment || $isRejectedPayment) {
                    // Excluir rutas de facturación para evitar redirección infinita
                    $isBillingRoute = $request->is('*/admin/billing*') || $request->routeIs('admin.billing.*') || $request->is('*/logout');
                    if (!$isBillingRoute) {
                        return redirect()->route('admin.billing.expired', ['shop_slug' => $shop->slug]);
                    }
                }
            }

            // Compartir de forma global para las vistas Blade
            View::share('currentShop', $shop);
            View::share('planHasBusinessModules', \App\Support\PlanFeatures::hasBusinessPanel($shop));
            View::share('shopEffectiveModules', \App\Support\PlanFeatures::effectiveModulesForShop($shop));

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
                'shop_category' => $shop->shop_category,
                'shop_category_icon' => $shop->shop_category_icon,
                'whatsapp' => $whatsapp,
                'logo' => $shop->logoUrl() ?? 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=1A1A1A&color=fff',
                'cover' => $shop->coverUrl() ?? 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200',
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
                'enable_free_shipping' => $shop->enable_free_shipping,
                'free_shipping_min_amount' => $shop->free_shipping_min_amount,
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
                'facebook_pixel_id' => $shop->facebook_pixel_id,
                'tiktok_pixel_id' => $shop->tiktok_pixel_id,
                'google_analytics_id' => $shop->google_analytics_id,
                'stripe_enabled' => $shop->stripe_enabled,
                'stripe_publishable_key' => $shop->stripe_publishable_key,
                'binance_enabled' => $shop->binance_enabled,
                'pagomovil_enabled' => $shop->pagomovil_enabled,
                'pagomovil_bank' => $shop->pagomovil_bank,
                'pagomovil_phone' => $shop->pagomovil_phone,
                'pagomovil_id' => $shop->pagomovil_id,
                'colors' => [
                    'primary' => \App\Support\PlanFeatures::brandColor($shop, 'primary'),
                    'secondary' => \App\Support\PlanFeatures::brandColor($shop, 'secondary'),
                    'bg_light' => \App\Support\PlanFeatures::brandColor($shop, 'background'),
                    'bg_accent' => \App\Support\PlanFeatures::brandColor($shop, 'background'),
                ]
            ]);

            // Limpiar parámetro de la ruta para los controladores
            $request->route()->forgetParameter('shop_slug');

        return $next($request);
    }
}
