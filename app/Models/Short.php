<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }
}
