<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Users\Interfaces\Http\Middlewares\Traits\HasAuthorizationHelpers;
use App\Shared\Helpers\Enums\{
    ApiMessageEnum,
    ApiStatusCodeEnum
};

class CanManageUser
{
    use HasAuthorizationHelpers;

    /**
     * Rules:
     * - ROOT → allow
     * - If authenticated user == target user → allow
     * - If authenticated user is ADMIN of same organization as target → allow
     * - Otherwise → deny
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();
        $targetUserId = $request->route('user_id');

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

        // Target user is the auth user themselves
        if ((string)$authUser->id === (string)$targetUserId) {
            return $next($request);
        }

        // ADMIN of same organization
        if ($this->isAdminOfSameOrg($authUser, $targetUserId)) {
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
