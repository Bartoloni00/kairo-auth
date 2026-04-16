# Auth service proyect

# 🧠 Auth Core Platform (Multi-tenant SaaS Identity & Licensing)

## 📌 Overview

Sistema centralizado de autenticación, organizaciones (tenants), acceso a proyectos y licenciamiento, diseñado para reutilizarse en múltiples aplicaciones SaaS.

### Objetivos

- Evitar duplicación de usuarios entre apps
- Centralizar autenticación y autorización
- Soportar multitenancy (organizaciones con equipos)
- Gestionar licencias por organización
- Acelerar desarrollo de nuevos SaaS

---

# 🧱 Arquitectura

## 🧩 Estilo

- Monolito modular
- Clean Architecture (capas desacopladas)

## 📂 Estructura

(Sin definir)

---

# 🏢 Modelo de dominio

## Entidades principales

- User (global)
- Organization (tenant)
- Project
- License
- Invitation
- AuditLog

---

# 🗄️ Base de Datos
![base de datos](/database/DER-01.png)
# 🔐 Autenticación

## JWT Strategy

### Access Token

- corto (15–30 min)

### Refresh Token

- largo (7–30 días)
- almacenado en DB

---

## Payload JWT

```
{
  "sub":"user_id",
  "org_id":"org_id",
  "role":"admin",
  "iat":1710000000,
  "exp":1710003600
}
```

---

## Refresh Tokens (tabla sugerida)

```
refresh_tokens
- id
- user_id
- token (hash)
- expires_at
- revoked (bool)
```

---

# 🔄 Flujo de autenticación

## Registro

1. Usuario envía email/password + project_id
2. Backend:
    - busca user por email
    - si no existe → crea
3. crea organization (si es nuevo)
4. vincula project a organization
5. asigna rol admin

---

## Login

1. valida credenciales
2. devuelve:
    - access_token
    - refresh_token

---

## Refresh

1. valida refresh_token
2. genera nuevo access_token

---

# 🧩 Endpoints

## Auth

### POST /auth/register

```
{
  "email":"",
  "password":"",
  "project_id":""
}
```

---

### POST /auth/login

```
{
  "email":"",
  "password":""
}
```

---

### POST /auth/refresh

```
{
  "refresh_token":""
}
```

---

### POST /auth/logout

- revoca refresh token

---

## Organizations

### GET /organizations

- lista organizaciones del usuario

### POST /organizations

- crear nueva org

---

## Organization Users

### GET /organizations/{id}/users

### POST /organizations/{id}/invite

```
{
  "email":"",
  "role":"member"
}
```

---

### POST /invitations/accept

```
{
  "token":"",
  "password":""
}
```

---

## Projects

### GET /projects

### POST /organizations/{id}/projects/enable

```
{
  "project_id":""
}
```

---

## Licenses

### GET /organizations/{id}/license

### POST /organizations/{id}/license

```
{
  "plan":"pro"
}
```

---

# 🛡️ Middlewares

## 1. AuthMiddleware

- valida JWT

---

## 2. OrganizationMiddleware

- valida que user pertenece a org

---

## 3. ProjectAccessMiddleware

- valida:
    - org tiene project habilitado
    - licencia activa

Headers requeridos:

```
Authorization: Bearer xxx
X-Org-ID: org_id
X-Project-ID: project_id
```

---

## 4. RoleMiddleware

- valida roles:
    - admin
    - member

---

## 5. LicenseMiddleware

- valida plan activo

---

# 📩 Sistema de invitaciones

## Flujo

1. Admin invita usuario
2. se genera token único
3. se envía email
4. usuario acepta:
    - crea cuenta o vincula existente
    - se agrega a organization

---

# 📜 Logs (Audit System)

Registrar:

- login
- registro
- creación de org
- invitaciones
- cambios de rol
- cambios de licencia

---

# 💳 Licencias

## MVP

Planes:

- free → acceso limitado
- pro → acceso a todos los proyectos

---

## Reglas

- licencia por organización
- validar en cada request crítica

---

# 🧠 SDK (futuro)

Funciones:

```
auth.login()
auth.logout()
auth.getUser()
auth.getOrganizations()
auth.hasAccess(projectId)
```

---

# 🚀 Roadmap

## Fase 1

- auth básico
- organizations

## Fase 2

- projects + acceso

## Fase 3

- licencias

## Fase 4

- invitaciones

## Fase 5

- logs + SDK

---

# ⚠️ Consideraciones clave

- no sobrecargar JWT
- mantener lógica de permisos en backend
- separar identidad de acceso
- diseñar todo pensando en organización como unidad principal
