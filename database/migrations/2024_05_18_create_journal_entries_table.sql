-- SQL para crear la tabla de comprobantes contables (journal entries)
CREATE TABLE journal_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    description VARCHAR(255),
    third_party_id INT NOT NULL,
    FOREIGN KEY (third_party_id) REFERENCES third_parties(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
