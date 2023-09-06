<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_normal',
        'price_vip',
        'price_premium',
        'duration_normal',
        'duration_vip',
        'duration_premium',
        'value'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function () {
            if (static::get()->count() > 1) {
                throw new Exception("Price model can have only two record");
            }
        });
    }
}