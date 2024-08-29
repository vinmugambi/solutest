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

        $query = Tour::query();

        if ($request->query('available')) {
            $query->where('slots', '>', 0);
        }

        if ($request->query('min_price')) {
            $query->where('price', '>=', $request->query('min_price'));
        }

        if ($request->query('max_price')) {
            $query->where('price', '<=', $request->query('max_price'));
        }

        if ($request->query('destination')) {
            $query->where('destination_id', $request->query('destination'));
        }

        $tours = $query->get();

        return response()->json($tours, 200);
    }
}
