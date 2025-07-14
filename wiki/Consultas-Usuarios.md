# Consultas, actualización y eliminación de usuarios

## Consultar usuarios

### Listar todos los usuarios
- **GET /users**
- Requiere autenticación (Bearer JWT, rol admin)
- Respuesta ejemplo:
  ```json
  {
    "data": [
      { "id": 1, "username": "admin", "email": "admin@demo.com", "roles": ["admin"] },
      { "id": 2, "username": "editor", "email": "editor@demo.com", "roles": ["editor"] }
    ],
    "pagination": {
      "page": 1,
      "limit": 10,
      "total": 2
    }
  }
  ```

### Consultar usuario por ID
- **GET /users/{id}**
- Requiere autenticación (Bearer JWT, rol admin)
- Respuesta ejemplo:
  ```json
  {
    "id": 2,
    "username": "editor",
    "email": "editor@demo.com",
    "roles": ["editor"]
  }
  ```

## Actualizar usuario
- **PUT /users**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "id": 2,
    "email": "nuevo@demo.com",
    "password": "nuevaClave123"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Usuario actualizado"
  }
  ```

## Eliminar usuario
- **DELETE /users**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "id": 2
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Usuario eliminado"
  }
  ```

## Notas
- Solo usuarios con rol admin pueden consultar, actualizar o eliminar usuarios.
- Los endpoints devuelven errores de validación y permisos en formato JSON.

¿Te gustaría agregar ejemplos de gestión de roles o recuperación de contraseña?
