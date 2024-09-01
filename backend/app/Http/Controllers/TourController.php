<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTourRequest;
use App\Models\Tour;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TourController extends Controller
{
    public function store(StoreTourRequest $request)
    {
        if (Gate::denies('admin-only')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $newTour = $request->validated();
        $newTour["capacity"] = $newTour["slots"];

        $tour = Tour::create($newTour);

        return response()->json($tour, 201);
    }

    public function show($id)
    {
        $user = auth()->user();
        $isAdmin = $user && $user->isAdmin();

        $tourQuery = Tour::with('destination');

        if ($isAdmin) {
            $tourQuery->with('bookings');
        }

        $tour = $tourQuery->find($id);

        if (!$tour) {
            return response()->json(['error' => 'Tour not found'], 404);
        }

        $hasBooked = false;
        if ($user) {
            $hasBooked = $user->bookings()->where('tour_id', $id)->exists();
        }

        $tourData = $tour->toArray();
        $tourData['has_booked'] = $hasBooked;

        return response()->json($tour, 200);
    }

    public function index(Request $request)
    {

        $query = Tour::with('destination');

        // Filter by availability
        if ($request->query('available')) {
            $query->where('slots', '>', 0);
        }

        // Filter by minimum price
        if ($request->query('min_price')) {
            $query->where('price', '>=', $request->query('min_price'));
        }

        // Filter by maximum price
        if ($request->query('max_price')) {
            $query->where('price', '<=', $request->query('max_price'));
        }

        // Filter by destination
        if ($request->query('destination')) {
            $query->where('destination_id', $request->query('destination'));
        }

        // Filter by minimum start date
        if ($request->query('min_start_time')) {
            $query->whereDate('start_time', '>=', $request->query('min_start_time'));
        }

        // Filter by maximum start date
        if ($request->query('max_start_time')) {
            $query->whereDate('start_time', '<=', $request->query('max_start_time'));
        }

        // Order by start date ascending by default
        $query->orderBy('start_time', 'asc');

        if ($request->query('limit')) {
            $query->limit($request->query('limit'));
        }

        if ($request->query('skip')) {
            $query->skip($request->query('skip'));
        }

        $tours = $query->get();
        return response()->json($tours, 200);
    }
}
