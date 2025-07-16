-- Ejemplo de datos para la tabla transactions
INSERT INTO `transactions` (`date`, `amount`, `description`, `account_id`, `third_party_id`, `period_id`, `type`) VALUES
('2025-07-01', 1500.00, 'Venta producto A', 101, 1, 1, 'credit'),
('2025-07-02', 500.00, 'Compra insumos', 201, 2, 1, 'debit'),
('2025-07-03', 1200.00, 'Pago proveedor', 202, 2, 1, 'debit'),
('2025-07-04', 2000.00, 'Cobro cliente', 101, 3, 1, 'credit'),
('2025-07-05', 800.00, 'Gasto administrativo', 301, NULL, 1, 'debit'),
('2025-07-06', 950.00, 'Venta producto B', 101, 4, 1, 'credit'),
('2025-07-07', 400.00, 'Pago servicios', 302, NULL, 1, 'debit'),
('2025-07-08', 1100.00, 'Cobro cliente', 101, 5, 1, 'credit'),
('2025-07-09', 600.00, 'Compra inventario', 201, 2, 1, 'debit'),
('2025-07-10', 1300.00, 'Venta producto C', 101, 6, 1, 'credit');
