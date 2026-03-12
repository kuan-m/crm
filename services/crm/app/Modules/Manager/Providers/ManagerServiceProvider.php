<?php

namespace App\Modules\Manager\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutes();
    }

    protected function loadRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('app/Modules/Manager/Routes/web.php'));
    }
}
