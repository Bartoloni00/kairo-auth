# 🧠 Kairo Auth Core Platform

### Multi-tenant SaaS Identity & Licensing Service

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![JWT Auth](https://img.shields.io/badge/JWT-Authentication-black?style=for-the-badge&logo=json-web-tokens)](https://jwt.io)
[![Clean Architecture](https://img.shields.io/badge/Architecture-Clean-blue?style=for-the-badge)](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)

Kairo Auth es un microservicio de autenticación y autorización centralizado, diseñado para gestionar identidades, organizaciones (tenants), proyectos y licencias en un ecosistema de aplicaciones SaaS.

---

## 🏛️ Arquitectura de Software

El proyecto implementa una arquitectura robusta basada en estándares modernos para asegurar escalabilidad y mantenibilidad.

### 🧩 Monolito Modular

El sistema está organizado en **Módulos Independientes**. Cada módulo encapsula su propia lógica de dominio, controladores y rutas, facilitando una futura transición a microservicios:

- `Auth`: Gestión de tokens y sesiones.
- `Users`: Perfiles y gestión de identidades.
- `Organizations`: Soporte multi-tenant (Empresas/Grupos).
- `Projects`: Aislamiento de recursos por proyecto.
- `Auditlogs`: Seguimiento de actividad crítico.

### 🏗️ Clean Architecture & DDD

Se sigue un patrón de **Arquitectura Limpia** para separar las preocupaciones:

1.  **Domain**: Entidades, reglas de negocio puras y contratos (Interfaces).
2.  **Application**: Casos de uso (Use Cases) que orquestan la lógica de negocio.
3.  **Infrastructure**: Persistencia (Eloquent), servicios externos y adaptadores.
4.  **Interfaces**: Controladores API, Middlewares, Requests y Recursos de respuesta.

---

## 🔐 Seguridad y Autorización

### Registro Desacoplado (GitHub Style)

Los usuarios existen de forma independiente. Un usuario puede registrarse sin pertenecer a una organización y luego ser invitado o asociado a múltiples tenants con diferentes roles.

### Autorización Granular Multi-tenant

- **Middlewares por Acción**: Control de acceso basado en el contexto (Usuario + Organización + Proyecto).
- **Modelo Fail-Closed**: Todo acceso es denegado por defecto. Solo las reglas explícitas en `project_user_access` permiten la entrada.
- **Soporte ROOT**: Rol de Super Administrador para gestión global del sistema.

### Protección de Infraestructura

- **Rate Limiting Dinámico**: Protección contra ataques de fuerza bruta en login, registro y endpoints sensibles.
- **JWT Stateless**: Autenticación escalable sin estado en servidor.

---

## 🚀 Características Principales

- ✅ **JWT Auth**: Tokens de acceso y refresco seguros.
- ✅ **Audit Logging**: Registro automático de cada cambio de estado (IP, User Agent, Payload).
- ✅ **API Response Pattern**: Respuestas estandarizadas para una integración simple con el Frontend.
- ✅ **Swagger/OpenAPI**: Documentación interactiva siempre actualizada.
- ✅ **Postman Collection**: Colección lista para testear flujos completos.

---

## 📂 Estructura del Proyecto

```text
app/
├── Modules/             # Módulos Core del sistema
│   └── [Module]/
│       ├── Domain/      # Entidades y Contratos
│       ├── Application/ # Casos de Uso (Business Logic)
│       ├── Infrastructure/ # Implementación de Repositorios
│       └── Interfaces/  # Controladores, Rutas y Middlewares
├── Shared/              # Helpers y lógica compartida entre módulos
└── Docs/                # Documentación técnica detallada
```

---

## 🛠️ Instalación y Configuración

Consulta el archivo [**INSTALL.md**](./INSTALL.md) para ver los pasos detallados de despliegue en entornos locales y de producción.

---

## 📖 Documentación Adicional

- 📘 [Flujo de Usuarios y Roles](./app/Docs/USER_FLOW_GUIDE.md)
- 🛡️ [Sistema de Autorización](./app/Docs/AUTHORIZATION_MIDDLEWARE.md)
- 📜 [Guía de Logs de Auditoría](./app/Docs/LOGS_GUIDE.md)
- 🚦 [Sistema de Rate Limiting](./app/Docs/RATE_LIMITING.md)
- ⚠️ [Patrón de Manejo de Errores](./app/Docs/ERROR_HANDLING_PATTERN.md)
- 📦 [Guía de Factories y Testing](./app/Docs/FACTORIES_GUIDE.md)

---

## 🎯 Roadmap Architectural

- [x] Implementación de JWT (Tymon)
- [x] Arquitectura Modular Monolith
- [x] Patrón Unificado de Respuestas API
- [x] Sistema de Rate Limiting (Brute-force protection)
- [x] Sistema de Permisos Multi-tenant Granular
- [x] Logs de Auditoría Automatizados
- [ ] Implementación de SDK para aplicaciones satélite
- [ ] Sistema de Invitaciones por Email
- [ ] Gestión de Suscripciones y Planes de Pago (ver servicios de pagos online)
