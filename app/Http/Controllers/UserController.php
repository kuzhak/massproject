<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserServiceInterface $userService)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|string|in:' . User::ROLE_USER . ',' . User::ROLE_RESPONSIBLE,
        ]);
        $user = $this->userService->createUser($request->all());
        return response()->json($user, 201);
    }
}
