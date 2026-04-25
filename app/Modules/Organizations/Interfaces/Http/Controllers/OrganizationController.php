<?php

namespace App\Modules\Organizations\Interfaces\Http\Controllers;

use App\Modules\Organizations\Application\UseCases\{
  ListOrganizationsUseCase,
  GetOrganizationUseCase,
  CreateOrganizationUseCase,
  UpdateOrganizationUseCase,
  DeleteOrganizationUseCase
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController
{
  public function __construct(
    private readonly ListOrganizationsUseCase $listOrganizationsUseCase,
    private readonly GetOrganizationUseCase $getOrganizationUseCase,
    private readonly CreateOrganizationUseCase $createOrganizationUseCase,
    private readonly UpdateOrganizationUseCase $updateOrganizationUseCase,
    private readonly DeleteOrganizationUseCase $deleteOrganizationUseCase
  ) {}

  public function index(): JsonResponse
  {
    $organizations = $this->listOrganizationsUseCase->execute();
    return response()->json($organizations);
  }

  public function show(int $id): JsonResponse
  {
    $organization = $this->getOrganizationUseCase->execute($id);
    if (!$organization) {
      return response()->json(['message' => 'Organization not found'], 404);
    }
    return response()->json($organization);
  }

  public function store(Request $request): JsonResponse
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'is_system' => 'boolean',
    ]);

    $organization = $this->createOrganizationUseCase->execute($data);

    return response()->json($organization, 201);
  }

  public function update(Request $request, int $id): JsonResponse
  {
    $data = $request->validate([
      'name' => 'sometimes|string|max:255',
      'description' => 'nullable|string',
      'is_system' => 'boolean',
    ]);

    $updated = $this->updateOrganizationUseCase->execute($id, $data);
    if (!$updated) {
      return response()->json(['message' => 'Organization not found or update failed'], 404);
    }

    return response()->json(['message' => 'Organization updated successfully']);
  }

  public function destroy(int $id): JsonResponse
  {
    $deleted = $this->deleteOrganizationUseCase->execute($id);
    if (!$deleted) {
      return response()->json(['message' => 'Organization not found or delete failed'], 404);
    }

    return response()->json(['message' => 'Organization deleted successfully']);
  }
}
