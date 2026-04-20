<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ProjectsSeeder::class,
            RoleSeeder::class,
            OrganizationSeeder::class,
            UserSeeder::class,
            ProjectUserAccessSeeder::class,
        ]);
    }
}
