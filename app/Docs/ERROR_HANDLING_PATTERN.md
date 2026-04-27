# Patrón Unificado de Respuestas API

Kairo-Auth utiliza un formato estándar para todas las respuestas de la API, asegurando que el frontend pueda procesar los datos de manera predecible y consistente.

## Estructura de Éxito

Cuando una petición se procesa correctamente (Status 200, 201), la respuesta siempre incluirá:

- `status`: Siempre "success".
- `data`: El payload con la información solicitada (puede ser `null`).
- `message`: Una descripción opcional de la operación.

**Ejemplo:**

```json
{
    "status": "success",
    "data": {
        "id": 1,
        "email": "user@example.com"
    },
    "message": "Usuario recuperado exitosamente"
}
```

---

## Estructura de Error

Cuando ocurre un error (Status 4xx, 5xx), la respuesta incluye detalles para facilitar el debugging y la gestión de UI:

- `status`: Siempre "error".
- `message`: Una descripción legible para humanos del error.
- `code`: Un identificador de error en formato string (ej: `AUTH_FAILED`).
- `details`: Información adicional (como errores de validación, opcional).

**Ejemplo:**

```json
{
    "status": "error",
    "message": "No tienes permiso para realizar esta acción",
    "code": "FORBIDDEN",
    "details": null
}
```

---

## Códigos de Error Comunes

Se utilizan los siguientes códigos en la propiedad `code` para que el frontend pueda implementar lógica condicional:

| Código             | Descripción                                                         |
| :----------------- | :------------------------------------------------------------------ |
| `AUTH_FAILED`      | Error de autenticación o credenciales inválidas.                    |
| `FORBIDDEN`        | El usuario está autenticado pero no tiene permisos para el recurso. |
| `NOT_FOUND`        | El recurso solicitado no existe.                                    |
| `VALIDATION_ERROR` | Los datos enviados no cumplen con las reglas de validación.         |
| `TOKEN_EXPIRED`    | El token JWT ha expirado.                                           |
| `TOKEN_INVALID`    | El token JWT es malformado o inválido.                              |
| `INTERNAL_ERROR`   | Error inesperado en el servidor.                                    |

---

## Implementación Técnica

Los desarrolladores deben utilizar el Trait `App\Shared\Interfaces\Http\Responses\ApiResponse` en sus controladores y middlewares:

```php
// En el Controlador
return $this->successResponse($data, "Operación exitosa");

// En caso de Error
return $this->errorResponse(
    ApiMessageEnum::USER_NOT_FOUND,
    ApiErrorCodeEnum::NOT_FOUND->value,
    ApiStatusCodeEnum::NOT_FOUND
);
```
