<?php

namespace App\Modules\Users\Infraestructure\Adapters;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Users\Domain\Entities\User;

class UserRepository implements UserRepositoryInterface
{
  public function create(array $data): User
  {
    return User::create($data);
  }
  public function findByEmail(string $email): ?User
  {
    return User::where('email', $email)->first();
  }

  /*
  public function findById(int $id): ?User
  {
    return User::find($id);
  }
*/
}
