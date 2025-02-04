<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::saving(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = static::generateSlug($model->name, $model->getTable());
            }
        });
    }

    public static function generateSlug($name, $table)
    {
        $slug = Str::slug($name);
        $slugBase = $slug;
        $counter = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.Str::random(4);
        }

        return $slug;
    }
}
