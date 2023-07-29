<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airport::upsert([
                            [
                                'code'              => 'YKS',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => null,
                                'city_en'           => null,
                                'city_code'         => 'YKS',
                                'name'              => 'Якутск',
                                'name_en'           => 'Yakutsk',
                                'main_airport_name' => null,
                                'type'              => 'city',
                                'weight'            => 22136,
                                'cases'             => null
                            ], [
                                'code'              => 'VKO',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => 'Москва',
                                'city_en'           => 'Moscow',
                                'city_code'         => 'VKO',
                                'name'              => 'Внуково',
                                'name_en'           => 'Vnukovo Airport',
                                'main_airport_name' => null,
                                'type'              => 'airport',
                                'weight'            => 438605,
                                'cases'             => '{"accusative":"в Москву","genitive":"Москве","dative":"Москвы"}'
                            ], [
                                'code'              => 'DME',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => 'Москва',
                                'city_en'           => 'Moscow',
                                'city_code'         => 'DME',
                                'name'              => 'Домодедово',
                                'name_en'           => 'Moscow Domodedovo Airport',
                                'main_airport_name' => null,
                                'type'              => 'airport',
                                'weight'            => 370145,
                                'cases'             => '{"accusative":"в Москву","genitive":"Москве","dative":"Москвы"}'
                            ], [
                                'code'              => 'SVO',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => 'Москва',
                                'city_en'           => 'Moscow',
                                'city_code'         => 'SVO',
                                'name'              => 'Шереметьево',
                                'name_en'           => 'Sheremetyevo International Airport',
                                'main_airport_name' => null,
                                'type'              => 'airport',
                                'weight'            => 641331,
                                'cases'             => '{"accusative":"в Москву","genitive":"Москве","dative":"Москвы"}'
                            ], [
                                'code'              => 'IAA',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => null,
                                'city_en'           => null,
                                'city_code'         => 'IAA',
                                'name'              => 'Игарка',
                                'name_en'           => 'Igarka',
                                'main_airport_name' => null,
                                'type'              => 'city',
                                'weight'            => 186,
                                'cases'             => null
                            ], [
                                'code'              => 'IAA',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => null,
                                'city_en'           => null,
                                'city_code'         => 'IAA',
                                'name'              => 'Игарка',
                                'name_en'           => 'Igarka',
                                'main_airport_name' => null,
                                'type'              => 'city',
                                'weight'            => 186,
                                'cases'             => null
                            ], [
                                'code'              => 'IRM',
                                'country'           => 'Россия',
                                'state'             => null,
                                'city'              => null,
                                'city_en'           => null,
                                'city_code'         => 'IAA',
                                'name'              => 'Игрим',
                                'name_en'           => 'Igrim',
                                'main_airport_name' => null,
                                'type'              => 'city',
                                'weight'            => 100,
                                'cases'             => null
                            ]
                        ],
                        [
                            'code',
                            'country',
                            'state',
                            'city',
                            'city_en',
                            'city_code',
                            'name',
                            'name_en',
                            'main_airport_name',
                            'type',
                            'weight',
                            'cases'
                        ]);
    }
}
