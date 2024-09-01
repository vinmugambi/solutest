<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

        $bookings = Booking::with(['user', 'tour'])->get();

        return response()->json($bookings);
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

        if ($tour->slots <= 0) {
            return response()->json(['error' => 'No slots available'], 400);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'status'  => 'pending',
        ]);

        $tour->decrement('slots');

        return response()->json($booking);
    }
}
