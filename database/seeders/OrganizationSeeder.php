<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Organizations\Domain\Entities\Organization;

class OrganizationSeeder extends Seeder
{
  protected string $timeStamp;

  public function __construct()
  {
    $this->timeStamp = now();
  }

  public function run()
  {
    Organization::create([
      'name' => 'Prueba',
      'created_at' => $this->timeStamp,
      'updated_at' => $this->timeStamp,
    ]);
  }
}
