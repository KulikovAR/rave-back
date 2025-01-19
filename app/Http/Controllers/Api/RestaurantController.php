<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    private $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index(Request $request)
    {
        $restaurants = $this->restaurantService->getAllRestaurants($request->hidden, $request->priority);
        return response()->json($restaurants, 200);
    }

    public function show($id)
    {
        $restaurant = $this->restaurantService->getRestaurantById($id);

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

        $restaurant = $this->restaurantService->createRestaurant($validated, $request->file('photo'));
        return response()->json($restaurant, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'photo' => 'sometimes|image',
            'priority' => 'sometimes|integer',
        ]);

        $restaurant = $this->restaurantService->updateRestaurant($id, $validated, $request->file('photo'));

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        return response()->json($restaurant, 200);
    }

    public function destroy($id)
    {
        $restaurant = $this->restaurantService->deleteRestaurant($id);

        if (!$restaurant) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        return response()->json(['message' => 'Restaurant deleted successfully'], 200);
    }
}