<?php

use App\Enums\RouteName;
use App\Enums\ViewName;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\WidgetController;
use App\Modules\User\Http\Controllers\V1\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route(RouteName::WIDGET->value);
});

Route::get('/swagger', function () {
    return view(ViewName::SWAGGER_UI->value);
});

Route::get('/widget', WidgetController::class)->name(RouteName::WIDGET->value);

Route::prefix('manager')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showForm'])->name(RouteName::LOGIN->value);
        Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name(RouteName::DASHBOARD->value);
        Route::post('/logout', [LoginController::class, 'logout'])->name(RouteName::LOGOUT->value);
    });
});
