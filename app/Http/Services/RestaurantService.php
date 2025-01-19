<?php

namespace App\Http\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class RestaurantService
{
    public function getAllRestaurants($hidden = null, $priority = null)
    {
        $query = Restaurant::query();
        if ($hidden !== null) {
            $query->where('hidden', $hidden);
        }
        if ($priority !== null) {
            $query->orderBy('priority', 'asc');
        }
        return $query->get();
    }

    public function getRestaurantById($id)
    {
        return Restaurant::find($id);
    }

    public function createRestaurant(array $data, $photo)
    {
        $path = $photo->store('restaurants', 'public');
        $data['photo'] = $path;
        return Restaurant::create($data);
    }

    public function updateRestaurant($id, array $data, $photo = null)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            if ($photo) {
                Storage::disk('public')->delete($restaurant->photo);
                $data['photo'] = $photo->store('restaurants', 'public');
            }
            $restaurant->update($data);
        }
        return $restaurant;
    }

    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            Storage::disk('public')->delete($restaurant->photo);
            $restaurant->delete();
        }
        return $restaurant;
    }
}