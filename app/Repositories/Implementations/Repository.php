<?php

namespace App\Repositories\Implementations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Repository
{
    protected $model;

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function show(int $id): Model
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function destroy(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }
}
