<?php

namespace App\Modules\Users\Interfaces\Http\Controllers;

use App\Modules\Users\Application\UseCases\{
  ListUsersUseCase,
  GetUserUseCase,
  UpdateUserUseCase,
  DeleteUserUseCase
};
use App\Modules\Users\Application\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController
{
  public function __construct(
    private readonly ListUsersUseCase $listUsersUseCase,
    private readonly GetUserUseCase $getUserUseCase,
    private readonly UpdateUserUseCase $updateUserUseCase,
    private readonly DeleteUserUseCase $deleteUserUseCase
  ) {}

  public function index(): JsonResponse
  {
    $users = $this->listUsersUseCase->execute();
    return response()->json($users);
  }

  public function show(int $id): JsonResponse
  {
    $user = $this->getUserUseCase->execute($id);
    if (!$user) {
      return response()->json(['message' => 'User not found'], 404);
    }
    return response()->json($user);
  }

  public function update(UpdateUserRequest $request, int $id): JsonResponse
  {
    $updated = $this->updateUserUseCase->execute($id, $request->validated());
    if (!$updated) {
      return response()->json(['message' => 'User not found or update failed'], 404);
    }

    return response()->json(['message' => 'User updated successfully']);
  }

  public function destroy(int $id): JsonResponse
  {
    $deleted = $this->deleteUserUseCase->execute($id);
    if (!$deleted) {
      return response()->json(['message' => 'User not found or delete failed'], 404);
    }

    return response()->json(['message' => 'User deleted successfully']);
  }
}
