<?php

namespace App\Modules\Projects\Application\UseCases;

use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ListProjectsUseCase
{
  public function __construct(
    private readonly ProjectRepositoryInterface $projectRepository
  ) {}

  public function execute(?\App\Modules\Users\Domain\Entities\User $authUser = null, array $filters = []): Collection
  {
    return $this->projectRepository->all($authUser, $filters);
  }
}
