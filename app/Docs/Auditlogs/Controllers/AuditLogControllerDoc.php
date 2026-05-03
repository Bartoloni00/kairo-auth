<?php

namespace App\Docs\Auditlogs\Controllers;

use OpenApi\Attributes as OA;

class AuditLogControllerDoc
{
    #[OA\Get(
        path: "/api/audit-logs",
        summary: "Listar logs de auditoría",
        description: "Retorna una lista de logs filtrada por los parámetros enviados. Solo accesible para usuarios root.",
        operationId: "listAuditLogs",
        tags: ["Auditoría"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(name: "user_id", in: "query", description: "Filtrar por ID de usuario", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "action", in: "query", description: "Filtrar por nombre de acción (búsqueda parcial)", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "date_from", in: "query", description: "Fecha inicio (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", format: "date")),
            new OA\Parameter(name: "date_to", in: "query", description: "Fecha fin (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", format: "date")),
            new OA\Parameter(name: "search", in: "query", description: "Búsqueda en acción y metadatos", required: false, schema: new OA\Schema(type: "string")),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de logs",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "success"),
                        new OA\Property(property: "data", type: "array", items: new OA\Items(
                            properties: [
                                new OA\Property(property: "id", type: "integer"),
                                new OA\Property(property: "user_id", type: "integer"),
                                new OA\Property(property: "action", type: "string"),
                                new OA\Property(property: "metadata", type: "object"),
                                new OA\Property(property: "created_at", type: "string", format: "date-time"),
                                new OA\Property(property: "user", type: "object", properties: [
                                    new OA\Property(property: "id", type: "integer"),
                                    new OA\Property(property: "email", type: "string"),
                                ])
                            ]
                        ))
                    ]
                )
            ),
            new OA\Response(response: 401, description: "No autenticado"),
            new OA\Response(response: 403, description: "Permisos insuficientes (No es root)"),
        ]
    )]
    public function index() {}
}
