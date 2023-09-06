<?php

return [
    'email_support' => ['email_support' => env('MAIL_FROM_ADDRESS')],

    'prices_ru'     => [
        'prices' => [
            'price_normal'     => 999,
            'price_vip'        => 1499,
            'price_premium'    => 999,
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