<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Users\Domain\Entities\User;

class GetUserUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $id): ?User
  {
    return $this->userRepository->findById($id);
  }
}
