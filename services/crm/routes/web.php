<?php

use App\Enums\ViewName;
use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view(ViewName::WELCOME->value);
});

Route::get('/swagger', function () {
    return view(ViewName::SWAGGER_UI->value);
});

Route::get('/widget', WidgetController::class)->name(ViewName::WIDGET->value);
