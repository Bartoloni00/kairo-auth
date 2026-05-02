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
            new OA\Response(
                response: 200, 
                description: "Lista de usuarios",
                content: new OA\JsonContent(ref: "#/components/schemas/SuccessResponse")
            ),
            new OA\Response(
                response: 401, 
                description: "No autenticado",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            ),
            new OA\Response(
                response: 403, 
                description: "Prohibido - No tienes permisos",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            )
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
            new OA\Response(
                response: 200, 
                description: "Usuario encontrado",
                content: new OA\JsonContent(ref: "#/components/schemas/SuccessResponse")
            ),
            new OA\Response(
                response: 404, 
                description: "Usuario no encontrado",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            ),
            new OA\Response(
                response: 403, 
                description: "Prohibido - No tienes permisos",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            )
        ]
    )]
    public function show() {}

    #[OA\Post(
        path: "/api/users/{id}/projects",
        summary: "Agregar usuario a un proyecto",
        operationId: "addUserToProject",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "project_id", type: "integer", example: 1),
                    new OA\Property(property: "role_id", type: "integer", example: 2)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Usuario agregado al proyecto"),
            new OA\Response(response: 404, description: "Usuario no encontrado"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function addToProject() {}

    #[OA\Post(
        path: "/api/users/{id}/organizations",
        summary: "Agregar usuario a una organización",
        operationId: "addUserToOrganization",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "organization_id", type: "integer", example: 1),
                    new OA\Property(property: "role_id", type: "integer", example: 2)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Usuario agregado a la organización"),
            new OA\Response(response: 404, description: "Usuario no encontrado"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function addToOrganization() {}

    #[OA\Delete(
        path: "/api/users/{id}/projects/{projectId}",
        summary: "Eliminar usuario de un proyecto",
        operationId: "removeUserFromProject",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "projectId", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Usuario eliminado del proyecto"),
            new OA\Response(response: 404, description: "Usuario no encontrado o no está en el proyecto"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function removeFromProject() {}

    #[OA\Delete(
        path: "/api/users/{id}/organizations/{organizationId}",
        summary: "Eliminar usuario de una organización",
        operationId: "removeUserFromOrganization",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "organizationId", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Usuario eliminado de la organización"),
            new OA\Response(response: 404, description: "Usuario no encontrado o no está en la organización"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function removeFromOrganization() {}

    #[OA\Patch(
        path: "/api/users/{id}/projects/{projectId}/role",
        summary: "Actualizar rol de usuario en un proyecto",
        operationId: "updateUserProjectRole",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "projectId", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "role_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Rol actualizado en el proyecto"),
            new OA\Response(response: 404, description: "Usuario o proyecto no encontrado"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function updateProjectRole() {}

    #[OA\Patch(
        path: "/api/users/{id}/organizations/{organizationId}/role",
        summary: "Actualizar rol de usuario en una organización",
        operationId: "updateUserOrganizationRole",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "organizationId", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "role_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Rol actualizado en la organización"),
            new OA\Response(response: 404, description: "Usuario u organización no encontrada"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function updateOrganizationRole() {}

    #[OA\Put(
        path: "/api/users/{id}/email",
        summary: "Actualizar email de usuario",
        operationId: "updateUserEmail",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", example: "user@example.com")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Email actualizado"),
            new OA\Response(response: 404, description: "Usuario no encontrado"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function updateEmail() {}

    #[OA\Put(
        path: "/api/users/{id}/password",
        summary: "Actualizar contraseña de usuario",
        operationId: "updateUserPassword",
        tags: ["Usuarios"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "password", type: "string", example: "newpassword123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Contraseña actualizada"),
            new OA\Response(response: 404, description: "Usuario no encontrado"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function updatePassword() {}

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
            new OA\Response(response: 404, description: "Usuario no encontrado"),
            new OA\Response(response: 403, description: "Prohibido - No tienes permisos")
        ]
    )]
    public function destroy() {}
}
