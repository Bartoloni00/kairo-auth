<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ListUsersUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(): Collection
  {
    return $this->userRepository->all();
  }
}
