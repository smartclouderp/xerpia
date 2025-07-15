# Módulo Contabilidad: Comprobantes Contables (Journal Entries)

## Endpoints

### Registrar comprobante
- **POST /journal-entries**
- Body:
```json
{
  "date": "2025-07-15",
  "description": "Pago de factura",
  "third_party_id": 1,
  "lines": [
    { "account_id": 1, "debit": 1000, "credit": 0, "description": "Caja" },
    { "account_id": 2, "debit": 0, "credit": 1000, "description": "Clientes" }
  ]
}
```
- Respuesta exitosa:
```json
{
  "message": "Comprobante registrado"
}
```

### Eliminar comprobante
- **DELETE /journal-entries**
- Body:
```json
{
  "id": 1
}
```
- Respuesta exitosa:
```json
{
  "message": "Comprobante eliminado"
}
```

### Listar comprobantes
- **GET /journal-entries**
- Respuesta:
```json
{
  "data": [
    {
      "id": 1,
      "date": "2025-07-15",
      "description": "Pago de factura",
      "third_party_id": 1,
      "lines": [
        { "id": 1, "account_id": 1, "debit": 1000, "credit": 0, "description": "Caja" },
        { "id": 2, "account_id": 2, "debit": 0, "credit": 1000, "description": "Clientes" }
      ]
    }
  ]
}
```

### Obtener comprobante por ID
- **GET /journal-entries/id?id=1**
- Respuesta:
```json
{
  "id": 1,
  "date": "2025-07-15",
  "description": "Pago de factura",
  "third_party_id": 1,
  "lines": [
    { "id": 1, "account_id": 1, "debit": 1000, "credit": 0, "description": "Caja" },
    { "id": 2, "account_id": 2, "debit": 0, "credit": 1000, "description": "Clientes" }
  ]
}
```

## Notas
- El campo `third_party_id` debe existir en la tabla de terceros.
- El array `lines` debe tener al menos una línea con `account_id`, `debit`, `credit`.
- Todos los endpoints requieren autenticación JWT.
- Ver migraciones SQL en `database/migrations/` para la estructura de tablas.
