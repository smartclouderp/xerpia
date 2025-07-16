# Xerpia ERP - Endpoints REST y Swagger

## Autenticación y Usuarios
- `POST /login` - Autenticación de usuario, retorna JWT.
- `POST /users` - Registrar usuario.
- `GET /users` - Listar todos los usuarios.
- `GET /users/id` - Obtener usuario por ID.
- `PUT /users` - Actualizar usuario.
- `DELETE /users` - Eliminar usuario.

## Productos
- `POST /products` - Registrar producto.
- `GET /products` - Listar productos.
- `PUT /products` - Actualizar producto.
- `DELETE /products` - Eliminar producto.

## Proveedores
- `POST /providers` - Registrar proveedor.
- `GET /providers` - Consultar proveedor.
- `GET /providers/list` - Listar proveedores.
- `PUT /providers` - Actualizar proveedor.
- `DELETE /providers` - Eliminar proveedor.

## Periodos contables
- `POST /periods` - Crear periodo contable.
- `GET /periods` - Listar periodos contables.
- `POST /periods/close` - Cerrar periodo contable.
- `GET /periods/validate-date` - Validar si una fecha está en un periodo abierto.

## Transacciones contables
- `POST /transactions` - Registrar transacción contable.

## Informes y reportes contables
- `GET /reports/balance-sheet` - Balance general.
- `GET /reports/general-ledger` - Libro mayor.
- `GET /reports/transactions` - Listado de transacciones.
- `GET /reports/income-statement` - Estado de resultados.
- `GET /reports/journal` - Libro diario.
- `GET /reports/third-party` - Informe de movimientos y saldo por tercero.
- `GET /reports/accounts-receivable` - Cuentas por cobrar.
- `GET /reports/accounts-payable` - Cuentas por pagar.
- `GET /reports/tax` - Informe de impuestos.
- `GET /reports/cash-flow` - Flujo de efectivo.
- `GET /reports/account-movements` - Movimientos por cuenta.
- `GET /reports/period-close` - Cierre de periodo contable.
- `GET /reports/export` - Exportación fiscal (CSV, Excel, PDF).

---

## Swagger/OpenAPI
- La documentación Swagger está integrada en los comentarios de cada endpoint en el archivo `routes.php`.
- Solo se muestra en entorno local (según configuración en `.env`).
- Incluye ejemplos de request/response y parámetros para cada endpoint.

---

> Última actualización: 2025-07-16
