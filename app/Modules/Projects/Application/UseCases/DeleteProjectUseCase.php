<?php

namespace App\Modules\Projects\Application\UseCases;

use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;

class DeleteProjectUseCase
{
  public function __construct(
    private readonly ProjectRepositoryInterface $projectRepository
  ) {}

  public function execute(int $id): bool
  {
    return $this->projectRepository->delete($id);
  }
}
