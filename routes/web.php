<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// halaman home test
// Route::inertia('/home', 'Home');

Route::redirect('/login', '/');

Route::middleware('guest')->group(function () {
    Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, '__invoke'])->name('logout')->middleware('auth');