<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
  title: "Kairo Auth API",
  version: "1.0.0",
  description: "API de autenticación para Kairo"
)]
#[OA\Server(
  url: L5_SWAGGER_CONST_HOST,
  description: "Servidor principal"
)]
#[OA\SecurityScheme(
  securityScheme: "bearerAuth",
  type: "http",
  name: "Authorization",
  in: "header",
  scheme: "bearer",
  bearerFormat: "JWT"
)]
#[OA\Schema(
  schema: "SuccessResponse",
  properties: [
    new OA\Property(property: "status", type: "string", example: "success"),
    new OA\Property(property: "data", type: "object", nullable: true),
    new OA\Property(property: "message", type: "string", nullable: true)
  ]
)]
#[OA\Schema(
  schema: "ErrorResponse",
  properties: [
    new OA\Property(property: "status", type: "string", example: "error"),
    new OA\Property(property: "message", type: "string"),
    new OA\Property(property: "code", type: "string"),
    new OA\Property(property: "details", type: "object", nullable: true)
  ]
)]
class OpenApiSpec
{
  public function test() {}
}
