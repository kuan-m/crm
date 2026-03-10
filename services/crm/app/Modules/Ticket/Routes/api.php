<?php

use App\Modules\Ticket\Http\Controllers\V1\CreateController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/tickets')
    ->group(function () {
        Route::post('/', CreateController::class)
            ->name('api.v1.tickets.create');
    });
