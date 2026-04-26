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
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController
{
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
    return response()->json($users);
  }

  public function show(Request $request, int $id): JsonResponse
  {
    $user = $this->getUserUseCase->execute($id, $request->user());
    if (!$user) {
      return response()->json(['message' => 'User not found'], 404);
    }
    return response()->json($user);
  }

  public function destroy(int $id): JsonResponse
  {
    $deleted = $this->deleteUserUseCase->execute($id);
    if (!$deleted) {
      return response()->json(['message' => 'User not found or delete failed'], 404);
    }

    return response()->json(['message' => 'User deleted successfully']);
  }

  public function addToProject(AddUserToProjectRequest $request, int $id): JsonResponse
  {
    $success = $this->addUserToProjectUseCase->execute($id, $request->project_id, $request->role_id);
    if (!$success) {
      return response()->json(['message' => 'User not found or operation failed'], 404);
    }
    return response()->json(['message' => 'User added to project successfully']);
  }

  public function addToOrganization(AddUserToOrganizationRequest $request, int $id): JsonResponse
  {
    $success = $this->addUserToOrganizationUseCase->execute($id, $request->organization_id, $request->role_id);
    if (!$success) {
      return response()->json(['message' => 'User not found or operation failed'], 404);
    }
    return response()->json(['message' => 'User added to organization successfully']);
  }

  public function removeFromProject(int $id, int $projectId): JsonResponse
  {
    $success = $this->removeUserFromProjectUseCase->execute($id, $projectId);
    if (!$success) {
      return response()->json(['message' => 'User not found or not in project'], 404);
    }
    return response()->json(['message' => 'User removed from project successfully']);
  }

  public function removeFromOrganization(int $id, int $organizationId): JsonResponse
  {
    $success = $this->removeUserFromOrganizationUseCase->execute($id, $organizationId);
    if (!$success) {
      return response()->json(['message' => 'User not found or not in organization'], 404);
    }
    return response()->json(['message' => 'User removed from organization successfully']);
  }

  public function updateEmail(UpdateUserEmailRequest $request, int $id): JsonResponse
  {
    $success = $this->updateUserEmailUseCase->execute($id, $request->email);
    if (!$success) {
      return response()->json(['message' => 'User not found or update failed'], 404);
    }
    return response()->json(['message' => 'User email updated successfully']);
  }

  public function updatePassword(UpdateUserPasswordRequest $request, int $id): JsonResponse
  {
    $success = $this->updateUserPasswordUseCase->execute($id, $request->password);
    if (!$success) {
      return response()->json(['message' => 'User not found or update failed'], 404);
    }
    return response()->json(['message' => 'User password updated successfully']);
  }
}
