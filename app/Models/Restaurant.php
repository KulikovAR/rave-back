<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\PriorityTrait;

class Restaurant extends Model
{
    use HasFactory, PriorityTrait;

    protected $fillable = ['name', 'photo', 'priority'];
}
