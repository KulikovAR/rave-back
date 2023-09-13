<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Enums\SettingTagEnum;
use App\Models\Price;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // if (App::environment(EnvironmentTypeEnum::productEnv())) {
        //     return;
        // }

        $data = [
            [
                'tag'               => SettingTagEnum::PRICE->value,
                'field_name'        => 'price_normal',
                'field_description' => 'За месяц',
                'data'              => 300
            ],
            [
                'tag'               => SettingTagEnum::PRICE->value,
                'field_name'        => 'price_vip',
                'field_description' => 'За три месяц',
                'data'              => 1500
            ],
            [
                'tag'               => SettingTagEnum::PRICE->value,
                'field_name'        => 'price_premium',
                'field_description' => 'За год',
                'data'              => 2900
            ],
            [
                'tag'               => SettingTagEnum::PRICE_US->value,
                'field_name'        => 'price_normal',
                'field_description' => 'За месяц',
                'data'              => 10
            ],
            [
                'tag'               => SettingTagEnum::PRICE_US->value,
                'field_name'        => 'price_vip',
                'field_description' => 'За три месяц',
                'data'              => 20
            ],
            [
                'tag'               => SettingTagEnum::PRICE_US->value,
                'field_name'        => 'price_premium',
                'field_description' => 'За год',
                'data'              => 50
            ],
            [
                'tag'               => SettingTagEnum::SUBSCRIPTION->value,
                'field_name'        => 'duration_normal',
                'field_description' => 'Количество дней в подписке на один месяц',
                'data'              => 30
            ],
            [
                'tag'               => SettingTagEnum::SUBSCRIPTION->value,
                'field_name'        => 'duration_vip',
                'field_description' => 'Количество дней в подписке на три месяца',
                'data'              => 180
            ],
            [
                'tag'               => SettingTagEnum::SUBSCRIPTION->value,
                'field_name'        => 'duration_premium',
                'field_description' => 'Количество дней в подписке на год',
                'data'              => 365
            ],
            [
                'tag'               => SettingTagEnum::LESSON_SHEDULE->value,
                'field_name'        => 'lesson_shedule_duration',
                'field_description' => 'Промежуток выхода уроков в днях',
                'data'              => 7
            ],
        ];

        foreach ($data as $setting) {
            Setting::create($setting);
        }
    }
}