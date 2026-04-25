<?php

namespace App\Modules\Organizations\Application\UseCases;

use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;
use App\Modules\Organizations\Domain\Entities\Organization;
use Illuminate\Support\Str;

class CreateOrganizationUseCase
{
  public function __construct(
    private readonly OrganizationRepositoryInterface $organizationRepository
  ) {}

  public function execute(array $data): Organization
  {
    if (!isset($data['slug'])) {
      $data['slug'] = Str::slug($data['name']);
    }
    return $this->organizationRepository->create($data);
  }
}
