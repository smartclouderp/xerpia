-- SQL para crear la tabla de terceros contables
CREATE TABLE third_parties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    document VARCHAR(30),
    email VARCHAR(100),
    phone VARCHAR(30)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
