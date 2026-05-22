<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function index()
    {
        $shops = Shop::with('users')->latest()->get();
        return view('super-admin', compact('shops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'plan' => 'required|string|in:standard,premium,gold',
            'color_primary' => 'required|string|max:20',
            'color_secondary' => 'required|string|max:20',
            'color_background' => 'required|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|url',
            'cover' => 'nullable|image|max:4096',
            'cover_url' => 'nullable|url',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
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

        // Crear la tienda (Shop)
        $shop = Shop::create([
            'name' => $request->name,
            'slug' => $slug,
            'whatsapp_number' => $request->whatsapp_number,
            'description' => $request->description,
            'address' => $request->address,
            'color_primary' => $request->color_primary,
            'color_secondary' => $request->color_secondary,
            'color_background' => $request->color_background,
            'logo_path' => $logoPath,
            'cover_path' => $coverPath,
            'plan' => $request->plan,
            'is_active' => true,
        ]);

        // Crear el Usuario administrador de esa tienda
        User::create([
            'shop_id' => $shop->id,
            'name' => 'Administrador de ' . $shop->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', '¡Tienda "' . $shop->name . '" y su respectivo administrador creados con éxito!');
    }

    public function toggleStatus($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->is_active = !$shop->is_active;
        $shop->save();

        $statusText = $shop->is_active ? 'activada' : 'desactivada';
        return redirect()->back()->with('success', 'La tienda "' . $shop->name . '" ha sido ' . $statusText . ' correctamente.');
    }
}
