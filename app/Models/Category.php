<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\PriorityTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasSlug, HasUuids, PriorityTrait;

    protected $fillable = ['name', 'slug', 'hidden', 'priority', 'restaurant_id', 'image', 'description'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public static function boot()
    {
        parent::boot();

        static::setGroupByField('restaurant_id');
    }
}
