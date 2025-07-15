# Módulo Usuarios y Roles

Documentación detallada para la gestión de usuarios y roles en xerpia.

## Endpoints


### Registrar usuario
- **POST /users**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "username": "nuevo_usuario",
    "password": "123456",
    "email": "usuario@demo.com",
    "roles": ["admin"]
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Usuario registrado"
  }
  ```
- Respuesta de error (validación):
  ```json
  {
    "errors": {
      "username": "El usuario ya existe"
    }
  }
  ```

### Listar todos los usuarios
- **GET /users**
- Requiere autenticación (Bearer JWT, rol admin)
- Respuesta ejemplo:
  ```json
  {
    "data": [
      { "id": 1, "username": "admin", "email": "admin@demo.com" },
      { "id": 2, "username": "editor", "email": "editor@demo.com" }
    ]
  }
  ```

### Obtener usuario por id
- **GET /users/id**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "id": 2
  }
  ```
- Respuesta ejemplo:
  ```json
  {
    "id": 2,
    "username": "editor",
    "email": "editor@demo.com"
  }
  ```

### Actualizar usuario
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

### Eliminar usuario
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

### Login de usuario
- **POST /login**
- Body ejemplo:
  ```json
  {
    "username": "admin",
    "password": "123456"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "token": "<jwt>"
  }
  ```
- Respuesta de error:
  ```json
  {
    "error": "Credenciales inválidas"
  }
  ```

### Registrar rol
- **POST /roles**
- Requiere autenticación (Bearer JWT, rol admin)
- Body ejemplo:
  ```json
  {
    "name": "editor"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Rol registrado"
  }
  ```

### Asignar rol a usuario
- **POST /users/roles**
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

## Validaciones
- El usuario y el email deben ser únicos.
- La contraseña debe tener mínimo 6 caracteres.
- Solo usuarios con rol admin pueden crear usuarios o roles.

## Notas
- Todos los endpoints devuelven errores de validación en formato JSON.
- El token JWT debe enviarse en el header `Authorization: Bearer <jwt>` para endpoints protegidos.

---

¿Quieres agregar ejemplos de consulta de usuarios, actualización o eliminación?
