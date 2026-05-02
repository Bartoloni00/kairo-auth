<?php

namespace App\Modules\Auth\Interfaces\Http\Middlewares;

use Closure;
use Exception;
use Illuminate\Http\Request;
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use App\Shared\Helpers\Enums\{
  ApiMessageEnum,
  ApiStatusCodeEnum,
  ApiErrorCodeEnum
};
use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class JwtMiddleware
{
  use ApiResponse;

  public function __construct(
    private UserRepositoryInterface $userRepository
  ) {}

  public function handle(Request $request, Closure $next)
  {
    $header = $request->header('Authorization');

    if (!$header || !str_starts_with($header, 'Bearer ')) {
      return $this->errorResponse(
        ApiMessageEnum::TOKEN_NOT_PROVIDED,
        ApiErrorCodeEnum::AUTH_FAILED->value,
        ApiStatusCodeEnum::UNAUTHORIZED
      );
    }

    $token = str_replace('Bearer ', '', $header);

    try {
      $parts = explode('.', $token);
      if (count($parts) !== 3) {
        throw new Exception(ApiMessageEnum::TOKEN_INVALID);
      }
      [$header, $payload, $signature] = $parts;
      $payload = json_decode(base64_decode($payload), true);
    } catch (Exception $e) {
      return $this->errorResponse(
        ApiMessageEnum::TOKEN_INVALID,
        ApiErrorCodeEnum::TOKEN_INVALID->value,
        ApiStatusCodeEnum::UNAUTHORIZED
      );
    }

    if (!$payload || !isset($payload['user_id'])) {
      return $this->errorResponse(
        ApiMessageEnum::TOKEN_INVALID,
        ApiErrorCodeEnum::TOKEN_INVALID->value,
        ApiStatusCodeEnum::UNAUTHORIZED
      );
    }

    if ($payload['exp'] < time()) {
      return $this->errorResponse(
        ApiMessageEnum::TOKEN_EXPIRED,
        ApiErrorCodeEnum::TOKEN_EXPIRED->value,
        ApiStatusCodeEnum::UNAUTHORIZED
      );
    }

    $user = $this->userRepository->findById($payload['user_id']);

    if (!$user) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::AUTH_FAILED->value,
        ApiStatusCodeEnum::UNAUTHORIZED
      );
    }

    $request->setUserResolver(fn() => $user);

    return $next($request);
  }
}
