<?php

namespace App\Modules\Organizations\Application\Ports;

use App\Modules\Organizations\Domain\Entities\Organization;
use Illuminate\Database\Eloquent\Collection;

interface OrganizationRepositoryInterface
{
  public function create(array $data): Organization;
  public function findById(int $id): ?Organization;
  public function all(): Collection;
  public function update(int $id, array $data): bool;
  public function delete(int $id): bool;
}
