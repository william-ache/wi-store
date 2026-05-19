<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::withCount('orders')->get();
            return response()->json([
                'success' => true,
                'data' => $clients
            ]);
        }

        return view('admin.clients.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'required|boolean',
        ]);

        $client = Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'total_spent' => 0.00
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado exitosamente.',
            'data' => $client
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json([
            'success' => true,
            'data' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'required|boolean',
        ]);

        $client->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado exitosamente.',
            'data' => $client
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado exitosamente.'
        ]);
    }
}
