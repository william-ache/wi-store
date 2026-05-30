<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Support\AdminModules;
use App\Support\PlanFeatures;
use App\Support\PlanPricing;
use App\Support\PlatformPlanSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function index()
    {
        return redirect()->route('super-admin.companies.index');
    }

    public function companies()
    {
        $shops = Shop::with('users')->latest()->get();
        $pendingShops = Shop::with('users')->where('payment_status', 'pending')->latest()->get();

        return view('super-admin.companies.index', [
            'shops' => $shops,
            'pendingShops' => $pendingShops,
            'activeModule' => 'empresas',
            'planModulesMap' => [
                'free_trial' => PlatformPlanSettings::allowedModules('free_trial'),
                'standard' => PlatformPlanSettings::allowedModules('standard'),
                'premium' => PlatformPlanSettings::allowedModules('premium'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shop_category' => 'nullable|string|in:gastronomia,moda_estilo,detalles_regalos,servicios,otros',
            'shop_category_icon' => 'nullable|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'plan' => 'required|string|in:free_trial,standard,premium',
            'billing_cycle' => 'required|string|in:mensual,anual',
            'color_primary' => 'required|string|max:20',
            'color_secondary' => 'required|string|max:20',
            'color_background' => 'required|string|max:20',
            'text_on_primary' => 'nullable|string|in:auto,white,black',
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|string|max:2048',
            'cover' => 'nullable|image|max:4096',
            'cover_url' => 'nullable|string|max:2048',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'plan_expires_at' => 'nullable|date',
            'last_payment_date' => 'nullable|date',
            'last_payment_amount' => 'nullable|numeric|min:0',
            'enabled_modules' => 'nullable|array',
            'enabled_modules.*' => AdminModules::validationRule(),
        ]);

        // Generar slug unico
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Shop::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Manejar subida de logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        } elseif ($request->filled('logo_url')) {
            $logoPath = $request->logo_url;
        }

        // Manejar subida de portada
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        } elseif ($request->filled('cover_url')) {
            $coverPath = $request->cover_url;
        }

        // Calcular valores por defecto para suscripción si no vienen
        $defaultDays = $request->plan === 'free_trial' ? \App\Support\PlanTrial::days() : ($request->billing_cycle === 'anual' ? 365 : 30);
        $planExpiresAt = $request->filled('plan_expires_at') ? $request->plan_expires_at : now()->addDays($defaultDays)->format('Y-m-d');
        $lastPaymentDate = $request->filled('last_payment_date') ? $request->last_payment_date : now()->format('Y-m-d');
        
        $lastPaymentAmount = $request->last_payment_amount;
        if (is_null($lastPaymentAmount) || $lastPaymentAmount === '') {
            if (in_array($request->plan, ['standard', 'premium'], true)) {
                $lastPaymentAmount = PlanPricing::amount(
                    $request->plan,
                    $request->billing_cycle === 'anual' ? 'anual' : 'mensual'
                );
            } else {
                $lastPaymentAmount = 0.00;
            }
        }

        $categoryIcons = [
            'gastronomia' => '🍽️',
            'moda_estilo' => '👗',
            'detalles_regalos' => '🎁',
            'servicios' => '🔧',
            'otros' => '📦',
        ];
        $shopCategory = $request->shop_category ?: 'otros';
        $shopCategoryIcon = $request->filled('shop_category_icon') ? $request->shop_category_icon : ($categoryIcons[$shopCategory] ?? '📦');

        // Crear la tienda (Shop)
        $shop = Shop::create([
            'name' => $request->name,
            'slug' => $slug,
            'shop_category' => $shopCategory,
            'shop_category_icon' => $shopCategoryIcon,
            'whatsapp_number' => $request->whatsapp_number,
            'description' => $request->description,
            'address' => $request->address,
            'color_primary' => $request->color_primary,
            'color_secondary' => $request->color_secondary,
            'color_background' => $request->color_background,
            'text_on_primary' => $request->input('text_on_primary', 'white'),
            'logo_path' => $logoPath,
            'cover_path' => $coverPath,
            'plan' => $request->plan,
            'billing_cycle' => $request->plan === 'free_trial' ? 'mensual' : $request->billing_cycle,
            'plan_expires_at' => $planExpiresAt,
            'last_payment_date' => $lastPaymentDate,
            'last_payment_amount' => $lastPaymentAmount,
            'is_active' => true,
        ]);

        PlanFeatures::bootstrapShopModules($shop);
        PlanFeatures::syncShopModulesForPlan($shop->fresh());

        if ($request->filled('enabled_modules')) {
            $shop->update([
                'enabled_modules' => PlanFeatures::filterEnabledModules($request->input('enabled_modules'), $shop->fresh()),
            ]);
        }

        // Crear el Usuario administrador de esa tienda
        User::create([
            'shop_id' => $shop->id,
            'name' => 'Administrador de ' . $shop->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'temp_password' => $request->password,
        ]);

        return redirect()->back()->with('success', '¡Tienda "' . $shop->name . '" y su respectivo administrador creados con éxito!');
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $user = User::where('shop_id', $shop->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'shop_category' => 'nullable|string|in:gastronomia,moda_estilo,detalles_regalos,servicios,otros',
            'shop_category_icon' => 'nullable|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'plan' => 'required|string|in:free_trial,standard,premium',
            'billing_cycle' => 'required|string|in:mensual,anual',
            'color_primary' => 'required|string|max:20',
            'color_secondary' => 'required|string|max:20',
            'color_background' => 'required|string|max:20',
            'text_on_primary' => 'nullable|string|in:auto,white,black',
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|string|max:2048',
            'cover' => 'nullable|image|max:4096',
            'cover_url' => 'nullable|string|max:2048',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'plan_expires_at' => 'nullable|date',
            'last_payment_date' => 'nullable|date',
            'last_payment_amount' => 'nullable|numeric|min:0',
            'enabled_modules' => 'nullable|array',
            'enabled_modules.*' => AdminModules::validationRule(),
        ]);

        // Generar slug unico si el nombre cambió
        $slug = $shop->slug;
        if ($shop->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Shop::where('slug', $slug)->where('id', '!=', $shop->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        $categoryIcons = [
            'gastronomia' => '🍽️',
            'moda_estilo' => '👗',
            'detalles_regalos' => '🎁',
            'servicios' => '🔧',
            'otros' => '📦',
        ];
        $shopCategory = $request->shop_category ?: ($shop->shop_category ?: 'otros');
        $shopCategoryIcon = $request->filled('shop_category_icon') ? $request->shop_category_icon : ($categoryIcons[$shopCategory] ?? '📦');

        // Manejar logo
        $logoPath = $shop->logo_path;
        if ($request->hasFile('logo')) {
            if ($shop->logo_path && !filter_var($shop->logo_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->logo_path);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        } elseif ($request->filled('logo_url')) {
            $logoPath = $request->logo_url;
        }

        // Manejar portada
        $coverPath = $shop->cover_path;
        if ($request->hasFile('cover')) {
            if ($shop->cover_path && !filter_var($shop->cover_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($shop->cover_path);
            }
            $coverPath = $request->file('cover')->store('covers', 'public');
        } elseif ($request->filled('cover_url')) {
            $coverPath = $request->cover_url;
        }

        $shop->plan = $request->plan;
        $shop->billing_cycle = $request->plan === 'free_trial' ? 'mensual' : $request->billing_cycle;

        // Actualizar Shop
        $shop->update([
            'name' => $request->name,
            'slug' => $slug,
            'shop_category' => $shopCategory,
            'shop_category_icon' => $shopCategoryIcon,
            'whatsapp_number' => $request->whatsapp_number,
            'description' => $request->description,
            'address' => $request->address,
            'color_primary' => $request->color_primary,
            'color_secondary' => $request->color_secondary,
            'color_background' => $request->color_background,
            'text_on_primary' => $request->input('text_on_primary', 'white'),
            'logo_path' => $logoPath,
            'cover_path' => $coverPath,
            'plan' => $request->plan,
            'billing_cycle' => $shop->billing_cycle,
            'plan_expires_at' => $request->plan_expires_at,
            'last_payment_date' => $request->last_payment_date,
            'last_payment_amount' => $request->last_payment_amount,
            'enabled_modules' => PlanFeatures::filterEnabledModules($request->input('enabled_modules'), $shop),
        ]);

        // Actualizar User
        $userData = [
            'name' => 'Administrador de ' . $shop->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
            $userData['temp_password'] = $request->password;
        }

        $user->update($userData);

        $shop->refresh();
        PlanFeatures::syncShopModulesForPlan($shop);

        return redirect()->back()->with('success', '¡Tienda "' . $shop->name . '" y su administrador actualizados con éxito!');
    }

    public function updatePlan(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);

        $request->validate([
            'plan' => 'required|string|in:free_trial,standard,premium',
            'billing_cycle' => 'nullable|string|in:mensual,anual',
        ]);

        $plan = $request->plan;
        $billingCycle = $plan === 'free_trial'
            ? 'mensual'
            : ($request->input('billing_cycle', $shop->billing_cycle ?? 'mensual'));

        $shop->update([
            'plan' => $plan,
            'billing_cycle' => $billingCycle,
        ]);

        PlanFeatures::syncShopModulesForPlan($shop);

        $label = match ($plan) {
            'premium' => 'Negocio',
            'free_trial' => 'Prueba gratis',
            default => 'Emprendedor',
        };

        return redirect()->back()->with('success', 'Plan de "' . $shop->name . '" actualizado a ' . $label . '.');
    }

    public function toggleStatus($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->is_active = !$shop->is_active;
        $shop->save();

        $statusText = $shop->is_active ? 'activada' : 'desactivada';
        return redirect()->back()->with('success', 'La tienda "' . $shop->name . '" ha sido ' . $statusText . ' correctamente.');
    }

    public function showLoginForm()
    {
        if (session('super_admin_authenticated')) {
            return redirect()->route('super-admin.companies.index');
        }
        return view('super-admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password === '88888888') {
            session(['super_admin_authenticated' => true]);
            return redirect()->route('super-admin.companies.index');
        }

        return redirect()->back()->withErrors(['password' => 'Contraseña incorrecta.']);
    }

    public function logout()
    {
        session()->forget('super_admin_authenticated');
        return redirect()->route('super-admin.login-form')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Approve manual payment and extend subscription.
     */
    public function approvePayment($id)
    {
        $shop = Shop::findOrFail($id);
        
        $plan = $shop->pending_plan ?: 'standard';
        $cycle = $shop->pending_billing_cycle ?: 'mensual';
        
        // Calculate new plan expiration date
        $days = ($cycle === 'anual') ? 365 : 30;
        $newExpiresAt = now()->addDays($days)->format('Y-m-d');
        
        // Determine billing amounts
        $amount = in_array($plan, ['standard', 'premium'], true)
            ? PlanPricing::amount($plan, $cycle === 'anual' ? 'anual' : 'mensual')
            : 0.00;
        
        // Update subscription data
        $shop->update([
            'plan' => $plan,
            'billing_cycle' => $cycle,
            'plan_expires_at' => $newExpiresAt,
            'last_payment_date' => now()->format('Y-m-d'),
            'last_payment_amount' => $amount,
            'payment_status' => 'none',
            'pending_plan' => null,
            'pending_billing_cycle' => null,
            'payment_reference' => null,
            'payment_receipt_path' => null,
            'payment_company_name' => null,
            'payment_company_email' => null,
            'is_active' => true, // Reactivate shop if it was deactivated
        ]);
        
        // Create an internal shop notification of approval
        \App\Models\Notification::create([
            'shop_id' => $shop->id,
            'title' => '¡Suscripción Activada con Éxito!',
            'content' => 'Tu pago de $' . $amount . ' USD por el plan ' . ucfirst($plan) . ' (' . $cycle . ') ha sido verificado y aprobado. Tu tienda ha sido reactivada hasta el ' . now()->addDays($days)->format('d/m/Y') . '.',
            'type' => 'billing',
            'is_read' => false,
        ]);
        
        return redirect()->back()->with('success', '¡El pago de la tienda "' . $shop->name . '" por el Plan ' . ucfirst($plan) . ' (' . $cycle . ') ha sido aprobado y la tienda ha sido reactivada con éxito!');
    }

    /**
     * Reject manual payment.
     */
    public function rejectPayment(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        
        // Update payment status to rejected
        $shop->update([
            'payment_status' => 'rejected',
        ]);
        
        // Create an internal shop notification of rejection
        \App\Models\Notification::create([
            'shop_id' => $shop->id,
            'title' => 'Pago Reportado Rechazado',
            'content' => 'Tu reporte de pago ha sido rechazado por inconsistencia en los datos de referencia o captura de comprobante. Por favor verifica tus datos e inténtalo nuevamente.',
            'type' => 'billing',
            'is_read' => false,
        ]);
        
        return redirect()->back()->with('success', 'El pago de la tienda "' . $shop->name . '" ha sido rechazado. El cliente recibirá una alerta en su panel para reportarlo nuevamente.');
    }
}
