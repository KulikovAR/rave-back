<?php

return [
    'email_support' => ['email_support' => env('MAIL_FROM_ADDRESS') ?? "support@support.com"],
    'phone_support' => ['phone_support' => env('PHONE_FROM_ADDRESS') ?? '+71231112233'],

    'prices_ru'     => [
        'prices' => [
            'value' => '₽'
        ]
    ],
    'prices_us'     => [
        'prices' => [
            'value' => '$'
        ]
    ],
    'locales'       => [
        'en',
        'ru'
    ]
];