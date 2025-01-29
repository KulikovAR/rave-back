<?php

namespace App\Models;

use App\Traits\PriorityTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, HasUuids, PriorityTrait;

    protected $fillable = ['name', 'image_path', 'priority', 'hidden'];
}
