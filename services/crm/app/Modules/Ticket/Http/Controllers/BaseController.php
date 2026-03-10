<?php

namespace App\Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ticket\Services\Service;

class BaseController extends Controller
{
    public function __construct(protected Service $service) {}
}
