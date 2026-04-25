<?php

namespace App\Modules\Projects\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'projects';

  protected $fillable = [
    'name',
    'slug',
    'is_multitenant',
  ];

  protected $hidden = [
    'deleted_at',
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
    return \Database\Factories\ProjectFactory::new();
  }
}
