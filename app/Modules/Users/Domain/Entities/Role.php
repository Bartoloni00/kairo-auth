<?php

namespace App\Modules\Users\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Database\Factories\RoleFactory;

class Role extends Model
{
  use HasFactory;

  protected $table = 'roles';

  protected $fillable = [
    'name',
    'description',
    'is_system',
    'project_id'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'is_system',
    'description',
  ];

  protected $casts = [
    'name' => 'string',
    'description' => 'string',
    'is_system' => 'boolean',
    'project_id' => 'integer',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  protected static function newFactory()
  {
    return \Database\Factories\RoleFactory::new();
  }
}
