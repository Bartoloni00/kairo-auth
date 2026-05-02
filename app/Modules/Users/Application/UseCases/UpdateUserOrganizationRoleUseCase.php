<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class UpdateUserOrganizationRoleUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, int $organizationId, int $roleId): bool
  {
    return $this->userRepository->updateOrganizationRole($userId, $organizationId, $roleId);
  }
}
