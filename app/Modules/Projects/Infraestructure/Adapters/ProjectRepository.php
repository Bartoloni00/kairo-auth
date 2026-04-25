<?php

namespace App\Modules\Projects\Infraestructure\Adapters;

use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;
use App\Modules\Projects\Domain\Entities\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
  public function create(array $data): Project
  {
    return Project::create($data);
  }

  public function findById(int $id): ?Project
  {
    return Project::find($id);
  }

  public function all(?\App\Modules\Users\Domain\Entities\User $authUser = null, array $filters = []): Collection
  {
    $query = Project::query();
    $showDeleted = ($authUser && $authUser->is_root && ($filters['deleted'] ?? '') === 'true');

    if ($showDeleted) {
      $query->withTrashed();
    }

    $projects = $query->get();

    if ($showDeleted) {
      $projects->each->makeVisible('deleted_at');
    }

    return $projects;
  }

  public function update(int $id, array $data): bool
  {
    $project = Project::find($id);
    if (!$project) return false;
    return $project->update($data);
  }

  public function delete(int $id): bool
  {
    $project = Project::find($id);
    if (!$project) return false;
    return $project->delete();
  }
}
