<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Users\Interfaces\Http\Middlewares\Traits\HasAuthorizationHelpers;
use App\Shared\Helpers\Enums\{
    ApiMessageEnum,
    ApiStatusCodeEnum
};

class CanManageProject
{
    use HasAuthorizationHelpers;

    /**
     * Rules:
     * - ROOT → allow
     * - If authenticated user is ADMIN of the project → allow
     * - Otherwise → deny
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();
        $projectId = $request->route('id'); // Note: Projects routes use {id} instead of {project_id}

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

        if ($this->isAdminOfProject($authUser, $projectId)) {
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
