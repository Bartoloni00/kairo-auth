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
    return User::with(['access.project', 'access.organization', 'access.role'])->find($id);
  }

  public function all(?User $authUser = null, array $filters = []): Collection
  {
    $query = User::with(['access.project', 'access.organization', 'access.role']);
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
    if (!$user) {
      return false;
    }

    return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $data) {
      // Update user basic info
      $user->update(\Illuminate\Support\Arr::except($data, ['access']));

      // Sync access if provided
      if (isset($data['access'])) {
        $user->access()->delete();
        foreach ($data['access'] as $accessData) {
          $user->access()->create($accessData);
        }
      }

      return true;
    });
  }

  public function delete(int $id): bool
  {
    $user = User::find($id);
    if (!$user) return false;
    return $user->delete();
  }

  public function addToProject(int $userId, int $projectId, ?int $roleId = null): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    // Use a default role if none provided (e.g. role_id 2 for member)
    $roleId = $roleId ?? 2;

    $user->access()->create([
      'project_id' => $projectId,
      'role_id' => $roleId
    ]);

    return true;
  }

  public function addToOrganization(int $userId, int $organizationId, ?int $roleId = null): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    $roleId = $roleId ?? 2;

    $user->access()->create([
      'organization_id' => $organizationId,
      'role_id' => $roleId
    ]);

    return true;
  }

  public function removeFromProject(int $userId, int $projectId): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    return $user->access()->where('project_id', $projectId)->delete() > 0;
  }

  public function removeFromOrganization(int $userId, int $organizationId): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    return $user->access()->where('organization_id', $organizationId)->delete() > 0;
  }

  public function updateProjectRole(int $userId, int $projectId, int $roleId): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    return $user->access()->where('project_id', $projectId)->update(['role_id' => $roleId]) > 0;
  }

  public function updateOrganizationRole(int $userId, int $organizationId, int $roleId): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    return $user->access()->where('organization_id', $organizationId)->update(['role_id' => $roleId]) > 0;
  }

  public function updateEmail(int $userId, string $email): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    return $user->update(['email' => $email]);
  }

  public function updatePassword(int $userId, string $password): bool
  {
    $user = User::find($userId);
    if (!$user) return false;

    return $user->update(['password' => \Illuminate\Support\Facades\Hash::make($password)]);
  }
}
