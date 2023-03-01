<?php

namespace App\Providers;

use App\QueryFilters\Filterable;
use App\QueryFilters\Sortable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class QueryBuilderMacroServiceProvider extends ServiceProvider
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
        Builder::macro('filterable', function (array $filters = [], $freeLike = false) {
            return Filterable::filter($this, $filters);
        });

        Builder::macro('sortable', function (array $filters = []) {
            return Sortable::sort($this, $filters);
        });
    }
}
