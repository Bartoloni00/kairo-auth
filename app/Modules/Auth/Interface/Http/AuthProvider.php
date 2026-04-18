<?php
namespace App\Modules\Auth\Interface\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Modules\Auth\Interface\{
  UserServiceInterface,
  AuthRepositoryInterface
};
use App\Modules\Auth\Infrastructure\{
  UserService,
  AuthRepository
};

class AuthProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
      $this->app->singleton(AuthRepositoryInterface::class, AuthRepository::class);
      $this->app->singleton(UserServiceInterface::class, UserService::class);
    }

    public function provides(): array
    {
        return [
            AuthRepositoryInterface::class,
            UserServiceInterface::class,
        ];
    }

    public function boot(): void
    {

    }
}