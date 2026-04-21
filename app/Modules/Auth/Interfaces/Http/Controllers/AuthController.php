<?php

namespace App\Modules\Auth\Interfaces\Http\Controllers;

use App\Modules\Auth\Application\UseCases\{
  RegisterUserUseCase,
  LoginUserUseCase,
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Modules\Auth\Application\Requests\{
  RegisterUserRequest,
  LoginRequest
};

class AuthController
{
  public function __construct(
    private RegisterUserUseCase $registerUseCase,
    private LoginUserUseCase $loginUseCase
  ) {}

  public function register(RegisterUserRequest $request): JsonResponse
  {
    $user = $this->registerUseCase->execute($request->validated());
    $token = $this->loginUseCase->execute($request->getEmail(), $request->getPassword());

    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'user' => $user,
    ], 201);
  }

  public function login(LoginRequest $request): JsonResponse
  {
    $token = $this->loginUseCase->execute($request->getEmail(), $request->getPassword());

    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
    ], 200);
  }

  public function me(Request $request): JsonResponse
  {
    $user = $request->attributes->get('user');

    return response()->json([
      'user' => [
        'id' => $user->id,
        'email' => $user->email,
      ]
    ], 200);
  }
}
