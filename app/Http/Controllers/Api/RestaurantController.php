<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    private $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index(Request $request): ApiJsonResponse
    {
        $restaurants = $this->restaurantService->getAllRestaurants($request->hidden, $request->priority);

        return new ApiJsonResponse(data: $restaurants);
    }

    public function show($slug): ApiJsonResponse
    {
        $restaurant = $this->restaurantService->getRestaurantBySlug($slug);

        if (! $restaurant) {
            return new ApiJsonResponse(404, false, 'Restaurant not found');
        }

        return new ApiJsonResponse(data: $restaurant);
    }

    public function store(Request $request): ApiJsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image',
            'priority' => 'required|integer',
            'background_image' => 'required|image',
            'map_image' => 'required|image',
            'map_link' => 'nullable|url',
            'address' => 'required|string|max:255',
        ]);

        $restaurant = $this->restaurantService->createRestaurant($validated, $request->file('photo'));

        return new ApiJsonResponse(201, data: $restaurant);
    }

    public function update(Request $request, $id): ApiJsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'photo' => 'sometimes|image',
            'priority' => 'sometimes|integer',
            'background_image' => 'sometimes|image',
            'map_image' => 'sometimes|image',
            'map_link' => 'sometimes|url',
            'address' => 'sometimes|string|max:255',
        ]);

        $restaurant = $this->restaurantService->updateRestaurant($id, $validated, $request->file('photo'));

        if (! $restaurant) {
            return new ApiJsonResponse(404, false, 'Restaurant not found');
        }

        return new ApiJsonResponse(data: $restaurant);
    }

    public function destroy($id): ApiJsonResponse
    {
        $restaurant = $this->restaurantService->deleteRestaurant($id);

        if (! $restaurant) {
            return new ApiJsonResponse(404, false, 'Restaurant not found');
        }

        return new ApiJsonResponse(message: 'Restaurant deleted successfully');
    }
}
