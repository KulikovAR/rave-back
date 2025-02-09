<?php

namespace App\Http\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class RestaurantService
{
    public function getAllRestaurants($hidden = null, $priority = null)
    {
        $query = Restaurant::with('schedule'); // Загружаем расписание вместе с ресторанами
        $query->orderBy('priority', 'asc');
        if ($hidden !== null) {
            $query->where('hidden', $hidden);
        }
        if ($priority !== null) {
            $query->orderBy('priority', 'asc');
        }

        return $query->limit(3)->get();
    }

    public function getRestaurantById($id)
    {
        return Restaurant::find($id);
    }

    public function getRestaurantBySlug($slug)
    {
        return Restaurant::where('slug', $slug)->first();
    }

    public function createRestaurant(array $data, $photo)
    {
        if (isset($data['background_image'])) {
            $data['background_image'] = $data['background_image']->store('restaurants/backgrounds', 'public');
        }
        if (isset($data['map_image'])) {
            $data['map_image'] = $data['map_image']->store('restaurants/maps', 'public');
        }

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
            if (isset($data['background_image'])) {
                Storage::disk('public')->delete($restaurant->background_image);
                $data['background_image'] = $data['background_image']->store('restaurants/backgrounds', 'public');
            }
            if (isset($data['map_image'])) {
                Storage::disk('public')->delete($restaurant->map_image);
                $data['map_image'] = $data['map_image']->store('restaurants/maps', 'public');
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
            Storage::disk('public')->delete($restaurant->background_image);
            Storage::disk('public')->delete($restaurant->map_image);
            $restaurant->delete();
        }

        return $restaurant;
    }
}
