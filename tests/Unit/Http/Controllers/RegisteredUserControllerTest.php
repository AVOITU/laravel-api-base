<?php

namespace Tests\Unit\Http\Controllers;

use App\Services\Contracts\UserServiceInterface;
use Mockery;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    private $userServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userServiceMock = Mockery::mock(UserServiceInterface::class);
        $this->app->instance(UserServiceInterface::class, $this->userServiceMock);
    }

    public function test_store_returns_201_on_successful_registration()
    {
        $userData = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => 'hashed_password',
            ],
            'access_token' => 'fake_token',
            'token_type' => 'Bearer',
        ];

        $this->userServiceMock
            ->shouldReceive('register')
            ->once()
            ->andReturn($userData);

        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson($userData);
    }

    public function test_store_returns_500_on_service_exception()
    {
        $this->userServiceMock
            ->shouldReceive('register')
            ->once()
            ->andThrow(new \Exception('Unexpected error'));

        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(500)
            ->assertJson(['message' => 'Erreur lors de l’enregistrement']);
    }
}
