<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Validation\ValidationException;

interface UserRepositoryInterface
{
    /**
     * Crée un nouvel utilisateur.
     *
     * @throws ValidationException
     */
    public function create(array $data): User;
}