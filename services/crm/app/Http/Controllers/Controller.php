<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "CRM API",
    version: "1.0.0",
    description: "API документация"
)]
#[OA\Server(
    url: "/api",
    description: "Главный API сервер"
)]
abstract class Controller
{
    //
}
