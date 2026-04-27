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
  UpdateUserPasswordUseCase
};
use App\Modules\Users\Application\Requests\{
  AddUserToProjectRequest,
  AddUserToOrganizationRequest,
  UpdateUserEmailRequest,
  UpdateUserPasswordRequest
};
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use App\Shared\Helpers\Enums\{
  ApiStatusCodeEnum,
  ApiMessageEnum,
  ApiErrorCodeEnum
};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
    private readonly UpdateUserPasswordUseCase $updateUserPasswordUseCase
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
    $deleted = $this->deleteUserUseCase->execute($id);
    if (!$deleted) {
      return $this->errorResponse(
        ApiMessageEnum::DELETE_FAILED,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }

    return $this->successResponse(
      null,
      ApiMessageEnum::USER_DELETED_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS // Changed from NO_CONTENT to SUCCESS to allow body if needed, or keep 204
    );
  }

  public function addToProject(AddUserToProjectRequest $request, int $id): JsonResponse
  {
    $success = $this->addUserToProjectUseCase->execute($id, $request->project_id, $request->role_id);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_ADDED_TO_PROJECT_SUCCESSFULLY,
      ApiStatusCodeEnum::CREATED
    );
  }

  public function addToOrganization(AddUserToOrganizationRequest $request, int $id): JsonResponse
  {
    $success = $this->addUserToOrganizationUseCase->execute($id, $request->organization_id, $request->role_id);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_ADDED_TO_ORGANIZATION_SUCCESSFULLY,
      ApiStatusCodeEnum::CREATED
    );
  }

  public function removeFromProject(int $id, int $projectId): JsonResponse
  {
    $success = $this->removeUserFromProjectUseCase->execute($id, $projectId);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_REMOVED_FROM_PROJECT_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS
    );
  }

  public function removeFromOrganization(int $id, int $organizationId): JsonResponse
  {
    $success = $this->removeUserFromOrganizationUseCase->execute($id, $organizationId);
    if (!$success) {
      return $this->errorResponse(
        ApiMessageEnum::USER_NOT_FOUND,
        ApiErrorCodeEnum::NOT_FOUND->value,
        ApiStatusCodeEnum::NOT_FOUND
      );
    }
    return $this->successResponse(
      null,
      ApiMessageEnum::USER_REMOVED_FROM_ORGANIZATION_SUCCESSFULLY,
      ApiStatusCodeEnum::SUCCESS
    );
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
}
