<?php

namespace App\Providers;

use App\Modules\File\Providers\FileServiceProvider;
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
        //
    }
}
