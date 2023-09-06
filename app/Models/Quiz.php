<?php

namespace App\Models;

use App\Traits\QuizResultStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quiz extends Model
{
    use HasFactory, HasUuids, QuizResultStatus;

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

    public function quiz_result(): HasOne
    {
        return $this->hasOne(QuizResult::class);
    }
}
