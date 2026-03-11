<?php

namespace App\Modules\Ticket\Providers;

use App\Modules\Customer\Contracts\ICustomerRepository;
use App\Modules\Customer\Repositories\EloquentCustomerRepository;
use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\Repositories\EloquentTicketRepository;
use App\Modules\Ticket\Repositories\InMemTicketRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ITicketRepository::class,
            $this->app->runningUnitTests()
                ? InMemTicketRepository::class
                : EloquentTicketRepository::class
        );

        $this->app->bind(
            ICustomerRepository::class,
            EloquentCustomerRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(function () {
                $this->loadRoutesFrom(
                    __DIR__.'/../Routes/api.php'
                );
            });
    }
}
