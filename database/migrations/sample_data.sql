-- Cuentas contables de ejemplo
INSERT INTO accounts (id, code, name, type) VALUES
  (1, '1-01', 'Caja', 'asset'),
  (2, '2-01', 'Proveedores', 'liability'),
  (3, '4-01', 'Ventas', 'income'),
  (4, '5-01', 'Gastos', 'expense');

-- Tercero de ejemplo
INSERT INTO third_parties (id, name, document) VALUES (1, 'Cliente Demo', 'CC123');

-- Comprobante contable de ejemplo
INSERT INTO journal_entries (id, date, description, third_party_id) VALUES
  (1, '2025-06-15', 'Venta de producto', 1),
  (2, '2025-06-20', 'Pago a proveedor', 1);

-- Líneas de comprobante (movimientos)
INSERT INTO journal_entry_lines (id, journal_entry_id, account_id, debit, credit, description) VALUES
  (1, 1, 1, 1000, 0, 'Ingreso en caja'),
  (2, 1, 3, 0, 1000, 'Venta realizada'),
  (3, 2, 4, 500, 0, 'Gasto pagado'),
  (4, 2, 1, 0, 500, 'Salida de caja');
