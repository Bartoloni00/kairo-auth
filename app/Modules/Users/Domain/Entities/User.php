<?php

namespace App\Modules\Users\Domain\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Database\Factories\UserFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'is_root',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
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
        //return UserFactory::new();
    }
}
