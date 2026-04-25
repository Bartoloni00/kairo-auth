<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Users\Domain\Entities\Role;

class RoleSeeder extends Seeder
{
  public function run()
  {
    Role::create([
      'project_id' => null, // Global system role
      'name' => 'Root',
      'description' => 'Super admin',
      'is_system' => true,
    ]);

    Role::create([
      'project_id' => null,
      'name' => 'Admin',
      'description' => 'Cliente administrador',
      'is_system' => true,
    ]);
  }
}
