<?php

namespace App\Services;

use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface RequestServiceInterface
{
    public function createRequest(User $user, string $message): RequestModel;

    public function answerRequest(int $requestId, string $comment): RequestModel;

    public function listRequest(Request $request): Collection;
}
