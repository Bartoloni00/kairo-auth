<?php

namespace Database\Factories;

use App\Modules\Projects\Domain\Entities\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_multitenant' => $this->faker->boolean(20),
        ];
    }
}
