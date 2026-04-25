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
class OpenApiSpec
{
    #[OA\Get(
        path: "/api/test",
        summary: "Endpoint de prueba",
        responses: [
            new OA\Response(
                response: 200,
                description: "OK"
            )
        ]
    )]
    public function test() {}
}
