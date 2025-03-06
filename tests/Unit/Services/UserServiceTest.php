<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private $userRepositoryMock;
    private UserServiceInterface $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function test_register_user_successfully()
    {
        Event::fake(); // Empêche l'exécution réelle des événements
        $user = User::factory()->make(['id' => 1]); // Générer un user fake

        $this->userRepositoryMock
            ->shouldReceive('createUser')
            ->once()
            ->andReturn($user);

        $result = $this->userService->register([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'password123',
        ]);

        $this->assertArrayHasKey('access_token', $result);
        Event::assertDispatched(Registered::class);
    }
}
