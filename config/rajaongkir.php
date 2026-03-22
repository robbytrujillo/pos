<?php

return [
    // 'api_key' => env('RAJAONGKIR_API_KEY', ''),
    'api_key' => env('RAJAONGKIR_API_KEY', 'dummy_123456'),
    'origin_city_id' => env('RAJAONGKIR_ORIGIN_CITY_ID', '501'),
    // 'endpoints' => [
    //     'province' => 'https://rajaongkir.komerce.id/api/v1/destination/province',
    //     'city' => 'https://rajaongkir.komerce.id/api/v1/destination/city',
    // ],

     // Tambahan penting
    'use_dummy' => env('RAJAONGKIR_USE_DUMMY', true),

    'endpoints' => [
        'province' => env('RAJAONGKIR_USE_DUMMY', true)
            ? 'http://localhost:8000/api/province'
            : 'https://rajaongkir.komerce.id/api/v1/destination/province',

        'city' => env('RAJAONGKIR_USE_DUMMY', true)
            ? 'http://localhost:8000/api/city'
            : 'https://rajaongkir.komerce.id/api/v1/destination/city',
    ],
];