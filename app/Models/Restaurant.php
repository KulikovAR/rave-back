<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\PriorityTrait;

class Restaurant extends Model
{
    use HasFactory, PriorityTrait, HasUuids;

    protected $fillable = ['name', 'photo', 'priority'];
}
