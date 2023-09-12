<?php
$baseUrl = env('FRONT_URL', 'http://localhost:3000');

return [
    'front_url' => $baseUrl,
    'pass_reset_url' => $baseUrl . '/account/recovery',
    'email_verified' => $baseUrl . '/account/registration/success',
    'email_verified_error' => $baseUrl . '/account/registration/error',
    'auth_provider' => $baseUrl,
    'payment_success' => $baseUrl . '/dashboard/',
    'payment_failed' => $baseUrl . '/dashboard/',
    'payment_status_failed' => '?payment=false&message=',
    'payment_status_success' => '?payment=true',
    'subscription_expired' => $baseUrl . '/account/subscription'
];

