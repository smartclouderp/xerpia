# Módulo Productos

Documentación detallada para la gestión de productos en xerpia.

## Endpoints

### Registrar producto
- **POST /products**
- Requiere autenticación (Bearer JWT)
- Body ejemplo:
  ```json
  {
    "name": "Producto demo",
    "price": 100.5,
    "stock": 10
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Producto registrado"
  }
  ```
- Respuesta de error (validación):
  ```json
  {
    "errors": {
      "name": "El nombre es requerido"
    }
  }
  ```

### Listar productos (paginación y filtros)
- **GET /products?page=1&limit=10&name=demo**
- Requiere autenticación (Bearer JWT)
- Parámetros soportados:
  - `page`: número de página
  - `limit`: cantidad por página
  - `name`: filtro por nombre (opcional)
- Respuesta ejemplo:
  ```json
  {
    "data": [
      { "id": 1, "name": "Producto demo", "price": 100.5, "stock": 10 }
    ],
    "pagination": {
      "page": 1,
      "limit": 10,
      "total": 1
    }
  }
  ```

### Actualizar producto
- **PUT /products**
- Requiere autenticación (Bearer JWT)
- Body ejemplo:
  ```json
  {
    "id": 1,
    "name": "Producto actualizado",
    "price": 120.0,
    "stock": 8
  }
  ```
- Respuesta exitosa:
  ```json
  {
    "message": "Producto actualizado"
  }
  ```

### Eliminar producto
- **DELETE /products**
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
    "message": "Producto eliminado"
  }
  ```

## Validaciones
- Todos los campos son requeridos salvo que se indique lo contrario.
- El precio debe ser numérico y mayor a 0.
- El stock debe ser entero y mayor o igual a 0.

## Notas
- Todos los endpoints devuelven errores de validación en formato JSON.
- Se recomienda usar Postman o similar para pruebas.

---

¿Quieres que agregue ejemplos de errores comunes o flujos de uso avanzados?
