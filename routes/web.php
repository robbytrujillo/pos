<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// halaman home test
Route::inertia('/home', 'Home');