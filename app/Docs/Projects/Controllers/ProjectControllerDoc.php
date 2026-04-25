<?php

namespace App\Docs\Projects\Controllers;

use OpenApi\Attributes as OA;

class ProjectControllerDoc
{
    #[OA\Get(
        path: "/api/projects",
        summary: "Listar proyectos",
        operationId: "listProjects",
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "deleted", in: "query", required: false, schema: new OA\Schema(type: "boolean"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Lista de proyectos"),
            new OA\Response(response: 401, description: "No autenticado")
        ]
    )]
    public function index() {}

    #[OA\Post(
        path: "/api/projects",
        summary: "Crear un proyecto",
        operationId: "createProject",
        tags: ["Proyectos"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "is_multitenant", type: "boolean")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Proyecto creado"),
            new OA\Response(response: 422, description: "Datos inválidos")
        ]
    )]
    public function store() {}

    #[OA\Get(
        path: "/api/projects/{id}",
        summary: "Obtener un proyecto",
        operationId: "getProject",
        tags: ["Proyectos"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Proyecto encontrado"),
            new OA\Response(response: 404, description: "Proyecto no encontrado")
        ]
    )]
    public function show() {}

    #[OA\Put(
        path: "/api/projects/{id}",
        summary: "Actualizar un proyecto",
        operationId: "updateProject",
        tags: ["Proyectos"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "is_multitenant", type: "boolean")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Proyecto actualizado"),
            new OA\Response(response: 404, description: "Proyecto no encontrado")
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: "/api/projects/{id}",
        summary: "Eliminar un proyecto",
        operationId: "deleteProject",
        tags: ["Proyectos"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Proyecto eliminado"),
            new OA\Response(response: 404, description: "Proyecto no encontrado")
        ]
    )]
    public function destroy() {}
}
