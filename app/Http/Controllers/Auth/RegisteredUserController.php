<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

class RegisteredUserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {
        try {
            $datas = $this->userService->register($request->all());

            return response()->json($datas, 201);

        } catch (Throwable $e) {
            Log::error('Erreur lors de l’enregistrement', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Erreur lors de l’enregistrement'
            ], 500);
        }
    }
}
