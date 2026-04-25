<?php

namespace Database\Factories;

use App\Modules\Users\Domain\Entities\User;
use App\Modules\Users\Domain\Entities\ProjectUserAccess;
use App\Modules\Projects\Domain\Entities\Project;
use App\Modules\Organizations\Domain\Entities\Organization;
use App\Modules\Users\Domain\Entities\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'is_root' => false,
        ];
    }

    public function root(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_root' => true,
        ]);
    }

    /**
     * Define access for the user.
     * $config = [
     *   ['project' => $p1, 'organizations' => [$o1, $o2], 'role' => $r1],
     *   ['project' => $p2, 'organizations' => [$o3], 'role' => $r2]
     * ]
     */
    public function withAccess(array $config = []): static
    {
        return $this->afterCreating(function (User $user) use ($config) {
            if (empty($config)) {
                // Create new random access: 1 project, 1-2 organizations
                $project = Project::factory()->create();
                $organizations = Organization::factory()->count(rand(1, 2))->create();
                $role = Role::inRandomOrder()->first() ?? Role::factory()->create();

                foreach ($organizations as $org) {
                    ProjectUserAccess::create([
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                        'organization_id' => $org->id,
                        'role_id' => $role->id,
                    ]);
                }
                return;
            }

            foreach ($config as $item) {
                $project = $item['project'] ?? Project::factory()->create();
                $organizations = $item['organizations'] ?? [Organization::factory()->create()];
                $role = $item['role'] ?? Role::factory()->create();

                foreach ($organizations as $org) {
                    ProjectUserAccess::create([
                        'user_id' => $user->id,
                        'project_id' => $project->id instanceof Project ? $project->id : $project,
                        'organization_id' => $org instanceof Organization ? $org->id : $org,
                        'role_id' => $role instanceof Role ? $role->id : $role,
                    ]);
                }
            }
        });
    }
}
