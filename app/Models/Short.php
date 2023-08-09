<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Short extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title', 
        'slide_count',
        'view_count'
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }
}
