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
    'slug',
    'description',
    'is_system',
    'project_id'
  ];

  protected $casts = [
    'name' => 'string',
    'slug' => 'string',
    'description' => 'string',
    'is_system' => 'boolean',
    'project_id' => 'integer',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  protected static function newFactory()
  {
    //  return RoleFactory::new();
  }
}
