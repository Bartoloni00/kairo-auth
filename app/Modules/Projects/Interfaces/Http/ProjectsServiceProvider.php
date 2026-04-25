<?php

namespace App\Modules\Projects\Interfaces\Http;

use Illuminate\Support\ServiceProvider;
use App\Modules\Projects\Application\Ports\ProjectRepositoryInterface;
use App\Modules\Projects\Infraestructure\Adapters\ProjectRepository;
use Illuminate\Contracts\Support\DeferrableProvider;

class ProjectsServiceProvider extends ServiceProvider implements DeferrableProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(ProjectRepositoryInterface::class, ProjectRepository::class);
  }

  public function provides(): array
  {
    return [
      ProjectRepositoryInterface::class,
    ];
  }
}
