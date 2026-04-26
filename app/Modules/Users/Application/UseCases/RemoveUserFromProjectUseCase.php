<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class RemoveUserFromProjectUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, int $projectId): bool
  {
    return $this->userRepository->removeFromProject($userId, $projectId);
  }
}
