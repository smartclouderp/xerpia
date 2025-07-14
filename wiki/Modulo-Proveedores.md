# Módulo Proveedores

Documentación detallada para la gestión de proveedores en xerpia.

## Endpoints

### Registrar proveedor
- **POST /providers**
- Requiere autenticación (Bearer JWT)
- Body ejemplo:
  ```json
  {
    "name": "Proveedor demo",
    "email": "proveedor@demo.com",
    "phone": "555-1234"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Proveedor registrado"
  }
  ```

### Listar proveedores (paginación y filtros)
- **GET /providers?page=1&limit=10&name=demo**
- Requiere autenticación (Bearer JWT)
- Parámetros soportados:
  - `page`: número de página
  - `limit`: cantidad por página
  - `name`: filtro por nombre (opcional)
- Respuesta ejemplo:
  ```json
  {
    "data": [
      { "id": 1, "name": "Proveedor demo", "email": "proveedor@demo.com", "phone": "555-1234" }
    ],
    "pagination": {
      "page": 1,
      "limit": 10,
      "total": 1
    }
  }
  ```

### Actualizar proveedor
- **PUT /providers**
- Requiere autenticación (Bearer JWT)
- Body ejemplo:
  ```json
  {
    "id": 1,
    "name": "Proveedor actualizado",
    "email": "nuevo@demo.com",
    "phone": "555-5678"
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Proveedor actualizado"
  }
  ```

### Eliminar proveedor
- **DELETE /providers**
- Requiere autenticación (Bearer JWT)
- Body ejemplo:
  ```json
  {
    "id": 1
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Proveedor eliminado"
  }
  ```

### Asociar producto a proveedor
- **POST /providers/products**
- Body ejemplo:
  ```json
  {
    "provider_id": 1,
    "product_id": 2
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Producto asociado al proveedor"
  }
  ```

### Desasociar producto de proveedor
- **DELETE /providers/products**
- Body ejemplo:
  ```json
  {
    "provider_id": 1,
    "product_id": 2
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Producto desasociado del proveedor"
  }
  ```

## Validaciones
- Todos los campos son requeridos salvo que se indique lo contrario.
- El email debe tener formato válido.
- El teléfono debe ser válido.

## Notas
- Todos los endpoints devuelven errores de validación en formato JSON.
- Se recomienda usar Postman o similar para pruebas.

---

¿Te gustaría agregar ejemplos de errores comunes o flujos avanzados de consulta?
