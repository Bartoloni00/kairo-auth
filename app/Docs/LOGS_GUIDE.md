# Sistema de Logs y Auditoría

Cada acción relevante en el sistema registra un log tanto en los archivos estándar de Laravel como en la tabla `audit_logs` de la base de datos.

## Estructura de la Tabla `audit_logs`

- **user_id**: ID del usuario que realizó la acción.
- **action**: Nombre de la acción (ej: `user_registered`, `login_failed`).
- **metadata**: JSON con información detallada del request.
- **created_at**: Fecha y hora del evento.

## Metadatos Automáticos
Cada log incluye automáticamente:
- `endpoint`: URL completa del request.
- `method`: Método HTTP (GET, POST, etc).
- `ip`: IP del cliente (vía helper `requestIP()`).
- `headers`: Headers del request (vía helper `requestHeaders()`).
- `params`: Parámetros de la query string (vía helper `requestParams()`).
- `body`: Cuerpo del request (vía helper `requestBody()`).

## Endpoint de Consulta

**GET `/audit-logs`** (Solo para usuarios con rol `is.root`)

### Filtros Disponibles:
- `user_id`: Filtrar por un usuario específico.
- `action`: Búsqueda parcial por nombre de acción.
- `date_from`: Fecha de inicio (YYYY-MM-DD).
- `date_to`: Fecha de fin (YYYY-MM-DD).
- `search`: Búsqueda de texto en acción y metadatos.

## Uso del Servicio
Para registrar logs desde cualquier controlador, inyectar `AuditLogService`:

```php
$this->auditLogService->info('mi_accion_personalizada', ['dato' => 'extra']);
```
