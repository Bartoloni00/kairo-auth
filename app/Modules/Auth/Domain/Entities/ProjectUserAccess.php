<?php

namespace App\Modules\Auth\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Modules\Users\Domain\Entities\User;
use App\Modules\Projects\Domain\Entities\Project;
use App\Modules\Organizations\Domain\Entities\Organization;
use App\Modules\Users\Domain\Entities\Role;

class ProjectUserAccess extends Model
{
  use HasFactory;

  protected $table = 'project_user_access';

  protected $fillable = [
    'user_id',
    'project_id',
    'organization_id',
    'role_id',
  ];

  protected $casts = [
    'user_id' => 'integer',
    'project_id' => 'integer',
    'organization_id' => 'integer',
    'role_id' => 'integer',
  ];

  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function project()
  {
    return $this->belongsTo(Project::class);
  }

  public function organization()
  {
    return $this->belongsTo(Organization::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  /*
    |--------------------------------------------------------------------------
    | Domain Logic
    |--------------------------------------------------------------------------
    */

  public function isMultiTenant(): bool
  {
    return $this->organization_id !== null;
  }

  public function belongsToOrganization(int $organizationId): bool
  {
    return $this->organization_id === $organizationId;
  }

  public function isInProject(int $projectId): bool
  {
    return $this->project_id === $projectId;
  }
}
