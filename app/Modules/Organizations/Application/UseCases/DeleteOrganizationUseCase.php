<?php

namespace App\Modules\Organizations\Application\UseCases;

use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;

class DeleteOrganizationUseCase
{
  public function __construct(
    private readonly OrganizationRepositoryInterface $organizationRepository
  ) {}

  public function execute(int $id): bool
  {
    return $this->organizationRepository->delete($id);
  }
}
