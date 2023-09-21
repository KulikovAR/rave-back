<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SlideObserver;

class Slide extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'image',
        'video_path',
    ];

    protected static function boot(): void
    {
        parent::boot();
        Slide::observe(SlideObserver::class);
    }
}
