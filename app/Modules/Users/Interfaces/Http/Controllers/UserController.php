<?php

namespace App\Modules\Users\Interfaces\Http\Controllers;

use App\Modules\Users\Application\UseCases\{
  ListUsersUseCase,
  GetUserUseCase,
  DeleteUserUseCase,
  AddUserToProjectUseCase,
  AddUserToOrganizationUseCase,
  RemoveUserFromProjectUseCase,
  RemoveUserFromOrganizationUseCase,
  UpdateUserEmailUseCase,
  UpdateUserPasswordUseCase,
  UpdateUserProjectRoleUseCase,
  UpdateUserOrganizationRoleUseCase
};
use App\Modules\Users\Application\Requests\{
  AddUserToProjectRequest,
  AddUserToOrganizationRequest,
  UpdateUserEmailRequest,
  UpdateUserPasswordRequest,
  UpdateUserProjectRoleRequest,
  UpdateUserOrganizationRoleRequest
};
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use App\Shared\Helpers\Enums\{
  ApiStatusCodeEnum,
  ApiMessageEnum,
  ApiErrorCodeEnum
};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Modules\Auditlogs\Application\Services\AuditLogService;

class UserController
{
  use ApiResponse;

  public function __construct(
    private readonly ListUsersUseCase $listUsersUseCase,
    private readonly GetUserUseCase $getUserUseCase,
    private readonly DeleteUserUseCase $deleteUserUseCase,
    private readonly AddUserToProjectUseCase $addUserToProjectUseCase,
    private readonly AddUserToOrganizationUseCase $addUserToOrganizationUseCase,
    private readonly RemoveUserFromProjectUseCase $removeUserFromProjectUseCase,
    private readonly RemoveUserFromOrganizationUseCase $removeUserFromOrganizationUseCase,
    private readonly UpdateUserEmailUseCase $updateUserEmailUseCase,
    private readonly UpdateUserPasswordUseCase $updateUserPasswordUseCase,
    private readonly UpdateUserProjectRoleUseCase $updateUserProjectRoleUseCase,
    private readonly UpdateUserOrganizationRoleUseCase $updateUserOrganizationRoleUseCase,
    private readonly AuditLogService $auditLogService
  ) {}

  public function index(Request $request): JsonResponse
  {
    $users = $this->listUsersUseCase->execute($request->user(), $request->all());
    return $this->successResponse($users);
  }

  public function show(Request $request, int $id): JsonResponse
  {
    $user = $this->getUserUseCase->execute($id, $request->user());
    if (!$user) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse($user);
  }

  public function destroy(int $id): JsonResponse
  {
    try {
      $deleted = $this->deleteUserUseCase->execute($id);
      if (!$deleted) {
        throw new Exception(ApiMessageEnum::DELETE_FAILED);
      }

      $this->auditLogService->info('user_deleted', ['user_id' => $id]);

      return $this->successResponse(
        null,
        ApiMessageEnum::USER_DELETED_SUCCESSFULLY,
        ApiStatusCodeEnum::SUCCESS
      );
    } catch (Exception $e) {
      $this->auditLogService->error('user_deletion_failed', [
        'user_id' => $id,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }

  public function addToProject(AddUserToProjectRequest $request, int $id): JsonResponse
  {
    try {
      $success = $this->addUserToProjectUseCase->execute($id, $request->project_id, $request->role_id);
      if (!$success) {
        throw new Exception(ApiMessageEnum::USER_NOT_FOUND);
      }

      $this->auditLogService->info('user_added_to_project', [
        'target_user_id' => $id,
        'project_id' => $request->project_id,
        'role_id' => $request->role_id
      ]);

      return $this->successResponse(
        null,
        ApiMessageEnum::USER_ADDED_TO_PROJECT_SUCCESSFULLY,
        ApiStatusCodeEnum::CREATED
      );
    } catch (Exception $e) {
      $this->auditLogService->error('add_user_to_project_failed', [
        'target_user_id' => $id,
        'project_id' => $request->project_id,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }

  public function addToOrganization(AddUserToOrganizationRequest $request, int $id): JsonResponse
  {
    try {
      $success = $this->addUserToOrganizationUseCase->execute($id, $request->organization_id, $request->role_id);
      if (!$success) {
        throw new Exception(ApiMessageEnum::USER_NOT_FOUND);
      }

      $this->auditLogService->info('user_added_to_organization', [
        'target_user_id' => $id,
        'organization_id' => $request->organization_id,
        'role_id' => $request->role_id
      ]);

      return $this->successResponse(
        null,
        ApiMessageEnum::USER_ADDED_TO_ORGANIZATION_SUCCESSFULLY,
        ApiStatusCodeEnum::CREATED
      );
    } catch (Exception $e) {
      $this->auditLogService->error('add_user_to_organization_failed', [
        'target_user_id' => $id,
        'organization_id' => $request->organization_id,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }

  public function removeFromProject(int $id, int $projectId): JsonResponse
  {
    try {
      $success = $this->removeUserFromProjectUseCase->execute($id, $projectId);
      if (!$success) {
        throw new Exception(ApiMessageEnum::USER_NOT_FOUND);
      }

      $this->auditLogService->info('user_removed_from_project', [
        'target_user_id' => $id,
        'project_id' => $projectId
      ]);

      return $this->successResponse(
        null,
        ApiMessageEnum::USER_REMOVED_FROM_PROJECT_SUCCESSFULLY,
        ApiStatusCodeEnum::SUCCESS
      );
    } catch (Exception $e) {
      $this->auditLogService->error('remove_user_from_project_failed', [
        'target_user_id' => $id,
        'project_id' => $projectId,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }

  public function removeFromOrganization(int $id, int $organizationId): JsonResponse
  {
    try {
      $success = $this->removeUserFromOrganizationUseCase->execute($id, $organizationId);
      if (!$success) {
        throw new Exception(ApiMessageEnum::USER_NOT_FOUND);
      }

      $this->auditLogService->info('user_removed_from_organization', [
        'target_user_id' => $id,
        'organization_id' => $organizationId
      ]);

      return $this->successResponse(
        null,
        ApiMessageEnum::USER_REMOVED_FROM_ORGANIZATION_SUCCESSFULLY,
        ApiStatusCodeEnum::SUCCESS
      );
    } catch (Exception $e) {
      $this->auditLogService->error('remove_user_from_organization_failed', [
        'target_user_id' => $id,
        'organization_id' => $organizationId,
        'error' => $e->getMessage()
      ]);

      return $this->errorResponse(
        $e->getMessage(),
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
  }

  public function updateEmail(UpdateUserEmailRequest $request, int $id): JsonResponse
  {
    $success = $this->updateUserEmailUseCase->execute($id, $request->email);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_EMAIL_UPDATED_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS
    );
  }

  public function updatePassword(UpdateUserPasswordRequest $request, int $id): JsonResponse
  {
    $success = $this->updateUserPasswordUseCase->execute($id, $request->password);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_PASSWORD_UPDATED_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS
    );
  }

  public function updateProjectRole(UpdateUserProjectRoleRequest $request, int $user_id, int $project_id): JsonResponse
  {
    $success = $this->updateUserProjectRoleUseCase->execute($user_id, $project_id, $request->role_id);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_ROLE_UPDATED_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS
    );
  }

  public function updateOrganizationRole(UpdateUserOrganizationRoleRequest $request, int $user_id, int $organization_id): JsonResponse
  {
    $success = $this->updateUserOrganizationRoleUseCase->execute($user_id, $organization_id, $request->role_id);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_ROLE_UPDATED_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS
    );
  }
}
