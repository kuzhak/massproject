<?php

namespace App\Services;

use App\Dto\RequestFilterDto;
use App\Models\Request as RequestModel;
use App\Models\User;
use App\Repositories\RequestRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RequestService implements RequestServiceInterface
{
    public function __construct(protected RequestRepositoryInterface $requestRepository)
    {
    }

    public function createRequest(User $user, string $message): RequestModel
    {
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'message' => $message
        ];

        return $this->requestRepository->create($data);
    }

    public function answerRequest(int $requestId, string $comment): RequestModel
    {
        $data = [
            'status' => RequestModel::STATUS_RESOLVED,
            'comment' => $comment
        ];

        return $this->requestRepository->update($requestId, $data);
    }

    public function listRequest(Request $request): Collection
    {
        $requestFilterDto = new RequestFilterDto(
            $request->status,
            $request->date_from ? new Carbon($request->date_from) : null,
            $request->date_from ? new Carbon($request->date_to) : null
        );

        return $this->requestRepository->list($requestFilterDto);
    }
}
