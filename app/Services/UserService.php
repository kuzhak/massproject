<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function createUser(array $userData): User
    {
        $user = $this->userRepository->create($userData);
        $user->token = $user->createToken($user->email)->plainTextToken;
        return $user;
    }
}
