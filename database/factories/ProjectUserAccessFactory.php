<?php

namespace Database\Factories;

use App\Modules\Users\Domain\Entities\ProjectUserAccess;
use App\Modules\Users\Domain\Entities\User;
use App\Modules\Projects\Domain\Entities\Project;
use App\Modules\Organizations\Domain\Entities\Organization;
use App\Modules\Users\Domain\Entities\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectUserAccessFactory extends Factory
{
    protected $model = ProjectUserAccess::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'organization_id' => Organization::factory(),
            'role_id' => Role::factory(),
        ];
    }
}
