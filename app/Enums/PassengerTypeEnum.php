<?php

namespace App\Enums;

enum PassengerTypeEnum: string
{
    case ADULT  = 'adults';
    case CHILD  = 'children';
    case INFANT = 'babies';

    public static function allValues(): array
    {
        return [
            self::ADULT->value,
            self::CHILD->value,
            self::INFANT->value
        ];
    }
}