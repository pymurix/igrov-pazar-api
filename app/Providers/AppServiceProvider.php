<?php

namespace App\Providers;

use App\QueryFilters\Filterable;
use App\QueryFilters\Sortable;
use App\Services\GameService;
use App\Services\Implementations\GameServiceImplementation;
use Illuminate\Database\Query\Builder;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('filterable', function (array $filters = [], $freeLike = false) {
            return Filterable::filter($this, $filters);
        });

        Builder::macro('sortable', function (array $filters = []) {
            return Sortable::sort($this, $filters);
        });
    }
}
