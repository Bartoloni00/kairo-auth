# Arquitectura de Middlewares de Autorización

Este documento explica el sistema de autorización utilizado en el microservicio Kairo-Auth, el cual soporta operaciones multi-tenant a través de diferentes organizaciones y proyectos.

## Descripción General de la Arquitectura

El sistema sigue un enfoque de **Denegación por Defecto (Fail-Closed)** utilizando **Middlewares Específicos por Acción**. En lugar de usar un middleware genérico de "verificar rol", utilizamos middlewares granulares que encapsulan las reglas de negocio específicas para cada tipo de recurso y acción.

### Componentes Clave

1.  **Trait de Ayudantes de Autorización**: Ubicado en `App\Modules\Users\Interfaces\Http\Middlewares\Traits\HasAuthorizationHelpers`. Este trait centraliza la complejidad de las consultas a la tabla pivote `project_user_access`.
2.  **Middlewares**: Clases individuales para cada acción (ej. `CanManageUser`, `CanManageOrganization`).
3.  **Anulaciones Globales**: El atributo `is_root` en el modelo `User` permite omitir todas las verificaciones.

---

## Jerarquía de Roles y Reglas

### 1. ROOT (Super Administrador)
- **Acceso**: Global (omite todas las verificaciones de middleware).
- **Regla**: `if ($authUser->is_root) return $next($request);`

### 2. ADMIN (Dueño de Organización)
- **Acceso**: Limitado a sus organizaciones específicas.
- **Regla**: Puede gestionar usuarios, proyectos y configuraciones dentro de las organizaciones donde tiene el rol `admin`.

### 3. USER (Usuario Básico)
- **Acceso**: Nivel básico.
- **Regla**: Solo puede actuar sobre sí mismo (ej. actualizar su propia contraseña) a menos que comparta una organización con un permiso específico.

---

## Lista de Middlewares

| Alias del Middleware | Descripción |
| :--- | :--- |
| `is.root` | Solo permite el acceso a usuarios con `is_root = true`. |
| `can.view.users` | Permite ROOT o cualquier usuario que pertenezca al menos a una organización. |
| `can.manage.user` | Permite ROOT, al propio usuario, o a un ADMIN de la misma organización. |
| `can.delete.user` | Misma lógica que gestión, pero desacoplado para futuros cambios de política. |
| `can.manage.project` | Permite ROOT o a un ADMIN del proyecto. |
| `can.manage.organization` | Permite ROOT o a un ADMIN de esa organización específica. |

---

## Patrón de Implementación

Cada middleware sigue esta estructura estándar:

```php
public function handle(Request $request, Closure $next)
{
    $authUser = $request->user();
    $targetId = $request->route('id'); // o 'user_id'

    // 1. Verificación de Autenticación
    if (!$authUser) return response()->json([...], 401);

    // 2. Omisión para ROOT
    if ($authUser->is_root) return $next($request);

    // 3. Lógica de Negocio Granular (vía Trait)
    if ($this->isAdminOfResource($authUser, $targetId)) {
        return $next($request);
    }

    // 4. Denegación por Defecto
    return response()->json([...], 403);
}
```

---

## Registro y Uso

### Registro
Los middlewares se registran en `bootstrap/app.php`:

```php
$middleware->alias([
    'can.manage.user' => \App\Modules\Users\Interfaces\Http\Middlewares\CanManageUser::class,
    // ...
]);
```

### Uso en Rutas
Se aplican directamente en las definiciones de rutas:

```php
Route::put('/{user_id}/email', [UserController::class, 'updateEmail'])
    ->middleware('can.manage.user');
```

---

## Buenas Prácticas
- **No quemar roles en código (hardcode)**: Siempre usa el trait `HasAuthorizationHelpers` para verificar permisos.
- **Mantén la granularidad**: Crea un nuevo middleware si una acción tiene un conjunto único de reglas.
- **Centraliza los mensajes**: Usa `ApiMessageEnum` y `ApiStatusCodeEnum` para todas las respuestas para mantener la consistencia en la API.
