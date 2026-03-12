<?php

namespace App\Modules\File\Providers;

use App\Modules\File\Contracts\IFileRepository;
use App\Modules\File\Repositories\EloquentFileRepository;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IFileRepository::class, EloquentFileRepository::class);
    }
}
