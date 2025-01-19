<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'key', 'value'];

    public static function getSettingByKey($key)
    {
        return self::where('key', $key)->first();
    }
}
