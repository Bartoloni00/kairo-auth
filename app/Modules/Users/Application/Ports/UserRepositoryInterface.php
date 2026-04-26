<?php

namespace App\Modules\Users\Application\Ports;

use App\Modules\Users\Domain\Entities\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
  public function create(array $data): User;
  public function findByEmail(string $email): ?User;
  public function findById(int $id): ?User;
  public function all(?User $authUser = null, array $filters = []): Collection;
  public function delete(int $id): bool;
  public function addToProject(int $userId, int $projectId, ?int $roleId = null): bool;
  public function addToOrganization(int $userId, int $organizationId, ?int $roleId = null): bool;
  public function removeFromProject(int $userId, int $projectId): bool;
  public function removeFromOrganization(int $userId, int $organizationId): bool;
  public function updateEmail(int $userId, string $email): bool;
  public function updatePassword(int $userId, string $password): bool;
}
