<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\PriorityTrait;


class Category extends Model
{
    use HasFactory, PriorityTrait, HasUuids;

    protected $fillable = ['name', 'hidden', 'priority', 'restaurant_id',];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
