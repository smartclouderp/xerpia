# Xerpia ERP

ERP modular en PHP 8.2, arquitectura hexagonal, SOLID, MariaDB, Docker, Composer plugins.

## Estructura
- src/Core: Dominio y lógica central
- src/Modules: Módulos funcionales (ej: Inventario, Ventas)
- src/Shared: Utilidades y recursos compartidos
- src/Plugins: Plugins vía Composer
- config: Configuración
- public: Punto de entrada web
- docker: Docker y docker-compose
- tests: Pruebas

## Docker
- PHP 8.2 + Apache
- MariaDB

## Composer
- PSR-4 autoload
- Plugins y dependencias

## Escalabilidad
- Modularidad por paquetes
- Hexagonal: separación de dominio, aplicación, infraestructura y adaptadores

## Ejecución
1. Instala dependencias:
   ```powershell
   composer install
   ```
2. Levanta el entorno:
   ```powershell
   docker-compose -f docker/docker-compose.yml up --build
   ```
3. Accede a http://localhost:8080

# Endpoints principales

## Autenticación

**POST /login**
- Body (JSON):
  ```json
  {
    "username": "usuario",
    "password": "contraseña"
  }
  ```
- Respuesta: `{ "token": "..." }`

## Usuarios

**POST /users**
- Body (JSON):
  ```json
  {
    "username": "nuevo_usuario",
    "password": "contraseña",
    "roles": [1, 2]
  }
  ```
- Respuesta: `{ "message": "Usuario creado" }`

## Productos

**POST /products**
- Body (JSON):
  ```json
  {
    "name": "Producto",
    "price": 100.5,
    "stock": 20
  }
  ```
- Respuesta: `{ "message": "Producto registrado" }`

## Proveedores

**POST /providers**
- Body (JSON):
  ```json
  {
    "businessName": "Proveedor Ejemplo",
    "taxId": "RFC123456",
    "address": "Calle 123, Ciudad",
    "contactName": "Juan Pérez",
    "contactEmail": "juan@proveedor.com",
    "contactPhone": "555-1234"
  }
  ```
- Respuesta: `{ "message": "Proveedor registrado" }`

**GET /providers**
- Parámetro opcional: `id` (para consultar uno)
- Ejemplo: `/providers?id=1`
- Respuesta: proveedor o lista de proveedores

**GET /providers/list**
- Parámetros opcionales: `page`, `limit`, `search`
- Ejemplo: `/providers/list?page=1&limit=10&search=Juan`
- Respuesta: lista paginada y filtrada

**PUT /providers**
- Body (JSON): igual que POST, más campo `id` obligatorio
  ```json
  {
    "id": 1,
    "businessName": "Proveedor Actualizado",
    "taxId": "RFC987654",
    "address": "Nueva dirección",
    "contactName": "Ana López",
    "contactEmail": "ana@proveedor.com",
    "contactPhone": "555-5678"
  }
  ```
- Respuesta: `{ "message": "Proveedor actualizado" }`

**DELETE /providers**
- Body (JSON): `{ "id": 1 }`
- Respuesta: `{ "message": "Proveedor eliminado" }`
