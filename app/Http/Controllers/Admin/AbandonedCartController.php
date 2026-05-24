<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbandonedCart;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    /**
     * Display a listing of the abandoned carts.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $carts = AbandonedCart::orderBy('updated_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $carts
            ]);
        }

        return view('admin.abandoned_carts.index');
    }

    /**
     * Remove the specified abandoned cart from storage.
     */
    public function destroy(AbandonedCart $abandonedCart)
    {
        $abandonedCart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registro de carrito abandonado eliminado.'
        ]);
    }
}
