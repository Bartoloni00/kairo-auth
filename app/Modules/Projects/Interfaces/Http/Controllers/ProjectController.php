<?php

namespace App\Modules\Projects\Interfaces\Http\Controllers;

use App\Modules\Projects\Application\UseCases\{
  ListProjectsUseCase,
  GetProjectUseCase,
  CreateProjectUseCase,
  UpdateProjectUseCase,
  DeleteProjectUseCase
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

  public function store(Request $request): JsonResponse
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'is_system' => 'boolean',
      'organization_id' => 'required|exists:organizations,id',
    ]);

    $project = $this->createProjectUseCase->execute($data);

    return response()->json($project, 201);
  }

  public function update(Request $request, int $id): JsonResponse
  {
    $data = $request->validate([
      'name' => 'sometimes|string|max:255',
      'description' => 'nullable|string',
      'is_system' => 'boolean',
      'organization_id' => 'sometimes|exists:organizations,id',
    ]);

    $updated = $this->updateProjectUseCase->execute($id, $data);
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
