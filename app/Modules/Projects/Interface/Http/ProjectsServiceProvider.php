<?php

namespace App\Modules\Projects\Interface\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ProjectsServiceProvider extends ServiceProvider  implements DeferrableProvider
{
  public function register(): void {}

  public function provides(): array
  {
    return [];
  }
}
