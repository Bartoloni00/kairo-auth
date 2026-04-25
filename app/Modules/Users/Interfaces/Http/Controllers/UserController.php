<?php

namespace App\Modules\Users\Interfaces\Http\Controllers;

use App\Modules\Users\Application\UseCases\{
  ListUsersUseCase,
  GetUserUseCase,
  UpdateUserUseCase,
  DeleteUserUseCase
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

  public function update(Request $request, int $id): JsonResponse
  {
    // Basic validation for now, or create a specific Request class
    $data = $request->validate([
      'email' => 'sometimes|email|unique:users,email,' . $id,
      'password' => 'sometimes|min:6',
    ]);

    $updated = $this->updateUserUseCase->execute($id, $data);
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
