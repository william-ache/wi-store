<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display the feedback form and previous submissions list.
     */
    public function index(Request $request)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        // Fetch previous feedbacks for the active shop, ordered by created_at DESC
        // BelongsToTenant scope will automatically scope this query to the current shop
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();

        if ($request->wantsJson()) {
            // Map formatted date and dynamic badge color to feedbacks
            $formattedFeedbacks = $feedbacks->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'title' => $item->title,
                    'description' => $item->description,
                    'status' => $item->status,
                    'created_at_formatted' => $item->created_at->format('d/m/Y h:i A'),
                ];
            });

            return response()->json([
                'success' => true,
                'feedbacks' => $formattedFeedbacks
            ]);
        }

        return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug])->with('open_feedback_modal', true);
    }

    /**
     * Save new feedback to the database.
     */
    public function store(Request $request)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $request->validate([
            'type' => 'required|string|in:bug,idea,comentario',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ], [
            'type.required' => 'El tipo de feedback es requerido.',
            'type.in' => 'El tipo de feedback seleccionado no es válido.',
            'title.required' => 'El título es requerido.',
            'title.max' => 'El título no debe exceder los 255 caracteres.',
            'description.required' => 'La descripción es requerida.',
            'description.max' => 'La descripción no debe exceder los 1000 caracteres.',
        ]);

        Feedback::create([
            'shop_id' => $shop->id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', '¡Muchas gracias! Tu feedback ha sido enviado con éxito y será revisado por nuestro equipo.');
    }
}
