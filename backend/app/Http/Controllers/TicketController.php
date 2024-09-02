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
}
