<?php

namespace App\Modules\Organizations\Interface\Http;

use Illuminate\Support\ServiceProvider;

class OrganizationsServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    // Register module specific dependencies here
  }

  public function boot(): void {}
}
