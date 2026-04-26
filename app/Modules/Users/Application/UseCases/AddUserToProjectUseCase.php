<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class AddUserToProjectUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, int $projectId, ?int $roleId = null): bool
  {
    return $this->userRepository->addToProject($userId, $projectId, $roleId);
  }
}
