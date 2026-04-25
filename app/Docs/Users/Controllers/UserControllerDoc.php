<?php

namespace App\Docs\Users\Controllers;

use OpenApi\Attributes as OA;

class UserControllerDoc
{
    #[OA\Get(
        path: "/api/users",
        summary: "Listar usuarios",
        operationId: "listUsers",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "organization_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "project_id", in: "query", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "deleted", in: "query", required: false, schema: new OA\Schema(type: "boolean"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista de usuarios"),
            new OA\Response(response: 401, description: "No autenticado")
        ]
    )]
    public function index() {}

    #[OA\Get(
        path: "/api/users/{id}",
        summary: "Obtener un usuario",
        operationId: "getUser",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Usuario encontrado"),
            new OA\Response(response: 404, description: "Usuario no encontrado")
        ]
    )]
    public function show() {}

    #[OA\Put(
        path: "/api/users/{id}",
        summary: "Actualizar un usuario",
        operationId: "updateUser",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "password", type: "string", format: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Usuario actualizado"),
            new OA\Response(response: 404, description: "Usuario no encontrado")
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: "/api/users/{id}",
        summary: "Eliminar un usuario",
        operationId: "deleteUser",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Usuario eliminado"),
            new OA\Response(response: 404, description: "Usuario no encontrado")
        ]
    )]
    public function destroy() {}
}
