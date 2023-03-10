<?php

namespace App\Repositories\CacheDecorators;

use App\Repositories\OrderRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class OrderRepositoryCacheDecorator extends RepositoryCacheDecorator implements OrderRepository
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
        parent::__construct($this->orderRepository);
    }

    public function allWithFiltersAndPagination(array $filters): LengthAwarePaginator
    {
        return Cache::tags([$this->getCacheBaseKey(), 'all'])->remember("{$this->getCacheBaseKey()}.all." . json_encode($filters), 60, function () use ($filters) {
            return $this->orderRepository->allWithFiltersAndPagination($filters);
        });
    }
}
