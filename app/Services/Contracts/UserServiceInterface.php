<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Validation\ValidationException;

interface UserServiceInterface
{
    /**
     * Valide et crée un nouvel utilisateur.
     *
     * @throws ValidationException
     */
    public function register(array $data): User;
}
