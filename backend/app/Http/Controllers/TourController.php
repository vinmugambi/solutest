<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTourRequest;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TourController extends Controller
{
    public function store(StoreTourRequest $request)
    {
        if (Gate::denies('admin-only')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tour = Tour::create($request->validated());

        return response()->json($tour, 201);
    }

    public function index(Request $request)
    {

        // Initialize query builder with relations
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
        if ($request->query('min_start_date')) {
            $query->whereDate('start_date', '>=', $request->query('min_start_date'));
        }

        // Filter by maximum start date
        if ($request->query('max_start_date')) {
            $query->whereDate('start_date', '<=', $request->query('max_start_date'));
        }

        // Order by start date ascending by default
        $query->orderBy('start_date', 'asc');

        // Apply limit and skip (offset)
        if ($request->query('limit')) {
            $query->limit($request->query('limit'));
        }

        if ($request->query('skip')) {
            $query->skip($request->query('skip'));
        }

        // Get the results
        $tours = $query->get();

        // Return the JSON response
        return response()->json($tours, 200);
    }
}
