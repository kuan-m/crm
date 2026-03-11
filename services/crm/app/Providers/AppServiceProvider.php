<?php

namespace App\Providers;

use App\Modules\File\Providers\FileServiceProvider;
use App\Modules\Ticket\Providers\TicketServiceProvider;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
