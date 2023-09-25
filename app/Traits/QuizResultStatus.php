<?php

namespace App\Traits;

use App\Enums\QuizResultStatusEnum;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait QuizResultStatus
{
    public function getQuizResultStatus(User $user): string
    {
        $quiz_result = $this->quiz_results()->whereHas('user', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->first();

        if(is_null($quiz_result)) {
            return QuizResultStatusEnum::NOT_PASSED->value;
        }

        return $quiz_result->verify ? QuizResultStatusEnum::VERIFIED->value : QuizResultStatusEnum::IS_PROCESSING->value;
    }
}