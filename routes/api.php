<?php

use Illuminate\Support\Facades\Route;

Route::get('/province', function () {
    return response()->json([
        ['province_id' => 1, 'province' => 'DKI Jakarta'],
        ['province_id' => 2, 'province' => 'Jawa Barat'],
    ]);
});

Route::get('/city', function () {
    return response()->json([
        ['city_id' => 501, 'city_name' => 'Jakarta'],
        ['city_id' => 114, 'city_name' => 'Bandung'],
    ]);
});