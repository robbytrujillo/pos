<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// halaman home test
// Route::inertia('/home', 'Home');

Route::redirect('/login', '/');

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Route::get('/dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard')->middleware('permission:dashboard.index');
    Route::get('/dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, '__invoke'])->name('logout')->middleware('auth');

$resources = [
    'roles' => [
        'controller' => \App\Http\Controllers\Admin\RoleController::class,
        'permissions' => 'roles.index|roles.create|roles.edit|roles.delete',
        'names' => 'roles'
    ],
];

foreach ($resources as $name => $resource) {
    $route = Route::resource($name, $resource['controller'])
        ->middleware("permission:{$resource['permissions']}");
    if (isset($resource['names'])) {
        $route->names($resource['names']);
    }
}