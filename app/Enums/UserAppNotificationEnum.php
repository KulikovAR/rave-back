<?php

namespace App\Enums;

enum UserAppNotificationEnum: string
{
    case QUIZ_VERIFY = 'qiuz_verifed';

    public static function allValues(): array
    {
        return [
            self::QUIZ_VERIFY->value,
        ];
    }
}