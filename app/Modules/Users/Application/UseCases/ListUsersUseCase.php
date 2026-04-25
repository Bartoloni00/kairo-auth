<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Users\Domain\Entities\User;
use Illuminate\Database\Eloquent\Collection;

class ListUsersUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(?User $authUser = null, array $filters = []): Collection
  {
    return $this->userRepository->all($authUser, $filters);
  }
}
