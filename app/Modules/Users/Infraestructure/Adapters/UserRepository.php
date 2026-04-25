<?php

namespace App\Modules\Users\Infraestructure\Adapters;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Users\Domain\Entities\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
  public function create(array $data): User
  {
    return User::create($data);
  }
  public function findByEmail(string $email): ?User
  {
    return User::where('email', $email)->first();
  }

  public function findById(int $id): ?User
  {
    return User::find($id);
  }

  public function all(?User $authUser = null, array $filters = []): Collection
  {
    $query = User::query();
    $showDeleted = ($authUser && $authUser->is_root && ($filters['deleted'] ?? '') === 'true');

    if ($showDeleted) {
      $query->withTrashed();
    }

    // If not root, filter by user's own projects and organizations
    if ($authUser && !$authUser->is_root) {
      $myAccess = $authUser->access;
      $myProjects = $myAccess->pluck('project_id')->filter()->unique();
      $myOrgs = $myAccess->pluck('organization_id')->filter()->unique();

      $query->whereHas('access', function ($q) use ($myProjects, $myOrgs) {
        $q->whereIn('project_id', $myProjects)
          ->orWhereIn('organization_id', $myOrgs);
      });
    }

    // Apply explicit filters if provided
    if (!empty($filters['organization_id'])) {
      $query->whereHas('access', function ($q) use ($filters) {
        $q->where('organization_id', $filters['organization_id']);
      });
    }

    if (!empty($filters['project_id'])) {
      $query->whereHas('access', function ($q) use ($filters) {
        $q->where('project_id', $filters['project_id']);
      });
    }

    $users = $query->get();

    if ($showDeleted) {
      $users->each->makeVisible('deleted_at');
    }

    return $users;
  }

  public function update(int $id, array $data): bool
  {
    $user = User::find($id);
    if (!$user) return false;
    return $user->update($data);
  }

  public function delete(int $id): bool
  {
    $user = User::find($id);
    if (!$user) return false;
    return $user->delete();
  }
}
