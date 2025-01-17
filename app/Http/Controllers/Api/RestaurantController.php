<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::query();

        if ($request->has('hidden')) {
            $query->where('hidden', $request->hidden);
        }

        if ($request->has('priority')) {
            $query->orderBy('priority', 'asc');
        }

        $restaurants = $query->get();

        return response()->json($restaurants, 200);
    }

    public function show($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        return response()->json($restaurant, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image',
            'priority' => 'required|integer',
        ]);

        $path = $request->file('photo')->store('restaurants', 'public');

        $restaurant = Restaurant::create([
            'name' => $validated['name'],
            'photo' => $path,
            'priority' => $validated['priority'],
        ]);

        return response()->json($restaurant, 201);
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'photo' => 'sometimes|image',
            'priority' => 'sometimes|integer',
        ]);

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($restaurant->photo);
            $path = $request->file('photo')->store('restaurants', 'public');
            $restaurant->photo = $path;
        }

        $restaurant->update($validated);

        return response()->json($restaurant, 200);
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        Storage::disk('public')->delete($restaurant->photo);
        $restaurant->delete();

        return response()->json(['message' => 'Restaurant deleted successfully'], 200);
    }
}