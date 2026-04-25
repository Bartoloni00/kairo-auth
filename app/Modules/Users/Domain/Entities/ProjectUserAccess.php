<?php

namespace App\Modules\Users\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectUserAccess extends Model
{
    protected $table = 'project_user_access';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'project_id',
        'organization_id',
        'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
