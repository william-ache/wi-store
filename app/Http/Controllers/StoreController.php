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
        $shop = config('current_shop') ?: \App\Models\Shop::first();
        $categories = Category::where('status', true)
            ->with(['products' => function ($query) {
                $query->where('is_available', true);
            }])
            ->get();

        $reviews = Review::where('is_approved', true)->latest()->get();
        $averageRating = $reviews->count() > 0 ? $reviews->avg('rating') : 5.0;
        $branches = \App\Models\Shop::select('name', 'slug', 'address', 'google_maps_link')->get();

        // Obtener anuncios activos y vigentes para esta tienda
        $announcements = \App\Models\Announcement::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now()->startOfDay());
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'image_path' => $announcement->image_path ? asset('storage/' . $announcement->image_path) : null,
                    'button_text' => $announcement->button_text,
                    'button_link' => $announcement->button_link,
                ];
            });

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
            'enable_free_shipping' => $shop->enable_free_shipping,
            'free_shipping_min_amount' => $shop->free_shipping_min_amount,
            'work_hours' => $shop->work_hours,
            'base_currency' => $shop->base_currency,
            'has_dine_in' => $shop->has_dine_in ?? true,
            'has_pickup' => $shop->has_pickup ?? true,
            'has_delivery' => $shop->has_delivery ?? true,
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
            'cashea_enabled' => $shop->cashea_enabled,
            'cashea_qr_url' => $shop->casheaQrUrl(),
            'cashea_link_enabled' => $shop->cashea_link_enabled,
            'cashea_link_url' => $shop->cashea_link_url,
            'has_cashea' => $shop->hasCasheaAvailable(),
            'krece_enabled' => $shop->krece_enabled,
            'krece_qr_url' => $shop->kreceQrUrl(),
            'krece_link_enabled' => $shop->krece_link_enabled,
            'krece_link_url' => $shop->krece_link_url,
            'has_krece' => $shop->hasKreceAvailable(),
            'payment_methods' => $shop->payment_methods,
            'plan' => $shop->plan ?? 'standard',
            'subscription_plan' => $shop->plan ?? 'standard',
        ];

        return view('store.index', compact('categories', 'reviews', 'averageRating', 'branches', 'company', 'announcements'));
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
            'table_number' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string',
            'coupon_code' => 'nullable|string'
        ]);

        $pmText = $request->payment_method ? ' - Pago: ' . $request->payment_method : '';
        $couponText = '';

        if ($request->coupon_code) {
            $code = strtoupper(trim($request->coupon_code));
            $coupon = \App\Models\Coupon::where('code', $code)->first();
            if ($coupon) {
                $coupon->increment('used_count');
                $couponText = ' (Cupón: ' . $coupon->code . ')';
            }
        }

        // Obtener cliente para vincular si existe
        $client = \App\Models\Client::where('phone', $request->customer_phone)->first();
        $clientId = $client ? $client->id : null;

        // Generar un número de orden único y estético
        $orderNumber = 'ORD-' . strtoupper(dechex(time())) . rand(10, 99);

        // Guardar físicamente la orden en la base de datos
        \App\Models\Order::create([
            'client_id' => $clientId,
            'order_number' => $orderNumber,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'total' => $request->total,
            'status' => 'pending',
            'payment_method' => $request->payment_method ?: 'efectivo',
            'payment_status' => 'pending',
            'table_number' => $request->table_number,
            'delivery_type' => $request->delivery_type,
        ]);

        $deliveryTypeText = $request->delivery_type === 'delivery' ? 'Delivery' : ($request->delivery_type === 'dine_in' ? 'Consumo en Mesa #' . $request->table_number : 'Retiro en local');

        \App\Models\Notification::create([
            'title' => 'Nueva orden recibida',
            'content' => 'Has recibido una nueva orden de ' . $request->customer_name . ' (' . $request->customer_phone . ') por un monto de $' . number_format($request->total, 2) . '. Tipo: ' . $deliveryTypeText . $pmText . $couponText . '.',
            'type' => 'new_order',
            'is_read' => false
        ]);

        // Eliminar registro de telemetría de carrito abandonado si existía
        \App\Models\AbandonedCart::where('customer_phone', $request->customer_phone)->delete();

        return response()->json(['success' => true]);
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'El código de cupón ingresado no existe.'
            ]);
        }

        $validation = $coupon->validateForAmount($request->subtotal);
        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validation['message']
            ]);
        }

        $discount = 0.00;
        if ($coupon->type === 'percentage') {
            $discount = $request->subtotal * ($coupon->value / 100);
        } else {
            $discount = $coupon->value;
        }

        if ($discount > $request->subtotal) {
            $discount = $request->subtotal;
        }

        return response()->json([
            'success' => true,
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'discount' => round($discount, 2),
            ]
        ]);
    }

    /**
     * Submit a public booking from the storefront.
     */
    public function submitBooking(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string|max:255',
        ]);

        $booking = \App\Models\Booking::create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'status' => 'pending',
        ]);

        // Registrar cliente si no existe
        \App\Models\Client::firstOrCreate(
            ['phone' => $request->client_phone],
            ['name' => $request->client_name, 'status' => 'Activo']
        );

        \App\Models\Notification::create([
            'title' => 'Nueva solicitud de reserva',
            'content' => 'Has recibido una nueva solicitud de reserva de ' . $request->client_name . ' (' . $request->client_phone . ') para el día ' . date('d/m/Y', strtotime($request->date)) . ' en el bloque horario ' . $request->time_slot . '.',
            'type' => 'new_booking',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reserva solicitada con éxito. Por favor finaliza el proceso enviando la confirmación por WhatsApp.',
            'booking' => $booking
        ]);
    }

    /**
     * Save cart telemetry for active shopping sessions to track abandoned carts.
     */
    public function saveCartTelemetry(Request $request)
    {
        $request->validate([
            'customer_phone' => 'required|string|max:50',
            'customer_name' => 'nullable|string|max:255',
            'cart_data' => 'required|array',
        ]);

        if (empty($request->cart_data)) {
            \App\Models\AbandonedCart::where('customer_phone', $request->customer_phone)->delete();
            return response()->json(['success' => true, 'message' => 'Carrito vacío, telemetría removida.']);
        }

        $cart = \App\Models\AbandonedCart::updateOrCreate(
            ['customer_phone' => $request->customer_phone],
            [
                'customer_name' => $request->customer_name ?: 'Cliente Anónimo',
                'cart_data' => $request->cart_data,
                'status' => 'abandoned'
            ]
        );

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    /**
     * Generate dynamic PWA manifest based on active shop configurations.
     */
    public function manifest()
    {
        $shop = config('current_shop') ?: \App\Models\Shop::first();
        
        $host = request()->getHost();
        $isCustomDomain = !str_ends_with($host, 'wistore.com') && $host !== 'localhost' && $host !== '127.0.0.1' && $shop->custom_domain === $host;
        $startUrl = $isCustomDomain ? '/' : '/' . $shop->slug;

        $logoUrl = $shop->logo_path ? (filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path)) : 'https://ui-avatars.com/api/?name='.urlencode($shop->name).'&background=1A1A1A&color=fff';

        $manifest = [
            'name' => $shop->name,
            'short_name' => $shop->name,
            'description' => $shop->description ?: 'Catálogo digital interactivo.',
            'start_url' => $startUrl,
            'background_color' => $shop->color_background ?: '#0B0F19',
            'theme_color' => $shop->color_primary ?: '#E60067',
            'display' => 'standalone',
            'orientation' => 'portrait',
            'icons' => [
                [
                    'src' => $logoUrl,
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable'
                ]
            ]
        ];

        return response()->json($manifest)
            ->header('Content-Type', 'application/manifest+json');
    }

    /**
     * Dynamic service worker script for offline capability.
     */
    public function serviceWorker()
    {
        $js = <<<JS
const CACHE_NAME = 'wistore-cache-v1';
const urlsToCache = [
    '/',
    '/css/app.css',
    '/js/app.js'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                return fetch(event.request);
            })
    );
});
JS;

        return response($js)
            ->header('Content-Type', 'application/javascript');
    }
}
