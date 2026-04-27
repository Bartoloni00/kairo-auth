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

class CanManageOrganization
{
    use HasAuthorizationHelpers, ApiResponse;

    /**
     * Rules:
     * - ROOT → allow
     * - If authenticated user is ADMIN of the organization → allow
     * - Otherwise → deny
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();
        $organizationId = $request->route('id');

        if (!$authUser) {
            return $this->errorResponse(
                ApiMessageEnum::UNAUTHORIZED_MESSAGE,
                ApiErrorCodeEnum::AUTH_FAILED->value,
                ApiStatusCodeEnum::UNAUTHORIZED
            );
        }

        if ($authUser->is_root) {
            return $next($request);
        }

        if ($this->isAdminOfOrganization($authUser, $organizationId)) {
            return $next($request);
        }

        return $this->errorResponse(
            ApiMessageEnum::FORBIDDEN_MESSAGE,
            ApiErrorCodeEnum::FORBIDDEN->value,
            ApiStatusCodeEnum::FORBIDDEN
        );
    }
}
