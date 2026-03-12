<?php

namespace App\Providers;

use App\Modules\File\Providers\FileServiceProvider;
use App\Modules\Manager\Providers\ManagerServiceProvider;
use App\Modules\Ticket\Providers\TicketServiceProvider;
use App\Modules\User\Providers\UserServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->register(
            ManagerServiceProvider::class,
        );
        $this->app->register(
            TicketServiceProvider::class,
        );
        $this->app->register(
            FileServiceProvider::class,
        );
        $this->app->register(
            UserServiceProvider::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
