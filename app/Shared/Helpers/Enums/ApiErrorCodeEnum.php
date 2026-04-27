<?php

namespace App\Shared\Helpers\Enums;

enum ApiErrorCodeEnum: string
{
    case AUTH_FAILED = 'AUTH_FAILED';
    case FORBIDDEN = 'FORBIDDEN';
    case NOT_FOUND = 'NOT_FOUND';
    case VALIDATION_ERROR = 'VALIDATION_ERROR';
    case INTERNAL_ERROR = 'INTERNAL_ERROR';
    case INVALID_REQUEST = 'INVALID_REQUEST';
    case TOKEN_EXPIRED = 'TOKEN_EXPIRED';
    case TOKEN_INVALID = 'TOKEN_INVALID';
}
