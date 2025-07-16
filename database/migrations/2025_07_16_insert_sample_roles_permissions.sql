-- Ejemplo de roles
INSERT INTO roles (name, description) VALUES
('Administrador', 'Acceso total al sistema'),
('Contador', 'Gestión contable y fiscal'),
('Finanzas', 'Gestión financiera'),
('Operaciones', 'Gestión operativa'),
('Usuario estándar', 'Acceso limitado'),
('Auditor', 'Solo lectura de reportes');

-- Ejemplo de permisos
INSERT INTO permissions (name, description) VALUES
('manage_users', 'Gestionar usuarios y roles'),
('view_reports', 'Ver reportes'),
('edit_transactions', 'Editar transacciones contables'),
('close_periods', 'Cerrar periodos contables'),
('manage_products', 'Gestionar productos'),
('manage_providers', 'Gestionar proveedores'),
('read_only', 'Solo lectura');

-- Asignación de permisos a roles
INSERT INTO role_permissions (role_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), -- Administrador
(2, 2), (2, 3), (2, 4),                        -- Contador
(3, 2),                                         -- Finanzas
(4, 5), (4, 6),                                 -- Operaciones
(5, 2),                                         -- Usuario estándar
(6, 2), (6, 7);                                 -- Auditor

-- Ejemplo de usuarios
INSERT INTO users (username, email, password_hash) VALUES
('admin', 'admin@demo.com', '$2y$10$tWpcmSrHzlH3TyLgWAQZfeqJdZVkAasQRFujQwaWL6O08Tw1ev25'),
('conta', 'conta@demo.com', '$2y$10$U4/jrwcOGc2JWUGok0YEKeOqbivUxbeetCNKR.2H/x62P7kxRuJ5'),
('finanzas', 'finanzas@demo.com', '$2y$10$7nv.pimTL5iiwGl6aVrJSurjESpKTDkU9DzUJx0Y6y5GGDdPM28N'),
('oper', 'oper@demo.com', '$2y$10$Xp1RJsqgAL/31fnVbF5Yu.GpCRAWJnGK2hk5gD8BtserwHCR.MB9'),
('user', 'user@demo.com', '$2y$10$5ewfoj.LiEm2tyGEyDeH5vFSscDgRp.n'),
('auditor', 'auditor@demo.com', '$2y$10$3.aSyu6A8TFw48vJobgIpJA5ecW3fU.t');

-- Asignación de roles a usuarios
INSERT INTO user_roles (user_id, role_id) VALUES
(1, 1), -- admin como Administrador
(2, 2), -- conta como Contador
(3, 3), -- finanzas como Finanzas
(4, 4), -- oper como Operaciones
(5, 5), -- user como Usuario estándar
(6, 6); -- auditor como Auditor
