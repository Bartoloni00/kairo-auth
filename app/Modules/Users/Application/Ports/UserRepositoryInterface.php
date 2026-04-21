<?php

namespace App\Modules\Users\Application\Ports;

use App\Modules\Users\Domain\Entities\User;

interface UserRepositoryInterface
{
  public function create(array $data): User;
  public function findByEmail(string $email): ?User;
}
