# Módulo Contabilidad - Estado de Resultados (Income Statement)

## Endpoint

```
GET /reports/income-statement
```

### Descripción

Devuelve el estado de resultados (pérdidas y ganancias) de la empresa, mostrando ingresos, egresos y utilidad neta en el periodo solicitado.

### Parámetros de consulta (query params)

- `date_from` (opcional): Fecha inicial en formato `YYYY-MM-DD`.
- `date_to` (opcional): Fecha final en formato `YYYY-MM-DD`.

### Ejemplo de petición

```
GET /reports/income-statement?date_from=2025-01-01&date_to=2025-06-30
```

### Respuesta exitosa

```json
{
  "income": 15000.00,
  "expense": 8000.00,
  "net_income": 7000.00,
  "details": [
    {
      "id": 10,
      "code": "4-01",
      "name": "Ventas",
      "type": "income",
      "debit": 0.00,
      "credit": 15000.00,
      "balance": -15000.00
    },
    {
      "id": 20,
      "code": "5-01",
      "name": "Costos",
      "type": "expense",
      "debit": 8000.00,
      "credit": 0.00,
      "balance": 8000.00
    }
  ]
}
```

- `income`: Total de ingresos.
- `expense`: Total de egresos.
- `net_income`: Utilidad neta (ingresos - egresos).
- `details`: Detalle por cuenta de ingresos y egresos.

### Notas
- Solo cuentas de tipo `income` y `expense` son consideradas.
- Puedes filtrar por rango de fechas usando los parámetros opcionales.
- Requiere autenticación JWT.
