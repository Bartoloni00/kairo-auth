<?php

namespace App\Docs\Organizations\Controllers;

use OpenApi\Attributes as OA;

class OrganizationControllerDoc
{
    public function index() {}

    #[OA\Post(
        path: "/api/organizations",
        summary: "Crear una organización",
        operationId: "createOrganization",
        tags: ["Organizaciones"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Organización creada"),
            new OA\Response(response: 422, description: "Datos inválidos")
        ]
    )]
    public function store() {}

    #[OA\Get(
        path: "/api/organizations/{id}",
        summary: "Obtener una organización",
        operationId: "getOrganization",
        tags: ["Organizaciones"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Organización encontrada"),
            new OA\Response(response: 404, description: "Organización no encontrada")
        ]
    )]
    public function show() {}

    #[OA\Put(
        path: "/api/organizations/{id}",
        summary: "Actualizar una organización",
        operationId: "updateOrganization",
        tags: ["Organizaciones"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Organización actualizada"),
            new OA\Response(response: 404, description: "Organización no encontrada")
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: "/api/organizations/{id}",
        summary: "Eliminar una organización",
        operationId: "deleteOrganization",
        tags: ["Organizaciones"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Organización eliminada"),
            new OA\Response(response: 404, description: "Organización no encontrada")
        ]
    )]
    public function destroy() {}
}
