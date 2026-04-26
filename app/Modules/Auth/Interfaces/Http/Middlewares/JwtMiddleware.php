<?php

namespace App\Modules\Auth\Interfaces\Http\Middlewares;

use Closure;
use Exception;
use Illuminate\Http\Request;

use App\Shared\Helpers\Enums\ApiMessageEnum;
use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class JwtMiddleware
{
  public function __construct(
    private UserRepositoryInterface $userRepository
  ) {}

  public function handle(Request $request, Closure $next)
  {
    $header = $request->header('Authorization');

    if (!$header || !str_starts_with($header, 'Bearer ')) {
      throw new Exception(ApiMessageEnum::TOKEN_NOT_PROVIDED);
    }

    $token = str_replace('Bearer ', '', $header);

    [$header, $payload, $signature] = explode('.', $token);

    $payload = json_decode(base64_decode($payload), true);

    if (!$payload || !isset($payload['user_id'])) {
      throw new Exception(ApiMessageEnum::TOKEN_INVALID);
    }

    if ($payload['exp'] < time()) {
      throw new Exception(ApiMessageEnum::TOKEN_EXPIRED);
    }

    $user = $this->userRepository->findById($payload['user_id']);

    if (!$user) {
      throw new Exception(ApiMessageEnum::USER_NOT_FOUND);
    }

    $request->attributes->set('user', $user);

    return $next($request);
  }
}
