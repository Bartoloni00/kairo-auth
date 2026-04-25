<?php

namespace App\Modules\Projects\Application\Ports;

use App\Modules\Projects\Domain\Entities\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
  public function create(array $data): Project;
  public function findById(int $id): ?Project;
  public function all(?\App\Modules\Users\Domain\Entities\User $authUser = null, array $filters = []): Collection;
  public function update(int $id, array $data): bool;
  public function delete(int $id): bool;
}
