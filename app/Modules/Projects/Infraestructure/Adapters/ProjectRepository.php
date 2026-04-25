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

  public function all(): Collection
  {
    return Project::all();
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
