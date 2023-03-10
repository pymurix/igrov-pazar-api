<?php

namespace App\Repositories\CacheDecorators;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
abstract class RepositoryCacheDecorator
{
    public function __construct(private readonly Repository $repository)
    {
    }

    public function all(): Collection
    {
        return Cache::remember("{$this->getCacheBaseKey()}.all", 3600, function () {
            return $this->repository->all();
        });
    }

    public function store(array $data): Model
    {
        $model = $this->repository->store($data);
        Cache::delete("{$this->getCacheBaseKey()}.all*");
        return $model;
    }

    public function show(int $id): Model
    {
        return Cache::remember("{$this->getCacheBaseKey()}.{$id}", 3600, function () use ($id) {
            return $this->repository->show($id);
        });
    }

    public function update(int $id, array $data): bool
    {
        $updated = $this->repository->update($id, $data);
        Cache::delete("{$this->getCacheBaseKey()}.{$id}");
        return $updated;
    }

    public function destroy(int $id): bool
    {
        $deleted = $this->repository->destroy($id);
        Cache::delete("{$this->getCacheBaseKey()}.{$id}");
        return $deleted;
    }

    public function getCacheBaseKey(): string
    {
        return Str::ucsplit(class_basename($this))[0];
    }
}
