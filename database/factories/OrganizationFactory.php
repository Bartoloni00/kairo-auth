<?php

namespace Database\Factories;

use App\Modules\Organizations\Domain\Entities\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company . ' ' . $this->faker->companySuffix,
        ];
    }
}
