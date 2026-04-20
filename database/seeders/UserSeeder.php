<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
  protected string $timeStamp;

  public function __construct()
  {
    $this->timeStamp = now();
  }

  public function run()
  {
    DB::table('users')->updateOrInsert(
      [
        'email' => 'abraham-bartoloni@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('asdASD123'),
        'is_root' => true,
        'created_at' => $this->timeStamp,
        'updated_at' => $this->timeStamp,
      ]
    );

    DB::table('users')->updateOrInsert(
      [
        'email' => 'ezequiel-arevalo@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('asdasd'),
        'is_root' => true,
        'created_at' => $this->timeStamp,
        'updated_at' => $this->timeStamp,
      ]
    );
  }
}
