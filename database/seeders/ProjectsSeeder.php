<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Projects\Domain\Entities\Project;

class ProjectsSeeder extends Seeder
{
  protected string $timeStamp;

  public function __construct()
  {
    $this->timeStamp = now();
  }

  public function run()
  {
    Project::create([
      'name' => 'HandyStock',
      'slug' => 'handystock',
      'is_multitenant' => true,
      'created_at' => $this->timeStamp,
      'updated_at' => $this->timeStamp,
    ]);
  }
}
