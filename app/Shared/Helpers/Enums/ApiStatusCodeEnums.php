<?php

namespace App\Shared\Helpers\Enums;

enum ApiStatusCodeEnum: int
{
  public const SUCCESS = 200;
  public const CREATED = 201;
  public const NO_CONTENT = 204;
  public const ERROR = 400;
  public const UNAUTHORIZED = 401;
  public const FORBIDDEN = 403;
  public const NOT_FOUND = 404;
  public const INVALID_REQUEST = 422;
  public const INTERNAL_ERROR = 500;
}
