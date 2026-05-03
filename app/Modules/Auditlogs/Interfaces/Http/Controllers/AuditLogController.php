<?php

namespace App\Modules\Auditlogs\Interfaces\Http\Controllers;

use App\Modules\Auditlogs\Application\UseCases\ListAuditLogsUseCase;
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use App\Shared\Helpers\Enums\{ApiStatusCodeEnum, ApiErrorCodeEnum};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class AuditLogController
{
    use ApiResponse;

    public function __construct(
        private readonly ListAuditLogsUseCase $listAuditLogsUseCase
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $logs = $this->listAuditLogsUseCase->execute($request->all());
            return $this->successResponse($logs);
        } catch (Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                ApiErrorCodeEnum::INTERNAL_ERROR->value,
                ApiStatusCodeEnum::INTERNAL_ERROR
            );
        }
    }
}
