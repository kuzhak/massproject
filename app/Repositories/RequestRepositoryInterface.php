<?php

namespace App\Repositories;

use App\Dto\RequestFilterDto;
use App\Models\Request;
use Illuminate\Database\Eloquent\Collection;

interface RequestRepositoryInterface
{
    public function get(int $id): Request;

    public function list(RequestFilterDto $requestFilterDto): Collection;

    public function create(array $data): Request;

    public function update(int $id, array $data): Request;

    public function delete(int $id): void;
}
