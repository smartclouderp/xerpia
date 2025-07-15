# Módulo Contabilidad: Plan de Cuentas (Chart of Accounts)

## Endpoints

### Registrar cuenta
- **POST /accounts**
- Body:
```json
{
  "code": "1001",
  "name": "Caja",
  "parent_id": null,
  "type": "asset"
}
```
- Respuesta exitosa:
```json
{
  "message": "Cuenta registrada"
}
```

### Listar cuentas
- **GET /accounts**
- Respuesta:
```json
{
  "data": [
    {
      "id": 1,
      "code": "1001",
      "name": "Caja",
      "parent_id": null,
      "type": "asset"
    },
    ...
  ]
}
```

### Actualizar cuenta
- **PUT /accounts**
- Body:
```json
{
  "id": 1,
  "code": "1001",
  "name": "Caja Principal",
  "parent_id": null,
  "type": "asset"
}
```
- Respuesta exitosa:
```json
{
  "message": "Cuenta actualizada"
}
```

### Eliminar cuenta
- **DELETE /accounts**
- Body:
```json
{
  "id": 1
}
```
- Respuesta exitosa:
```json
{
  "message": "Cuenta eliminada"
}
```

### Obtener cuenta por ID
- **GET /accounts/id?id=1**
- Respuesta:
```json
{
  "id": 1,
  "code": "1001",
  "name": "Caja",
  "parent_id": null,
  "type": "asset"
}
```

## Notas
- El campo `type` puede ser: `asset`, `liability`, `equity`, `income`, `expense`.
- El campo `parent_id` permite jerarquía de cuentas.
- Todos los endpoints requieren autenticación JWT.
- Ver migración SQL en `database/migrations/2024_05_18_create_accounts_table.sql`.
