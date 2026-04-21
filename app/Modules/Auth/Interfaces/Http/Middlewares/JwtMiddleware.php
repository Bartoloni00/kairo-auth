<?php

namespace App\Modules\Auth\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use Exception;

class JwtMiddleware
{
  public function __construct(
    private UserRepositoryInterface $userRepository
  ) {}

  public function handle(Request $request, Closure $next)
  {
    $header = $request->header('Authorization');

    if (!$header || !str_starts_with($header, 'Bearer ')) {
      throw new Exception('Token not provided');
    }

    $token = str_replace('Bearer ', '', $header);

    [$header, $payload, $signature] = explode('.', $token);

    $payload = json_decode(base64_decode($payload), true);

    if (!$payload || !isset($payload['user_id'])) {
      throw new Exception('Invalid token');
    }

    if ($payload['exp'] < time()) {
      throw new Exception('Token expired');
    }

    $user = $this->userRepository->findById($payload['user_id']);

    if (!$user) {
      throw new Exception('User not found');
    }

    $request->attributes->set('user', $user);

    return $next($request);
  }
}
