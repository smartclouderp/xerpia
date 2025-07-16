-- Tabla de transacciones contables
CREATE TABLE `transactions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `amount` DECIMAL(18,2) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `account_id` INT UNSIGNED NOT NULL,
  `third_party_id` INT UNSIGNED DEFAULT NULL,
  `period_id` INT UNSIGNED DEFAULT NULL,
  `type` ENUM('debit','credit') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX (`account_id`),
  INDEX (`third_party_id`),
  INDEX (`period_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
