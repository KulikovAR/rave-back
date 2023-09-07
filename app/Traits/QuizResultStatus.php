<?php

namespace App\Traits;

use App\Enums\QuizResultStatusEnum;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Hash;

trait QuizResultStatus
{
    public function getQuizResultStatus(): string
    {
        if(!$this->verify) {
            return QuizResultStatusEnum::IS_PROCESSING->value;
        }

        return QuizResultStatusEnum::VERIFIED->value;
    }
}