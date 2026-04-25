<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;

class UpdateUserUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $id, array $data): bool
  {
    if (isset($data['password'])) {
      $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
    }
    return $this->userRepository->update($id, $data);
  }
}
