<?php

namespace App\Modules\Auth\Infraestructure\Adapters;

use App\Modules\Auth\Application\Ports\ProjectUserRepositoryInterface;
use App\Modules\Auth\Domain\Entities\ProjectUserAccess;

class ProjectUserRepository implements ProjectUserRepositoryInterface
{
  public function create(array $data): ProjectUserAccess
  {
    return ProjectUserAccess::create($data);
  }
}
