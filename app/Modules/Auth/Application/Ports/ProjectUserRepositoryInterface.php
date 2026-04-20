<?php

namespace App\Modules\Auth\Application\Ports;

use App\Modules\Auth\Domain\Entities\ProjectUserAccess;

interface ProjectUserRepositoryInterface
{
  public function create(array $data): ProjectUserAccess;
}
