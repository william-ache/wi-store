<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons for the active shop.
     */
    public function index(Request $request)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        // Scoped automatically to active tenant shop via BelongsToTenant scope
        $coupons = Coupon::orderBy('created_at', 'desc')->get();

        return view('admin.coupons.index', compact('shop', 'coupons'));
    }

    /**
     * Store a newly created coupon in the database.
     */
    public function store(Request $request)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $code = strtoupper(trim($request->code));

        // Validate uniqueness within current tenant
        $exists = Coupon::where('code', $code)->exists();
        if ($exists) {
            return back()->withErrors(['code' => 'Este código de cupón ya existe en tu tienda.'])->withInput();
        }

        $request->validate([
            'code' => 'required|string|max:255',
            'type' => 'required|string|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ], [
            'code.required' => 'El código de descuento es obligatorio.',
            'type.in' => 'El tipo de descuento seleccionado no es válido.',
            'value.required' => 'El valor de descuento es obligatorio.',
            'value.numeric' => 'El valor de descuento debe ser numérico.',
            'value.min' => 'El valor de descuento debe ser mayor a 0.',
            'min_order_amount.min' => 'El monto mínimo de compra no puede ser negativo.',
            'usage_limit.min' => 'El límite de usos debe ser mayor o igual a 1.',
            'expires_at.after_or_equal' => 'La fecha de expiración no puede ser en el pasado.',
        ]);

        Coupon::create([
            'shop_id' => $shop->id,
            'code' => $code,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'expires_at' => $request->expires_at,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', '¡Cupón de descuento creado con éxito!');
    }

    /**
     * Update (toggle active state of) the coupon.
     */
    public function update(Request $request, $id)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);

        $status = $coupon->is_active ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "El cupón {$coupon->code} ha sido {$status} con éxito.");
    }

    /**
     * Remove the coupon from the database.
     */
    public function destroy($coupon_id)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $coupon = Coupon::findOrFail($coupon_id);
        $coupon->delete();

        return redirect()->back()->with('success', 'Cupón eliminado correctamente.');
    }
}
