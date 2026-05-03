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
use Illuminate\Http\{
  JsonResponse,
  Request
};
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use App\Shared\Helpers\Enums\{
  ApiStatusCodeEnum,
  ApiMessageEnum,
  ApiErrorCodeEnum
};
use Exception;
use App\Modules\Auditlogs\Application\Services\AuditLogService;

class ProjectController
{
  use ApiResponse;

  public function __construct(
    private readonly ListProjectsUseCase $listProjectsUseCase,
    private readonly GetProjectUseCase $getProjectUseCase,
    private readonly CreateProjectUseCase $createProjectUseCase,
    private readonly UpdateProjectUseCase $updateProjectUseCase,
    private readonly DeleteProjectUseCase $deleteProjectUseCase,
    private readonly AuditLogService $auditLogService
  ) {}

  public function index(Request $request): JsonResponse
  {
    $projects = $this->listProjectsUseCase->execute($request->user(), $request->all());
    return $this->successResponse($projects);
  }

  public function show(int $id): JsonResponse
  {
    $project = $this->getProjectUseCase->execute($id);
    if (!$project) {
      return $this->errorResponse(
        ApiMessageEnum::PROJECT_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse($project);
  }

  public function store(CreateProjectRequest $request): JsonResponse
  {
    try {
      $project = $this->createProjectUseCase->execute($request->validated());
      $this->auditLogService->info('project_created', [
        'project_id' => $project->id,
        'name' => $project->name
      ]);
      return $this->successResponse($project, null, ApiStatusCodeEnum::CREATED);
    } catch (Exception $e) {
      $this->auditLogService->error('project_creation_failed', [
        'data' => $request->validated(),
        'error' => $e->getMessage()
      ]);
      throw $e;
    }
  }

  public function update(UpdateProjectRequest $request, int $id): JsonResponse
  {
    try {
      $updated = $this->updateProjectUseCase->execute($id, $request->validated());
      if (!$updated) {
        throw new Exception(ApiMessageEnum::UPDATE_FAILED);
      }

      $this->auditLogService->info('project_updated', [
        'project_id' => $id,
        'updates' => $request->validated()
      ]);

      return $this->successResponse(null, 'Proyecto actualizado exitosamente');
    } catch (Exception $e) {
      $this->auditLogService->error('project_update_failed', [
        'project_id' => $id,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }

  public function destroy(int $id): JsonResponse
  {
    try {
      $deleted = $this->deleteProjectUseCase->execute($id);
      if (!$deleted) {
        throw new Exception(ApiMessageEnum::DELETE_FAILED);
      }

      $this->auditLogService->info('project_deleted', ['project_id' => $id]);

      return $this->successResponse(null, 'Proyecto eliminado exitosamente');
    } catch (Exception $e) {
      $this->auditLogService->error('project_deletion_failed', [
        'project_id' => $id,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }
}
