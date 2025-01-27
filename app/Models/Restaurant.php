<?php

namespace App\Models;

use App\Traits\PriorityTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceSchedule;

class Restaurant extends Model
{
    use HasFactory, HasUuids, PriorityTrait;

    protected $fillable = [
        'name', 
        'photo', 
        'priority', 
        'background_image', 
        'map_image', 
        'map_link',
        'address',
    ];

    protected static function booted()
    {
        static::created(function ($restaurant) {
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            foreach ($days as $day) {
                ServiceSchedule::create([
                    'restaurant_id' => $restaurant->id,
                    'day_of_week' => $day,
                    'is_open' => true,
                    'opening_time' => null,
                    'closing_time' => null,
                ]);
            }
        });
    }
}
