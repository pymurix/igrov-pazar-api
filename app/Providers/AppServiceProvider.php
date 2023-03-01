<?php

namespace App\Providers;

use App\Services\GameService;
use App\Services\Implementations\GameServiceImplementation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app
            ->bind(
                GameService::class,
                GameServiceImplementation::class
            );

        $this->app->register(QueryBuilderMacroServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
