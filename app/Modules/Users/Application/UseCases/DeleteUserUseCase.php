<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class DeleteUserUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $id): bool
  {
    return $this->userRepository->delete($id);
  }
}
