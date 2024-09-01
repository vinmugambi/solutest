<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name',
            'description' => 'nullable|string',
        ]);

        // Automatically generate the slug from the name
        $slug = Str::slug($validated['name']);

        $originalSlug = $slug;
        $counter = 1;
        while (Destination::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $destination = Destination::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json($destination, 201);
    }

    public function index()
    {
        $destinations = Destination::all();
        return response()->json($destinations);
    }
}
