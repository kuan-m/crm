<?php

use App\Enums\ViewName;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view(ViewName::WELCOME->value);
});

Route::get('/swagger', function () {
    return view(ViewName::SWAGGER_UI->value);
});
