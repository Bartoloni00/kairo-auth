<?php

namespace App\Docs\Auth\Controllers;

use OpenApi\Attributes as OA;

class AuthControllerDoc
{
    #[OA\Post(
        path: "/api/auth/register",
        summary: "Registrar un nuevo usuario",
        operationId: "registerUser",
        tags: ["Autenticación"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "juan@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "12345678"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Usuario registrado"
            ),
            new OA\Response(
                response: 422,
                description: "Datos inválidos"
            )
        ]
    )]
    public function register() {}

    #[OA\Post(
        path: "/api/auth/login",
        summary: "Login",
        operationId: "loginUser",
        tags: ["Autenticación"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string"),
                    new OA\Property(property: "password", type: "string"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "OK"),
            new OA\Response(response: 401, description: "Unauthorized"),
        ]
    )]
    public function login() {}

    #[OA\Get(
        path: "/api/auth/me",
        summary: "Perfil",
        operationId: "me",
        tags: ["Autenticación"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "OK"),
            new OA\Response(response: 401, description: "No autenticado"),
        ]
    )]
    public function me() {}
}
