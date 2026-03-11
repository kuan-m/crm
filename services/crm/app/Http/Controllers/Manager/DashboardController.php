<?php

namespace App\Http\Controllers\Manager;

use App\Enums\ViewName;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view(ViewName::DASHBOARD->value);
    }
}
