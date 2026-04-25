<?php

namespace App\Modules\Projects\Application\UseCases;

use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;
use App\Modules\Projects\Domain\Entities\Project;
use Illuminate\Support\Str;

class CreateProjectUseCase
{
  public function __construct(
    private readonly ProjectRepositoryInterface $projectRepository
  ) {}

  public function execute(array $data): Project
  {
    if (!isset($data['slug'])) {
      $data['slug'] = Str::slug($data['name']);
    }
    return $this->projectRepository->create($data);
  }
}
