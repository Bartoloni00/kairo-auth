<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Users\Interfaces\Http\Middlewares\Traits\HasAuthorizationHelpers;
use App\Shared\Helpers\Enums\{
    ApiMessageEnum,
    ApiStatusCodeEnum
};

class CanViewUsers
{
    use HasAuthorizationHelpers;

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
            return response()->json(
                [
                    'message' => ApiMessageEnum::UNAUTHORIZED_MESSAGE
                ],
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

        return response()->json(
            [
                'message' => ApiMessageEnum::FORBIDDEN_MESSAGE
            ],
            ApiStatusCodeEnum::FORBIDDEN
        );
    }
}
