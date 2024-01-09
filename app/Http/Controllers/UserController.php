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

    /**
     * @OA\Post(
     *     path="/api/user/create",
     *     summary="Create a new user",
     *     description="Create a new user with required fields",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "role"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 maxLength=255
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 maxLength=255
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 minLength=8,
     *                 maxLength=255
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 enum={"user", "responsible"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="User created successfully"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     )
     * )
     */
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
