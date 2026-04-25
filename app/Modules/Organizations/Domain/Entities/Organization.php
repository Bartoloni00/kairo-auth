<?php

namespace App\Modules\Organizations\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
  use HasFactory;

  protected $table = 'organizations';

  protected $fillable = [
    'name',
  ];

  protected $casts = [
    'name' => 'string',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  protected static function newFactory()
  {
    //return OrganizationFactory::new();
  }
}
