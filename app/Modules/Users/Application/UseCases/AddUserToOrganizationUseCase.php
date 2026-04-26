<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class AddUserToOrganizationUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, int $organizationId, ?int $roleId = null): bool
  {
    return $this->userRepository->addToOrganization($userId, $organizationId, $roleId);
  }
}
