<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Shared\Helpers\Enums\{
    ApiMessageEnum,
    ApiStatusCodeEnum
};

class IsRoot
{
    /**
     * Rules:
     * - ROOT → allow
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

        if ($authUser->is_root) {
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
