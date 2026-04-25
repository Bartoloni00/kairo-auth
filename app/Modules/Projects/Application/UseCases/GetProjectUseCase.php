<?php

namespace App\Modules\Projects\Application\UseCases;

use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;
use App\Modules\Projects\Domain\Entities\Project;

class GetProjectUseCase
{
  public function __construct(
    private readonly ProjectRepositoryInterface $projectRepository
  ) {}

  public function execute(int $id): ?Project
  {
    return $this->projectRepository->findById($id);
  }
}
