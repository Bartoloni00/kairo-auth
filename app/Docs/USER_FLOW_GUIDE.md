# Guía de Flujo de Usuarios y Roles (Estilo GitHub)

Este documento explica el proceso de registro, asociación y gestión de permisos en Kairo-Auth.

## 1. Registro de Usuario

El registro es **desacoplado**. Un usuario puede registrarse en el sistema sin pertenecer inicialmente a ninguna organización o proyecto.

- **Endpoint**: `POST /api/auth/register`
- **Requisitos**: Solo `email` y `password`.
- **Resultado**: El usuario es creado en la base de datos y recibe un JWT para autenticarse.

## 2. Asociación a Entidades

Una vez que el usuario tiene una cuenta, puede ser vinculado a organizaciones o proyectos.

### Organizaciones (Tenants)

- **Endpoint**: `POST /api/users/{user_id}/organizations`
- **Uso**: Vincula al usuario con una empresa. Por defecto se le asigna un rol de "Member" (o el especificado).

### Proyectos

- **Endpoint**: `POST /api/users/{user_id}/projects`
- **Uso**: Vincula al usuario a un proyecto específico. Útil para proyectos aislados o accesos granulares.

## 3. Gestión de Roles (Edición)

Si un usuario ya pertenece a una organización o proyecto, su nivel de acceso puede ser modificado mediante `PATCH`.

- **Organización**: `PATCH /api/users/{user_id}/organizations/{org_id}/role`
- **Proyecto**: `PATCH /api/users/{user_id}/projects/{proj_id}/role`

## 4. Desvinculación

Para eliminar el acceso de un usuario a una entidad se utiliza `DELETE`.

- **Endpoint**: `DELETE /api/users/{user_id}/organizations/{org_id}`
