<?php
$baseUrl = env('FRONT_URL', 'http://localhost:3000');

return [
    'front_url'              => $baseUrl,
    'pass_reset_url'         => $baseUrl . '/account/recovery'
    'email_verified'         => $baseUrl . '/?email_verified=true',
    'email_verified_error'   => $baseUrl . '/?email_verified=false',
    'auth_provider'          => $baseUrl ,
    'payment_success'        => $baseUrl . '/bookingSuccess/',
    'payment_failed'         => $baseUrl . '/bookingSuccess/',
];
