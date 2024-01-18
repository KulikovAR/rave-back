<?php
return [
    "terminal" => env('TINKOFF_TERMINAL'),
    "secret"   => env('TINKOFF_SECRET'),
    "recurrent_payments"=>env('TINKOFF_RECURRENT_PAY',1),
];