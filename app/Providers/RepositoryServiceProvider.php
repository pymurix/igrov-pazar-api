<?php

namespace App\Providers;

use App\Repositories\CacheDecorators\OrderRepositoryCacheDecorator;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->decorate(OrderRepository::class, \App\Repositories\Implementations\OrderRepository::class, OrderRepositoryCacheDecorator::class);
    }

    public function decorate(string $abstract, string $concrete, string $decorator): void
    {
        $this->app->bind($abstract, $concrete);
        $this->app->extend($abstract, function ($repository, Application $app) use ($decorator) {
            return new $decorator($repository);
        });
    }
}
