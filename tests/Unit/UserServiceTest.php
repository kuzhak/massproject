<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $userService;
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = \Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function test_create_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'user',
        ];

        $this->userRepository
            ->shouldReceive('create')
            ->with($userData)
            ->andReturn(User::create($userData));

        $result = $this->userService->createUser($userData);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($userData['name'], $result->name);
        $this->assertEquals($userData['email'], $result->email);
        $this->assertEquals($userData['role'], $result->role);
    }
}
