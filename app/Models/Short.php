<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Short extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slide_count',
        'view_count',
        'thumbnail',
        'video_path',
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function ($model) {
            Storage::disk('public')->delete('video/' . $model->getOriginal('video_path'));
        });
    }
}
