<?php

namespace App\Modules\Ticket\Providers;

use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\Repositories\EloquentTicketRepository;
use App\Modules\Ticket\Repositories\InMemTicketRepository;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        if ($this->app->runningUnitTests()) {
            $this->app->bind(
                ITicketRepository::class,
                InMemTicketRepository::class
            );
        } else {
            $this->app->bind(
                ITicketRepository::class,
                EloquentTicketRepository::class
            );
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(
            __DIR__.'/../Routes/api.php'
        );
    }
}
