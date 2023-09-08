<?php

return [
    'email_support' => ['email_support' => env('MAIL_FROM_ADDRESS') ?? "support@support.com"],
    'phone_support' => ['phone_support' => env('PHONE_FROM_ADDRESS') ?? '+71231112233'],

    'prices_ru'     => [
        'prices' => [
            'price_normal'     => 300,
            'price_vip'        => 1500,
            'price_premium'    => 2900,
            'duration_normal'  => 30,
            'duration_vip'     => 180,
            'duration_premium' => 365,
            'value'            => '₽'
        ]
    ],
    'prices_us'     => [
        'prices' => [
            'price_normal'       => 10,
            'price_vip'   => 20,
            'price_premium' => 10,
            'duration_normal'  => 30,
            'duration_vip'     => 180,
            'duration_premium' => 365,
            'value'       => '$'
        ]
    ],
    'locales'       => [
        'en',
        'ru'
    ]
];