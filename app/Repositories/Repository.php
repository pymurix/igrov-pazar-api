<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface Repository
{
    public function all(): Collection;

    public function store(array $data): Model;

    public function show(int $id): Model;

    public function update(int $id, array $data): bool;

    public function destroy(int $id): bool;
}
