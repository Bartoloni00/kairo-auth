<?php

namespace App\Modules\Users\Domain\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'deleted_at',
        'is_root'
    ];

    protected $casts = [
        'email' => 'string',
        'password' => 'hashed',
        'is_root' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }

    public function access()
    {
        return $this->hasMany(ProjectUserAccess::class);
    }
}
