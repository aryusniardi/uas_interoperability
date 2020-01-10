<?php
    return [
        'defaults' => [
            'guard' => 'api',
            'passwords' => 'petugas'
        ],
        'guards' => [
            'api' => [
                'driver' => 'jwt',
                'provider' => 'petugas'
            ],
        ],
        'providers' => [
            'petugas' => [
                'driver' => 'eloquent',
                'model' => \App\Models\Petugas::class
            ]
        ]
    ];
?>