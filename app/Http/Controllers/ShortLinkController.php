<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShortLinkController extends Controller
{
    /**
     * Store or update the short link for the authenticated shop.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $shop = Auth::user()->shop;

        $request->validate([
            'code' => [
                'required',
                'string',
                'min:2',
                'max:30',
                'alpha_dash',
                Rule::unique('short_links', 'code')->ignore($shop->shortLinks()->first()?->id),
            ]
        ], [
            'code.unique' => 'Este código ya está en uso por otra tienda. Elige uno diferente.',
            'code.alpha_dash' => 'El código solo puede contener letras, números, guiones y barras bajas.',
        ]);

        // Guardar o actualizar el link corto atado a la tienda
        $shop->shortLinks()->updateOrCreate(
            [], // Identificador vacío para forzar que sea el único registro 1-a-1 de la tienda
            [
                'code' => strtolower($request->code),
                'destination_url' => url('/' . $shop->slug),
            ]
        );

        return redirect()->back()->with('success_short_link', 'Tu enlace corto ha sido actualizado con éxito.');
    }

    /**
     * Redirect a short link to its full destination URL using HTTP 301 (Permanent Redirect).
     *
     * @param string $code
     * @return RedirectResponse
     */
    public function redirect(string $code): RedirectResponse
    {
        // 1. Buscar el enlace corto con consulta optimizada
        $link = ShortLink::where('code', $code)->firstOrFail();

        // 2. Incrementar el contador de clics de forma atómica y ultra eficiente
        $link->increment('clicks_count');

        // 3. Retornar redirección permanente HTTP 301 limpia
        return redirect()->to($link->destination_url, 301);
    }
}
