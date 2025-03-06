<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Services\Contracts\UserServiceInterface;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): array
    {

        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->createUser($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        event(new Registered($user));

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}
