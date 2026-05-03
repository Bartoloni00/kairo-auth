<?php

namespace App\Modules\Auditlogs\Application\Services;

use App\Modules\Auditlogs\Domain\Entities\AuditLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    /**
     * Log an action to both Laravel logs and database.
     *
     * @param string $action
     * @param array $metadata
     * @param string $level (info, error, warning, etc.)
     * @param int|null $userId
     * @return void
     */
    public function log(string $action, array $metadata = [], string $level = 'info', ?int $userId = null): void
    {
        // Enrich metadata with request information
        $metadata = array_merge([
            'endpoint' => request()->fullUrl(),
            'method' => request()->method(),
            'ip' => requestIP(),
            'headers' => requestHeaders(),
            'params' => requestParams(),
            'body' => requestBody(),
        ], $metadata);

        Log::log($level, $action, $metadata);

        try {
            $userId = $userId ?? Auth::id();

            if ($userId) {
                AuditLog::create([
                    'user_id' => $userId,
                    'action' => $action,
                    'metadata' => $metadata,
                    'created_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            // If DB logging fails, log the error to Laravel logs but don't crash the app
            Log::error("Failed to save audit log to database: " . $e->getMessage(), [
                'original_action' => $action,
                'original_metadata' => $metadata
            ]);
        }
    }

    public function info(string $action, array $metadata = [], ?int $userId = null): void
    {
        $this->log($action, $metadata, 'info', $userId);
    }

    public function error(string $action, array $metadata = [], ?int $userId = null): void
    {
        $this->log($action, $metadata, 'error', $userId);
    }

    public function warning(string $action, array $metadata = [], ?int $userId = null): void
    {
        $this->log($action, $metadata, 'warning', $userId);
    }
}
