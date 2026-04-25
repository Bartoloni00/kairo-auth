<?php

namespace App\Modules\Projects\Interfaces\Http\Controllers;

use App\Modules\Projects\Application\UseCases\{
  ListProjectsUseCase,
  GetProjectUseCase,
  CreateProjectUseCase,
  UpdateProjectUseCase,
  DeleteProjectUseCase
};
use App\Modules\Projects\Application\Requests\{
  CreateProjectRequest,
  UpdateProjectRequest
};
use Illuminate\Http\JsonResponse;

class ProjectController
{
  public function __construct(
    private readonly ListProjectsUseCase $listProjectsUseCase,
    private readonly GetProjectUseCase $getProjectUseCase,
    private readonly CreateProjectUseCase $createProjectUseCase,
    private readonly UpdateProjectUseCase $updateProjectUseCase,
    private readonly DeleteProjectUseCase $deleteProjectUseCase
  ) {}

  public function index(): JsonResponse
  {
    $projects = $this->listProjectsUseCase->execute();
    return response()->json($projects);
  }

  public function show(int $id): JsonResponse
  {
    $project = $this->getProjectUseCase->execute($id);
    if (!$project) {
      return response()->json(['message' => 'Project not found'], 404);
    }
    return response()->json($project);
  }

  public function store(CreateProjectRequest $request): JsonResponse
  {
    $project = $this->createProjectUseCase->execute($request->validated());
    return response()->json($project, 201);
  }

  public function update(UpdateProjectRequest $request, int $id): JsonResponse
  {
    $updated = $this->updateProjectUseCase->execute($id, $request->validated());
    if (!$updated) {
      return response()->json(['message' => 'Project not found or update failed'], 404);
    }

    return response()->json(['message' => 'Project updated successfully']);
  }

  public function destroy(int $id): JsonResponse
  {
    $deleted = $this->deleteProjectUseCase->execute($id);
    if (!$deleted) {
      return response()->json(['message' => 'Project not found or delete failed'], 404);
    }

    return response()->json(['message' => 'Project deleted successfully']);
  }
}
