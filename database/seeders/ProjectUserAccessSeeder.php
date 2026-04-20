<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUserAccessSeeder extends Seeder
{
  protected string $timeStamp;

  public function __construct()
  {
    $this->timeStamp = now();
  }

  public function run()
  {
    DB::table('project_user_access')->updateOrInsert(
      [
        'user_id' => 1,
        'project_id' => null,
        'organization_id' => null,
        'role_id' => 1,
      ]
    );

    DB::table('project_user_access')->updateOrInsert(
      [
        'user_id' => 2,
        'project_id' => null,
        'organization_id' => null,
        'role_id' => 1,
      ]
    );
  }
}
