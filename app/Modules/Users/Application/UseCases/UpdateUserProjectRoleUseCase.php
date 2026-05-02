<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class UpdateUserProjectRoleUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, int $projectId, int $roleId): bool
  {
    return $this->userRepository->updateProjectRole($userId, $projectId, $roleId);
  }
}
