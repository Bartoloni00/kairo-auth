<?php

namespace App\Modules\Organizations\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'organizations';

  protected $fillable = [
    'name',
  ];

  protected $hidden = [
    'deleted_at',
  ];

  protected $casts = [
    'name' => 'string',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  protected static function newFactory()
  {
    return \Database\Factories\OrganizationFactory::new();
  }
}
