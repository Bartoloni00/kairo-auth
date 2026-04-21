<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Auth\Application\Ports\TokenProviderInterface;
use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Exception;

class LoginUserUseCase
{
  public function __construct(
    private UserRepositoryInterface $userRepository,
    private TokenProviderInterface $tokenProvider
  ) {}

  public function execute(string $email, string $password): string
  {
    $user = $this->userRepository->findByEmail($email);

    if (!$user || !Hash::check($password, $user->password)) {
      throw new Exception('Invalid credentials');
    }

    return $this->tokenProvider->generate([
      'user_id' => $user->id,
    ]);
  }
}
