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
use App\Modules\Auditlogs\Application\Services\AuditLogService;

class AuthController
{
  use ApiResponse;

  public function __construct(
    private RegisterUserUseCase $registerUseCase,
    private LoginUserUseCase $loginUseCase,
    private GetUserUseCase $getUserUseCase,
    private AuditLogService $auditLogService
  ) {}

  public function register(RegisterUserRequest $request): JsonResponse
  {
    try {
      $user = $this->registerUseCase->execute($request->validated());
      $token = $this->loginUseCase->execute($request->getEmail(), $request->getPassword());

      $this->auditLogService->info('user_registered', [
        'email' => $request->getEmail(),
        'user_id' => $user->id
      ], $user->id);

      return $this->successResponse([
        'access_token' => $token,
        'token_type' => 'bearer',
        'user' => $user,
      ], null, ApiStatusCodeEnum::CREATED);
    } catch (\Exception $e) {
      $this->auditLogService->error('registration_failed', [
        'email' => $request->getEmail(),
        'error' => $e->getMessage()
      ]);
      throw $e;
    }
  }

  public function login(LoginRequest $request): JsonResponse
  {
    try {
      $token = $this->loginUseCase->execute($request->getEmail(), $request->getPassword());

      return $this->successResponse([
        'access_token' => $token,
        'token_type' => 'bearer',
      ]);
    } catch (\Exception $e) {
      $this->auditLogService->error('login_failed', [
        'email' => $request->getEmail(),
        'error' => $e->getMessage()
      ]);
      throw $e;
    }
  }

  public function me(Request $request): JsonResponse
  {
    $user = $this->getUserUseCase->execute($request->user()->id);

    $this->auditLogService->info('user_profile_accessed', [
      'user_id' => $user->id
    ]);

    return $this->successResponse([
      'user' => $user
    ]);
  }
}
