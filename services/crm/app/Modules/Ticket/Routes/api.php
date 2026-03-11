<?php

use App\Modules\Ticket\Http\Controllers\V1\CreateController;
use App\Modules\Ticket\Http\Controllers\V1\ShowController;
use App\Modules\Ticket\Http\Controllers\V1\StatisticsController;
use App\Modules\Ticket\Http\Controllers\V1\UploadFileController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/tickets')
    ->group(function () {
        Route::get('/statistics', StatisticsController::class)
            ->name('api.v1.tickets.statistics');

        Route::post('/', CreateController::class)
            ->name('api.v1.tickets.create');

        Route::get('/{id}', ShowController::class)
            ->name('api.v1.tickets.show');

        Route::post('/{ticket}/files', UploadFileController::class)
            ->name('api.v1.tickets.files.upload');
    });
