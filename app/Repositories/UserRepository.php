<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function get(int $id): User
    {
        return User::findOrFail($id);
    }

    public function list(): Collection
    {
        return User::all();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->get($id);
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function delete(int $id): void
    {
        $user = $this->get($id);
        $user->delete();
    }
}
