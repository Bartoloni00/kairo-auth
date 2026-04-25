<?php

namespace App\Modules\Organizations\Interfaces\Http\Controllers;

use App\Modules\Organizations\Application\UseCases\{
  ListOrganizationsUseCase,
  GetOrganizationUseCase,
  CreateOrganizationUseCase,
  UpdateOrganizationUseCase,
  DeleteOrganizationUseCase
};
use App\Modules\Organizations\Application\Requests\{
  CreateOrganizationRequest,
  UpdateOrganizationRequest
};
use Illuminate\Http\JsonResponse;

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

  public function store(CreateOrganizationRequest $request): JsonResponse
  {
    $organization = $this->createOrganizationUseCase->execute($request->validated());
    return response()->json($organization, 201);
  }

  public function update(UpdateOrganizationRequest $request, int $id): JsonResponse
  {
    $updated = $this->updateOrganizationUseCase->execute($id, $request->validated());
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
