# Guía de Instalación Local

Sigue estos pasos para configurar el entorno de desarrollo de Kairo-Auth en tu máquina local.

## Requisitos Previos

- **PHP**: 8.3 o superior
- **Composer**: Gestor de dependencias de PHP
- **Base de Datos**: MySQL / MariaDB / PostgreSQL o SQLite
- **Servidor Web**: Apache / Nginx o usar `php artisan serve`

---

## Pasos de Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Bartoloni00/kairo-auth.git
cd kairo-auth
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar el entorno

Copia el archivo de ejemplo `.env` y ajusta las variables según tu configuración local.

```bash
cp .env.example .env
```

Asegúrate de configurar los datos de tu base de datos en las siguientes variables:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kairo_auth
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Generar claves de la aplicación

```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Ejecutar migraciones y seeders

Esto creará las tablas necesarias y los roles básicos del sistema.

```bash
php artisan migrate --seed
```

### 6. Generar documentación Swagger

Para visualizar la documentación de la API en `http://localhost:8000/api/documentation`:

```bash
php artisan l5-swagger:generate
```

### 7. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

---

## Documentación Útil

- **API (Swagger)**: `http://localhost:8000/api/documentation`
- **Postman**: Puedes importar la colección ubicada en `app/Docs/Kairo-Auth.postman_collection.json`.
- **Middlewares**: Consulta `app/Docs/AUTHORIZATION_MIDDLEWARE.md` para entender el sistema de permisos.
