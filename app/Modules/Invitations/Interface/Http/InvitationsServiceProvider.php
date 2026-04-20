<?php

namespace App\Modules\Invitations\Interface\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class InvitationsServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public function register(): void {}

  public function provides(): array
  {
    return [];
  }
}
