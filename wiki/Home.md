# Wiki de xerpia

Bienvenido a la documentación extendida de xerpia ERP.

## Índice

- [Introducción](#introducción)
- [Guía de instalación y despliegue](#guía-de-instalación-y-despliegue)
- [Autenticación y JWT](#autenticación-y-jwt)
- [Módulo Usuarios y Roles](#módulo-usuarios-y-roles)
- [Módulo Productos](#módulo-productos)
- [Módulo Proveedores](#módulo-proveedores)
- [Esquemas SQL y migraciones](#esquemas-sql-y-migraciones)
- [Arquitectura hexagonal y patrones](#arquitectura-hexagonal-y-patrones)
- [FAQ](#faq)

---

## Introducción

xerpia es un sistema ERP modular, basado en arquitectura hexagonal, desarrollado en PHP 8.2 y MariaDB. Soporta JWT para autenticación y está diseñado para ser extensible y fácil de mantener.

## Guía de instalación y despliegue

1. Clona el repositorio y entra al directorio:
   ```bash
   git clone <url-del-repo>
   cd xerpia
   ```
2. Instala dependencias:
   ```bash
   composer install
   ```
3. Configura la base de datos en `config/database.php`.
4. Ejecuta las migraciones SQL (ver sección de esquemas SQL).
5. Levanta el servidor:
   ```bash
   php -S localhost:8000 -t public
   ```

## Autenticación y JWT

- Endpoint: `POST /login`
- Envía usuario y contraseña, recibe un JWT válido para usar en endpoints protegidos.
- Ejemplo de request:
  ```json
  {
    "username": "admin",
    "password": "123456"
  }
  ```
- Ejemplo de response:
  ```json
  {
    "token": "<jwt>"
  }
  ```

## Módulo Usuarios y Roles

- Registro de usuarios y asignación de roles.
- Endpoints: `POST /users`, `POST /roles`, etc.
- Ver detalles y ejemplos en la página específica del módulo.

## Módulo Productos

- Registro, listado, actualización y eliminación de productos.
- Soporta paginación y filtros en el listado.
- Endpoints:
  - `POST /products`
  - `GET /products`
  - `PUT /products`
  - `DELETE /products`
- Ejemplo de registro:
  ```json
  {
    "name": "Producto demo",
    "price": 100.5,
    "stock": 10
  }
  ```
- Ejemplo de listado:
  ```http
  GET /products?page=1&limit=10&name=demo
  Authorization: Bearer <jwt>
  ```

## Módulo Proveedores

- CRUD de proveedores y asociación con productos.
- Endpoints: `POST /providers`, `GET /providers`, etc.

## Esquemas SQL y migraciones

- Consulta los archivos SQL en la raíz o sección correspondiente.

## Arquitectura hexagonal y patrones

- Explicación de la estructura de carpetas, capas y dependencias.

## FAQ

- Preguntas frecuentes y solución de problemas comunes.

## Desacoplamiento y estructura de archivos

A partir de la versión 2025-07, el archivo `public/index.php` fue desacoplado para facilitar el mantenimiento y la escalabilidad. Ahora la lógica principal se divide en:

- `public/index.php`: solo carga el entorno, dependencias, rutas y despacha la petición.
- `config/dependencies.php`: define e instancia los controladores y repositorios principales.
- `config/routes.php`: define las rutas principales y las asocia a los controladores.
- `src/Core/Bootstrap/EnvLoader.php`: clase para cargar variables de entorno desde `.env`.
- `src/Core/Bootstrap/Router.php`: clase para el enrutamiento y despacho de peticiones.
- `src/Core/Bootstrap/JwtHelper.php`: clase para la verificación de JWT.

**Ventajas:**
- Cada módulo puede crecer de forma independiente.
- El router y la autenticación son reutilizables y fáciles de testear.
- Las dependencias y rutas se pueden modificar sin tocar el archivo principal.

**Ejemplo de flujo:**
1. `index.php` carga el entorno y la configuración.
2. Instancia los controladores y rutas desde `config/`.
3. Usa el router para despachar la petición y validar JWT si es necesario.

Para detalles técnicos, revisa la sección de [Arquitectura hexagonal y patrones](./Arquitectura-Hexagonal.md).

---

Para detalles de cada módulo, consulta las páginas específicas del Wiki.
