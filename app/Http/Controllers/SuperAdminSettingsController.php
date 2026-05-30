<?php

namespace App\Http\Controllers;

use App\Support\PlatformPlanSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminSettingsController extends Controller
{
    public function plans(): View
    {
        return view('super-admin.settings.plans', [
            'settings' => PlatformPlanSettings::all(),
            'pricingPreview' => PlatformPlanSettings::pricingPlans(),
            'activeModule' => 'ajustes',
        ]);
    }

    public function updatePlans(Request $request): RedirectResponse
    {
        $request->validate([
            'trial_days' => 'required|integer|min:1|max:90',
            'plans.standard.marketing_name' => 'required|string|max:80',
            'plans.standard.monthly' => 'required|numeric|min:0',
            'plans.standard.annual_discount_percent' => 'required|integer|min:0|max:90',
            'plans.standard.max_products' => 'nullable|integer|min:0',
            'plans.standard.max_categories' => 'nullable|integer|min:0',
            'plans.standard.purpose' => 'nullable|string|max:500',
            'plans.standard.highlights_text' => 'nullable|string',
            'plans.premium.marketing_name' => 'required|string|max:80',
            'plans.premium.monthly' => 'required|numeric|min:0',
            'plans.premium.annual_discount_percent' => 'required|integer|min:0|max:90',
            'plans.premium.max_products' => 'nullable|integer|min:0',
            'plans.premium.max_categories' => 'nullable|integer|min:0',
            'plans.premium.purpose' => 'nullable|string|max:500',
            'plans.premium.highlights_text' => 'nullable|string',
        ]);

        PlatformPlanSettings::save($request->only(['trial_days', 'plans']));

        return redirect()
            ->route('super-admin.settings.plans')
            ->with('success', 'Configuración de planes guardada. Los cambios ya aplican en la landing y registros.');
    }
}
