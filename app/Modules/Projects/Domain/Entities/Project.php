<?php

namespace App\Modules\Projects\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
  use HasFactory;

  protected $table = 'projects';

  protected $fillable = [
    'name',
    'slug',
    'description',
    'is_system',
    'organization_id',
  ];

  protected $casts = [
    'name' => 'string',
    'slug' => 'string',
    'description' => 'string',
    'is_system' => 'boolean',
    'organization_id' => 'integer',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  protected static function newFactory()
  {
    //return ProjectFactory::new();
  }
}
