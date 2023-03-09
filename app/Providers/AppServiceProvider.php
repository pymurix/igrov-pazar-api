<?php

namespace App\Providers;

use App\Repositories\CacheDecorators\OrderRepositoryCacheDecorator;
use App\Repositories\OrderRepository;
use App\Services\Auth\RegisterService;
use App\Services\GameService;
use App\Services\Implementations\Auth\RegisterServiceImplementation;
use App\Services\Implementations\GameServiceImplementation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GameService::class,GameServiceImplementation::class);
        $this->app->bind(RegisterService::class, RegisterServiceImplementation::class);

        $this->app->bind(OrderRepository::class, function ($app) {
            return new OrderRepositoryCacheDecorator(
                new \App\Repositories\Implementations\OrderRepository()
            );
        });


        $this->app->register(QueryBuilderMacroServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (in_array(\Config::get('app.env'), ['testing', 'local'])) {
            DB::listen(function ($query) {
                \Log::info($query->sql);
                \Log::info($query->bindings);
                \Log::info($query->time);
            });
        }
    }
}
