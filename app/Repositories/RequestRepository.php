<?php

namespace App\Repositories;

use App\Dto\RequestFilterDto;
use App\Models\Request;
use Illuminate\Database\Eloquent\Collection;

class RequestRepository implements RequestRepositoryInterface
{
    public function get(int $id): Request
    {
        return Request::findOrFail($id);
    }

    public function list(RequestFilterDto $requestFilterDto): Collection
    {
        $query = Request::query();

        if ($status = $requestFilterDto->getStatus()) {
            $query->where('status', $status);
        }
        if ($dateFrom = $requestFilterDto->getDateFrom()) {
            $query->whereDate('updated_at', '>=', $dateFrom);
        }
        if ($dateTo = $requestFilterDto->getDateTo()) {
            $query->whereDate('updated_at', '<=', $dateTo);
        }

        return $query->get();
    }

    public function create(array $data): Request
    {
        return Request::create($data);
    }

    public function update(int $id, array $data): Request
    {
        $request = $this->get($id);
        $request->fill($data);
        $request->save();
        return $request;
    }

    public function delete(int $id): void
    {
        $request = $this->get($id);
        $request->delete();
    }
}
