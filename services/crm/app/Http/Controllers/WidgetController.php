<?php

namespace App\Http\Controllers;

use App\Enums\ViewName;
use Illuminate\View\View;

class WidgetController extends Controller
{
    public function __invoke(): View
    {
        return view(ViewName::WIDGET->value);
    }
}
