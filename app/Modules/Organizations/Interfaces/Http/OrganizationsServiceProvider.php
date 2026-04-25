<?php

namespace App\Modules\Organizations\Interfaces\Http;

use Illuminate\Support\ServiceProvider;
use App\Modules\Organizations\Application\Ports\OrganizationRepositoryInterface;
use App\Modules\Organizations\Infraestructure\Adapters\OrganizationRepository;
class OrganizationsServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(OrganizationRepositoryInterface::class, OrganizationRepository::class);
  }

  public function provides(): array
  {
    return [
      OrganizationRepositoryInterface::class,
    ];
  }
}
