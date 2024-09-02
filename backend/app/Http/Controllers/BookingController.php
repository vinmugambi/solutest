<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    public function index()
    {
        if (Gate::denies('admin-only')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $bookings = Booking::with(['tour', 'tickets', 'user'])->get();

        return response()->json($bookings);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $booking = Booking::with(['tour.destination', 'tickets'])->findOrFail($id);

        if ($user->role === 'admin' || $booking->user_id === $user->id) {
            return response()->json($booking);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function confirm(Booking $booking)
    {
        if (Gate::denies('admin-only')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $booking->update(['status' => 'confirmed']);

        return response()->json(['message' => 'Booking confirmed', 'booking' => $booking]);
    }

    public function me()
    {
        $user = Auth::user();

        $bookings = Booking::with(["tour.destination", 'tickets'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request, Tour $tour)
    {

        $user = $request->user();

        $validatedData = $request->validate([
            'seats' => 'nullable|integer|min:1',
        ]);

        $seats = $validatedData['seats'] ?? 1;

        if ($seats > $tour->slots) {
            return response()->json(['error' => 'Not enough slots available'], 400);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'status'  => 'pending',
        ]);

        $tour->decrement('slots', $seats);

        // should be done asynchronously but I let it slide
        for ($i = 0; $i < $seats; $i++) {
            Ticket::create([
                'booking_id' => $booking->id,
                'ticket_number' => $this->generateTicketNumber(),
            ]);
        }

        return response()->json($booking, 201);
    }



    protected function generateTicketNumber()
    {
        return strtoupper(uniqid('TKT_'));
    }
}
