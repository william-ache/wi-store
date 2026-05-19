<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('client')->orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $orders
            ]);
        }

        $clients = Client::where('status', true)->get();
        return view('admin.orders.index', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'total' => 'required|numeric|min:0',
            'status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'client_id' => 'nullable|exists:clients,id'
        ]);

        $orderNumber = '#' . (Order::max('id') ? (1000 + Order::max('id') + 1) : 1001);

        $order = Order::create([
            'order_number' => $orderNumber,
            'client_id' => $request->client_id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'total' => $request->total,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
        ]);

        // Sincronizar total gastado del cliente si está asociado
        if ($order->client_id && $order->status === 'delivered') {
            $client = Client::find($order->client_id);
            if ($client) {
                $client->total_spent = $client->orders()->where('status', 'delivered')->sum('total');
                $client->save();
            }
        }

        $order->load('client');

        return response()->json([
            'success' => true,
            'message' => 'Orden registrada exitosamente.',
            'data' => $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('client');
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'total' => 'required|numeric|min:0',
            'status' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'client_id' => 'nullable|exists:clients,id'
        ]);

        $oldStatus = $order->status;

        $order->update([
            'client_id' => $request->client_id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'total' => $request->total,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
        ]);

        // Sincronizar total gastado del cliente si cambia el estado o total de la orden
        if ($order->client_id) {
            $client = Client::find($order->client_id);
            if ($client) {
                $client->total_spent = $client->orders()->where('status', 'delivered')->sum('total');
                $client->save();
            }
        }

        $order->load('client');

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizada exitosamente.',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $clientId = $order->client_id;
        $order->delete();

        // Recalcular para el cliente
        if ($clientId) {
            $client = Client::find($clientId);
            if ($client) {
                $client->total_spent = $client->orders()->where('status', 'delivered')->sum('total');
                $client->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden eliminada exitosamente.'
        ]);
    }
}
