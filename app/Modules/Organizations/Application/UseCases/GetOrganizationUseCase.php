<?php

namespace App\Modules\Organizations\Application\UseCases;

use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;
use App\Modules\Organizations\Domain\Entities\Organization;

class GetOrganizationUseCase
{
  public function __construct(
    private readonly OrganizationRepositoryInterface $organizationRepository
  ) {}

  public function execute(int $id): ?Organization
  {
    return $this->organizationRepository->findById($id);
  }
}
