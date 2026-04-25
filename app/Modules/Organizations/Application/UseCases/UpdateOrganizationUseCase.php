<?php

namespace App\Modules\Organizations\Application\UseCases;

use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;
use Illuminate\Support\Str;

class UpdateOrganizationUseCase
{
  public function __construct(
    private readonly OrganizationRepositoryInterface $organizationRepository
  ) {}

  public function execute(int $id, array $data): bool
  {
    if (isset($data['name']) && !isset($data['slug'])) {
      $data['slug'] = Str::slug($data['name']);
    }
    return $this->organizationRepository->update($id, $data);
  }
}
