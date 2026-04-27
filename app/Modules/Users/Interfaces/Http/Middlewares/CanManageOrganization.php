<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Users\Interfaces\Http\Middlewares\Traits\HasAuthorizationHelpers;
use App\Shared\Helpers\Enums\{
    ApiMessageEnum,
    ApiStatusCodeEnum
};

class CanManageOrganization
{
    use HasAuthorizationHelpers;

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
            return response()->json(
                [
                    'message' => ApiMessageEnum::UNAUTHORIZED_MESSAGE
                ],
                ApiStatusCodeEnum::UNAUTHORIZED
            );
        }

        if ($authUser->is_root) {
            return $next($request);
        }

        if ($this->isAdminOfOrganization($authUser, $organizationId)) {
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
