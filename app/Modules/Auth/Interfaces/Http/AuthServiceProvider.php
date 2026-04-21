<?php

namespace App\Modules\Auth\Interfaces\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Modules\Auth\Application\Ports\{
  ProjectUserRepositoryInterface,
  TokenProviderInterface
};
use App\Modules\Auth\Infraestructure\Adapters\ProjectUserRepository;
use App\Modules\Auth\Infraestructure\Providers\JWTTokenProvider;

class AuthServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public function register(): void
  {
    $this->app->singleton(ProjectUserRepositoryInterface::class, ProjectUserRepository::class);
    $this->app->singleton(TokenProviderInterface::class, JWTTokenProvider::class);
  }

  public function provides(): array
  {
    return [
      ProjectUserRepositoryInterface::class,
      TokenProviderInterface::class,
    ];
  }
}
