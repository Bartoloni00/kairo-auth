<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
  protected string $timeStamp;

  public function __construct()
  {
    $this->timeStamp = now();
  }

  public function run()
  {
    DB::table('plans')->updateOrInsert(
      [
        'name' => 'free',
        'type' => 'nulo',
        'symbol' => '$',
        'currency' => 'ARS',
        'price' => 100000,
        'created_at' => $this->timeStamp,
        'updated_at' => $this->timeStamp,
      ]
    );
  }
}
