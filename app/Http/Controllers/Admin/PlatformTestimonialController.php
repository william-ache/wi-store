<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformTestimonialController extends Controller
{
    public function index(Request $request)
    {
        $shop = config('current_shop');
        if (! $shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $testimonial = PlatformTestimonial::where('shop_id', $shop->id)->first();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'testimonial' => $testimonial ? [
                    'id' => $testimonial->id,
                    'rating' => $testimonial->rating,
                    'title' => $testimonial->title,
                    'comment' => $testimonial->comment,
                    'is_published' => $testimonial->is_published,
                    'created_at_formatted' => $testimonial->created_at->format('d/m/Y h:i A'),
                ] : null,
            ]);
        }

        return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug])
            ->with('open_rate_modal', true);
    }

    public function store(Request $request)
    {
        $shop = config('current_shop');
        if (! $shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ], [
            'rating.required' => 'Selecciona una calificación de 1 a 5 estrellas.',
            'rating.min' => 'La calificación mínima es 1 estrella.',
            'rating.max' => 'La calificación máxima es 5 estrellas.',
            'title.required' => 'El asunto es requerido.',
            'comment.required' => 'El comentario es requerido.',
        ]);

        PlatformTestimonial::updateOrCreate(
            ['shop_id' => $shop->id],
            [
                'user_id' => Auth::id(),
                'rating' => (int) $validated['rating'],
                'title' => $validated['title'],
                'comment' => $validated['comment'],
                'is_published' => true,
            ]
        );

        return redirect()->back()->with('success', '¡Gracias! Tu calificación se publicó en la landing de WI-Store.');
    }
}
