<?php

namespace App\Modules\Users\Application\Ports;

use App\Modules\Users\Domain\Entities\User;

interface UserRepositoryInterface
{
  public function create(array $data): User;
  public function findByEmail(string $email): ?User;
  public function findById(int $id): ?User;
  public function all(): \Illuminate\Database\Eloquent\Collection;
  public function update(int $id, array $data): bool;
  public function delete(int $id): bool;
}
