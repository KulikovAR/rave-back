<?php
$baseUrl = env('FRONT_URL', 'http://localhost:3000');

return [
    'front_url'              => $baseUrl,
    'email_verified'         => $baseUrl . '/?email_verified=true&bearer_token=',
    'email_verified_error'   => $baseUrl . '/?email_verified=false',
    'auth_provider'          => $baseUrl . '/?bearer_token=',
    'payment_success'        => $baseUrl . '/bookingSuccess/',
    'payment_failed'         => $baseUrl . '/bookingSuccess/',
    'booking_failed'         => '?booking=failed&message=',
    'payment_status_failed'  => '?payment=failed&message=',
    'payment_status_success' => '?payment=success'
];
