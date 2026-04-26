<?php

namespace App\Modules\Users\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectUserAccess extends Model
{
    use HasFactory;

    protected $table = 'project_user_access';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'project_id',
        'organization_id',
        'role_id'
    ];

    protected static function newFactory()
    {
        return \Database\Factories\ProjectUserAccessFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(\App\Modules\Projects\Domain\Entities\Project::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Modules\Organizations\Domain\Entities\Organization::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function toArray()
    {
        $project = $this->project ? $this->project->toArray() : null;
        $organization = $this->organization ? $this->organization->toArray() : null;
        $role = $this->role ? $this->role->toArray() : null;

        if ($project && $organization) {
            $organization['role'] = $role;
            $project['organization'] = $organization;
        }

        return [
            'project_id' => $this->project_id,
            'project' => $project
        ];
    }
}
