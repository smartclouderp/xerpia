# Errores comunes y soluciones

Esta sección recopila los errores más frecuentes al usar la API de xerpia y cómo resolverlos.

## 1. Error de validación de campos
- **Causa:** Faltan campos requeridos o tienen formato incorrecto.
- **Respuesta ejemplo:**
  ```json
  {
    "errors": {
      "name": "El nombre es requerido",
      "price": "El precio debe ser mayor a 0"
    }
  }
  ```
- **Solución:** Verifica que todos los campos requeridos estén presentes y tengan el formato correcto.

## 2. Token JWT inválido o expirado
- **Causa:** El token enviado en el header Authorization es incorrecto o ha expirado.
- **Respuesta ejemplo:**
  ```json
  {
    "error": "Token inválido o expirado"
  }
  ```
- **Solución:** Realiza login nuevamente y usa el nuevo token en el header `Authorization: Bearer <jwt>`.

## 3. Endpoint no encontrado
- **Causa:** La ruta o método HTTP no existe.
- **Respuesta ejemplo:**
  ```json
  {
    "error": "Endpoint no encontrado"
  }
  ```
- **Solución:** Verifica la URL y el método HTTP usados.

## 4. Error de conexión a base de datos
- **Causa:** Configuración incorrecta en `config/database.php` o base de datos no disponible.
- **Respuesta ejemplo:**
  ```json
  {
    "error": "No se pudo conectar a la base de datos"
  }
  ```
- **Solución:** Revisa los parámetros de conexión y que el servicio de base de datos esté activo.

## 5. Error de permisos
- **Causa:** El usuario autenticado no tiene permisos para la acción.
- **Respuesta ejemplo:**
  ```json
  {
    "error": "No tienes permisos para realizar esta acción"
  }
  ```
- **Solución:** Asegúrate de que el usuario tenga el rol adecuado.

---

¿Quieres agregar más casos o ejemplos de debugging avanzado?
