<?php

namespace App\Models;

use App\Enums\QuizResultStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    use HasFactory, HasUuids;

    protected $casts = ['data' => 'array'];

    protected $fillable = [
        'user_id',
        'quiz_id',
        'data',
        'verify',
        'curator_comment',
        ''
    ];

    public function quiz(): BelongsTo
    {
        return $this->BelongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
