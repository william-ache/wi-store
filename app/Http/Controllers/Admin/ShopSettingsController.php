<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\ImageOptimizer;
use App\Support\PlanFeatures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopSettingsController extends Controller
{
    public function __construct(
        private readonly ImageOptimizer $imageOptimizer,
    ) {}
    protected function currentShop(): Shop
    {
        $shop = config('current_shop') ?? Auth::user()?->shop;

        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        return $shop;
    }

    public function edit()
    {
        $shop = $this->currentShop();
        return view('admin.settings', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = $this->currentShop();

        $request->validate([
            'name' => 'required|string|max:255',
            'shop_category' => 'nullable|string|max:255',
            'shop_category_icon' => 'nullable|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'google_maps_link' => 'nullable|url|max:500',
            'work_hours' => 'nullable|string',
            'work_hours_type' => 'nullable|string|in:simple,custom',
            'work_hours_simple' => 'nullable|string',
            'schedule' => 'nullable|array',
            'base_currency' => 'nullable|string|max:10',
            'exchange_rate' => 'nullable|string|max:50',
            'payment_methods' => 'nullable|string',
            'color_primary' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/i',
            'color_secondary' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/i',
            'color_background' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/i',
            'delivery_rate_per_km' => 'nullable|numeric|min:0',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'enable_free_shipping' => 'nullable|boolean',
            'free_shipping_min_amount' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|max:2048',
            'cover' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'x_twitter' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:30',
            'contact_sms' => 'nullable|string|max:30',
            'telegram' => 'nullable|string|max:255',
            'has_dine_in' => 'nullable|boolean',
            'has_pickup' => 'nullable|boolean',
            'has_delivery' => 'nullable|boolean',
            'amenities' => 'nullable|array',
            'enabled_modules' => 'nullable|array',
            'enabled_modules.*' => 'string|in:categories,products,orders,clients,invoices,delivery,analytics,announcements,referrals',
            'custom_domain' => 'nullable|string|max:255|unique:shops,custom_domain,' . $shop->id,
            'facebook_pixel_id' => 'nullable|string|max:255',
            'tiktok_pixel_id' => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:255',
            'stripe_enabled' => 'nullable|boolean',
            'stripe_publishable_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'binance_enabled' => 'nullable|boolean',
            'binance_api_key' => 'nullable|string',
            'binance_secret_key' => 'nullable|string',
            'pagomovil_enabled' => 'nullable|boolean',
            'pagomovil_bank' => 'nullable|string|max:255',
            'pagomovil_phone' => 'nullable|string|max:255',
            'pagomovil_id' => 'nullable|string|max:255',
            'cashea_enabled' => 'nullable|boolean',
            'cashea_qr' => 'nullable|image|max:4096',
            'remove_cashea_qr' => 'nullable|boolean',
            'cashea_link_enabled' => 'nullable|boolean',
            'cashea_link_url' => 'nullable|url|max:500',
            'krece_enabled' => 'nullable|boolean',
            'krece_qr' => 'nullable|image|max:4096',
            'remove_krece_qr' => 'nullable|boolean',
            'krece_link_enabled' => 'nullable|boolean',
            'krece_link_url' => 'nullable|url|max:500',
        ]);

        $data = $request->only([
            'name', 'shop_category', 'shop_category_icon', 'whatsapp_number', 'description', 'address', 'google_maps_link', 'base_currency', 'exchange_rate',
            'payment_methods', 'color_primary', 'color_secondary', 'color_background',
            'delivery_rate_per_km', 'latitude', 'longitude',
            'facebook', 'instagram', 'tiktok', 'x_twitter', 'contact_phone', 'contact_sms', 'telegram',
            'has_dine_in', 'has_pickup', 'has_delivery', 'amenities',
            'enable_free_shipping', 'free_shipping_min_amount',
            'custom_domain', 'facebook_pixel_id', 'tiktok_pixel_id', 'google_analytics_id',
            'stripe_publishable_key', 'stripe_secret_key',
            'binance_api_key', 'binance_secret_key',
            'pagomovil_bank', 'pagomovil_phone', 'pagomovil_id',
            'cashea_link_url',
            'krece_link_url',
        ]);

        $data['stripe_enabled'] = $request->has('stripe_enabled');
        $data['binance_enabled'] = $request->has('binance_enabled');
        $data['pagomovil_enabled'] = $request->has('pagomovil_enabled');
        $data['cashea_enabled'] = $request->has('cashea_enabled');
        $data['cashea_link_enabled'] = $request->has('cashea_link_enabled');
        $data['krece_enabled'] = $request->has('krece_enabled');
        $data['krece_link_enabled'] = $request->has('krece_link_enabled');
        $data['enabled_modules'] = PlanFeatures::filterEnabledModules(
            $request->input('enabled_modules', []),
            $shop
        );

        // Actualizar fecha de actualización de tasa de cambio si se modificó
        if ($request->filled('exchange_rate')) {
            $data['exchange_updated_at'] = date('d/m/Y h:i A');
        }

        // Manejar horarios de trabajo con la nueva estructura
        if ($request->filled('work_hours_type')) {
            $workHoursType = $request->work_hours_type;
            $workHoursData = [
                'type' => $workHoursType
            ];

            if ($workHoursType === 'simple') {
                $workHoursData['text'] = $request->work_hours_simple ?? '';
            } elseif ($workHoursType === 'custom') {
                $workHoursData['schedule'] = $request->schedule ?? [];
            }

            $data['work_hours'] = json_encode($workHoursData);
        } elseif ($request->filled('work_hours')) {
            // Mantener compatibilidad con el formato antiguo
            $decoded = json_decode($request->work_hours, true);
            $data['work_hours'] = is_array($decoded) ? json_encode($decoded) : $request->work_hours;
        } else {
            $data['work_hours'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($shop->logo_path && !filter_var($shop->logo_path, FILTER_VALIDATE_URL)) {
                $this->imageOptimizer->deleteStoredImages($shop->logo_path, $shop->logo_webp_path);
            }
            $data = array_merge($data, $this->imageOptimizer->storeLogoImage($request->file('logo')));
        }

        if ($request->hasFile('cover')) {
            if ($shop->cover_path && !filter_var($shop->cover_path, FILTER_VALIDATE_URL)) {
                $this->imageOptimizer->deleteStoredImages($shop->cover_path, $shop->cover_webp_path);
            }
            $data = array_merge($data, $this->imageOptimizer->storeCoverImage($request->file('cover')));
        }

        if ($request->hasFile('cashea_qr')) {
            if ($shop->cashea_qr_path && ! filter_var($shop->cashea_qr_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->cashea_qr_path);
            }
            $data['cashea_qr_path'] = $request->file('cashea_qr')->store('cashea', 'public');
        }

        if ($request->boolean('remove_cashea_qr') && $shop->cashea_qr_path) {
            if (! filter_var($shop->cashea_qr_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->cashea_qr_path);
            }
            $data['cashea_qr_path'] = null;
        }

        if ($request->hasFile('krece_qr')) {
            if ($shop->krece_qr_path && ! filter_var($shop->krece_qr_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->krece_qr_path);
            }
            $data['krece_qr_path'] = $request->file('krece_qr')->store('krece', 'public');
        }

        if ($request->boolean('remove_krece_qr') && $shop->krece_qr_path) {
            if (! filter_var($shop->krece_qr_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->krece_qr_path);
            }
            $data['krece_qr_path'] = null;
        }

        $shop->update($data);

        // Actualizar contraseña si se proporcionó
        if ($request->filled('password')) {
            $user = Auth::user();
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Configuración de tienda actualizada exitosamente.');
    }

    public function resolveShortUrl(Request $request)
    {
        $url = $request->input('url');
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'URL inválida'], 400);
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
            curl_exec($ch);
            $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);

            return response()->json(['url' => $effectiveUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the brand & modules wizard for first-time login.
     */
    public function setupModulesForm()
    {
        $shop = $this->currentShop();
        return view('admin.setup_modules', compact('shop'));
    }

    /**
     * Save the initial configuration of brand & modules.
     */
    public function saveSetupModules(Request $request)
    {
        $shop = $this->currentShop();

        $request->validate([
            'enabled_modules' => 'nullable|array',
            'enabled_modules.*' => 'string|in:categories,products,orders,clients,invoices,delivery,analytics,announcements,referrals',
        ]);

        $modules = PlanFeatures::filterEnabledModules($request->input('enabled_modules', []), $shop);

        $shop->update([
            'enabled_modules' => $modules,
            'has_setup_modules' => true,
        ]);

        return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug])
            ->with('success', '¡Excelente! Tu menú ha sido configurado con éxito.');
    }
}
