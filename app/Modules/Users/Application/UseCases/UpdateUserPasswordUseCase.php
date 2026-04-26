<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class UpdateUserPasswordUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, string $password): bool
  {
    return $this->userRepository->updatePassword($userId, $password);
  }
}
