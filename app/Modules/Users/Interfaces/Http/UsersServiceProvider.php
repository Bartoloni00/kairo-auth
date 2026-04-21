<?php

namespace App\Modules\Users\Interfaces\Http;

use Illuminate\Support\ServiceProvider;
use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Users\Infraestructure\Adapters\UserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;

class UsersServiceProvider extends ServiceProvider implements DeferrableProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
  }

  public function provides(): array
  {
    return [
      UserRepositoryInterface::class,
    ];
  }
}
