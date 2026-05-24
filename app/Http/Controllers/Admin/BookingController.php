<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bookings = Booking::orderBy('date', 'desc')->orderBy('time_slot', 'asc')->get();
            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);
        }

        return view('admin.bookings.index');
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'date' => 'required|date',
            'time_slot' => 'required|string|max:255',
            'status' => 'required|string|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Reserva creada exitosamente.',
            'data' => $booking
        ]);
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'date' => 'required|date',
            'time_slot' => 'required|string|max:255',
            'status' => 'required|string|in:pending,confirmed,cancelled',
        ]);

        $booking->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Reserva actualizada exitosamente.',
            'data' => $booking
        ]);
    }

    /**
     * Remove the specified booking from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reserva eliminada exitosamente.'
        ]);
    }
}
