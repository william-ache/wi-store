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

            // Auto-login de desarrollo para poder probar el panel de administración localmente de la tienda demo
            if (app()->environment('local') && !app()->runningInConsole() && !\Illuminate\Support\Facades\Auth::check()) {
                if ($shop->slug === 'demo' && ($request->is('*/admin*') || $request->routeIs('admin.*'))) {
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                            $user = \App\Models\User::where('email', 'admin@wistore.com')->first();
                            if ($user) {
                                \Illuminate\Support\Facades\Auth::login($user);
                            }
                        }
                    } catch (\Throwable $e) {
                        // Ignorar silenciosamente
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

            // Valores de prueba para la demo si están vacíos
            $facebook = $shop->facebook;
            $instagram = $shop->instagram;
            $tiktok = $shop->tiktok;
            $x_twitter = $shop->x_twitter;
            $telegram = $shop->telegram;
            $whatsapp = $shop->whatsapp_number;
            $contactPhone = $shop->contact_phone;
            $contactSms = $shop->contact_sms;

            if ($shop->slug === 'demo') {
                if (empty($facebook)) $facebook = 'https://facebook.com';
                if (empty($instagram)) $instagram = 'https://instagram.com';
                if (empty($tiktok)) $tiktok = 'https://tiktok.com';
                if (empty($x_twitter)) $x_twitter = 'https://x.com';
                if (empty($telegram)) $telegram = 'https://t.me/wydex_demo';
                if (empty($whatsapp)) $whatsapp = 'Ventas:+584120000000,Soporte:+584121111111';
                if (empty($contactPhone)) $contactPhone = '+584120000000';
                if (empty($contactSms)) $contactSms = '+584120000000';
            }

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
