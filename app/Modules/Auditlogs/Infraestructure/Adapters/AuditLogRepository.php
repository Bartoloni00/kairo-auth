<?php

namespace App\Modules\Auditlogs\Infraestructure\Adapters;

use App\Modules\Auditlogs\Application\Ports\AuditLogRepositoryInterface;
use App\Modules\Auditlogs\Domain\Entities\AuditLog;
use Illuminate\Database\Eloquent\Collection;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = AuditLog::with('user');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', 'like', '%' . $filters['action'] . '%');
        }

        if (!empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%$search%")
                  ->orWhere('metadata', 'like', "%$search%");
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
