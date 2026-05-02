<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Modules\Users\Domain\Entities\User;
use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Auth\Application\Ports\ProjectUserRepositoryInterface;

class RegisterUserUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository,
    private readonly ProjectUserRepositoryInterface $projectUserRepository
  ) {}

  public function execute(array $data): User
  {
    return \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
      $user = $this->userRepository->create([
        'email' => $data['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
      ]);

      if (isset($data['project_id'], $data['organization_id'], $data['role_id'])) {
        $this->projectUserRepository->create([
          'user_id' => $user->id,
          'project_id' => $data['project_id'],
          'role_id' => $data['role_id'],
          'organization_id' => $data['organization_id'],
        ]);
      }

      return $user;
    });
  }
}
