<?php

namespace Database\Factories;

use App\Modules\Users\Domain\Entities\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->jobTitle,
            'description' => $this->faker->sentence,
            'is_system' => false,
            'project_id' => null,
        ];
    }

    public function system(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_system' => true,
        ]);
    }
}
