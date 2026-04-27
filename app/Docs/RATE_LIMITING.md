# Sistema de Rate Limiting

Kairo-Auth implementa un sistema de limitación de tasa para proteger la API contra ataques de fuerza bruta, credential stuffing y abuso general.

## Estrategias de Limitación

Se han definido cuatro limitadores principales aplicados según la criticidad del endpoint:

### 1. `login`
**Objetivo**: Prevenir ataques de fuerza bruta en el inicio de sesión.
- **Reglas**: 
  - Máximo 5 intentos por minuto por combinación de Email + IP.
  - Máximo 10 intentos por minuto por IP globalmente.
- **Clave**: `email|ip` e `ip`.

### 2. `register`
**Objetivo**: Evitar la creación masiva de cuentas (spam).
- **Reglas**: Máximo 5 peticiones por minuto por IP.
- **Clave**: `ip`.

### 3. `api`
**Objetivo**: Protección general para rutas autenticadas.
- **Reglas**: Máximo 60 peticiones por minuto.
- **Clave**: `user_id|ip` (si está autenticado) o `ip` (si es invitado).

### 4. `sensitive`
**Objetivo**: Proteger acciones críticas como cambios de contraseña o email.
- **Reglas**: Máximo 3 peticiones por minuto.
- **Clave**: `user_id|ip`.

---

## Respuesta de Error (Status 429)

Cuando un usuario excede el límite, la API responde con el formato estándar de error:

```json
{
    "message": "Too many attempts"
}
```

---

## Implementación Técnica

Los limitadores están definidos en `App\Providers\AppServiceProvider::boot()` y se aplican mediante el middleware `throttle`:

```php
// Ejemplo en rutas
Route::post('/auth/login', 'login')->middleware('throttle:login');

Route::middleware(['jwt', 'throttle:api'])->group(function () {
    Route::get('/users', 'index');
});

Route::put('/users/{id}/password', 'updatePassword')
    ->middleware(['jwt', 'throttle:sensitive']);
```
