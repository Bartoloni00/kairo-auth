<?php

namespace App\Modules\Auditlogs\Application\UseCases;

use App\Modules\Auditlogs\Application\Ports\AuditLogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ListAuditLogsUseCase
{
    public function __construct(
        private readonly AuditLogRepositoryInterface $repository
    ) {}

    public function execute(array $filters = []): Collection
    {
        return $this->repository->all($filters);
    }
}
