# 🧠 Kairo Auth Core Platform

### Multi-tenant SaaS Identity & Licensing Service

Kairo Auth es un microservicio de autenticación y autorización centralizado, diseñado para gestionar identidades, organizaciones (tenants), proyectos y licencias en un ecosistema de aplicaciones SaaS.

---

## 🏗️ Arquitectura y Hitos de Diseño

El proyecto implementa una arquitectura robusta basada en estándares modernos para asegurar escalabilidad y mantenibilidad:

### 🧩 Monolito Modular

El sistema está organizado en **Módulos Independientes** (Auth, Users, Organizations, Projects, etc.). Cada módulo encapsula su propia lógica de dominio, controladores y rutas, facilitando una futura transición a microservicios si fuera necesario.

### 🏛️ Clean Architecture & DDD

Se sigue un patrón de **Arquitectura Limpia** para separar las preocupaciones:

- **Domain**: Entidades y reglas de negocio puras.
- **Application**: Casos de uso (Use Cases) que orquestan la lógica.
- **Infrastructure**: Implementaciones de persistencia, servicios externos y adaptadores.
- **Interfaces**: Controladores API, Middlewares y Requests.

### 🔐 Autorización Granular y Multi-tenant

A diferencia de los sistemas de roles tradicionales, Kairo Auth utiliza un sistema de **Middlewares por Acción** con soporte multi-tenant nativo:

- **Relación Dinámica**: Los permisos se definen en una tabla pivote `project_user_access` que vincula Usuario + Proyecto + Organización + Rol.
- **Fail-Closed**: El sistema deniega cualquier acceso por defecto a menos que exista una regla explícita que lo permita.
- **Bypass de ROOT**: Soporte para un rol Super Admin (Root) que permite la gestión global del ecosistema.

### 📜 Sistema de Auditoría (Audit Logs)

Cada acción crítica (creación, edición, eliminación, login) se registra automáticamente en una tabla de auditoría, capturando metadatos como IP, headers, cuerpo de la petición y estado de la operación.

---

## 🚀 Características Principales

- **JWT Auth**: Autenticación segura mediante JSON Web Tokens con soporte para Access y Refresh Tokens.
- **Multi-tenancy**: Gestión de múltiples organizaciones donde un usuario puede tener diferentes roles en cada una.
- **RBAC Extensible**: Roles jerárquicos (ROOT, ADMIN, USER) preparados para extensiones futuras.
- **Documentación Viva**:
    - **Swagger/OpenAPI**: Documentación interactiva generada desde el código.
    - **Postman**: Colección lista para importar y probar el flujo completo.

---

## 📂 Estructura del Proyecto

```text
app/
├── Modules/             # Módulos del sistema (Auth, Users, Projects, etc.)
│   └── [Module]/
│       ├── Domain/      # Entidades y Contratos
│       ├── Application/ # Casos de Uso
│       └── Interfaces/  # Controladores, Rutas y Middlewares
├── Shared/              # Helpers, Enums y lógica compartida
└── Docs/                # Documentación detallada y esquemas
```

---

## 🛠️ Instalación y Configuración

Consulta el archivo [INSTALL.md](./INSTALL.md) para ver los pasos detallados de despliegue en local.

---

## 📖 Documentación Adicional

- [Sistema de Autorización](./app/Docs/AUTHORIZATION_MIDDLEWARE.md)
- [Guía de Logs de Auditoría](./app/Docs/LOGS_GUIDE.md)
- [Patrón de Respuestas API](./app/Docs/API_RESPONSE_PATTERN.md)
- [Uso de Factories](./app/Docs/FACTORIES_GUIDE.md)

---

## 🎯 Roadmap Architectural

- [x] Implementación de JWT (Tymon)
- [x] Arquitectura Modular Monolith
- [x] Patrón Unificado de Respuestas API
- [x] Sistema de Permisos Multi-tenant Granular
- [x] Logs de Auditoría Automatizados
- [ ] Implementación de SDK para aplicaciones satélite
- [ ] Sistema de Invitaciones por Email
- [ ] Gestión de Suscripciones y Planes de Pago (ver servicios de pagos online)
