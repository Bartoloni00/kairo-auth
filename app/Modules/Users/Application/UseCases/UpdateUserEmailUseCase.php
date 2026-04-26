<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class UpdateUserEmailUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, string $email): bool
  {
    return $this->userRepository->updateEmail($userId, $email);
  }
}
