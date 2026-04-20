<?php

namespace App\Modules\Auth\Interface\Http\Controllers;

use App\Modules\Auth\Application\UseCases\RegisterUserUseCase;
//use App\Modules\Auth\Application\UseCases\LoginUseCase;
use Illuminate\Http\JsonResponse;
use App\Modules\Auth\Application\Requests\RegisterUserRequest;

class AuthController
{
  public function __construct(
    private RegisterUserUseCase $registerUseCase,
  ) {}

  public function register(RegisterUserRequest $request): JsonResponse
  {
    $user = $this->registerUseCase->execute($request->validated());

    //$token = auth()->login($user);

    return response()->json([
      //'access_token' => $token,
      'token_type' => 'bearer',
      'user' => $user,
    ], 201);
  }
}
