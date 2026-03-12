<?php

use App\Enums\RouteName;
use App\Modules\Manager\Http\Controllers\DashboardController;
use App\Modules\Manager\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name(RouteName::LOGIN->value);
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name(RouteName::DASHBOARD->value);
        Route::get('/tickets/list', [DashboardController::class, 'getTicketList'])->name(RouteName::MANAGER_TICKETS_LIST->value);
        Route::post('/logout', [LoginController::class, 'logout'])->name(RouteName::LOGOUT->value);
    });
});
