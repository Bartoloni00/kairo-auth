# Guía de Uso: Factories de Kairo-Auth

Esta guía explica cómo utilizar los factories creados para generar datos de prueba de manera rápida y consistente.

## 1. ¿Cómo ejecutarlos?
La forma más sencilla de ejecutar un factory individualmente es a través de **Laravel Tinker**. Para entrar, ejecuta en tu terminal:

```bash
php artisan tinker
```

## 2. Orden de Ejecución Sugerido
Aunque el `UserFactory` es inteligente y puede crear sus propias dependencias, el orden lógico para tener control total sobre los datos es:

1.  **Roles**: Necesarios para definir qué puede hacer un usuario en un proyecto.
2.  **Organizaciones y Proyectos**: Las entidades estructurales.
3.  **Usuarios**: Que se vinculan a lo anterior.

---

## 3. Ejemplos de Uso en Tinker

### A. Crear entidades básicas
```php
// Crear 5 proyectos
$projects = \App\Modules\Projects\Domain\Entities\Project::factory()->count(5)->create();

// Crear 3 organizaciones
$orgs = \App\Modules\Organizations\Domain\Entities\Organization::factory()->count(3)->create();

// Crear roles de sistema
$adminRole = \App\Modules\Users\Domain\Entities\Role::factory()->create(['name' => 'Admin']);
```

### B. Crear un Usuario ROOT
```php
\App\Modules\Users\Domain\Entities\User::factory()->root()->create([
    'email' => 'admin@kairo.com'
]);
```

### C. Crear Usuario con Acceso Aleatorio
Este comando crea un usuario y le asigna automáticamente un proyecto y organizaciones aleatorias (creándolos si no existen).
```php
\App\Modules\Users\Domain\Entities\User::factory()->withAccess()->create();
```

### D. Escenario Completo (Control Total)
Si quieres crear un usuario que pertenezca a un proyecto específico y a ciertas organizaciones:

```php
$project = \App\Modules\Projects\Domain\Entities\Project::factory()->create(['name' => 'Proyecto Kairo']);
$org1 = \App\Modules\Organizations\Domain\Entities\Organization::factory()->create(['name' => 'Org A']);
$org2 = \App\Modules\Organizations\Domain\Entities\Organization::factory()->create(['name' => 'Org B']);
$role = \App\Modules\Users\Domain\Entities\Role::factory()->create(['name' => 'Manager']);

\App\Modules\Users\Domain\Entities\User::factory()->withAccess([
    [
        'project' => $project,
        'organizations' => [$org1, $org2],
        'role' => $role
    ]
])->create(['email' => 'manager@kairo.com']);
```

---

## 4. Uso en DatabaseSeeder
Puedes integrar estos factories en tu `DatabaseSeeder.php` para poblar la base de datos de un solo comando (`php artisan migrate --seed`):

```php
public function run(): void
{
    // Crear ecosistema inicial
    $project = Project::factory()->create(['name' => 'Main Project']);
    $orgs = Organization::factory()->count(2)->create();
    $role = Role::factory()->create(['name' => 'Member']);

    // Crear 10 usuarios con ese acceso
    User::factory()->count(10)->withAccess([
        ['project' => $project, 'organizations' => $orgs, 'role' => $role]
    ])->create();
}
```

## 5. Resumen de Métodos Especiales
- `root()`: Marca al usuario como `is_root = true`.
- `withAccess($config)`: Crea las entradas en `project_user_access`. Si se pasa vacío, genera datos aleatorios.
