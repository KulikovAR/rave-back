<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announce extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'video_path',
        'preview_path',
        'release_at',
        'main'
    ];

    public function tags(): BelongsToMany
    {
        return $this->BelongsToMany(Tag::class);
    }
}