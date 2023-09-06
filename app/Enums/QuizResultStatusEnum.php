<?php

namespace App\Enums;

enum QuizResultStatusEnum: string
{
    case NOT_PASSED = 'not_passed';
    case IS_PROCESSING = 'is_processing';
    case VERIFIED = 'verified';

    public static function allValues(): array
    {
        return [
            self::NOT_PASSED->value,
            self::IS_PROCESSING->value,
            self::VERIFIED->value
        ];
    }
}