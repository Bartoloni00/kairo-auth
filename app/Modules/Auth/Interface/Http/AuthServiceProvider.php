<?php

namespace App\Modules\Auth\Interface\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Modules\Auth\Application\Ports\{
  ProjectUserRepositoryInterface
};
use App\Modules\Auth\Infraestructure\Adapters\ProjectUserRepository;

class AuthServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public function register(): void
  {
    $this->app->singleton(ProjectUserRepositoryInterface::class, ProjectUserRepository::class);
  }

  public function provides(): array
  {
    return [
      ProjectUserRepositoryInterface::class,
    ];
  }
}
