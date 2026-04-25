<?php

namespace App\Modules\Organizations\Application\UseCases;

use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ListOrganizationsUseCase
{
  public function __construct(
    private readonly OrganizationRepositoryInterface $organizationRepository
  ) {}

  public function execute(?\App\Modules\Users\Domain\Entities\User $authUser = null, array $filters = []): Collection
  {
    return $this->organizationRepository->all($authUser, $filters);
  }
}
