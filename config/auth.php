<?php
    return [
        'defaults' => [
            'guard' => 'api',
            'passwords' => 'user',
        ],
        
        'guards' => [
            'api' => [
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