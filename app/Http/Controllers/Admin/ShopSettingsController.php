<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ShopSettingsController extends Controller
{
    public function edit()
    {
        $shop = Auth::user()->shop;
        return view('admin.settings', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = Auth::user()->shop;

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
        ]);

        $data = $request->only([
            'name', 'shop_category', 'shop_category_icon', 'whatsapp_number', 'description', 'address', 'google_maps_link', 'base_currency', 'exchange_rate',
            'payment_methods', 'color_primary', 'color_secondary', 'color_background',
            'delivery_rate_per_km', 'latitude', 'longitude',
            'facebook', 'instagram', 'tiktok', 'x_twitter', 'contact_phone', 'contact_sms', 'telegram',
            'has_dine_in', 'has_pickup', 'has_delivery', 'amenities',
            'enable_free_shipping', 'free_shipping_min_amount'
        ]);

        $data['enabled_modules'] = $request->input('enabled_modules', []);

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

        // Subida segura del Logo (elimina el archivo previo si existe)
        if ($request->hasFile('logo')) {
            if ($shop->logo_path && !filter_var($shop->logo_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        // Subida segura de la Portada/Cover (elimina el archivo previo si existe)
        if ($request->hasFile('cover')) {
            if ($shop->cover_path && !filter_var($shop->cover_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
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
        $shop = Auth::user()->shop;
        return view('admin.setup_modules', compact('shop'));
    }

    /**
     * Save the initial configuration of brand & modules.
     */
    public function saveSetupModules(Request $request)
    {
        $shop = Auth::user()->shop;

        $request->validate([
            'enabled_modules' => 'nullable|array',
            'enabled_modules.*' => 'string|in:categories,products,orders,clients,invoices,delivery,analytics,announcements,referrals',
        ]);

        $modules = $request->input('enabled_modules', []);

        $shop->update([
            'enabled_modules' => $modules,
            'has_setup_modules' => true,
        ]);

        return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug])
            ->with('success', '¡Excelente! Tu menú ha sido configurado con éxito.');
    }
}
