<?php

namespace App\Models;

use App\Traits\PriceFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, PriceFormat;

    protected $fillable = [
        'tag',
        'field_name',
        'field_description',
        'data'
    ];
}