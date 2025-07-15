-- SQL para crear la tabla accounts (Plan de cuentas)
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(100) NOT NULL,
    parent_id INT DEFAULT NULL,
    type VARCHAR(20) NOT NULL,
    FOREIGN KEY (parent_id) REFERENCES accounts(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
