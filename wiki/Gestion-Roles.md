# Gestión de roles de usuario

## Asignar rol a usuario
- **POST /users/roles**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "user_id": 2,
    "role": "editor"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Rol asignado"
  }
  ```
- Respuesta de error:
  ```json
  {
    "error": "El usuario o rol no existe"
  }
  ```

## Listar roles de un usuario
- **GET /users/{id}/roles**
- Requiere autenticación (Bearer JWT, rol admin)
- Respuesta ejemplo:
  ```json
  {
    "user_id": 2,
    "roles": ["editor", "viewer"]
  }
  ```

## Eliminar rol de usuario
- **DELETE /users/roles**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "user_id": 2,
    "role": "viewer"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Rol eliminado"
  }
  ```

## Notas
- Solo usuarios con rol admin pueden gestionar roles.
- Los endpoints devuelven errores de validación y permisos en formato JSON.

¿Te gustaría agregar ejemplos de recuperación de contraseña o gestión avanzada de permisos?
