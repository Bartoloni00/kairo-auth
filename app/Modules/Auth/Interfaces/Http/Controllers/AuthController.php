<?php

namespace App\Modules\Auth\Interfaces\Http\Controllers;

use App\Modules\Auth\Application\UseCases\{
  RegisterUserUseCase,
  LoginUserUseCase,
};
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Modules\Auth\Application\Requests\{
  RegisterUserRequest,
  LoginRequest
};
use App\Modules\Users\Application\UseCases\GetUserUseCase;
use App\Shared\Helpers\Enums\ApiStatusCodeEnum;

class AuthController
{
  use ApiResponse;

  public function __construct(
    private RegisterUserUseCase $registerUseCase,
    private LoginUserUseCase $loginUseCase,
    private GetUserUseCase $getUserUseCase
  ) {}

  public function register(RegisterUserRequest $request): JsonResponse
  {
    $user = $this->registerUseCase->execute($request->validated());
    $token = $this->loginUseCase->execute($request->getEmail(), $request->getPassword());

    return $this->successResponse([
      'access_token' => $token,
      'token_type' => 'bearer',
      'user' => $user,
    ], null, ApiStatusCodeEnum::CREATED);
  }

  public function login(LoginRequest $request): JsonResponse
  {
    $token = $this->loginUseCase->execute($request->getEmail(), $request->getPassword());

    return $this->successResponse([
      'access_token' => $token,
      'token_type' => 'bearer',
    ]);
  }

  public function me(Request $request): JsonResponse
  {
    $user = $this->getUserUseCase->execute($request->user()->id);

    return $this->successResponse([
      'user' => $user
    ]);
  }
}
