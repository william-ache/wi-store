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
            'whatsapp_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'google_maps_link' => 'nullable|url|max:500',
            'work_hours' => 'nullable|string', // Viene como JSON string desde Alpine
            'base_currency' => 'nullable|string|max:10',
            'exchange_rate' => 'nullable|string|max:50',
            'payment_methods' => 'nullable|string',
            'color_primary' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/i',
            'color_secondary' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/i',
            'color_background' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/i',
            'logo' => 'nullable|image|max:2048',
            'cover' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name', 'whatsapp_number', 'description', 'address', 'google_maps_link', 'base_currency', 'exchange_rate',
            'payment_methods', 'color_primary', 'color_secondary', 'color_background'
        ]);

        if ($request->filled('work_hours')) {
            $decoded = json_decode($request->work_hours, true);
            $data['work_hours'] = is_array($decoded) ? $decoded : $request->work_hours;
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

        return redirect()->back()->with('success', 'Configuración de tienda actualizada exitosamente.');
    }
}
