<?php

namespace App\Traits;

use App\Enums\SettingTagEnum;

trait PriceFormat
{
    protected static function getPrices(string $locale = 'ru'): array
    {
        $price_tag = $locale == 'ru' ? SettingTagEnum::PRICE->value : SettingTagEnum::PRICE_US->value;

        $settings = self::whereIn('tag', [$price_tag, SettingTagEnum::SUBSCRIPTION])->get();

        return self::getValuesWithFieldNameAsKey($settings, [
            'price_normal',
            'price_vip',
            'price_premium',
            'duration_normal',
            'duration_vip',
            'duration_premium',
        ], true) + ['value' => __('translations.prices.value')];
    }

    protected static function getValueFromFieldName(string $field_name, $locale = 'ru')
    {
        return self::where('field_name', $field_name)->first()?->data;
    }

    protected static function getPriceValueFromFieldName(string $field_name, $locale = 'ru')
    {
        $price_tag = $locale == 'ru' ? SettingTagEnum::PRICE->value : SettingTagEnum::PRICE_US->value;

        return self::where('tag', $price_tag)->where('field_name', $field_name)->first()?->data;
    }


    private static function getValuesWithFieldNameAsKey($settings, array $field_names, bool $int_values = false): array
    {
        $data = [];

        foreach ($field_names as $field_name) {
            $value             = $settings->where('field_name', $field_name)->first()?->data;
            $data[$field_name] = $int_values ? (int) $value : $value;
        }

        return $data;
    }
}