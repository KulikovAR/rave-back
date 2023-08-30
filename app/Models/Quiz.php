<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'lesson_id',
        'data',
        'title',
        'description',
        'duration'
    ];

    public function lessons(): BelongsTo
    {
        return $this->BelongsTo(Lesson::class, 'lesson_id');
    }

    public function quiz_results(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }
}
