<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\ServiceSchedule;
use Illuminate\Http\Request;

class ServiceScheduleController extends Controller
{
    public function index($restaurantId)
    {
        $schedule = ServiceSchedule::where('restaurant_id', $restaurantId)->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $schedule,
        ]);
    }

    public function getBySlug($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->first();
        if (! $restaurant) {
            return response()->json([
                'status' => false,
                'message' => 'Restaurant not found',
            ]);
        }
        $schedule = ServiceSchedule::where('restaurant_id', $restaurant->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $schedule,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'is_open' => 'required|boolean',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i|after:opening_time',
        ]);

        $schedule = ServiceSchedule::findOrFail($id);

        $schedule->update([
            'is_open' => $request->is_open,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Расписание обновлено успешно.',
            'data' => $schedule,
        ]);
    }
}
