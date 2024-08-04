<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'merchants',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'merchants',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'merchants',
        ],
    ],

    'providers' => [
        'merchants' => [
            'driver' => 'eloquent',
            'model' => \Core\Infrastructure\Models\Merchant::class,
        ],
    ],

    'passwords' => [
        'merchants' => [
            'provider' => 'merchants',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
