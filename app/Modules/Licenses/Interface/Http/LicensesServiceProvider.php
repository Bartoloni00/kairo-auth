<?php

namespace App\Modules\Licenses\Interface\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class LicensesServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public function register(): void {}

  public function provides(): array
  {
    return [];
  }
}
