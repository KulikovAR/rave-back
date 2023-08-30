<?php

namespace App\Models;

use App\Traits\Rating;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory, HasUuids, Rating;

    protected $fillable = [
        'title',
        'description',
        'video_path',
        'preview_path',
        'announc_date',
        'rating'
    ];

    public function tags(): BelongsToMany
    {
        return $this->BelongsToMany(Tag::class);
    }

    public function lesson_additional_data(): HasMany
    {
        return $this->hasMany(LessonAdditionalData::class);
    }


    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
    
    public function ratings(): HasMany
    {
        return $this->hasMany(LessonRating::class);
    }

    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }
}
