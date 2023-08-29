<?php
$baseUrl = env('FRONT_URL', 'http://localhost:3000');

return [
    'front_url'              => $baseUrl,
    'pass_reset_url'         => $baseUrl . '/account/recovery',
    'email_verified'         => $baseUrl . '/account/registration/success',
    'email_verified_error'   => $baseUrl . '/account/registration/error',
    'auth_provider'          => $baseUrl,
    'payment_success'        => $baseUrl . '/bookingSuccess/',
    'payment_failed'         => $baseUrl . '/bookingSuccess/',
    'booking_failed'         => '?booking=failed&message=',
    'payment_status_failed'  => '?payment=failed&message=',
    'payment_status_success' => '?payment=success',
    'subscription_expired'   => $baseUrl . '/account/subscription'
];

