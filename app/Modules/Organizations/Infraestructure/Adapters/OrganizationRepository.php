<?php

namespace App\Modules\Organizations\Infraestructure\Adapters;

use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;
use App\Modules\Organizations\Domain\Entities\Organization;
use Illuminate\Database\Eloquent\Collection;

class OrganizationRepository implements OrganizationRepositoryInterface
{
  public function create(array $data): Organization
  {
    return Organization::create($data);
  }

  public function findById(int $id): ?Organization
  {
    return Organization::find($id);
  }

  public function all(): Collection
  {
    return Organization::all();
  }

  public function update(int $id, array $data): bool
  {
    $organization = Organization::find($id);
    if (!$organization) return false;
    return $organization->update($data);
  }

  public function delete(int $id): bool
  {
    $organization = Organization::find($id);
    if (!$organization) return false;
    return $organization->delete();
  }
}
