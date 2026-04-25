<?php

namespace App\Modules\Projects\Application\UseCases;

use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;
use Illuminate\Support\Str;

class UpdateProjectUseCase
{
  public function __construct(
    private readonly ProjectRepositoryInterface $projectRepository
  ) {}

  public function execute(int $id, array $data): bool
  {
    if (isset($data['name']) && !isset($data['slug'])) {
      $data['slug'] = Str::slug($data['name']);
    }
    return $this->projectRepository->update($id, $data);
  }
}
