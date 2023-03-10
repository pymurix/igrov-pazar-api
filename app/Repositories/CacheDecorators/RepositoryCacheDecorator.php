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
        return Cache::tags([$this->getCacheBaseKey(), 'all'])->remember("{$this->getCacheBaseKey()}.all", 60, function () {
            return $this->repository->all();
        });
    }

    public function store(array $data): Model
    {
        $model = $this->repository->store($data);
        Cache::tags([$this->getCacheBaseKey(), 'all'])->flush();
        return $model;
    }

    public function show(int $id): Model
    {
        return Cache::remember("{$this->getCacheBaseKey()}.{$id}", 60, function () use ($id) {
            return $this->repository->show($id);
        });
    }

    public function update(int $id, array $data): bool
    {
        $updated = $this->repository->update($id, $data);
        Cache::delete("{$this->getCacheBaseKey()}.{$id}");
        Cache::tags([$this->getCacheBaseKey(), 'all'])->flush();
        return $updated;
    }

    public function destroy(int $id): bool
    {
        $deleted = $this->repository->destroy($id);
        Cache::delete("{$this->getCacheBaseKey()}.{$id}");
        Cache::tags([$this->getCacheBaseKey(), 'all'])->flush();
        return $deleted;
    }

    public function getCacheBaseKey(): string
    {
        return Str::ucsplit(class_basename($this))[0];
    }
}
