<?php

use App\Enums\RouteName;
use App\Enums\ViewName;
use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route(RouteName::WIDGET->value);
});

Route::get('/swagger', function () {
    return view(ViewName::SWAGGER_UI->value);
});

Route::get('/widget', WidgetController::class)->name(RouteName::WIDGET->value);
