<?php
    return [
        'defaults' => [
            'guard' => env('user', 'admin'),
        ],
        
        'guards' => [
            'user' => [
                'driver' => 'jwt',
                'provider' => 'user',
                'hash' => false,
            ],
            'admin' => [
                'driver' => 'jwt',
                'provider' => 'admin',
            ]
        ],
        
        'providers' => [
            'user' => [
                'driver' => 'eloquent',
                'model' => \App\Models\User::class,
            ],
            'admin' => [
                'driver' => 'eloquent',
                'model' => \App\Models\Petugas::class,
            ]
        ]
    ];
?>