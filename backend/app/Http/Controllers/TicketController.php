<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use function Psy\debug;

class TicketController extends Controller
{

    public function index()
    {
        if (Gate::denies('admin-only')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tickets = Ticket::with('booking')->get();

        return response()->json($tickets);
    }

    public function store(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($booking->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($booking->tickets()->exists()) {
            return response()->json(['error' => 'Ticket already generated'], 400);
        }

        $ticket = Ticket::create([
            'booking_id'    => $booking->id,
            'ticket_number' => strtoupper(uniqid('TICKET-')),
        ]);

        $booking->update(['status' => 'completed']);

        return response()->json($ticket);
    }
}
