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
    'is_multitenant',
  ];

  protected $casts = [
    'name' => 'string',
    'slug' => 'string',
    'is_multitenant' => 'boolean',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  protected static function newFactory()
  {
    //return ProjectFactory::new();
  }
}
