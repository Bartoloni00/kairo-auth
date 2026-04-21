<?php

namespace App\Modules\Auditlogs\Interfaces\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class AuditlogsServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public function register(): void {}

  public function provides(): array
  {
    return [];
  }
}
