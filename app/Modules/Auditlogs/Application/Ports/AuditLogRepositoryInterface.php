<?php

namespace App\Modules\Auditlogs\Application\Ports;

use Illuminate\Database\Eloquent\Collection;

interface AuditLogRepositoryInterface
{
    public function all(array $filters = []): Collection;
}
