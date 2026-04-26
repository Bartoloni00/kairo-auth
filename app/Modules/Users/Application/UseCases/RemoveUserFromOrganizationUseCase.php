<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class RemoveUserFromOrganizationUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $userId, int $organizationId): bool
  {
    return $this->userRepository->removeFromOrganization($userId, $organizationId);
  }
}
