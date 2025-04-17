<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\PriorityTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory, HasSlug, HasUuids, PriorityTrait;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'priority',
        'background_image',
        'map_image',
        'map_link',
        'address',
        'description',
        'privacy',
    ];

    public function schedule()
    {
        return $this->hasMany(ServiceSchedule::class);
    }

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
