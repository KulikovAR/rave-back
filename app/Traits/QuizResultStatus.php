<?php

namespace App\Traits;

use App\Enums\QuizResultStatusEnum;
use Illuminate\Support\Facades\Hash;

trait QuizResultStatus
{
    protected function getQuizResultStatus(): string
    {
        if(is_null($this->quiz_result)) {
            return QuizResultStatusEnum::NOT_PASSED->value;
        }

        if(!$this->quiz_result->verify) {
            return QuizResultStatusEnum::IS_PROCESSING->value;
        }

        return QuizResultStatusEnum::VERIFIED->value;
    }
}