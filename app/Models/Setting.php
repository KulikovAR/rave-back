<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'key', 'value'];

    public static function getSettingByKey($key)
    {
        return self::where('key', $key)->first();
    }
}
