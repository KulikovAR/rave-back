<?php

namespace App\Enums;

enum SettingTagEnum: string
{
    case PRICE = 'price';
    case PRICE_US = 'price_us';
    case SUBSCRIPTION = 'subscription';
    case LESSON_SHEDULE = 'lesson_shedule';

    public static function allValues(): array
    {
        return [
            self::SUBSCRIPTION,
            self::LESSON_SHEDULE,
        ];
    }

    public static function allValuesWithDescription(): array
    {
        return [
            self::PRICE->value          => 'Цена подписки в рублях',
            self::PRICE_US->value       => 'Цена подписки в долларах',
            self::SUBSCRIPTION->value   => 'Подписки',
            self::LESSON_SHEDULE->value => 'Очередь видео'
        ];
    }
}