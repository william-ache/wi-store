<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillingController extends Controller
{
    /**
     * Show the expired subscription or pending payment screen.
     */
    public function expired(Request $request)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        // Parse local exchange rate (strip string formatting)
        $cleanRate = preg_replace('/[^0-9.]/', '', $shop->exchange_rate);
        $rate = (float) $cleanRate;
        if ($rate <= 0) {
            $rate = 40.00; // Sensible default fallback
        }

        return view('admin.billing.expired', compact('shop', 'rate'));
    }

    /**
     * Handle manual payment submission (Pago Móvil receipt and reference).
     */
    public function submitPayment(Request $request)
    {
        $shop = config('current_shop');
        if (!$shop) {
            abort(404, 'Tienda no encontrada.');
        }

        $request->validate([
            'plan' => 'required|string|in:standard,premium',
            'billing_cycle' => 'required|string|in:mensual,anual',
            'payment_reference' => 'required|string|max:255',
            'payment_receipt' => 'required|image|max:4096', // Max 4MB receipt image
            'payment_company_name' => 'required|string|max:255',
            'payment_company_email' => 'required|email|max:255',
        ], [
            'plan.required' => 'Debes seleccionar un plan.',
            'billing_cycle.required' => 'Debes seleccionar el ciclo de facturación.',
            'payment_reference.required' => 'Debes ingresar el número de referencia del Pago Móvil.',
            'payment_receipt.required' => 'Debes subir una captura o imagen de tu comprobante de pago.',
            'payment_receipt.image' => 'El comprobante debe ser una imagen válida.',
            'payment_receipt.max' => 'La imagen del comprobante no debe superar los 4MB.',
            'payment_company_name.required' => 'Debes ingresar el nombre de la empresa.',
            'payment_company_email.required' => 'Debes ingresar el correo electrónico de la empresa.',
            'payment_company_email.email' => 'El correo electrónico debe tener un formato válido.',
        ]);

        // Upload receipt to public storage disk
        $receiptPath = null;
        if ($request->hasFile('payment_receipt')) {
            $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
        }

        // Update shop subscription payment status
        $shop->update([
            'pending_plan' => $request->plan,
            'pending_billing_cycle' => $request->billing_cycle,
            'payment_status' => 'pending',
            'payment_reference' => $request->payment_reference,
            'payment_receipt_path' => $receiptPath,
            'payment_company_name' => $request->payment_company_name,
            'payment_company_email' => $request->payment_company_email,
            'payment_submitted_at' => now(),
        ]);

        // Create an internal shop notification
        Notification::create([
            'shop_id' => $shop->id,
            'title' => 'Pago Móvil Recibido',
            'content' => 'Tu reporte de pago por Pago Móvil con referencia ' . $request->payment_reference . ' para la empresa ' . $request->payment_company_name . ' ha sido recibido. El Súper Administrador validará la información pronto.',
            'type' => 'billing',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', '¡Comprobante de pago móvil subido con éxito! Tu pago se encuentra en proceso de confirmación.');
    }
}
