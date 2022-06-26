<?php

return [
    'authUrl' => env('API_MEDIC_AUTH_URL', 'https://sandbox-authservice.priaid.ch/'),
    'authApiKey' => env('API_MEDIC_AUTH_API_KEY'),
    'authSecretKey' => env('API_MEDIC_AUTH_SECRET_KEY'),
    'sandboxUrl' => env('API_MEDIC_SANDBOX_URL', 'https://sandbox-healthservice.priaid.ch/'),
    'format' => env('API_MEDIC_FORMAT', 'json'),
    'lang' => env('API_MEDIC_LANG', 'en-gb'),
];