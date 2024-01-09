<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function get(int $id): User;

    public function list(): Collection;

    public function create(array $data): User;

    public function update(int $id, array $data): User;

    public function delete(int $id): void;
}
