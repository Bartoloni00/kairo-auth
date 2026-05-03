<?php

namespace App\Modules\Auditlogs\Interfaces\Http;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class AuditlogsServiceProvider extends ServiceProvider implements DeferrableProvider
{
  public function register(): void
  {
    $this->app->singleton(\App\Modules\Auditlogs\Application\Services\AuditLogService::class, function ($app) {
      return new \App\Modules\Auditlogs\Application\Services\AuditLogService();
    });

    $this->app->bind(
      \App\Modules\Auditlogs\Application\Ports\AuditLogRepositoryInterface::class,
      \App\Modules\Auditlogs\Infraestructure\Adapters\AuditLogRepository::class
    );

    $this->app->singleton(\App\Modules\Auditlogs\Application\UseCases\ListAuditLogsUseCase::class);
  }

  public function provides(): array
  {
    return [
      \App\Modules\Auditlogs\Application\Services\AuditLogService::class,
      \App\Modules\Auditlogs\Application\Ports\AuditLogRepositoryInterface::class,
      \App\Modules\Auditlogs\Application\UseCases\ListAuditLogsUseCase::class
    ];
  }
}
