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
}
