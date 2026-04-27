<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Users\Interfaces\Http\Middlewares\Traits\HasAuthorizationHelpers;
use App\Shared\Interfaces\Http\Responses\ApiResponse;
use App\Shared\Helpers\Enums\{
    ApiMessageEnum,
    ApiStatusCodeEnum,
    ApiErrorCodeEnum
};

class CanViewUsers
{
    use HasAuthorizationHelpers, ApiResponse;

    /**
     * Rules:
     * - ROOT → allow
     * - Any authenticated user with at least one organization → allow
     * - Otherwise → deny
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();

        if (!$authUser) {
            return $this->errorResponse(
                ApiMessageEnum::UNAUTHORIZED_MESSAGE,
                ApiErrorCodeEnum::AUTH_FAILED->value,
                ApiStatusCodeEnum::UNAUTHORIZED
            );
        }

        // ROOT bypasses all checks
        if ($authUser->is_root) {
            return $next($request);
        }

        // Any user with at least one organization
        if ($this->hasAnyOrganization($authUser)) {
            return $next($request);
        }

        return $this->errorResponse(
            ApiMessageEnum::FORBIDDEN_MESSAGE,
            ApiErrorCodeEnum::FORBIDDEN->value,
            ApiStatusCodeEnum::FORBIDDEN
        );
    }
}
