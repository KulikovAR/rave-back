<?php

namespace App\Enums;

enum SubscriptionTypeEnum: string
{
    case MONTH = 'month';
    case THREE_MOTHS = 'three_months';
    case YEAR = 'year';

    public static function allValues(): array
    {
        return [
            self::MONTH->value,
            self::THREE_MOTHS->value,
            self::YEAR->value
        ];
    }
}